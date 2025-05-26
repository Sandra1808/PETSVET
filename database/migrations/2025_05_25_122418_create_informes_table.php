<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('informes', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('historial_id');
        $table->unsignedBigInteger('cita_id')->nullable();
        $table->unsignedBigInteger('veterinario_id')->nullable();
        $table->text('diagnostico')->nullable();
        $table->text('procedimientos')->nullable();
        $table->text('medicamentos')->nullable();
        $table->text('tratamiento')->nullable();
        $table->text('recomendaciones')->nullable();
        $table->text('observaciones')->nullable();
        $table->date('proxima_cita')->nullable();
        $table->string('archivo_pdf')->nullable();
        $table->timestamps();

        $table->foreign('historial_id')->references('id')->on('historiales')->onDelete('cascade');
        $table->foreign('cita_id')->references('id')->on('citas')->onDelete('set null');
        $table->foreign('veterinario_id')->references('id')->on('users')->onDelete('set null');
    });
}
};
