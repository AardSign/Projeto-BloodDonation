<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with('user')->orderBy('date')->get();
        return view('admin.agendamentos', compact('appointments'));
    }

    public function create()
    {
        return view('admin.novo_agendamento');
    }

    public function store(Request $request)
    {
    $request->validate([
        'date' => 'required|date',
        'time' => 'required',
    ]);

    // Define o user_id com base no tipo de usuário
    if (Auth::user()->usertype == '1' && $request->filled('user_id')) {
        $userId = $request->user_id;
    } else {
        $userId = Auth::id();
    }

    //Regra 1: Verifica intervalo de 3 meses para o mesmo usuário
    $ultimoAgendamento = \App\Models\Appointment::where('user_id', $userId)
        ->where('status', '!=', 'Cancelado')
        ->orderByDesc('date')
        ->first();

    if ($ultimoAgendamento && Carbon::parse($ultimoAgendamento->date)->diffInDays(Carbon::parse($request->date)) < 90) {
        return redirect()->back()->with('message', 'Erro: O usuário já realizou uma doação recentemente. Deve aguardar 3 meses.');
    }

    // Regra 2: Limita número de agendamentos por data (ex: 10)
    $limite = 10;
    $agendamentosDoDia = \App\Models\Appointment::where('date', $request->date)
        ->where('status', 'Agendado')
        ->count();

    if ($agendamentosDoDia >= $limite) {
        return redirect()->back()->with('message', 'Erro: O limite de agendamentos para essa data já foi atingido.');
    }

    
    Appointment::create([
        'user_id' => $userId,
        'date' => $request->date,
        'time' => $request->time,
        'status' => 'Agendado',
    ]);

    return redirect()->back()->with('message', 'Agendamento criado com sucesso!');
    }

    public function edit($id)
    {
    $agendamento = Appointment::findOrFail($id);
    return view('admin.editar_agendamento', compact('agendamento'));
    }

    public function update(Request $request, $id)
    {
    $request->validate([
        'date' => 'required|date',
        'time' => 'required',
        'status' => 'required|in:Agendado,Cancelado,Concluído',
    ]);

    $agendamento = Appointment::findOrFail($id);
    $agendamento->update([
        'date' => $request->date,
        'time' => $request->time,
        'status' => $request->status,
    ]);

    return redirect('/agendamentos')->with('message', 'Agendamento atualizado com sucesso.');
    }
    
    public function agendamentosMarcados()
    {
    $agendamentos = Appointment::with('user')
        ->where('status', 'Agendado')
        ->orderBy('date')
        ->get();

    return view('admin.agendamentos_marcados', compact('agendamentos'));
    }

    public function concluir($id)
    {
    $agendamento = Appointment::findOrFail($id);
    $agendamento->status = 'Concluído';
    $agendamento->save();

    return redirect()->back()->with('message', 'Agendamento marcado como concluído.');
    }



    public function cancel($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'Cancelado';
        $appointment->save();

        return redirect()->back()->with('message', 'Agendamento cancelado.');
    }

    
}