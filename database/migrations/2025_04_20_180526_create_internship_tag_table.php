<?php

use App\Models\Internship;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Tag;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('internship_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Internship::class)->constrained('internships')->cascadeOnDelete();
            $table->foreignIdFor(Tag::class)->constrained('tags')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internship_tag');
    }
};
