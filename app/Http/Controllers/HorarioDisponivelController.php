<?php

namespace App\Http\Controllers;

use App\Models\HorarioDisponivel;
use App\Models\LocalDoacao;
use App\Models\User;
use Illuminate\Http\Request;

class HorarioDisponivelController extends Controller
{
    public function index(Request $request)
    {
        $query = HorarioDisponivel::with('local');

        if ($request->filled('filtro_local')) {
            $query->where('local_doacao_id', $request->filtro_local);
        }

        if ($request->filled('filtro_data')) {
            $query->whereDate('data', $request->filtro_data);
        }

        $horarios = $query->orderBy('data')->orderBy('horario')->get();
        $locais = LocalDoacao::all();

        return view('horarios.index', compact('horarios', 'locais'));
    }


    public function create()
    {
        $locais = LocalDoacao::all();
        return view('horarios.create', compact('locais'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'local_doacao_id' => 'required|exists:locais_doacao,id',
            'horario' => 'required|date_format:H:i',
            'turno' => 'required|in:AM,PM',
            'nome_doutor' => 'nullable|string|max:255',
            'limite' => 'required|integer|in:1,2',
            'data' => 'required|date|after_or_equal:today',
        ]);

        HorarioDisponivel::create($request->all());

        return redirect()->route('horarios.index')->with('message', 'Horário criado com sucesso.');
    }

        public function disponiveis(Request $request)
    {
        $request->validate([
            'local_id' => 'required|exists:locais_doacao,id',
            'data' => 'required|date',
        ]);

        $horarios = HorarioDisponivel::withCount([
            'agendamentos as total_agendados' => function ($query) use ($request) {
                $query->where('status', 'Marcado')
                    ->where('date', $request->data);
            }
        ])
        ->where('local_doacao_id', $request->local_id)
        ->whereDate('data', $request->data)
        ->orderBy('horario')
        ->get();

        $response = $horarios->map(function ($h) {
            return [
                'id' => $h->id,
                'horario' => $h->horario,
                'nome_doutor' => $h->nome_doutor,
                'turno' => $h->turno,
                'limite' => $h->limite,
                'total_agendados' => $h->total_agendados,
                'data' => $h->data,
            ];
        });

        return response()->json($response);
    }





    public function destroy($id)
    {
        $horario = HorarioDisponivel::findOrFail($id);
        $horario->delete();

        return back()->with('message', 'Horário removido.');
    }

    public function edit($id)
    { 
        $horario = HorarioDisponivel::findOrFail($id);
        $locais = LocalDoacao::all();

        return view('horarios.edit', compact('horario', 'locais'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'local_doacao_id' => 'required|exists:locais_doacao,id',
            'horario' => 'required|date_format:H:i',
            'turno' => 'required|in:AM,PM',
            'nome_doutor' => 'nullable|string|max:255',
            'limite' => 'required|integer|in:1,2',
            'data' => 'required|date|after_or_equal:today',
        ]);

        $horario = HorarioDisponivel::findOrFail($id);
        $horario->update($request->all());

        return redirect()->route('horarios.index')->with('message', 'Horário atualizado com sucesso.');
    }

    
}
