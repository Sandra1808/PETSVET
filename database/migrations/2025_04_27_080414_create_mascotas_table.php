<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mascotas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('microchip')->unique();
            $table->string('dni_dueño');
            $table->date('fecha_nacimiento');
            $table->enum('sexo', ['Macho', 'Hembra']);
            $table->string('imagen')->nullable();
            $table->string('especie')->nullable(); // Perro, Gato, Otros
            $table->string('domicilio')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mascotas');
    }
};
