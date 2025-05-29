<?php

namespace App\Http\Controllers;

use App\Models\HistoricoMedico;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class HistoricoMedicoController extends Controller
{
    public function show($user_id)
    {
        $usuario = User::findOrFail($user_id);
        $historico = HistoricoMedico::where('user_id', $user_id)->first();

        return view('admin.historico_medico.show', compact('usuario', 'historico'));
    }

    public function edit($user_id)
    {
        $usuario = User::findOrFail($user_id);
        $historico = HistoricoMedico::firstOrNew(['user_id' => $user_id]);

        return view('admin.historico_medico.edit', compact('usuario', 'historico'));
    }

    public function storeOrUpdate(Request $request, $user_id)
    {
        $this->validarDados($request);

        $historico = HistoricoMedico::updateOrCreate(
            ['user_id' => $user_id],
            $this->extrairDadosCompletos($request)
        );

        return redirect()->route('historico.show', $historico->user_id)
                ->with('success', 'Histórico médico atualizado com sucesso!');
    }


    public function update(Request $request, $id)
    {
        $historico = HistoricoMedico::findOrFail($id);
        $this->validarDados($request);

        $dados = $this->extrairDadosCompletos($request);
        $historico->fill($dados)->save();

       return redirect()->route('historico.show', $historico->user_id)
                 ->with('success', 'Histórico médico atualizado com sucesso!');
    }

    
     //Valida os campos médicos
     
    private function validarDados(Request $request)
    {
        $request->validate([
            'peso' => 'nullable|numeric|min:30|max:250',
            'tem_doenca_infecciosa' => 'nullable|string|max:255',
            'usa_medicamentos' => 'nullable|string',
            'data_ultima_transfusao' => 'nullable|date|before_or_equal:today',
            'doencas_autoimunes' => 'nullable|string',
            'usa_insulina' => 'required|boolean',
            'tem_doenca_cardiaca' => 'required|boolean',
            'teve_cancer' => 'required|boolean',
            'historico_convulsoes' => 'required|boolean',
        ]);
    }

    
     //Retorna um array de dados para criar ou atualizar o histórico
    
    private function extrairDadosCompletos(Request $request): array
    {
        return [
            'peso' => $request->peso,
            'tem_doenca_infecciosa' => $request->tem_doenca_infecciosa,
            'usa_medicamentos' => $request->usa_medicamentos,
            'data_ultima_transfusao' => $request->data_ultima_transfusao,
            'doencas_autoimunes' => $request->doencas_autoimunes,

            'usa_insulina' => $request->usa_insulina,
            'tem_doenca_cardiaca' => $request->tem_doenca_cardiaca,
            'teve_cancer' => $request->teve_cancer,
            'historico_convulsoes' => $request->historico_convulsoes,

            'pode_doar' => $this->avaliarElegibilidade($request),
        ];
    }

    
      //Regra de negócio para definir se o usuário pode doar
     
    private function avaliarElegibilidade(Request $request): bool
    {
        if (
            $request->usa_insulina ||
            $request->tem_doenca_cardiaca ||
            $request->teve_cancer ||
            $request->historico_convulsoes
        ) {
            return false;
        }

        if (!empty($request->tem_doenca_infecciosa) || !empty($request->doencas_autoimunes)) {
            return false;
        }

        if ($request->data_ultima_transfusao) {
            $data = Carbon::parse($request->data_ultima_transfusao);
            if ($data->diffInDays(now()) < 365) {
                return false;
            }
        }

        return true;
    }
}
