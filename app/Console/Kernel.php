<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\NotificarDoacoesAgendadas; // <-- IMPORTANTE

class Kernel extends ConsoleKernel
{
    /**
     * Registrar comandos personalizados.
     */
    protected $commands = [
        NotificarDoacoesAgendadas::class,
    ];

    /**
     * Agendamento de tarefas.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('notificar:doacoes')->dailyAt('08:00');
    }

    /**
     * Carrega os comandos da pasta Commands.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
