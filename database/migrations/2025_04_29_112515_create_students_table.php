<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\Illuminate\Foundation\Auth\User::class)->constrained()->cascadeOnDelete();
            $table->string('profile_photo_path')->nullable();
            $table->enum('education_level', ['high_school', 'associate', 'bachelor', 'master', 'phd']);
            $table->string('institution');
            $table->string('field_of_study')->nullable();
            $table->date('graduation_date')->nullable();
            $table->text('skills')->nullable();
            $table->text('bio')->nullable();
            $table->string('resume_path')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('github_url')->nullable();
            $table->string('portfolio_url')->nullable();
            $table->string('phone')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};