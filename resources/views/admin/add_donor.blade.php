<!DOCTYPE html>
<html lang="en">
  <head>
    <style type="text/css">
      label {
          display: inline-block;
          width: 200px;
      }
      small.text-danger {
          color: red;
          display: block;
          margin-top: 5px;
      }
    </style>

    @include('admin.css')
  </head>
  <body>
    <div class="container-scroller">

      @include('admin.sidebar')
      @include('admin.navbar')

      <div class="container-fluid page-body-wrapper">
        <div class="container" align="center" style="padding-top:100px;">

        @if(session()->has('message'))
          <div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert">&times;</button>  
              {{ session()->get('message') }}
          </div>
        @endif

        <form action="{{ url('upload_donor') }}" method="POST" enctype="multipart/form-data" id="form-doador">
          @csrf

          <div style="padding:15px;">
              <label>Nome</label>
              <input type="text" name="name" required>
          </div>

          <div style="padding:15px;">
              <label>Email</label>
              <input type="email" name="email" required>
          </div>

          <div style="padding:15px;">
              <label>Telefone</label>
              <input type="text" name="phone" required placeholder="(11) 91234-5678">
          </div>

          <div style="padding:15px;">
              <label>Endereço</label>
              <input type="text" name="address" required>
          </div>

          <div style="padding:15px;">
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

          <div style="padding:15px;">
              <label>Data de Nascimento</label>
              <input type="date" name="data_nascimento" id="data_nascimento" required>
              <small class="text-danger d-none" id="erroIdade">Você deve ter pelo menos 16 anos.</small>
          </div>

          <div style="padding:15px;">
              <label>Sexo</label>
              <select name="sexo" id="sexo" required>
                  <option value="">Selecione...</option>
                  <option value="M">Masculino</option>
                  <option value="F">Feminino</option>
              </select>
              <small class="text-danger d-none" id="erroSexo">Selecione o sexo.</small>
          </div>

          <div style="padding:15px;">
              <label>Imagem</label>
              <input type="file" name="image">
          </div>

          <div style="padding:15px;">
              <input type="submit" class="btn btn-success" value="Cadastrar doador">
          </div>
        </form>
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

      // Verifica idade
      if (!nascimento.value || calcularIdade(nascimento.value) < 16) {
        erroIdade.classList.remove('d-none');
        valido = false;
      }

      // Verifica sexo
      if (!sexo.value) {
        erroSexo.classList.remove('d-none');
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
