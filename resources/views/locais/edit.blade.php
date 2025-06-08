<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    @include('admin.css')

    <style>
      label {
        display: inline-block;
        width: 150px;
        font-weight: bold;
        color: #f0f0f0;
      }

thead tr{
        background-color: #fff;
      }

      tbody tr{
        background-color: #2f3b52;
        color: white;
        border-color: white;
      }

      small.text-danger {
        color: red;
        display: block;
        margin-top: 5px;
      }

      .card-custom {
        background-color: #264653;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        width: 100%;
        margin: auto;
        color: white;
      }

      .action-buttons {
  display: flex;
  flex-direction: column;
  gap: 8px; /* Espaço entre os botões */
  align-items: center; /* Opcional: centraliza os botões na célula */
}


      .form-container {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
      }

      .form-group {
        flex: 1 1 45%;
        min-width: 300px;
        display: flex;
        align-items: center;
        padding: 2px 0;
      }

      .form-group label {
        width: 130px;
        margin-right: 4px;
        color: #ffff;
        user-select: none;
      }

      .form-group label:not(.custom-file-upload)::after {
        content: ":";
        margin-left: 2px;
      }

      .form-group input:not([type="file"]) {
        flex: 1;
        padding: 6px 8px;
        border-radius: 4px;
        border: 1px solid #ccc;
        font-size: 1rem;
        background-color: #fff;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        color: #222;
      }

      .form-group input[disabled] {
        color: #999;
        background-color: #fff;
        border: 1px solid #ccc;
        cursor: not-allowed;
      }

      .form-group input:focus {
        outline: none;
        border-color: #2a9d8f;
        box-shadow: 0 0 5px #2a9d8f;
        background-color: #fff;
        color: #222;
      }

      .form-group input[type="file"] {
        display: none;
      }

      .custom-file-upload {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 100px;
  height: 40px;
  cursor: pointer;
  border-radius: 4px;
  border: 1px solid #1e90ff !important;
  background-color: #1e90ff !important;
  color: white;
  font-size: 1rem;
  user-select: none;
  transition: background-color 0.3s ease, color 0.3s ease;
   margin-right: 1px; /* ou o quanto quiser */
  text-decoration: none;
}


      .custom-file-upload:hover {
        background-color: #005bb5 !important;
        border-color: #005bb5 !important;
        color: white;
      }

      

      .form-photo {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 4px 0;
      }

      .form-photo label {
        width: 130px;
        margin-right: 4px;
        color: #ffff;
        font-weight: bold;
        font-size: 14px;
        user-select: none;
      }

      .form-photo label::after {
        content: ":";
        margin-left: 2px;
      }

      .form-photo img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #ccc;
      }

      .form-actions {
        padding: 12px 0;
        display: flex;
        justify-content: center;
        gap: 15px;
      }

      .form-actions .btn-primary,
      .form-actions .btn-secondary {
        padding: 8px 16px;
        border-radius: 4px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        cursor: pointer;
        transition: color 0.3s ease, background-color 0.3s ease, border-color 0.3s ease;
      }

      .btn-primary {
        width: 100px;
        height: 40px;
        background-color: #4CAF50 !important;
        border: 1px solid #4CAF50 !important;
        color: white;
      }

      .btn-green {
        width: 70px;
        height: 25px;
        background-color: #4CAF50 !important;
        border: 1px solid #4CAF50 !important;
        color: white;
      }

      .btn-secondary {
        width: 100px;
        height: 30px;
        background-color: #d32f2f !important;
        border: 1px solid #d32f2f !important;
        color: white !important;
      }

      .btn-primary:hover {
        background-color: #388E3C !important;
        border-color: #388E3C !important;
        color: black;
      }

      .btn-green:hover {
        background-color: #388E3C !important;
        border-color: #388E3C !important;
        color: black;
      }

     .btn-secondary:hover {
        background-color: #b71c1c !important;
        border-color: #b71c1c !important;
        color: white ;
      }

      h2 {
        margin-bottom: 20px;
        margin-top: 40px;
        font-size: 2rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #1e90ff;
        user-select: none;
      }

      .form-group select {
    flex: 1;
    padding: 6px 8px;
    border-radius: 4px;
    border: 1px solid #ccc;
    font-size: 1rem;
    background-color: #fff !important;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
    color: #222;}

      input.form-control {
  background-color: #fff !important;
  color: #222 !important;
}

input.form-control:focus {
  background-color: #fff !important;
  color: #222 !important;
  border-color: #2a9d8f;
  box-shadow: 0 0 5px #2a9d8f;
}


      .edit-info-title {
        font-size: 1.3rem;
        text-transform: uppercase;
        color: #1e90ff;
        font-weight: 600;
        margin-bottom: 15px;
        user-select: none;
        text-align: left;
        width: 100%;
      }

      .container {
        padding-top: 90px;
        padding-bottom: 20px;
        width: 95%;
      }

      @media (max-width: 768px) {
  .form-group {
    flex: 1 1 100%;
    flex-direction: column;
    align-items: flex-start;
  }

  .form-group label {
    width: 100%;
    margin-bottom: 4px;
    text-align: left;
  }

  .form-actions {
    flex-direction: column;
    align-items: stretch;
  }

  .btn {
    width: 100% !important;
  }
}

    </style>
  </head>
  <body>
    <div class="container-scroller">
      @include('admin.sidebar')
      @include('admin.navbar')

      <div class="container-fluid">
        <div class="container" align="center">

          <div class="card-custom">

          <div class="edit-info-title">Editar Locais de Doação</div>

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
