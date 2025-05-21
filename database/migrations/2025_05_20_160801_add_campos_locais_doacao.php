<?php

/**
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    
    public function up(): void
    {
        Schema::table('locais_doacao', function (Blueprint $table) {
            $table->string('nome')->nullable();
            $table->string('endereco')->nullable();
            $table->string('cidade')->nullable();
            $table->string('estado')->nullable();
            $table->string('telefone')->nullable();
        });

    }

  
     * Reverse the migrations.
    
    public function down(): void
    {
        //
    }
}; */
