<?php
  
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
{
    Schema::create('appointments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // doador ou admin que criou
        $table->date('date');
        $table->time('time');
        $table->string('status')->default('Agendado'); // Agendado, Cancelado, Realizado
        $table->timestamps();
    });
}

  
    
     
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};