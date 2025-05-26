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
        Schema::table('historiales', function (Blueprint $table) {
            $table->unsignedBigInteger('propietario_id')->after('mascota_id'); // Agregar la columna
            $table->foreign('propietario_id')->references('id')->on('users'); // Clave foránea
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historiales', function (Blueprint $table) {
            $table->dropForeign(['propietario_id']); // Eliminar clave foránea
            $table->dropColumn('propietario_id'); // Eliminar columna
        });
    }
};
