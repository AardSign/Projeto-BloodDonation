
<?php
/**
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('appointments', function (Blueprint $table) {
        $table->foreignId('local_doacao_id')
              ->nullable()
              ->constrained('locais_doacao')
              ->onDelete('set null');
    });
}

public function down(): void
{
    Schema::table('appointments', function (Blueprint $table) {
        $table->dropForeign(['local_doacao_id']);
        $table->dropColumn('local_doacao_id');
    });
}

};

     * Run the migrations.
     */