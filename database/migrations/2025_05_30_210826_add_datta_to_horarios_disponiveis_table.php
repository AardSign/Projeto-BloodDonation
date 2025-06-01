<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::table('horarios_disponiveis', function (Blueprint $table) {
            $table->date('data')->default('2025-01-01')->after('local_doacao_id');
        });
    }


    public function down()
    {
        Schema::table('horarios_disponiveis', function (Blueprint $table) {
            $table->dropColumn('data');
        });
    }

};
