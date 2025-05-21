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
        <div class="container" style="padding-top: 100px;">

          <h2 class="text-center">Locais de Doação</h2>

          @if(session()->has('success'))
            <div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              {{ session('success') }}
            </div>
          @endif

          <div class="text-end mb-3">
            <a href="{{ route('locais-doacao.create') }}" class="btn btn-success">Novo Local</a>
          </div>

          {{-- Barra de Pesquisa --}}
          <form method="GET" action="{{ route('locais-doacao.index') }}" class="row g-3 mb-4">
            <div class="col-md-4">
              <input type="text" name="cidade" class="form-control" placeholder="Filtrar por cidade" value="{{ request('cidade') }}">
            </div>
            <div class="col-md-4">
              <input type="text" name="estado" class="form-control" placeholder="Filtrar por estado (sigla)" value="{{ request('estado') }}">
            </div>
            <div class="col-md-4">
              <input type="text" name="endereco" class="form-control" placeholder="Filtrar por endereço" value="{{ request('endereco') }}">
            </div>
            <div class="col-12 text-end">
              <button type="submit" class="btn btn-primary">Buscar</button>
              <a href="{{ route('locais-doacao.index') }}" class="btn btn-secondary">Limpar</a>
            </div>
          </form>

          <table class="table table-bordered mt-3">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Endereço</th>
                <th>Cidade</th>
                <th>Telefone</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              @foreach($locais as $local)
                <tr>
                  <td>{{ $local->nome }}</td>
                  <td>{{ $local->endereco }}</td>
                  <td>{{ $local->cidade ?? '-' }}</td>
                  <td>{{ $local->telefone ?? '-' }}</td>
                  <td>
                    <a href="{{ route('locais-doacao.edit', $local) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('locais-doacao.destroy', $local) }}" method="POST" style="display:inline-block;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Deseja excluir este local?')">Excluir</button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>

        </div>
      </div>
    </div>

    @include('admin.script')
  </body>
</html>
