<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoMedico extends Model
{
    use HasFactory;

    protected $table = 'historico_medico';

    protected $fillable = [
        'user_id',
        'usa_insulina',
        'tem_doenca_cardiaca',
        'tem_doenca_infecciosa',
        'peso',
        'usa_medicamentos',
        'data_ultima_transfusao',
        'teve_cancer',
        'doencas_autoimunes',
        'historico_convulsoes',
        'pode_doar',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
