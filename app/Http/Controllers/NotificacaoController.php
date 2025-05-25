<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificacaoController extends Controller
{
    /**
     * Lista todas as notificações do usuário autenticado.
     */
    public function index()
    {
        $notificacoes = Notification::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('notificacoes.index', compact('notificacoes'));
    }

    /**
     * Marca uma notificação como lida e redireciona de volta.
     */
    public function visualizar($id)
    {
        $notificacao = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $notificacao->update(['lida' => true]);

        return redirect()->back()->with('message', 'Notificação marcada como lida.');
    }

    /**
     * Marca todas as notificações como lidas (opcional).
     */
    public function marcarTodasComoLidas()
    {
        Notification::where('user_id', Auth::id())
            ->where('lida', false)
            ->update(['lida' => true]);

        return redirect()->back()->with('message', 'Todas as notificações foram marcadas como lidas.');
    }

    /**
     * Remove uma notificação específica (opcional).
     */
    public function deletar($id)
    {
        $notificacao = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $notificacao->delete();

        return redirect()->back()->with('message', 'Notificação removida.');
    }
}
