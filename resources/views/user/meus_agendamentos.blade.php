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

          <h2 class="text-center">Meus Agendamentos</h2>

          @if(session('success'))
            <div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              {{ session('success') }}
            </div>
          @endif

          <div class="text-end mb-3">
            <a href="{{ url('/agendar') }}" class="btn btn-success">Novo Agendamento</a>
          </div>

          <table class="table table-bordered mt-3">
            <thead>
              <tr>
                <th>Data</th>
                <th>Hora</th>
                <th>Local</th>
                <th>Status</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              @forelse($appointments as $agendamento)
                <tr>
                  <td>{{ \Carbon\Carbon::parse($agendamento->date)->format('d/m/Y') }}</td>
                  <td>{{ \Carbon\Carbon::parse($agendamento->time)->format('H:i') }}</td>
                  <td>{{ $agendamento->local->nome ?? '-' }}</td>
                  <td>{{ $agendamento->status }}</td>
                  <td>
                    @if($agendamento->status === 'Marcado')
                      <a href="{{ url('/agendamento/'.$agendamento->id.'/remarcar') }}" class="btn btn-sm btn-primary">Remarcar</a>
                      <form action="{{ url('/agendamento/'.$agendamento->id.'/cancelar') }}" method="POST" style="display:inline;">
                        @csrf
                        <a href="{{ url('/agendamento/'.$agendamento->id.'/cancelar') }}" class="btn btn-danger btn-sm">Cancelar</a>
                      </form>
                    @else
                      <span class="text-muted">-</span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="text-center">Nenhum agendamento encontrado.</td>
                </tr>
              @endforelse
            </tbody>
          </table>

        </div>
      </div>
    </div>

    @include('admin.script')
  </body>
</html>
