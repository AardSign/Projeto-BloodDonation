<?php
 
    
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   

     
    public function up(): void
    {
        Schema::create('locais_doacao', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('endereco');
            $table->string('cidade')->nullable();
            $table->string('estado')->nullable();
            $table->string('telefone')->nullable();
            $table->timestamps();
        });

    }

   
    public function down(): void
    {
        Schema::dropIfExists('local_doacaos');
    }
};