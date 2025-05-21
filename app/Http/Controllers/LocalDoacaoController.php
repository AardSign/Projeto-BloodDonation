<?php

namespace App\Http\Controllers;

use App\Models\LocalDoacao;
use Illuminate\Http\Request;

class LocalDoacaoController extends Controller
{
    public function index(Request $request)
    {
    // Mapeamento de nomes de estados para suas siglas
    $estados = [
        'AC' => 'Acre', 'AL' => 'Alagoas', 'AP' => 'Amapá', 'AM' => 'Amazonas', 'BA' => 'Bahia',
        'CE' => 'Ceará', 'DF' => 'Distrito Federal', 'ES' => 'Espírito Santo', 'GO' => 'Goiás', 'MA' => 'Maranhão',
        'MT' => 'Mato Grosso', 'MS' => 'Mato Grosso do Sul', 'MG' => 'Minas Gerais', 'PA' => 'Pará', 'PB' => 'Paraíba',
        'PR' => 'Paraná', 'PE' => 'Pernambuco', 'PI' => 'Piauí', 'RJ' => 'Rio de Janeiro', 'RN' => 'Rio Grande do Norte',
        'RS' => 'Rio Grande do Sul', 'RO' => 'Rondônia', 'RR' => 'Roraima', 'SC' => 'Santa Catarina', 'SP' => 'São Paulo',
        'SE' => 'Sergipe', 'TO' => 'Tocantins'
    ];

    // Inicia a query base
    $query = LocalDoacao::query();

    // Filtro por cidade
    if ($request->filled('cidade')) {
        $query->where('cidade', 'like', '%' . $request->cidade . '%');
    }

    // Filtro por estado (aceita sigla ou nome)
    if ($request->filled('estado')) {
        $estadoInput = trim($request->estado);
        $sigla = strtoupper($estadoInput);

        // Tenta converter nome completo para sigla
        $siglaConvertida = array_search(ucwords(strtolower($estadoInput)), $estados);
        if ($siglaConvertida) {
            $sigla = $siglaConvertida;
        }

        $query->where('estado', 'like', "%$sigla%");
    }

    // Filtro por endereço
    if ($request->filled('endereco')) {
        $query->where('endereco', 'like', '%' . $request->endereco . '%');
    }

    // Executa a consulta e obtém os resultados
    $locais = $query->get();

    // Retorna a view com os locais filtrados
    return view('locais.index', compact('locais'));
    }



    // Exibe o formulário de criação
    public function create() {
        return view('locais.create');
    }

    // Salva um novo local com validações e regras de negócio
    public function store(Request $request) {
        // Validação dos campos
        $request->validate([
            'nome' => 'required|string|min:3|max:255',
            'endereco' => 'required|string|max:255',
            'cidade' => 'nullable|string|max:100',
            'estado' => 'nullable|string|max:2',
            'telefone' => [
                'nullable',
                'regex:/^\(?\d{2}\)?[\s-]?\d{4,5}-?\d{4}$/',
            ],
        ]);

        // Verifica duplicidade de nome + endereço
        $existe = LocalDoacao::where('nome', $request->nome)
            ->where('endereco', $request->endereco)
            ->exists();

        if ($existe) {
            return back()->withErrors(['nome' => 'Já existe um local com esse nome e endereço.'])->withInput();
        }

        // Sanitiza os dados antes de salvar
        $data = $request->all();
        $data['nome'] = trim(ucwords(strtolower($data['nome'])));
        $data['endereco'] = trim(ucwords(strtolower($data['endereco'])));
        $data['cidade'] = $data['cidade'] ? trim(ucwords(strtolower($data['cidade']))) : null;
        $data['estado'] = $data['estado'] ? strtoupper(trim($data['estado'])) : null;

        // Cria o local
        LocalDoacao::create($data);

        return redirect()->route('locais-doacao.index')->with('success', 'Local criado com sucesso!');
    }

    // Exibe o formulário de edição
    public function edit(LocalDoacao $localDoacao) {
        return view('locais.edit', compact('localDoacao'));
    }

    // Atualiza um local com validações e regras
    public function update(Request $request, LocalDoacao $localDoacao) {
        $request->validate([
            'nome' => 'required|string|min:3|max:255',
            'endereco' => 'required|string|max:255',
            'cidade' => 'nullable|string|max:100',
            'estado' => 'nullable|string|max:2',
            'telefone' => [
                'nullable',
                'regex:/^\(?\d{2}\)?[\s-]?\d{4,5}-?\d{4}$/',
            ],
        ]);

        // Verifica duplicidade (exceto se for o próprio)
        $existe = LocalDoacao::where('nome', $request->nome)
            ->where('endereco', $request->endereco)
            ->where('id', '!=', $localDoacao->id)
            ->exists();

        if ($existe) {
            return back()->withErrors(['nome' => 'Já existe outro local com esse nome e endereço.'])->withInput();
        }

        // Sanitiza os dados antes de atualizar
        $data = $request->all();
        $data['nome'] = trim(ucwords(strtolower($data['nome'])));
        $data['endereco'] = trim(ucwords(strtolower($data['endereco'])));
        $data['cidade'] = $data['cidade'] ? trim(ucwords(strtolower($data['cidade']))) : null;
        $data['estado'] = $data['estado'] ? strtoupper(trim($data['estado'])) : null;

        $localDoacao->update($data);

        return redirect()->route('locais-doacao.index')->with('success', 'Local atualizado com sucesso!');
    }

    // Remove um local, desde que não tenha agendamentos
    public function destroy(LocalDoacao $localDoacao) {
        // Verifica se existem agendamentos vinculados
        if ($localDoacao->agendamentos()->exists()) {
            return back()->withErrors(['erro' => 'Não é possível excluir um local com agendamentos vinculados.']);
        }

        $localDoacao->delete();

        return redirect()->route('locais-doacao.index')->with('success', 'Local removido com sucesso!');
    }
}
