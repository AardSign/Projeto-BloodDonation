<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\LocalDoacao;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Notification;


class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['user', 'local']);

        if ($request->filled('q')) {
            $search = $request->q;

            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($sub) use ($search) {
                    $sub->where('name', 'like', "%$search%");
                })
                ->orWhereHas('local', function ($sub) use ($search) {
                    $sub->where('nome', 'like', "%$search%");
                })
                ->orWhere('status', 'like', "%$search%")
                ->orWhereDate('date', $search)
                ->orWhereTime('time', $search);
            });
        }

        $appointments = $query->orderBy('date')->get();

        return view('agendamentos.index', compact('appointments'));
    }


    
        public function create()
    {   
    $user = auth()->user()->load('historicoMedico');
    $locais = LocalDoacao::orderBy('nome')->get();

    // Apenas impede se o histórico EXISTIR e indicar que NÃO pode doar
    if ($user->historicoMedico && !$user->historicoMedico->pode_doar) {
        return redirect('/meus-agendamentos')
            ->with('message', 'Você está temporariamente inapto para doar sangue.');
    }

    return view('agendamentos.create', compact('locais', 'user'));
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

    $historico = $usuario->historicoMedico;
    if ($historico && !$historico->pode_doar) {
        return redirect()->back()->with('message', 'Erro: O doador selecionado está inapto para doar conforme seu histórico médico.');
    }


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
        ->where('status', 'Marcado')
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

    Notification::create([
    'user_id' => $userId,
    'titulo' => 'Doação Marcada',
    'mensagem' => 'Você tem uma doação marcada para o dia ' . Carbon::parse($request->date)->format('d/m/Y') . ' às ' . $request->time . '.',
    'tipo' => 'lembrete',
    ]);

    // Notificação para todos os admins
    $admins = \App\Models\User::where('usertype', '1')->get();
    foreach ($admins as $admin) {
        Notification::create([
            'user_id' => $admin->id,
            'titulo' => 'Novo Agendamento',
            'mensagem' => 'O doador ' . $usuario->name . ' marcou uma doação para o dia ' . Carbon::parse($request->date)->format('d/m/Y') . ' às ' . $request->time . '.',
            'tipo' => 'admin_alerta',
        ]);
    }

    if (Auth::user()->usertype == '1') {
        return redirect()->route('agendamentos.index')->with('success', 'Agendamento criado com sucesso!');
    } else {
        return redirect('/meus-agendamentos')->with('success', 'Agendamento criado com sucesso!');
    }
}

    public function edit($id)
    {
        $agendamento = Appointment::findOrFail($id);

        if ($agendamento->status === 'Cancelado') {
            return redirect()->back()->with('message', 'Agendamentos cancelados não podem ser editados.');
        }

        
        $locais = LocalDoacao::orderBy('nome')->get();
        return view('agendamentos.edit', compact('agendamento', 'locais'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'status' => 'required|in:Marcado,Cancelado,Concluído',
            'local_doacao_id' => 'required|exists:locais_doacao,id',
        ]);

        $agendamento = Appointment::findOrFail($id);
        $agendamento->update([
            'date' => $request->date,
            'time' => $request->time,
            'status' => $request->status,
            'local_doacao_id' => $request->local_doacao_id,
        ]);

      
        Notification::create([
            'user_id' => $agendamento->user_id,
            'titulo' => 'Agendamento Atualizado',
            'mensagem' => 'Seu agendamento foi remarcado para o dia ' . Carbon::parse($request->date)->format('d/m/Y') . ' às ' . $request->time . '.',
            'tipo' => 'remarcada',
        ]);

      
        $usuario = $agendamento->user;
        $admins = \App\Models\User::where('usertype', '1')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'titulo' => 'Agendamento remarcado',
                'mensagem' => 'O doador ' . $usuario->name . ' teve o agendamento remarcado para ' . Carbon::parse($request->date)->format('d/m/Y') . ' às ' . $request->time . '.',
                'tipo' => 'admin_alerta',
            ]);
        }

        return redirect('/agendamentos')->with('message', 'Agendamento Remarcado com sucesso.');
    }


    public function agendamentosMarcados()
    {
        $agendamentos = Appointment::with(['user', 'local'])
            ->where('status', 'Marcado')
            ->orderBy('date')
            ->get();

        return view('agendamentos.marcados', compact('agendamentos'));
    }

    public function concluir($id)
    {
        $agendamento = Appointment::findOrFail($id);
        $agendamento->status = 'Concluído';
        $agendamento->save();

        
        Notification::create([
            'user_id' => $agendamento->user_id,
            'titulo' => 'Doação Concluída',
            'mensagem' => 'Sua doação realizada em ' . Carbon::parse($agendamento->date)->format('d/m/Y') . ' foi concluída com sucesso. Obrigado por contribuir!',
            'tipo' => 'concluida',
        ]);

        $user = $agendamento->user;
        $intervalo = $user->sexo === 'M' ? 60 : 90;
        $proximaData = Carbon::parse($agendamento->date)->addDays($intervalo)->format('d/m/Y');

        
        Notification::create([
            'user_id' => $user->id,
            'titulo' => 'Próxima Doação Permitida',
            'mensagem' => 'Você poderá doar novamente a partir de ' . Carbon::parse($proximaData)->format('d/m/Y') . '.',
            'tipo' => 'liberado',
        ]);

        
        $admins = \App\Models\User::where('usertype', '1')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'titulo' => 'Doação Concluída',
                'mensagem' => 'O doador ' . $user->name . ' concluiu sua doação no dia ' . Carbon::parse($agendamento->date)->format('d/m/Y') . '.',
                'tipo' => 'admin_alerta',
            ]);
        }

        return redirect()->back()->with('message', 'Agendamento marcado como concluído.');
    }


    public function meusAgendamentos()
    {
    $appointments = Appointment::with('local')
        ->where('user_id', auth()->id())
        ->orderByDesc('date')
        ->get();

    return view('user.meus_agendamentos', compact('appointments'));
    }

    public function remarcar(Request $request, $id)
    {
    $agendamento = Appointment::findOrFail($id);

    if ($agendamento->user_id !== Auth::id()) {
        abort(403, 'Acesso negado.');
    }

    $request->validate([
        'date' => ['required', 'date', 'after_or_equal:' . now()->toDateString()],
        'time' => ['required', 'date_format:H:i'],
    ]);

    $hora = Carbon::parse($request->time)->format('H:i');
    if ($hora < '08:00' || $hora > '17:00') {
        return redirect()->back()->with('message', 'Erro: O horário deve estar entre 08:00 e 17:00.');
    }

    $totalNoHorario = Appointment::where('date', $request->date)
        ->where('time', $request->time)
        ->where('status', 'Marcado')
        ->count();

    if ($totalNoHorario >= 2) {
        return redirect()->back()->with('message', 'Erro: Este horário já está com o limite de agendamentos atingido.');
    }

    $agendamento->update([
        'date' => $request->date,
        'time' => $request->time,
    ]);

    Notification::create([
    'user_id' => $agendamento->user_id,
    'titulo' => 'Doação Remarcada',
    'mensagem' => 'Sua doação foi remarcada para ' . Carbon::parse($request->date)->format('d/m/Y') . ' às ' . $request->time . '.',
    'tipo' => 'remarcada',
    ]);

    $usuario = $agendamento->user; 
    $admins = \App\Models\User::where('usertype', '1')->get();
    foreach ($admins as $admin) {
        Notification::create([
            'user_id' => $admin->id,
            'titulo' => 'Doação Remarcada',
            'mensagem' => 'O doador ' . $usuario->name . ' remarcou sua doação para ' . Carbon::parse($request->date)->format('d/m/Y') . ' às ' . $request->time . '.',
            'tipo' => 'admin_alerta',
        ]);
    }

    return redirect('/meus-agendamentos')->with('success', 'Agendamento remarcado com sucesso!');
    }

    public function formRemarcar($id)
    {
    $agendamento = Appointment::findOrFail($id);

    // Verifica se o agendamento pertence ao usuário logado
    if (auth()->user()->id !== $agendamento->user_id) {
        abort(403);
    }

    return view('user.remarcar_agendamento', compact('agendamento'));
    }

   public function remarcarAgendamento(Request $request, $id)
    {
    $request->validate([
        'date' => 'required|date|after_or_equal:today',
        'time' => 'required'
    ]);

    $agendamento = Appointment::findOrFail($id);

    // (Regra: só pode remarcar se ainda estiver "Marcado")
    if ($agendamento->status !== 'Marcado') {
        return redirect()->back()->with('message', 'Este agendamento não pode ser remarcado.');
    }

    $novaData = $request->date;
    $novoHorario = $request->time;

    // Verifica se já existem 2 agendamentos para o mesmo horário (excluindo o atual)
    $conflitoHorario = Appointment::where('date', $novaData)
        ->where('time', $novoHorario)
        ->where('status', 'Marcado')
        ->where('id', '!=', $agendamento->id)
        ->count();

    if ($conflitoHorario >= 2) {
        return redirect()->back()->with('message', 'Este horário já está cheio.');
    }

    // Verifica se o dia já tem 18 agendamentos (2 por hora entre 08h e 17h)
    $totalDoDia = Appointment::where('date', $novaData)
        ->where('status', 'Marcado')
        ->where('id', '!=', $agendamento->id)
        ->count();

    if ($totalDoDia >= 18) {
        return redirect()->back()->with('message', 'Este dia já atingiu o número máximo de agendamentos.');
    }

    // Atualiza o agendamento com os novos dados
    $agendamento->date = $novaData;
    $agendamento->time = $novoHorario;
    $agendamento->save();

    Notification::create([
    'user_id' => $agendamento->user_id,
    'titulo' => 'Doação Remarcada',
    'mensagem' => 'Sua doação foi remarcada para ' . $novaData . ' às ' . $novoHorario . '.',
    'tipo' => 'remarcada',
    ]);

    $usuario = $agendamento->user;
    $admins = \App\Models\User::where('usertype', '1')->get();
    foreach ($admins as $admin) {
        Notification::create([
            'user_id' => $admin->id,
            'titulo' => 'Doação Remarcada',
            'mensagem' => 'O doador ' . $usuario->name . ' remarcou sua doação para ' . $novaData . ' às ' . $novoHorario . '.',
            'tipo' => 'admin_alerta',
        ]);
    }

    return redirect('/meus-agendamentos')->with('success', 'Agendamento remarcado com sucesso!');
    }



    public function cancel($id)
    {
        $appointment = Appointment::findOrFail($id);

        if ($appointment->status === 'Cancelado') {
            return redirect()->back()->with('message', 'Este agendamento já está cancelado.');
        }

        $appointment->status = 'Cancelado';
        $appointment->save();

        Notification::create([
            'user_id' => $appointment->user_id,
            'titulo' => 'Doação Cancelada',
            'mensagem' => 'Sua doação agendada para ' . Carbon::parse($appointment->date)->format('d/m/Y') . ' foi cancelada.',
            'tipo' => 'cancelada',
        ]);

        // Notificação para os admins
        $usuario = $appointment->user;
        $admins = \App\Models\User::where('usertype', '1')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'titulo' => 'Doação Cancelada',
                'mensagem' => 'O doador ' . $usuario->name . ' cancelou sua doação marcada para ' . Carbon::parse($appointment->date)->format('d/m/Y') . '.',
                'tipo' => 'admin_alerta',
            ]);
        }

        return redirect()->back()->with('message', 'Agendamento cancelado.');
    }

}

