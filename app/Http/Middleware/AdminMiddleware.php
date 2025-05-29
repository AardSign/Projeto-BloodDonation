<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Manipula uma solicitação recebida.
     */
    public function handle(Request $request, Closure $next)
    {
        // Verifica se o usuário está logado e se é do tipo admin (usertype = 1)
        if (Auth::check() && Auth::user()->usertype === '1') {
            return $next($request);
        }

        // Caso contrário, redireciona para a home com mensagem de erro
        return redirect('/')->with('message', 'Acesso não autorizado.');
    }
}
