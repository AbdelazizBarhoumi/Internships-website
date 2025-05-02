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
        Schema::table('applications', function (Blueprint $table) {
            // Add deleted_at column for soft deletes
            if (!Schema::hasColumn('applications', 'deleted_at')) {
                $table->softDeletes();
            }
            
            // Add other potentially missing columns used in your Application model
            if (!Schema::hasColumn('applications', 'field_of_study')) {
                $table->string('field_of_study')->nullable();
            }
            
            if (!Schema::hasColumn('applications', 'interview_date')) {
                $table->dateTime('interview_date')->nullable();
            }
            
            if (!Schema::hasColumn('applications', 'response_date')) {
                $table->dateTime('response_date')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            // Remove columns in reverse order
            if (Schema::hasColumn('applications', 'response_date')) {
                $table->dropColumn('response_date');
            }
            if (Schema::hasColumn('applications', 'interview_date')) {
                $table->dropColumn('interview_date');
            }
            
            if (Schema::hasColumn('applications', 'field_of_study')) {
                $table->dropColumn('field_of_study');
            }
            
            if (Schema::hasColumn('applications', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
};