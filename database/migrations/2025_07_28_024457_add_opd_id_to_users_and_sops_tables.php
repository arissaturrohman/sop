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
            $table->foreignId('opd_id')->nullable()->constrained()->nullOnDelete();
        });
        
        Schema::table('sops', function (Blueprint $table) {
            $table->foreignId('opd_id')->nullable()->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users_and_sops_tables', function (Blueprint $table) {
            //
        });
    }
};
