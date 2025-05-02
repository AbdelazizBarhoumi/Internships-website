<?php
// Create a new migration
// Run this in terminal:
// php artisan make:migration add_view_count_to_internships_table

// The generated migration file should look like this:
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddViewCountToInternshipsTable extends Migration
{
    public function up()
    {
        Schema::table('internships', function (Blueprint $table) {
            $table->unsignedInteger('view_count')->default(0)->after('is_active');
        });
    }

    public function down()
    {
        Schema::table('internships', function (Blueprint $table) {
            $table->dropColumn('view_count');
        });
    }
}