<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('historico_medico', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->boolean('usa_insulina')->default(false);
            $table->boolean('tem_doenca_cardiaca')->default(false);
            $table->string('tem_doenca_infecciosa')->nullable();
            $table->decimal('peso', 5, 2)->nullable();
            $table->text('usa_medicamentos')->nullable();
            $table->date('data_ultima_transfusao')->nullable();
            $table->boolean('teve_cancer')->default(false);
            $table->text('doencas_autoimunes')->nullable();
            $table->boolean('historico_convulsoes')->default(false);
            $table->boolean('pode_doar')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historico_medico');
    }
};
