<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHorarioDisponivelIdToAppointments extends Migration
{
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            if (!Schema::hasColumn('appointments', 'horario_disponivel_id')) {
                $table->foreignId('horario_disponivel_id')->nullable()
                      ->constrained('horarios_disponiveis')
                      ->onDelete('set null');
            }
        });
    }

    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            if (Schema::hasColumn('appointments', 'horario_disponivel_id')) {
                $table->dropForeign(['horario_disponivel_id']);
                $table->dropColumn('horario_disponivel_id');
            }
        });
    }
}
