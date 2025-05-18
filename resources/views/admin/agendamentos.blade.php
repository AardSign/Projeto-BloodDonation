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

          <h2>Agendar Doação</h2>

          <form action="{{ url('/agendar') }}" method="POST">
  @csrf
    //YARE YARE DAZE
  @if(Auth::user()->usertype == '1') {{-- Admin --}}
    <div style="padding:15px;">
      <label>Selecionar Doador</label>
      <select name="user_id" required>
        <option value="">Selecione um doador...</option>
        @foreach(\App\Models\User::where('usertype', '0')->get() as $doador)
          <option value="{{ $doador->id }}">{{ $doador->name }} - {{ $doador->email }}</option>
        @endforeach
      </select>
    </div>
  @endif

  <div style="padding:15px;">
    <label>Data</label>
    <input type="date" name="date" required>
  </div>

  <div style="padding:15px;">
    <label>Hora</label>
    <input type="time" name="time" required>
  </div>

  <div style="padding:15px;">
    <input type="submit" class="btn btn-success" value="Agendar">
    <a href="{{ url('/') }}" class="btn btn-secondary">Cancelar</a>
  </div>
</form>

        </div>
      </div>
    </div>

    @include('admin.script')
  </body>
</html>
