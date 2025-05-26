<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historiales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mascota_id')->constrained('mascotas')->onDelete('cascade');
            $table->string('tipo'); // Vacunación, Consulta, Desparasitación, Revisión
            $table->text('descripcion');
            $table->date('fecha');
            $table->string('archivo_pdf')->nullable(); // Ruta del archivo PDF generado
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historiales');
    }
};
