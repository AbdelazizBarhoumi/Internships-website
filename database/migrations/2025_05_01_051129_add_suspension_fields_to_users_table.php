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
        Schema::table('users', function (Blueprint $table) {
            // Check if columns don't exist before adding them
            if (!Schema::hasColumn('users', 'last_login_at')) {
                $table->timestamp('last_login_at')->nullable();
            }
            
            if (!Schema::hasColumn('users', 'suspension_reason')) {
                $table->text('suspension_reason')->nullable();
            }
            
            if (!Schema::hasColumn('users', 'suspension_date')) {
                $table->timestamp('suspension_date')->nullable();
            }
            
            if (!Schema::hasColumn('users', 'suspension_end_date')) {
                $table->timestamp('suspension_end_date')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop columns in reverse order
            if (Schema::hasColumn('users', 'suspension_end_date')) {
                $table->dropColumn('suspension_end_date');
            }
            
            if (Schema::hasColumn('users', 'suspension_date')) {
                $table->dropColumn('suspension_date');
            }
            
            if (Schema::hasColumn('users', 'suspension_reason')) {
                $table->dropColumn('suspension_reason');
            }
            
            if (Schema::hasColumn('users', 'last_login_at')) {
                $table->dropColumn('last_login_at');
            }
        });
    }
};