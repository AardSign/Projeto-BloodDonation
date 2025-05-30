<!DOCTYPE html>
<html lang="en">
  <head>
    <style type="text/css">
      label {
        display: inline-block;
        width: 200px;
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

      <h2 style="margin-bottom: 20px;">Lista de Doadores</h2>
        
      <form method="GET" action="{{ url('/usuarios') }}" class="form-inline mb-4 d-flex justify-content-center">
        <input type="text" name="q" class="form-control mr-2 w-50" placeholder="Buscar por nome ou telefone..." value="{{ request('q') }}">
        <button type="submit" class="btn btn-primary">🔍 Buscar</button>
        <a href="{{ url('/usuarios') }}" class="btn btn-secondary ml-2">Limpar</a>
      </form>



      <table class="table table-bordered" style="width:90%;">
        <thead class="thead-dark">
          <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Endereço</th>
            <th>Tipo Sanguíneo</th>
            <th>Imagem</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          @foreach($usuarios as $user)
          <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->phone }}</td>
            <td>{{ $user->address }}</td>
            <td>{{ $user->blood_type }}</td>
            <td>
              @if($user->image)
                <img src="{{ asset('donorphotos/'.$user->image) }}" style="width: 70px; height: 70px; object-fit: cover;" alt="Foto">
              @else
                <span>Sem imagem</span>
              @endif
            </td>
            <td>
              <a href="{{ url('/usuarios/'.$user->id.'/editar') }}" class="btn btn-sm btn-primary mb-1">Editar</a>
              <a href="{{ url('/historico-medico/'.$user->id) }}" class="btn btn-sm btn-info mb-1">Ver Histórico</a>
              <a href="{{ url('/usuarios/'.$user->id.'/excluir') }}" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este usuário?')">Excluir</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>

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
