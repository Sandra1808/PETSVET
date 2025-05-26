<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('historiales', function (Blueprint $table) {
        $table->unsignedBigInteger('cita_id')->nullable()->after('propietario_id');
        $table->unsignedBigInteger('veterinario_id')->nullable()->after('cita_id');
    });
}
public function down()
{
    Schema::table('historiales', function (Blueprint $table) {
        $table->dropColumn(['cita_id', 'veterinario_id']);
    });
}
};
