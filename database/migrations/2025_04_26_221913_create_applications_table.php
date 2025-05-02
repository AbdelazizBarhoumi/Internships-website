<?php

use App\Models\Internship;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'user_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Internship::class, 'internship_id')->constrained()->cascadeOnDelete();
            $table->string('profile_photo_path')->nullable()->after('transcript_path');

            // Personal Information
            $table->string('phone');
            $table->date('availability');
            
            // Education
            $table->enum('education', ['high_school', 'associate', 'bachelor', 'master', 'phd']);
            $table->string('institution');
            
            // Skills & Experience
            $table->text('skills');
            
            // Documents
            $table->string('resume_path');
            $table->text('cover_letter')->nullable();
            $table->string('transcript_path')->nullable();
            
            // Why interested
            $table->text('why_interested');
            
            // Application Status
            $table->enum('status', ['pending', 'reviewing', 'interviewed', 'accepted', 'rejected'])
                  ->default('pending');
            $table->text('notes')->nullable();
            $table->text('admin_notes')->nullable();
            
            $table->softDeletes();



            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};