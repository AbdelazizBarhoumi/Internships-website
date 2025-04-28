<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Employer;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('internships', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Employer::class, 'employer_id')->constrained('employers')->cascadeOnDelete();
            $table->string('title');
            $table->string('salary');
            $table->string('location');
            $table->string('schedule');
            $table->string('url');
            $table->text('description')->nullable();
            $table->string('duration')->nullable();
            $table->date('deadline')->nullable();
            $table->integer('positions')->nullable();
            $table->boolean('featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internships');
    }
};