<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DisponibilidadeController extends Controller
{
    public function index(Request $request)
    {
        // Define o intervalo de verificação (ex: próximos 30 dias)
        $hoje = Carbon::today();
        $futuro = $hoje->copy()->addDays(30);

        // Recupera agendamentos nesse intervalo
        $agendamentos = Appointment::whereBetween('date', [$hoje, $futuro])
            ->where('status', 'Agendado')
            ->get();

        // Inicializa arrays para resposta
        $diasCheios = [];
        $horariosIndisponiveis = [];

        // Agrupa agendamentos por data e hora
        foreach ($agendamentos as $agendamento) {
            $data = $agendamento->date;
            $hora = Carbon::parse($agendamento->time)->format('H:i');

            // Conta por data
            if (!isset($diasCheios[$data])) {
                $diasCheios[$data] = 0;
            }
            $diasCheios[$data]++;

            // Conta por data/hora
            $key = $data . ' ' . $hora;
            if (!isset($horariosIndisponiveis[$key])) {
                $horariosIndisponiveis[$key] = 0;
            }
            $horariosIndisponiveis[$key]++;
        }

        // Filtra dias com 18 ou mais agendamentos
        $datasBloqueadas = array_keys(array_filter($diasCheios, fn($qtd) => $qtd >= 18));

        // Filtra horários com 2 ou mais agendamentos
        $horariosBloqueados = [];
        foreach ($horariosIndisponiveis as $key => $qtd) {
            if ($qtd >= 2) {
                [$data, $hora] = explode(' ', $key);
                if (!isset($horariosBloqueados[$data])) {
                    $horariosBloqueados[$data] = [];
                }
                $horariosBloqueados[$data][] = $hora;
            }
        }

        return response()->json([
            'datas_bloqueadas' => $datasBloqueadas,
            'horarios_bloqueados' => $horariosBloqueados,
        ]);
    }
}