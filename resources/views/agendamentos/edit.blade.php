<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <style>
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
        <div class="container" align="center" style="padding-top: 100px; max-width: 600px;">

          <h2>Editar Agendamento</h2>

          @if(session('message'))
            <div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              {{ session('message') }}
            </div>
          @endif

          <form action="{{ url('/agendamento/' . $agendamento->id . '/atualizar') }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Doador (apenas leitura) --}}
            <div style="padding:15px;">
              <label>Doador</label>
              <input type="text" class="form-control" value="{{ $agendamento->user->name ?? 'Usuário removido' }}" readonly>
            </div>

            {{-- Local --}}
            <div class="form-group mb-3">
              <label for="local_doacao_id">Local de Doação</label>
              <select name="local_doacao_id" class="form-control" required>
                <option value="">Selecione um local</option>
                @foreach($locais as $local)
                  <option value="{{ $local->id }}"
                    {{ $agendamento->local_doacao_id == $local->id ? 'selected' : '' }}>
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
              <label>Data</label>
              <input type="date" name="date" id="data" value="{{ $agendamento->date }}" class="form-control" required>
            </div>

            {{-- Horário --}}
            <div class="form-group mb-3">
              <label for="time">Horário</label>
              <select name="time" id="horario" class="form-control"
                data-horario-atual="{{ \Carbon\Carbon::parse($agendamento->time)->format('H:i') }}" required>
                
              </select>
            </div>

            {{-- Status --}}
            <div style="padding:15px;">
              <label>Status</label>
              <select name="status" required>
                <option value="Marcado" {{ $agendamento->status == 'Marcado' ? 'selected' : '' }}>Marcado</option>
                <option value="Concluído" {{ $agendamento->status == 'Concluído' ? 'selected' : '' }}>Concluído</option>
                <option value="Cancelado" {{ $agendamento->status == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
              </select>
            </div>

            <div style="padding:15px;">
              <button type="submit" class="btn btn-primary">Atualizar</button>
              <a href="{{ url('/agendamentos') }}" class="btn btn-secondary">Cancelar</a>
            </div>
          </form>

        </div>
      </div>
    </div>

    {{-- Script para horários dinâmicos --}}
    <script>
      document.addEventListener('DOMContentLoaded', async function () {
        const campoData = document.getElementById('data');
        const campoHora = document.getElementById('horario');
        const horarioAtual = campoHora.getAttribute('data-horario-atual');

        try {
          const resposta = await fetch('/disponibilidade');
          if (!resposta.ok) throw new Error('Erro ao buscar disponibilidade');
          const dados = await resposta.json();

          const diasBloqueados = dados.datas_bloqueadas;
          const horariosBloqueados = dados.horarios_bloqueados;

          const hoje = new Date().toISOString().split('T')[0];
          campoData.setAttribute('min', hoje);

          if (campoData.value) gerarHorarios(campoData.value);

          campoData.addEventListener('change', function () {
            gerarHorarios(this.value);
          });

          function gerarHorarios(data) {
            campoHora.innerHTML = '';
            const diaSemana = new Date(data).getDay();
            if (diaSemana === 0 || diaSemana === 6) {
              campoHora.innerHTML = '<option value="">Fim de semana indisponível</option>';
              return;
            }

            if (diasBloqueados.includes(data)) {
              campoHora.innerHTML = '<option value="">Este dia está com limite esgotado</option>';
              return;
            }

            const horarios = [];
            for (let h = 8; h < 17; h++) {
              const hora = h.toString().padStart(2, '0') + ':00';
              if (!horariosBloqueados[data] || !horariosBloqueados[data].includes(hora)) {
                horarios.push(hora);
              }
            }

            if (horarios.length === 0) {
              campoHora.innerHTML = '<option value="">Nenhum horário disponível</option>';
            } else {
              horarios.forEach(h => {
                const selected = h === horarioAtual ? 'selected' : '';
                campoHora.innerHTML += `<option value="${h}" ${selected}>${h}</option>`;
              });

              if (horarioAtual && !horarios.includes(horarioAtual)) {
                campoHora.innerHTML = `<option value="${horarioAtual}" selected>${horarioAtual} (atual)</option>` + campoHora.innerHTML;
              }
            }
          }
        } catch (e) {
          campoHora.innerHTML = '<option value="">Erro ao carregar horários</option>';
        }
      });
    </script>

    @include('admin.script')
  </body>
</html>
