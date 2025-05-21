<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function addview()
    {
        return view('admin.add_donor');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'data_nascimento' => 'required|date|before:-16 years',
            'sexo' => 'required|in:M,F',
        ]);

        $user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->blood_type = $request->blood_type;
        $user->data_nascimento = $request->data_nascimento;
        $user->sexo = $request->sexo;
        $user->usertype = '0'; // paciente/doador comum
        $user->password = Hash::make('senhapadrao'); 

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move('donorphotos', $imageName);
            $user->image = $imageName;
        }

        $user->save();

        return redirect()->back()->with('message', 'Doador (usuário) cadastrado com sucesso!');
    }

    public function showUsuarios()
    {
        $usuarios = User::where('usertype', '0')->get();
        return view('admin.usuarios', compact('usuarios'));
    }

    public function editarUsuario($id)
    {
        $usuario = User::findOrFail($id);
        return view('admin.editar_usuario', compact('usuario'));
    }

    public function atualizarUsuario(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->phone = $request->phone;
        $usuario->address = $request->address;
        $usuario->blood_type = $request->blood_type;
        $usuario->data_nascimento = $request->data_nascimento;
        $usuario->sexo = $request->sexo;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('donorphotos'), $filename);
            $usuario->image = $filename;
            logger('Imagem enviada com sucesso: '.$filename);
        } else {
            logger('Nenhuma imagem enviada.');
        }

        $usuario->save();

        logger('Final image: '.$usuario->image);

        return redirect('/usuarios')->with('message', 'Usuário atualizado com sucesso!');
    }

    public function excluirUsuario($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();

        return redirect('/usuarios')->with('message', 'Usuário excluído com sucesso!');
    }
}
