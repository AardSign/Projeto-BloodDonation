<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Histórico Médico</title>
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
      <div class="container mt-5">
        <h2 class="text-center mb-4">Meu Histórico Médico</h2>

        @if($ultimaDoacao)
          <div class="alert alert-info mt-4">
            Última doação: <strong>{{ \Carbon\Carbon::parse($ultimaDoacao->date)->format('d/m/Y') }}</strong><br>
            Próxima doação permitida: <strong>{{ $proximaPermitida->format('d/m/Y') }}</strong>
          </div>
        @else
          <div class="alert alert-secondary mt-4">
            Nenhuma doação realizada até o momento.
          </div>
        @endif

        @php $historico = Auth::user()->historicoMedico; @endphp

        @if($historico)
          <ul class="list-group">
            <li class="list-group-item">Usa insulina: <strong>{{ $historico->usa_insulina ? 'Sim' : 'Não' }}</strong></li>
            <li class="list-group-item">Doença cardíaca: <strong>{{ $historico->tem_doenca_cardiaca ? 'Sim' : 'Não' }}</strong></li>
            <li class="list-group-item">Doença infecciosa: <strong>{{ $historico->tem_doenca_infecciosa ?? 'Nenhuma' }}</strong></li>
            <li class="list-group-item">Peso: <strong>{{ $historico->peso ?? 'Não informado' }}</strong></li>
            <li class="list-group-item">Medicamentos: <strong>{{ $historico->usa_medicamentos ?? 'Nenhum' }}</strong></li>
            <li class="list-group-item">Última transfusão: <strong>{{ $historico->data_ultima_transfusao ?? 'Nunca' }}</strong></li>
            <li class="list-group-item">Teve câncer: <strong>{{ $historico->teve_cancer ? 'Sim' : 'Não' }}</strong></li>
            <li class="list-group-item">Doenças autoimunes: <strong>{{ $historico->doencas_autoimunes ?? 'Nenhuma' }}</strong></li>
            <li class="list-group-item">Histórico de convulsões: <strong>{{ $historico->historico_convulsoes ? 'Sim' : 'Não' }}</strong></li>
            <li class="list-group-item">Apto a doar: <strong>{{ $historico->pode_doar ? 'Sim' : 'Não' }}</strong></li>
          </ul>
        @else
          <div class="alert alert-warning mt-3">Nenhum histórico médico cadastrado.</div>
        @endif

        <div class="text-end mt-4">
          <a href="{{ url('/') }}" class="btn btn-secondary">Voltar ao Início</a>
        </div>
      </div>
    </div>
  </div>

  @include('admin.script')
  
</body>
</html>
