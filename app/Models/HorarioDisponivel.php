<?php  

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HorarioDisponivel extends Model
{
    protected $table = 'horarios_disponiveis';

    protected $fillable = [
        'local_doacao_id',
        'data',
        'horario',
        'turno',
        'nome_doutor',
        'limite',
        'disponivel',
    ];

    protected $casts = [
        'data' => 'date', 
    ];

    public function local()
    {
        return $this->belongsTo(LocalDoacao::class, 'local_doacao_id');
    }

    public function agendamentos()
    {
        return $this->hasMany(Appointment::class, 'horario_disponivel_id');
    }

    public function atualizarDisponibilidade()
    {
        $agendados = Appointment::where('horario_disponivel_id', $this->id)
            ->where('date', $this->data)
            ->where('status', 'Marcado')
            ->count();

        if ($agendados >= $this->limite && $this->disponivel) {
            $this->disponivel = false;
            $this->save();
        } elseif ($agendados < $this->limite && !$this->disponivel) {
            $this->disponivel = true;
            $this->save();
        }
    }
}
