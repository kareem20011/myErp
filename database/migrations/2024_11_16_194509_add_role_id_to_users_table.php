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
            // Adding a role_id column with foreign key constraints
            $table->unsignedBigInteger('role_id')->nullable();
            $table->foreign('role_id')
                ->references('id')->on('roles')
                ->onDelete('restrict'); // Set role_id to null if the role is deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Dropping the foreign key and the column
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });
    }
};
