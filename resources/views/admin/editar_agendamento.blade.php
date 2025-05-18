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
        <div class="container" style="padding-top:100px;">

          <h2>Editar Agendamento</h2>

          <form action="{{ url('/agendamento/'.$agendamento->id.'/atualizar') }}" method="POST">
            @csrf
            @method('PUT')

            <div style="padding:15px;">
              <label>Data</label>
              <input type="date" name="date" value="{{ $agendamento->date }}" required>
            </div>

            <div style="padding:15px;">
              <label>Hora</label>
              <input type="time" name="time" value="{{ $agendamento->time }}" required>
            </div>

            <div style="padding:15px;">
              <label>Status</label>
              <select name="status" required>
                @foreach(['Agendado', 'Concluído', 'Cancelado'] as $status)
                  <option value="{{ $status }}" @if($agendamento->status == $status) selected @endif>{{ $status }}</option>
                @endforeach
              </select>
            </div>

            <div style="padding:15px;">
              <input type="submit" class="btn btn-primary" value="Salvar alterações">
              <a href="{{ url('/agendamentos') }}" class="btn btn-secondary">Voltar</a>
            </div>
          </form>

        </div>
      </div>
    </div>

    @include('admin.script')
  </body>
</html>
