<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <style>
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

      <div class="container-fluid">
        <div class="container" align="center" style="padding-top:150px; width:95%;">

          <h2>Editar Perfil</h2>

          @if(session('success'))
            <div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              {{ session('success') }}
            </div>
          @endif

          <form action="{{ route('perfil.atualizar') }}" method="POST" enctype="multipart/form-data" style="background-color: black">
            @csrf
            @method('PUT')

            <div style="padding:15px;">
              <label>Nome</label>
              <input type="text" class="form-control" value="{{ $usuario->name }}" disabled>
            </div>

            <div style="padding:15px;">
              <label>Email</label>
              <input type="email" name="email" class="form-control" value="{{ $usuario->email }}" required>
            </div>

            <div style="padding:15px;">
              <label>Telefone</label>
              <input type="text" name="phone" class="form-control" value="{{ $usuario->phone }}" required>
            </div>

            <div style="padding:15px;">
              <label>Endereço</label>
              <input type="text" name="address" class="form-control" value="{{ $usuario->address }}" required>
            </div>

            <div style="padding:15px;">
              <label>Tipo Sanguíneo</label>
              <input type="text" class="form-control" value="{{ $usuario->blood_type }}" disabled>
            </div>

            <div style="padding:15px;">
              <label>Data de Nascimento</label>
              <input type="date" class="form-control" value="{{ $usuario->data_nascimento }}" disabled>
            </div>

            <div style="padding:15px;">
              <label>Sexo</label>
              <input type="text" class="form-control" value="{{ $usuario->sexo == 'M' ? 'Masculino' : 'Feminino' }}" disabled>
            </div>

            <div style="padding:15px;">
              <label>Foto Atual</label><br>
              @if($usuario->image)
                <img src="{{ asset('donorphotos/'.$usuario->image) }}" width="100" height="100" style="object-fit: cover; border-radius: 8px;">
              @else
                <span>Nenhuma imagem</span>
              @endif
            </div>

            <div style="padding:15px;">
              <label>Nova Foto</label>
              <input type="file" name="image" accept="image/*">
            </div>

            <div style="padding:15px;">
              <button type="submit" class="btn btn-primary">Salvar Alterações</button>
              <a href="{{ url('/') }}" class="btn btn-secondary">Cancelar</a>
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
      });
    </script>
  </body>
</html>
