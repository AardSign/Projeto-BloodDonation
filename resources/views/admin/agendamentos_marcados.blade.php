<!DOCTYPE html>
<html lang="en">
  <head>
    @include('admin.css')
  </head>
  <body>
    <div class="container-scroller">
      @include('admin.sidebar')
      @include('admin.navbar')

      <div class="container-fluid page-body-wrapper">
        <div class="container" style="padding-top: 100px;">

          <h2 class="text-center">Agendamentos Marcados</h2>

          @if(session()->has('message'))
            <div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              {{ session()->get('message') }}
            </div>
          @endif

          <table class="table table-bordered mt-4">
            <thead>
              <tr>
                <th>Doador</th>
                <th>Data</th>
                <th>Hora</th>
                <th>Status</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              @foreach($agendamentos as $agendamento)
                <tr>
                  <td>{{ $agendamento->user->name }}</td>
                  <td>{{ \Carbon\Carbon::parse($agendamento->date)->format('d/m/Y') }}</td>
                  <td>{{ \Carbon\Carbon::parse($agendamento->time)->format('H:i') }}</td>
                  <td>{{ $agendamento->status }}</td>
                  <td>
                    <a href="{{ url('/agendamento/'.$agendamento->id.'/editar') }}" class="btn btn-sm btn-primary">Editar</a>
                    <a href="{{ url('/agendamento/'.$agendamento->id.'/cancelar') }}" class="btn btn-sm btn-danger">Cancelar</a>
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
