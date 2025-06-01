<!DOCTYPE html>
<html lang="pt-BR">
<head>
  @include('admin.css')
  <style>
    label {
      display: inline-block;
      width: 200px;
    }
  </style>
</head>
<body>
<div class="container-scroller">
  @include('admin.sidebar')
  @include('admin.navbar')

  <div class="container-fluid page-body-wrapper">
    <div class="container" align="center" style="padding-top:100px;">

      <h2>Editar Agendamento</h2>

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
