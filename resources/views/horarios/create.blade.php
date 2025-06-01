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
          <h2 class="text-center mb-4">Cadastrar Horário Disponível</h2>

          @if(session('message'))
            <div class="alert alert-success">
              {{ session('message') }}
            </div>
          @endif

          @if ($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

        

          <div class="card">
            <div class="card-body">
              <form action="{{ route('horarios.store') }}" method="POST">
                @csrf

                <div class="form-group">
                  <label for="local_doacao_id">Local de Doação</label>
                  <select name="local_doacao_id" class="form-control" required>
                    <option value="">Selecione um local</option>
                    @foreach($locais as $local)
                      <option value="{{ $local->id }}" {{ old('local_doacao_id') == $local->id ? 'selected' : '' }}>
                        {{ $local->nome }} - {{ $local->cidade }}
                      </option>
                    @endforeach
                  </select>
                </div>

                @php use Carbon\Carbon; @endphp

                <div class="form-group">
                  <label for="data">Data</label>
                  <input type="date" name="data" class="form-control"
                         value="{{ old('data', Carbon::now()->toDateString()) }}"
                         required min="{{ Carbon::now()->toDateString() }}">
                </div>

                <div class="form-group">
                  <label for="horario">Horário (ex: 08:00)</label>
                  <input type="time" name="horario" class="form-control" value="{{ old('horario') }}" required>
                </div>

                <div class="form-group">
                  <label for="turno">Turno</label>
                  <select name="turno" class="form-control" required>
                    <option value="AM" {{ old('turno') == 'AM' ? 'selected' : '' }}>AM</option>
                    <option value="PM" {{ old('turno') == 'PM' ? 'selected' : '' }}>PM</option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="nome_doutor">Nome do Doutor</label>
                  <input type="text" name="nome_doutor" class="form-control" value="{{ old('nome_doutor') }}" placeholder="Opcional">
                </div>

                <div class="form-group">
                  <label for="limite">Limite de Agendamentos</label>
                  <select name="limite" class="form-control" required>
                    <option value="">Selecione...</option>
                    <option value="1" {{ old('limite') == 1 ? 'selected' : '' }}>1</option>
                    <option value="2" {{ old('limite') == 2 ? 'selected' : '' }}>2</option>
                  </select>
                </div>

                <div class="text-right mt-4">
                  <button type="submit" class="btn btn-primary">Salvar</button>
                  <a href="{{ route('horarios.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
              </form>
            </div>
          </div>

        </div>
      </div>
    </div>

    @include('admin.script')
  </body>
</html>
