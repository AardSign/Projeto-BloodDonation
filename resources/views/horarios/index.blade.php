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
          <h2 class="text-center mb-4">Horários Disponíveis</h2>

          @if(session('message'))
            <div class="alert alert-success">
              {{ session('message') }}
            </div>
          @endif

          <form method="GET" action="{{ route('horarios.index') }}" class="mb-4">
            <div class="row">
              <div class="col-md-5">
                <label for="filtro_local">Filtrar por Local</label>
                <select name="filtro_local" id="filtro_local" class="form-control">
                  <option value="">Todos os Locais</option>
                  @foreach($locais as $local)
                    <option value="{{ $local->id }}" {{ request('filtro_local') == $local->id ? 'selected' : '' }}>
                      {{ $local->nome }}
                    </option>
                  @endforeach
                </select>
              </div>
              
              <div class="col-md-4">
                <label for="filtro_data">Filtrar por Data</label>
                <input type="date" name="filtro_data" id="filtro_data" class="form-control" value="{{ request('filtro_data') }}">
              </div>

              <div class="col-md-3 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary w-100">Filtrar</button>

                @if(request()->has('filtro_local') || request()->has('filtro_data'))
                  <a href="{{ route('horarios.index') }}" class="btn btn-secondary w-100">Limpar</a>
                @endif
              </div>
            </div>
          </form>


          <div class="card">
            <div class="card-body">
              <div class="text-right mb-3">
                <a href="{{ route('horarios.create') }}" class="btn btn-success">Novo Horário</a>
              </div>
              
              <div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <thead class="thead-light">
                    <tr>
                      <th>Horário</th>
                      <th>Turno</th>
                      <th>Doutor</th>
                      <th>Local</th>
                      <th>Limite</th>
                      <th>Disponível?</th>
                      <th>Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($horarios as $horario)
                      <tr>
                        <td>{{ \Carbon\Carbon::parse($horario->horario)->format('H:i') }}</td>
                        <td>{{ $horario->turno }}</td>
                        <td>{{ $horario->nome_doutor ?? '-' }}</td>
                        <td>{{ $horario->local->nome ?? '-' }}</td>
                        <td>{{ $horario->limite }}</td>
                        <td>{{ $horario->disponivel ? 'Sim' : 'Não' }}</td>
                        <td>
                          <a href="{{ route('horarios.edit', $horario->id) }}" class="btn btn-sm btn-primary">Editar</a>
                          <form action="{{ route('horarios.destroy', $horario->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Tem certeza que deseja remover este horário?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Remover</button>
                          </form>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="7" class="text-center">Nenhum horário cadastrado.</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    @include('admin.script')
  </body>
</html>
