<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('historiales', function (Blueprint $table) {
        $table->text('diagnostico')->nullable();
        $table->text('procedimientos')->nullable();
        $table->text('medicamentos')->nullable();
        $table->text('tratamiento')->nullable();
        $table->text('recomendaciones')->nullable();
        $table->text('observaciones')->nullable();
        $table->date('proxima_cita')->nullable();
    });
}

public function down()
{
    Schema::table('historiales', function (Blueprint $table) {
        $table->dropColumn([
            'diagnostico',
            'procedimientos',
            'medicamentos',
            'tratamiento',
            'recomendaciones',
            'observaciones',
            'proxima_cita'
        ]);
    });
}
};
