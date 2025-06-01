<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
    {
        Schema::create('horarios_disponiveis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('local_doacao_id')->constrained('locais_doacao')->onDelete('cascade');
            $table->time('horario');
            $table->enum('turno', ['AM', 'PM']);
            $table->string('nome_doutor')->nullable(); 
            $table->unsignedInteger('limite')->default(2);
            $table->boolean('disponivel')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('horarios_disponiveis');
    }
    
};
