<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PerfilController extends Controller
{
    public function edit()
    {
        $usuario = Auth::user();
        return view('user.editar_perfil', compact('usuario'));
    }

    public function update(Request $request)
    {
        $usuario = Auth::user();

        $request->validate([
            'email' => 'required|email',
            'phone' => 'required|string|min:10',
            'address' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $usuario->email = $request->email;
        $usuario->phone = $request->phone;
        $usuario->address = $request->address;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('donorphotos'), $filename);
            $usuario->image = $filename;
        }

        $usuario->save();

        return redirect()->route('perfil.editar')->with('success', 'Perfil atualizado com sucesso!');
    }
}
