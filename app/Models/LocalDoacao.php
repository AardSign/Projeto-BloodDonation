<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocalDoacao extends Model
{
    use HasFactory;

    
    protected $fillable = ['nome', 'endereco', 'cidade', 'estado', 'telefone'];

    protected $table = 'locais_doacao';

    public function agendamentos()
    {
    return $this->hasMany(\App\Models\Agendamento::class, 'local_doacao_id');
    }


}
