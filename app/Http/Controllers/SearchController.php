<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Appointment;

class SearchController extends Controller
{
    public function buscar(Request $request)
    {
        $q = $request->input('q');

        // Busca usuários com nome parecido
        $usuarios = User::where('name', 'LIKE', '%'.$q.'%')
            ->where('usertype', '0') // apenas doadores
            ->get();

        // Busca agendamentos relacionados a esses usuários
        $agendamentos = Appointment::whereIn('user_id', $usuarios->pluck('id'))
            ->with('user')
            ->get();

        return view('admin.resultados_busca', compact('usuarios', 'agendamentos', 'q'));
    }
}

