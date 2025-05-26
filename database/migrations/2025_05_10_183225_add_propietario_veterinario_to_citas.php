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
        Schema::table('citas', function (Blueprint $table) {
            $table->unsignedBigInteger('propietario_id')->after('mascota_id');
            $table->unsignedBigInteger('veterinario_id')->after('propietario_id');

            $table->foreign('propietario_id')->references('id')->on('users');
            $table->foreign('veterinario_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->dropForeign(['propietario_id']);
            $table->dropForeign(['veterinario_id']);
            $table->dropColumn('propietario_id');
            $table->dropColumn('veterinario_id');
        });
    }
};
