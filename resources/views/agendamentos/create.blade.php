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

        <div class="mb-3">
          <label>Selecionar Doador</label>
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
          <input type="date" name="date" id="data" class="form-control" required>
        </div>

        {{-- Hora --}}
        <div class="form-group mb-3">
          <label for="time">Horário</label>
          <select name="time" id="horario" class="form-control" required>
            <option value="">Selecione uma data primeiro</option>
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
            document.addEventListener('DOMContentLoaded', async function () {
              const campoData = document.getElementById('data');
              const campoHora = document.getElementById('horario');

              let dados = {};

              try {
                const resposta = await fetch('/disponibilidade');
                if (!resposta.ok) throw new Error('Erro ao buscar disponibilidade');
                dados = await resposta.json(); 
              } catch (e) {
                campoHora.innerHTML = '<option value="">Erro ao carregar horários</option>';
                return; // Impede que o código abaixo rode em caso de falha
              }

              const diasBloqueados = dados.datas_bloqueadas;
              const horariosBloqueados = dados.horarios_bloqueados;

              // Limita datas passadas e finais de semana
              const hoje = new Date().toISOString().split('T')[0];
              campoData.setAttribute('min', hoje);

              campoData.addEventListener('change', function () {
                const dataSelecionada = this.value;
                campoHora.innerHTML = '';

                // Verifica se é fim de semana
                const diaSemana = new Date(dataSelecionada).getDay();
                if (diaSemana === 0 || diaSemana === 6) {
                  campoHora.innerHTML = '<option value="">Fim de semana indisponível</option>';
                  return;
                }

                // Verifica se o dia está cheio
                if (diasBloqueados.includes(dataSelecionada)) {
                  campoHora.innerHTML = '<option value="">Este dia está com limite esgotado</option>';
                  return;
                }

                // Gera horários válidos entre 08:00 e 16:00
                const horarios = [];
                for (let h = 8; h < 17; h++) {
                  const hora = h.toString().padStart(2, '0') + ':00';
                  if (!horariosBloqueados[dataSelecionada] || !horariosBloqueados[dataSelecionada].includes(hora)) {
                    horarios.push(hora);
                  }
                }

                if (horarios.length === 0) {
                  campoHora.innerHTML = '<option value="">Nenhum horário disponível</option>';
                } else {
                  campoHora.innerHTML = '<option value="">Selecione um horário</option>';
                  horarios.forEach(h => {
                    campoHora.innerHTML += `<option value="${h}">${h}</option>`;
                  });
                }
              });
            });
          </script>

    @include('admin.script')
  </body>




</html>
