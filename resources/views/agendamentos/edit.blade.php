<!DOCTYPE html>
<html lang="pt-BR">
<head>
  @include('admin.css')
  <style>
      label {
        display: inline-block;
        width: 150px;
        font-weight: bold;
        color: #f0f0f0;
      }

thead tr{
        background-color: #fff;
      }

      tbody tr{
        background-color: #2f3b52;
        color: white;
        border-color: white;
      }

      small.text-danger {
        color: red;
        display: block;
        margin-top: 5px;
      }

      .card-custom {
        background-color: #264653;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        width: 100%;
        margin: auto;
        color: white;
      }

      .action-buttons {
  display: flex;
  flex-direction: column;
  gap: 8px; /* Espaço entre os botões */
  align-items: center; /* Opcional: centraliza os botões na célula */
}


      .form-container {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
      }

      .form-group {
        flex: 1 1 45%;
        min-width: 300px;
        display: flex;
        align-items: center;
        padding: 2px 0;
      }

      .form-group label {
        width: 130px;
        margin-right: 4px;
        color: #ffff;
        user-select: none;
      }

      .form-group label:not(.custom-file-upload)::after {
        content: ":";
        margin-left: 2px;
      }

      .form-group input:not([type="file"]) {
        flex: 1;
        padding: 6px 8px;
        border-radius: 4px;
        border: 1px solid #ccc;
        font-size: 1rem;
        background-color: #fff;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        color: #222;
      }

      .form-group input[disabled] {
        color: #999;
        background-color: #fff;
        border: 1px solid #ccc;
        cursor: not-allowed;
      }

      .form-group input:focus {
        outline: none;
        border-color: #2a9d8f;
        box-shadow: 0 0 5px #2a9d8f;
        background-color: #fff;
        color: #222;
      }

      .form-group input[type="file"] {
        display: none;
      }

      .custom-file-upload {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 100px;
  height: 40px;
  cursor: pointer;
  border-radius: 4px;
  border: 1px solid #1e90ff !important;
  background-color: #1e90ff !important;
  color: white;
  font-size: 1rem;
  user-select: none;
  transition: background-color 0.3s ease, color 0.3s ease;
   margin-right: 1px; /* ou o quanto quiser */
  text-decoration: none;
}


      .custom-file-upload:hover {
        background-color: #005bb5 !important;
        border-color: #005bb5 !important;
        color: white;
      }

      

      .form-photo {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 4px 0;
      }

      .form-photo label {
        width: 130px;
        margin-right: 4px;
        color: #ffff;
        font-weight: bold;
        font-size: 14px;
        user-select: none;
      }

      .form-photo label::after {
        content: ":";
        margin-left: 2px;
      }

      .form-photo img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #ccc;
      }

      .form-actions {
        padding: 12px 0;
        display: flex;
        justify-content: center;
        gap: 15px;
      }

      .form-actions .btn-primary,
      .form-actions .btn-secondary {
        padding: 8px 16px;
        border-radius: 4px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        cursor: pointer;
        transition: color 0.3s ease, background-color 0.3s ease, border-color 0.3s ease;
      }

      .btn-primary {
        width: 100px;
        height: 40px;
        background-color: #4CAF50 !important;
        border: 1px solid #4CAF50 !important;
        color: white;
      }

      .btn-green {
        width: 70px;
        height: 25px;
        background-color: #4CAF50 !important;
        border: 1px solid #4CAF50 !important;
        color: white;
      }

      .btn-secondary {
        width: 100px;
        height: 30px;
        background-color: #d32f2f !important;
        border: 1px solid #d32f2f !important;
        color: white !important;
      }

      .btn-primary:hover {
        background-color: #388E3C !important;
        border-color: #388E3C !important;
        color: black;
      }

      .btn-green:hover {
        background-color: #388E3C !important;
        border-color: #388E3C !important;
        color: black;
      }

     .btn-secondary:hover {
        background-color: #b71c1c !important;
        border-color: #b71c1c !important;
        color: white ;
      }

      h2 {
        margin-bottom: 20px;
        margin-top: 40px;
        font-size: 2rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #1e90ff;
        user-select: none;
      }

      .form-group select {
    flex: 1;
    padding: 6px 8px;
    border-radius: 4px;
    border: 1px solid #ccc;
    font-size: 1rem;
    background-color: #fff !important;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
    color: #222;}

      input.form-control {
  background-color: #fff !important;
  color: #222 !important;
}

input.form-control:focus {
  background-color: #fff !important;
  color: #222 !important;
  border-color: #2a9d8f;
  box-shadow: 0 0 5px #2a9d8f;
}


      .edit-info-title {
        font-size: 1.3rem;
        text-transform: uppercase;
        color: #1e90ff;
        font-weight: 600;
        margin-bottom: 15px;
        user-select: none;
        text-align: left;
        width: 100%;
      }

      .container {
        padding-top: 90px;
        padding-bottom: 20px;
        width: 95%;
      }
  </style>
  <link rel="manifest" href="{{ asset('manifest.json') }}">
  <meta name="theme-color" content="#0d6efd">
  <link rel="icon" href="/icons/icon-192.png" type="image/png">
</head>
<body>
<div class="container-scroller">
  @include('admin.sidebar')
  @include('admin.navbar')

  <div class="container-fluid">
        <div class="container" align="center">

           <div class="card-custom">

          <div class="edit-info-title">Editar Agendamento</div>

      @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
      @endif

      <form action="{{ url('/agendamento/' . $agendamento->id . '/atualizar') }}" method="POST">
    @csrf
    @method('PUT')


        
        <div class="form-group mb-3">
          <label>Nome do Doador</label>
          <input type="text" class="form-control" value="{{ $agendamento->user->name }}" disabled>
        </div>

        {{-- Local de doação --}}
        <div class="form-group mb-3">
          <label for="local_doacao_id">Local de Doação</label>
          <select name="local_doacao_id" id="local_doacao_id" class="form-control" required>
            <option value="">Selecione um local</option>
            @foreach($locais as $local)
              <option value="{{ $local->id }}" {{ $agendamento->local_doacao_id == $local->id ? 'selected' : '' }}>
                {{ $local->nome }} - {{ $local->cidade ?? '' }}
              </option>
            @endforeach
          </select>
        </div>

        {{-- Data --}}
        <div class="form-group mb-3">
          <label for="data_visivel">Data</label>
          <input type="date" id="data_visivel" class="form-control"
                 value="{{ \Carbon\Carbon::parse($agendamento->date)->format('Y-m-d') }}">
          <input type="hidden" name="date" id="data" value="{{ \Carbon\Carbon::parse($agendamento->date)->format('Y-m-d') }}">
        </div>

        <div class="form-group mb-3">
            <label for="horario_disponivel_id">Horário</label>
            <select name="horario_disponivel_id" id="horario_disponivel_id" class="form-control" required>
                <option value="">Selecione um horário</option>
                @foreach($horarios as $horario)
                    @php
                        $totalAgendados = $horario->agendamentos()
                            ->where('date', $horario->data)
                            ->where('status', 'Marcado')
                            ->count();
                        $lotado = $totalAgendados >= $horario->limite;
                    @endphp
                    <option value="{{ $horario->id }}"
                            {{ $agendamento->horario_disponivel_id == $horario->id ? 'selected' : '' }}
                            {{ $lotado ? 'disabled' : '' }}>
                        {{ $horario->horario }} - {{ $horario->turno }} {{ $lotado ? '(Indisponível)' : '' }}
                    </option>
                @endforeach
            </select>
        </div>
        <input type="hidden" name="time" id="time" value="{{ $agendamento->time }}">

        {{-- Status --}}
        <div class="form-group mb-3">
          <label for="status">Status</label>
          <select name="status" class="form-control" required>
            <option value="Marcado" {{ $agendamento->status == 'Marcado' ? 'selected' : '' }}>Marcado</option>
            <option value="Concluído" {{ $agendamento->status == 'Concluído' ? 'selected' : '' }}>Concluído</option>
            <option value="Cancelado" {{ $agendamento->status == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
          </select>
        </div>

        {{-- Botões --}}
        <div class="text-end mt-4">
          <button type="submit" class="btn btn-primary">Salvar Alterações</button>
          <a href="{{ route('agendamentos.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
      </form>

    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const localSelect = document.getElementById('local_doacao_id');
    const dateInput = document.getElementById('data_visivel');
    const hiddenDate = document.getElementById('data');
    const horarioSelect = document.getElementById('horario_disponivel_id');
    const timeInput = document.getElementById('time');
    const agendamentoHorarioId = {{ $agendamento->horario_disponivel_id ?? 'null' }};

    const hoje = new Date().toISOString().split('T')[0];
    if (dateInput) dateInput.setAttribute('min', hoje);

    async function carregarHorariosDisponiveis() {
      const localId = localSelect.value;
      const data = dateInput.value;
      hiddenDate.value = data;

      if (!localId || !data) {
        horarioSelect.innerHTML = '<option value="">Selecione um horário</option>';
        return;
      }

      try {
        const resposta = await fetch(`/api/horarios-disponiveis?local_id=${localId}&data=${data}`);
        const horarios = await resposta.json();

        horarioSelect.innerHTML = '<option value="">Selecione um horário</option>';

        horarios.forEach(h => {
          const opt = document.createElement('option');
          opt.value = h.id;
          opt.setAttribute('data-hora', h.horario);

          const estaCheio = h.total_agendados >= h.limite;
          opt.textContent = `${h.horario} - Dr(a). ${h.nome_doutor || 'N/A'} (${h.turno})` + (estaCheio ? ' - Indisponível' : '');

          if (estaCheio) {
            opt.disabled = true;
          }

          if (parseInt(h.id) === agendamentoHorarioId) {
            opt.selected = true;
          }

          horarioSelect.appendChild(opt);
        });

        atualizarTime(); // atualiza o campo oculto time após carregar

      } catch (e) {
        console.error('Erro ao carregar horários:', e);
        horarioSelect.innerHTML = '<option value="">Erro ao carregar horários</option>';
      }
    }

    function atualizarTime() {
      const selectedOption = horarioSelect.options[horarioSelect.selectedIndex];
      const hora = selectedOption ? selectedOption.getAttribute('data-hora') : '';
      if (hora) {
        timeInput.value = hora;
      }
    }

    localSelect.addEventListener('change', carregarHorariosDisponiveis);
    dateInput.addEventListener('change', carregarHorariosDisponiveis);
    horarioSelect.addEventListener('change', atualizarTime);

    if (localSelect.value && dateInput.value) {
      carregarHorariosDisponiveis();
    } else {
      atualizarTime(); // garante preenchimento mesmo sem reload
    }
  });
</script>

    @include('admin.script')
  </body>
</html>
