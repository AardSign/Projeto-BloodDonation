<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\HistoricoMedico;


class AdminController extends Controller
{
    public function addview()
    {
        return view('admin.add_donor');
    }

    public function upload(Request $request)
    {
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

    // Cria histórico médico padrão
    HistoricoMedico::create([
        'user_id' => $user->id,
        'usa_insulina' => false,
        'tem_doenca_cardiaca' => false,
        'tem_doenca_infecciosa' => null,
        'peso' => null,
        'usa_medicamentos' => null,
        'data_ultima_transfusao' => null,
        'teve_cancer' => false,
        'doencas_autoimunes' => null,
        'historico_convulsoes' => false,
        'pode_doar' => true, 
    ]);

        return redirect()->back()->with('message', 'Doador (usuário) cadastrado com sucesso!');
    }

    public function showUsuarios(Request $request)
        {
            $query = User::where('usertype', '0'); 

            if ($request->filled('q')) {
                $search = $request->q;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
                });
            }

            $usuarios = $query->get();

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
