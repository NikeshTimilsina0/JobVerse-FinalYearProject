import re
import os
import pandas as pd
import numpy as np
import kagglehub
from sklearn.model_selection import train_test_split
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.compose import ColumnTransformer
from sklearn.pipeline import Pipeline
from sklearn.metrics import classification_report, roc_auc_score
from sklearn.calibration import CalibratedClassifierCV
from lightgbm import LGBMClassifier
import joblib

def load_and_process_kagglehub_data():
    base_path = kagglehub.dataset_download("shivamb/real-or-fake-fake-jobposting-prediction")
    csv_path = os.path.join(base_path, 'fake_job_postings.csv')

    print(f"Loading data from verified path: {csv_path}")
    df = pd.read_csv(csv_path)

    text_cols = ['title', 'company_profile', 'description', 'requirements']
    for col in text_cols:
        df[col] = df[col].fillna('')

    df['combined_text'] = (
        df['title'] + " " +
        df['company_profile'] + " " +
        df['description'] + " " +
        df['requirements']
    )

    def clean_text(text):
        text = text.lower()
        text = re.sub(r'[^a-z0-9\s]', '', text)
        return text

    df['combined_text'] = df['combined_text'].apply(clean_text)

    meta_cols = ['telecommuting', 'has_company_logo', 'has_questions']
    for col in meta_cols:
        df[col] = df[col].fillna(0).astype(int)

    return df

def build_calibrated_pipeline():
    text_transformer = TfidfVectorizer(max_features=5000, stop_words='english', ngram_range=(1, 2))
    meta_features = ['telecommuting', 'has_company_logo', 'has_questions']

    preprocessor = ColumnTransformer(
        transformers=[
            ('text', text_transformer, 'combined_text'),
            ('meta', 'passthrough', meta_features)
        ]
    )

    # Base LightGBM classifier optimized for multi-threading overhead reduction
    base_classifier = LGBMClassifier(
        n_estimators=200,
        learning_rate=0.05,
        scale_pos_weight=15,
        random_state=42,
        n_jobs=-1,
        force_col_wise=True
    )

    # CalibratedClassifierCV wrapper prevents overconfident false positives
    calibrated_classifier = CalibratedClassifierCV(
        estimator=base_classifier,
        method='sigmoid',
        cv=3
    )

    pipeline = Pipeline(steps=[
        ('preprocessor', preprocessor),
        ('classifier', calibrated_classifier)
    ])

    return pipeline

if __name__ == "__main__":
    df = load_and_process_kagglehub_data()

    X = df[['combined_text', 'telecommuting', 'has_company_logo', 'has_questions']]
    y = df['fraudulent']

    X_train, X_test, y_train, y_test = train_test_split(
        X, y, test_size=0.2, stratify=y, random_state=42
    )

    print("Training Calibrated LightGBM hybrid pipeline...")
    pipeline = build_calibrated_pipeline()
    pipeline.fit(X_train, y_train)

    preds = pipeline.predict(X_test)
    probs = pipeline.predict_proba(X_test)[:, 1]

    print("\n=== Model Evaluation Performance ===")
    print(classification_report(y_test, preds, target_names=['Legitimate', 'Fraudulent']))
    print(f"Area Under ROC Curve (ROC-AUC): {roc_auc_score(y_test, probs):.4f}")

    output_dir = '/kaggle/working' if os.path.exists('/kaggle/working') else '.'
    joblib.dump(pipeline, os.path.join(output_dir, 'real_job_fraud_detector.pkl'))
    print(f"\nModel artifacts saved to: {os.path.join(output_dir, 'real_job_fraud_detector.pkl')}")