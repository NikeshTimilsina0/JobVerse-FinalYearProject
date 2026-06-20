<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('user_jobs')->onDelete('restrict');
            $table->foreignId('seeker_id')->constrained('users')->onDelete('cascade');
            $table->text('cover_letter')->nullable();
            $table->enum('status', ['applied', 'shortlisted', 'rejected', 'accepted'])->default('applied');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};