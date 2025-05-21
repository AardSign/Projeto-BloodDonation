<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\LocalDoacao;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['user', 'local'])->orderBy('date')->get();
        return view('agendamentos.index', compact('appointments'));
    }

    public function create()
    {
        $locais = LocalDoacao::orderBy('nome')->get();
        return view('agendamentos.create', compact('locais'));
    }

    public function store(Request $request)
    {
    $request->validate([
        'date' => 'required|date',
        'time' => 'required',
        'local_doacao_id' => 'required|exists:locais_doacao,id',
    ]);

    // Define o user_id com base no tipo de usuário (admin ou doador)
    $userId = (Auth::user()->usertype == '1' && $request->filled('user_id')) 
        ? $request->user_id 
        : Auth::id();

    $usuario = \App\Models\User::findOrFail($userId);

    // REGRA 1: Verifica idade e se é primeira doação antes dos 60
    $dataNascimento = Carbon::parse($usuario->data_nascimento);
    $idade = $dataNascimento->diffInYears(Carbon::now());

    if ($idade < 16 || $idade > 69) {
        return redirect()->back()->with('message', 'Erro: A idade permitida para doação é entre 16 e 69 anos.');
    }

    // REGRA 2: Se for primeira doação e tiver 60 anos ou mais, não pode
    $jaDoou = Appointment::where('user_id', $userId)->where('status', '!=', 'Cancelado')->exists();
    if (!$jaDoou && $idade >= 60) {
        return redirect()->back()->with('message', 'Erro: A primeira doação deve ocorrer antes dos 60 anos.');
    }

    // REGRA 3: Limite de doações por ano
    $anoAtual = Carbon::now()->year;
    $doacoesAno = Appointment::where('user_id', $userId)
        ->where('status', '!=', 'Cancelado')
        ->whereYear('date', $anoAtual)
        ->count();

    if ($usuario->sexo === 'M' && $doacoesAno >= 4) {
        return redirect()->back()->with('message', 'Erro: Homens podem doar no máximo 4 vezes por ano.');
    }
    if ($usuario->sexo === 'F' && $doacoesAno >= 3) {
        return redirect()->back()->with('message', 'Erro: Mulheres podem doar no máximo 3 vezes por ano.');
    }

    // REGRA 4: Verifica intervalo mínimo entre doações (por sexo)
    $ultima = Appointment::where('user_id', $userId)
        ->where('status', '!=', 'Cancelado')
        ->orderByDesc('date')
        ->first();

    if ($ultima) {
        $diasDesdeUltima = Carbon::parse($ultima->date)->diffInDays(Carbon::parse($request->date));

        if ($usuario->sexo === 'M' && $diasDesdeUltima < 60) {
            return redirect()->back()->with('message', 'Erro: Homens devem aguardar 60 dias entre doações.');
        }

        if ($usuario->sexo === 'F' && $diasDesdeUltima < 90) {
            return redirect()->back()->with('message', 'Erro: Mulheres devem aguardar 90 dias entre doações.');
        }
    }

    // REGRA 5: Limita número de agendamentos por data
    $limite = 18;
    $agendamentosDoDia = Appointment::where('date', $request->date)
        ->where('status', 'Agendado')
        ->count();

    if ($agendamentosDoDia >= $limite) {
        return redirect()->back()->with('message', 'Erro: O limite de agendamentos para essa data já foi atingido.');
    }

    // REGRA 6: Só pode marcar depois em uma data presente ou futura
    if (Carbon::parse($request->date)->isPast()) {
        return redirect()->back()->with('message', 'Erro: Não é possível agendar em datas passadas.');
    }

    // REGRA 7: Só pode marcar entre 08:00 AM e 17:00 PM    
    $hora = Carbon::parse($request->time)->format('H:i');
    if ($hora < '08:00' || $hora > '17:00') {
        return redirect()->back()->with('message', 'Erro: O horário deve estar entre 08:00 e 17:00.');
    }

    // Cria o agendamento
    Appointment::create([
        'user_id' => $userId,
        'date' => $request->date,
        'time' => $request->time,
        'status' => 'Marcado',
        'local_doacao_id' => $request->local_doacao_id,
    ]);

    return redirect()->route('agendamentos.index')->with('success', 'Agendamento criado com sucesso!');
    }


    public function edit($id)
    {
        $agendamento = Appointment::findOrFail($id);
        $locais = LocalDoacao::orderBy('nome')->get();

        return view('agendamentos.edit', compact('agendamento', 'locais'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'status' => 'required|in:Agendado,Cancelado,Concluído',
            'local_doacao_id' => 'required|exists:locais_doacao,id',
        ]);

        $agendamento = Appointment::findOrFail($id);
        $agendamento->update([
            'date' => $request->date,
            'time' => $request->time,
            'status' => $request->status,
            'local_doacao_id' => $request->local_doacao_id,
        ]);

        return redirect('/agendamentos')->with('message', 'Agendamento atualizado com sucesso.');
    }

    public function agendamentosMarcados()
    {
        $agendamentos = Appointment::with(['user', 'local'])
            ->where('status', 'Agendado')
            ->orderBy('date')
            ->get();

        return view('agendamentos.marcados', compact('agendamentos'));
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
