<!DOCTYPE html>
<html lang="en">
  <head>
    @include('admin.css')
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#0d6efd">
    <link rel="icon" href="/icons/icon-192.png" type="image/png">
  </head>
  <body>
    <div class="container-scroller">
      @include('admin.sidebar')
      @include('admin.navbar')

      <div class="container-fluid page-body-wrapper">
        <div class="container py-5">

          <h2 class="mb-4">Editar Agendamento</h2>

          <form action="{{ url('/agendamento/'.$agendamento->id.'/atualizar') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row mb-3">
              <div class="col-12 col-md-6 mb-3">
                <label>Data</label>
                <input type="date" class="form-control" name="date" value="{{ $agendamento->date }}" required>
              </div>

              <div class="col-12 col-md-6 mb-3">
                <label>Hora</label>
                <input type="time" class="form-control" name="time" value="{{ $agendamento->time }}" required>
              </div>
            </div>

            <div class="mb-4">
              <label>Status</label>
              <select name="status" class="form-control" required>
                @foreach(['Agendado', 'Concluído', 'Cancelado'] as $status)
                  <option value="{{ $status }}" @if($agendamento->status == $status) selected @endif>{{ $status }}</option>
                @endforeach
              </select>
            </div>

            <div class="d-flex flex-column flex-md-row gap-2">
              <button type="submit" class="btn btn-primary">Salvar alterações</button>
              <a href="{{ url('/agendamentos') }}" class="btn btn-secondary">Voltar</a>
            </div>
          </form>

        </div>
      </div>
    </div>

    @include('admin.script')
  </body>
</html>
