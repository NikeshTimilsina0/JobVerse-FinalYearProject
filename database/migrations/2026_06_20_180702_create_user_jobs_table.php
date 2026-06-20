<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employer_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->text('requirements')->nullable();
            $table->string('salary_range')->nullable();
            $table->string('location')->nullable();
            $table->decimal('fraud_score', 5, 4)->default(0.0000);
            $table->boolean('is_fraud')->default(false);
            $table->boolean('is_visible')->default(true);
            $table->boolean('admin_override')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_jobs');
    }
};