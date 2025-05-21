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

          <form action="{{ url('/usuarios/'.$usuario->id.'/atualizar') }}" method="POST" enctype="multipart/form-data" id="form-editar">
            @csrf

            <div style="padding:15px;">
              <label>Nome</label>
              <input type="text" name="name" value="{{ $usuario->name }}" required>
            </div>

            <div style="padding:15px;">
              <label>Email</label>
              <input type="email" name="email" value="{{ $usuario->email }}" required>
            </div>

            <div style="padding:15px;">
              <label>Telefone</label>
              <input type="text" name="phone" value="{{ $usuario->phone }}" required>
            </div>

            <div style="padding:15px;">
              <label>Endereço</label>
              <input type="text" name="address" value="{{ $usuario->address }}" required>
            </div>

            <div style="padding:15px;">
              <label>Tipo Sanguíneo</label>
              <select name="blood_type" required>
                <option value="">Selecione...</option>
                @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $tipo)
                  <option value="{{ $tipo }}" @if($usuario->blood_type == $tipo) selected @endif>{{ $tipo }}</option>
                @endforeach
              </select>
            </div>

            <div style="padding:15px;">
              <label>Data de Nascimento</label>
              <input type="date" name="data_nascimento" id="data_nascimento" value="{{ $usuario->data_nascimento }}" required>
              <small class="text-danger d-none" id="erroIdade">Você deve ter pelo menos 16 anos.</small>
            </div>

            <div style="padding:15px;">
              <label>Sexo</label>
              <select name="sexo" id="sexo" required>
                  <option value="">Selecione...</option>
                  <option value="M" {{ $usuario->sexo == 'M' ? 'selected' : '' }}>Masculino</option>
                  <option value="F" {{ $usuario->sexo == 'F' ? 'selected' : '' }}>Feminino</option>
              </select>
              <small class="text-danger d-none" id="erroSexo">Selecione o sexo.</small>
            </div>

            <div style="padding:15px;">
              <label>Imagem atual</label><br>
              @if($usuario->image)
                <img src="{{ asset('donorphotos/'.$usuario->image) }}" width="100" height="100" style="object-fit: cover; border-radius: 8px;">
              @else
                <span>Sem imagem</span>
              @endif
            </div>

            <div style="padding:15px;">
              <label>Nova imagem</label>
              <input type="file" name="image">
            </div>

            <div style="padding:15px;">
              <input type="submit" class="btn btn-success" value="Atualizar">
              <a href="{{ url('/usuarios') }}" class="btn btn-secondary">Cancelar</a>
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
        const form = document.getElementById('form-editar');

        function calcularIdade(dataNascStr) {
          const dataNasc = new Date(dataNascStr);
          const hoje = new Date();
          let idade = hoje.getFullYear() - dataNasc.getFullYear();
          const m = hoje.getMonth() - dataNasc.getMonth();
          const d = hoje.getDate() - dataNasc.getDate();
          if (m < 0 || (m === 0 && d < 0)) idade--;
          return idade;
        }

        nascimento.addEventListener('change', function () {
          erroIdade.classList.add('d-none');
          if (nascimento.value && calcularIdade(nascimento.value) < 16) {
            erroIdade.classList.remove('d-none');
          }
        });

        form.addEventListener('submit', function (e) {
          let valido = true;
          erroIdade.classList.add('d-none');
          erroSexo.classList.add('d-none');

          if (!nascimento.value || calcularIdade(nascimento.value) < 16) {
            erroIdade.classList.remove('d-none');
            valido = false;
          }

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
