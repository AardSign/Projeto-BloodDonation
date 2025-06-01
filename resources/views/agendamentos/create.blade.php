<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <style>
      label {
        display: inline-block;
        width: 150px;
        font-weight: bold;
        color: #f0f0f0;
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
        display: inline-block;
        padding: 8px 16px;
        cursor: pointer;
        border-radius: 4px;
        border: 1px solid #1e90ff;
        background-color: #1e90ff;
        color: white;
        font-size: 1rem;
        user-select: none;
        transition: background-color 0.3s ease, color 0.3s ease;
      }

      .custom-file-upload:hover {
        background-color: #005bb5;
        border-color: #005bb5;
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

      .form-actions .btn-primary {
        width: 160px;
        height: 40px;
        background-color: #4CAF50;
        border: 1px solid #4CAF50;
        color: white;
      }

      .form-actions .btn-secondary {
        width: 140px;
        height: 40px;
        background-color: #d32f2f;
        border: 1px solid #d32f2f;
        color: white;
      }

      .form-actions .btn-primary:hover {
        background-color: #388E3C;
        border-color: #388E3C;
        color: black;
      }

      .form-actions .btn-secondary:hover {
        background-color: #b71c1c;
        border-color: #b71c1c;
        color: white;
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

      select{
        flex: 1;
        padding: 6px 8px;
        border-radius: 4px;
        border: 1px solid #ccc !important;
        font-size: 1rem;
        background-color: #fff !important;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        color: #222;

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
    @include('admin.css')
  </head>
  <body>
    <div class="container-scroller">
      @include('admin.sidebar')
      @include('admin.navbar')

      <div class="container-fluid">
        <div class="container" align="center">

          @if(session()->has('message'))
            <div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              {{ session('message') }}
            </div>
          @endif

          <div class="card-custom">
          <div class="edit-info-title">Novo Agendamento</div>

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
        
        <div class="form-actions">
                <button type="submit" class="btn btn-primary"{{ ($historico && !$historico->pode_doar && $user->usertype === '0') ? 'disabled' : '' }}>
            Agendar</button>
                <a href="{{ url('/') }}" class="btn btn-secondary">Cancelar</a>
              </div>
      </form>
          </div>

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
