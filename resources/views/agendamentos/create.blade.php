<!DOCTYPE html>
<html lang="pt-BR">
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
              {{ session('message') }}
            </div>
          @endif

          <h2>Agendar Doação</h2>

      <form action="{{ url('/agendar') }}" method="POST">
        @csrf

        @php $historico = $user->historicoMedico; @endphp

    
        @if($historico && !$historico->pode_doar)
          <div class="alert alert-danger mt-4">
            <strong>Atenção:</strong> Você está temporariamente ou permanentemente inapto para realizar novas doações, conforme seu histórico médico.
          </div>
        @endif

        {{-- Admin seleciona doador --}}
        @if(Auth::user()->usertype == '1')
        @php
          $doadores = \App\Models\User::where('usertype', '0')->with('historicoMedico')->get();
        @endphp

        <div class="form-group mb-3">
          <label>Selecionar Doador:</label>
          <select name="user_id" class="form-control" id="doador-select" required>
            <option value="">Selecione um doador...</option>
            @foreach($doadores as $doador)
              <option value="{{ $doador->id }}">
                {{ $doador->name }} - {{ $doador->email }}
              </option>
            @endforeach
          </select>
        </div>

        <div id="alerta-inapto" class="alert alert-danger d-none mt-2">
          <strong>Atenção:</strong> Este doador está inapto para doar conforme o histórico médico.
        </div>

        <script>
          const doadoresStatus = @json($doadores->mapWithKeys(function($u) {
            return [$u->id => $u->historicoMedico ? (bool)$u->historicoMedico->pode_doar : true];
          }));
        </script>
        @endif

        {{-- Local de doação --}}
        <div class="form-group mb-3">
          <label for="local_doacao_id">Local de Doação</label>
          <select name="local_doacao_id" class="form-control" required>
            <option value="">Selecione um local</option>
            @foreach($locais as $local)
              <option value="{{ $local->id }}" {{ old('local_doacao_id') == $local->id ? 'selected' : '' }}>
                {{ $local->nome }} - {{ $local->cidade ?? '' }}
              </option>
            @endforeach
          </select>
          @error('local_doacao_id')
            <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

        {{-- Data --}}
        <div class="form-group mb-3">
          <label for="date">Data</label>
          <input type="date" id="data_visivel" class="form-control">
          <input type="hidden" name="date" id="data" required>
        </div>

        {{-- Horário Disponível --}}
        <div class="form-group mb-3">
          <label for="horario_disponivel_id">Horário Disponível</label>
          <select name="horario_disponivel_id" id="horario_disponivel_id" class="form-control" required>
            <option value="">Selecione um local e uma data</option>
          </select>
        </div>


        {{-- Botões --}}
        <div class="text-end mt-4">
          <button type="submit" class="btn btn-success"
            {{ ($historico && !$historico->pode_doar && $user->usertype === '0') ? 'disabled' : '' }}>
            Agendar
          </button>
          <a href="{{ url('/') }}" class="btn btn-secondary">Cancelar</a>
        </div>
      </form>


        </div>
      </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const localSelect = document.querySelector('[name="local_doacao_id"]');
    const dateInput = document.getElementById('data_visivel');
    const hiddenDate = document.getElementById('data');
    const horarioSelect = document.getElementById('horario_disponivel_id');

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

                const estaCheio = h.total_agendados >= h.limite;

                opt.textContent = `${h.horario} - Dr(a). ${h.nome_doutor || 'N/A'} (${h.turno})` +
                                  (estaCheio ? ' - Indisponível' : '');

                if (estaCheio) {
                    opt.disabled = true;
                }

                horarioSelect.appendChild(opt);
            });

        } catch (e) {
            console.error('Erro ao carregar horários:', e);
            horarioSelect.innerHTML = '<option value="">Erro ao carregar horários</option>';
        }
    }

    localSelect.addEventListener('change', carregarHorariosDisponiveis);
    dateInput.addEventListener('change', carregarHorariosDisponiveis);
});
</script>






    @include('admin.script')
  </body>




</html>
