<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    @include('admin.css')
  </head>
  <body>
    <div class="container-scroller">
      @include('admin.sidebar')
      @include('admin.navbar')

      <div class="container-fluid page-body-wrapper">
        <div class="container" style="padding-top: 100px; max-width: 600px;">

          <h2 class="text-center mb-4">Editar Local de Doação</h2>

          {{-- ALERTAS --}}
          @if(session('success'))
            <div class="alert alert-success">
              {{ session('success') }}
            </div>
          @endif

          @if($errors->any())
            <div class="alert alert-danger">
              <strong>Ops! Houve alguns problemas:</strong>
              <ul class="mb-0">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ route('locais-doacao.update', $localDoacao->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
              <label for="nome">Nome do Local</label>
              <input type="text" name="nome" class="form-control"
                     value="{{ old('nome', $localDoacao->nome) }}" required>
              @error('nome') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group mb-3">
              <label for="endereco">Endereço</label>
              <input type="text" name="endereco" class="form-control"
                     value="{{ old('endereco', $localDoacao->endereco) }}" required>
              @error('endereco') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group mb-3">
              <label for="cidade">Cidade</label>
              <input type="text" name="cidade" class="form-control"
                     value="{{ old('cidade', $localDoacao->cidade) }}">
              @error('cidade') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group mb-3">
              <label for="estado">Estado</label>
              <select name="estado" class="form-control">
                <option value="">Selecione um estado</option>
                @php
                  $estados = [
                    'AC' => 'Acre', 'AL' => 'Alagoas', 'AP' => 'Amapá', 'AM' => 'Amazonas', 'BA' => 'Bahia',
                    'CE' => 'Ceará', 'DF' => 'Distrito Federal', 'ES' => 'Espírito Santo', 'GO' => 'Goiás', 'MA' => 'Maranhão',
                    'MT' => 'Mato Grosso', 'MS' => 'Mato Grosso do Sul', 'MG' => 'Minas Gerais', 'PA' => 'Pará', 'PB' => 'Paraíba',
                    'PR' => 'Paraná', 'PE' => 'Pernambuco', 'PI' => 'Piauí', 'RJ' => 'Rio de Janeiro', 'RN' => 'Rio Grande do Norte',
                    'RS' => 'Rio Grande do Sul', 'RO' => 'Rondônia', 'RR' => 'Roraima', 'SC' => 'Santa Catarina', 'SP' => 'São Paulo',
                    'SE' => 'Sergipe', 'TO' => 'Tocantins'
                  ];
                @endphp
                @foreach($estados as $sigla => $nome)
                  <option value="{{ $sigla }}"
                    {{ old('estado', $localDoacao->estado) == $sigla ? 'selected' : '' }}>
                    {{ $nome }}
                  </option>
                @endforeach
              </select>
              @error('estado') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group mb-3">
              <label for="telefone">Telefone</label>
              <input type="text" name="telefone" class="form-control"
                     value="{{ old('telefone', $localDoacao->telefone) }}">
              @error('telefone') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('locais-doacao.index') }}" class="btn btn-secondary">Cancelar</a>
          </form>

        </div>
      </div>
    </div>

     @include('admin.script')             

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
      $(document).ready(function(){
        $('input[name="telefone"]').mask('(00) 00000-0000');
      });
    </script>

    
  </body>
</html>
