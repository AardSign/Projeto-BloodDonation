<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'time',
        'status',
        'local_doacao_id',
    ];

    // Relacionamento: um agendamento pertence a um usuário (doador)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacionamento: um agendamento pertence a um local de doação
    public function local()
    {
        return $this->belongsTo(LocalDoacao::class, 'local_doacao_id');
    }
}
