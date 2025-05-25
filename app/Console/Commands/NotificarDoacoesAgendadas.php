<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Models\Notification;
use Carbon\Carbon;

class NotificarDoacoesAgendadas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
   protected $signature = 'notificar:doacoes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notifica usuários com doações marcadas para hoje ou amanhã.';

    /**
     * Execute the console command.
     */
    


    public function handle()
    {
    $amanha = Carbon::tomorrow()->toDateString();
    $hoje = Carbon::today()->toDateString();


    // Notificações para doações de amanhã
    $agendamentosAmanha = Appointment::where('date', $amanha)
        ->where('status', 'Agendado')
        ->get();

    foreach ($agendamentosAmanha as $agendamento) {
        Notification::create([
            'user_id' => $agendamento->user_id,
            'titulo' => 'Doação Amanhã',
            'mensagem' => 'Você tem uma doação marcada para amanhã, dia ' . $agendamento->date . ' às ' . $agendamento->time . '.',
            'tipo' => 'lembrete_amanha',
        ]);
    }

    // Notificações para doações de hoje
    $agendamentosHoje = Appointment::where('date', $hoje)
        ->where('status', 'Agendado')
        ->get();

    foreach ($agendamentosHoje as $agendamento) {
        Notification::create([
            'user_id' => $agendamento->user_id,
            'titulo' => 'Doação Hoje',
            'mensagem' => 'Você tem uma doação marcada para hoje às ' . $agendamento->time . '.',
            'tipo' => 'lembrete_hoje',
        ]);
    }

    $this->info('Notificações de doações programadas enviadas com sucesso.');
    }
}
