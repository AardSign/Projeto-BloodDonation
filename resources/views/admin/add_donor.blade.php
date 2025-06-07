<!DOCTYPE html>
<html lang="en">
  <head>
   <style>
      label {
        display: inline-block;
        width: 150px;
        font-weight: bold;
        color: #f0f0f0;
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
        display: inline-block;
        padding: 8px 16px;
        cursor: pointer;
        border-radius: 4px;
        border: 1px solid #1e90ff;
        background-color: #1e90ff;
        color: white;
        font-size: 1rem;
        user-select: none;
        transition: background-color 0.3s ease, color 0.3s ease;
      }

      .custom-file-upload:hover {
        background-color: #005bb5;
        border-color: #005bb5;
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
        justify-content: flex-end;
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

      .form-actions .btn-primary {
        width: 140px;
        height: 40px;
        background-color: #4CAF50 !important;
        border: 1px solid #4CAF50 !important;
        color: white;
      }

      .form-actions .btn-secondary {
        width: 140px;
        height: 40px;
        background-color: #d32f2f;
        border: 1px solid #d32f2f;
        color: white;
      }

      .form-actions .btn-primary:hover {
        background-color: #388E3C !important;
        border-color: #388E3C !important;
        color: black;
      }

      .form-actions .btn-secondary:hover {
        background-color: #b71c1c;
        border-color: #b71c1c;
        color: white;
      }

.form-group select {
    flex: 1;
    padding: 6px 8px;
    border-radius: 4px;
    border: 1px solid #ccc;
    font-size: 1rem;
    background-color: #fff;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
    color: #222;
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
    </style>

    @include('admin.css')
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#0d6efd">
    <link rel="icon" href="/icons/icon-192.png" type="image/png">
  </head>
  <body>
    <div class="container-scroller">

      @include('admin.sidebar')
      @include('admin.navbar')

      <div class="container-fluid">
        <div class="container" align="center">

        @if(session()->has('message'))
          <div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert">&times;</button>  
              {{ session()->get('message') }}
          </div>
        @endif


        
<div class="card-custom">
          <form action="{{ url('upload_donor') }}" method="POST" enctype="multipart/form-data" id="form-doador">
            @csrf

            <div class="edit-info-title">Adicionar Doadores</div>

            <div class="form-container">
              {{-- Nome e Sobrenome --}}
              <div class="form-group">
                <label>Nome</label>
                <input type="text" id="nome" class="form-control" required placeholder="Digite seu nome">
              </div>

              <div class="form-group">
                <label>Sobrenome</label>
                <input type="text" id="sobrenome" class="form-control" required placeholder="Digite seu sobrenome">
              </div>

              {{-- Campo oculto para name --}}
              <input type="hidden" name="name" id="name">

              {{-- Email --}}
              <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required placeholder="Digite seu e-mail">
              </div>

              {{-- Telefone --}}
              <div class="form-group">
                <label>Telefone</label>
                <input type="text" name="phone" id="phone" required placeholder="(11) 91234-5678">
              </div>

              {{-- Endereço --}}
              <div class="form-group">
                <label>Endereço</label>
                <input type="text" name="address" required placeholder="Digite seu endereço">
              </div>

              {{-- Tipo sanguíneo --}}
              <div class="form-group">
                <label>Tipo Sanguíneo</label>
                <select name="blood_type" required>
                  <option value="">Selecione...</option>
                  <option value="A+">A+</option>
                  <option value="A-">A-</option>
                  <option value="B+">B+</option>
                  <option value="B-">B-</option>
                  <option value="AB+">AB+</option>
                  <option value="AB-">AB-</option>
                  <option value="O+">O+</option>
                  <option value="O-">O-</option>
                </select>
              </div>

              {{-- Data de nascimento --}}
              <div class="form-group">
                <label>Data de Nascimento</label>
                <input type="date" name="data_nascimento" id="data_nascimento" required>
                <small class="text-danger d-none" id="erroIdade">Você deve ter pelo menos 16 anos.</small>
              </div>

              {{-- Sexo --}}
              <div class="form-group">
                <label>Sexo</label>
                <select name="sexo" id="sexo" required>
                  <option value="">Selecione...</option>
                  <option value="M">Masculino</option>
                  <option value="F">Feminino</option>
                </select>
                <small class="text-danger d-none" id="erroSexo">Selecione o sexo.</small>
              </div>

              {{-- Senha --}}
              <div class="form-group">
                <label>Senha</label>
                <input type="password" name="password" id="password" required minlength="8" class="form-control" placeholder="Mínimo 8 caracteres">
                <small class="text-danger d-none" id="erroSenha">A senha deve ter no mínimo 8 caracteres.</small>
              </div>
            </div>

            <div class="form-actions">
              <button type="submit" class="btn btn-primary">Adicionar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    @include('admin.script')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
      $(document).ready(function(){
        $('input[name="phone"]').mask('(00) 00000-0000');

        const nascimento = document.getElementById('data_nascimento');
        const erroIdade = document.getElementById('erroIdade');
        const sexo = document.getElementById('sexo');
        const erroSexo = document.getElementById('erroSexo');
        const senha = document.getElementById('password');
        const erroSenha = document.getElementById('erroSenha');
        const form = document.getElementById('form-doador');

        // Função para calcular idade com precisão
        function calcularIdade(dataNascStr) {
          const dataNasc = new Date(dataNascStr);
          const hoje = new Date();
          let idade = hoje.getFullYear() - dataNasc.getFullYear();
          const m = hoje.getMonth() - dataNasc.getMonth();
          const d = hoje.getDate() - dataNasc.getDate();

          if (m < 0 || (m === 0 && d < 0)) {
            idade--;
          }

          return idade;
        }

        // Evento ao mudar a data
        nascimento.addEventListener('change', function () {
          erroIdade.classList.add('d-none');
          if (nascimento.value && calcularIdade(nascimento.value) < 16) {
            erroIdade.classList.remove('d-none');
          }
        });

        // Validação final no envio
        form.addEventListener('submit', function (e) {
          let valido = true;
          erroIdade.classList.add('d-none');
          erroSexo.classList.add('d-none');
          erroSenha.classList.add('d-none');

          // Concatenar nome e sobrenome
          const nome = document.getElementById('nome').value.trim();
          const sobrenome = document.getElementById('sobrenome').value.trim();
          document.getElementById('name').value = `${nome} ${sobrenome}`.trim();

          if (!nascimento.value || calcularIdade(nascimento.value) < 16) {
            erroIdade.classList.remove('d-none');
            valido = false;
          }

          if (!sexo.value) {
            erroSexo.classList.remove('d-none');
            valido = false;
          }

          if (!senha.value || senha.value.length < 8) {
            erroSenha.classList.remove('d-none');
            valido = false;
          }

          if (!valido) {
            e.preventDefault();
          }
        });
      });
    </script>
    
  </body>
</html>
