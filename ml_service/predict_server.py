import os
import re
import joblib
import pandas as pd
from flask import Flask, request, jsonify

app = Flask(__name__)

# Resolve path to your joblib artifact
MODEL_PATH = os.path.join(os.path.dirname(__file__), 'real_job_fraud_detector.pkl')
model = None

def clean_text(text):
    if not text:
        return ""
    text = str(text).lower()
    text = re.sub(r'[^a-z0-9\s]', '', text)
    return text

def load_model():
    global model
    if not os.path.exists(MODEL_PATH):
        raise FileNotFoundError(f"Model artifact not found at: {MODEL_PATH}")
    # Using joblib matching your training exporter
    model = joblib.load(MODEL_PATH)
    print("Calibrated LightGBM pipeline successfully loaded into memory.")

@app.route('/predict', methods=['POST'])
def predict():
    try:
        data = request.get_json()
        if not data:
            return jsonify({'error': 'Invalid payload, JSON expected'}), 400

        # 1. Gather raw inputs sent by Laravel
        title = data.get('title', '')
        description = data.get('description', '')
        requirements = data.get('requirements', '')
        
        # We fetch company profile details from the employer profile relational data
        company_profile = data.get('company_profile', '') 

        # 2. Replicate your exact training 'combined_text' preprocessing
        raw_combined = f"{title} {company_profile} {description} {requirements}"
        cleaned_combined = clean_text(raw_combined)

        # 3. Parse meta features (defaulting to safe assumptions if missing)
        # Check if employer profile contains a logo, or if job has screeners
        telecommuting = int(data.get('telecommuting', 0))
        has_company_logo = int(data.get('has_company_logo', 0))
        has_questions = int(data.get('has_questions', 0))

        # 4. Wrap inputs into a temporary Pandas DataFrame to feed the ColumnTransformer
        input_df = pd.DataFrame([{
            'combined_text': cleaned_combined,
            'telecommuting': telecommuting,
            'has_company_logo': has_company_logo,
            'has_questions': has_questions
        }])

        # 5. Inference
        probabilities = model.predict_proba(input_df)[0]
        fraud_score = float(probabilities[1])
        
        # We can set a structural threshold here (e.g., 0.50)
        is_fraud = bool(fraud_score >= 0.50)

        return jsonify({
            'success': True,
            'fraud_score': fraud_score,
            'is_fraud': is_fraud
        })

    except Exception as e:
        return jsonify({
            'success': False,
            'error': str(e)
        }), 500

if __name__ == '__main__':
    load_model()
    app.run(host='127.0.0.1', port=5000, debug=True)