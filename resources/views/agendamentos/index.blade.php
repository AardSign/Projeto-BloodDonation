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

          <h2 class="text-center">Agendamentos</h2>

          @if(session('success'))
            <div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              {{ session('success') }}
            </div>
          @endif

          <div class="text-right mb-3">
            <a href="{{ url('/agendar') }}" class="btn btn-success">Novo Agendamento</a>
          </div>

          <form method="GET" action="{{ url('/agendamentos') }}" class="form-inline mb-4">
            <input type="text" name="q" class="form-control mr-2 w-50" placeholder="Buscar por doador, data, hora, status ou local..." value="{{ request('q') }}">
            <button type="submit" class="btn btn-primary">🔍 Buscar</button>
          </form>

          <table class="table table-bordered mt-3">
            <thead>
              <tr>
                <th>Doador</th>
                <th>Data</th>
                <th>Hora</th>
                <th>Local</th>
                <th>Status</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              @foreach($appointments as $agendamento)
                <tr>
                  <td>{{ $agendamento->user->name ?? 'Usuário removido' }}</td>
                  <td>{{ \Carbon\Carbon::parse($agendamento->date)->format('d/m/Y') }}</td>
                  <td>{{ \Carbon\Carbon::parse($agendamento->time)->format('H:i') }}</td>
                  <td>{{ $agendamento->local->nome ?? '-' }}</td>
                  <td>{{ $agendamento->status }}</td>
                  <td>
                    @if($agendamento->status === 'Marcado')
                      <a href="{{ url('/agendamento/'.$agendamento->id.'/editar') }}" class="btn btn-sm btn-primary">Editar</a>
                      <a href="{{ url('/agendamento/'.$agendamento->id.'/cancelar') }}" class="btn btn-sm btn-danger">Cancelar</a>
                      <a href="{{ url('/agendamento/'.$agendamento->id.'/concluir') }}" class="btn btn-sm btn-success">Concluir</a>
                    @else
                      <span class="text-muted">Ações indisponíveis</span>
                    @endif
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