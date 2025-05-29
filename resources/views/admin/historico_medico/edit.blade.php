<!DOCTYPE html>
<html lang="pt-BR">
<head>
  @include('admin.css')
  <style>
    label {
      display: inline-block;
      width: 250px;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="container-scroller">
    @include('admin.sidebar')
    @include('admin.navbar')

    <div class="container-fluid page-body-wrapper">
      <div class="container" style="padding-top: 100px; max-width: 800px;">
        <h2 class="mb-4 text-center">Editar Histórico Médico de {{ $usuario->name }}</h2>

        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('historico.storeOrUpdate', $usuario->id) }}" method="POST">
         @csrf


          {{-- Insulina --}}
          <div class="mb-3">
            <label>Usa insulina?</label>
            <input type="hidden" name="usa_insulina" value="0">
            <input type="checkbox" name="usa_insulina" value="1" {{ $historico->usa_insulina ? 'checked' : '' }}>
          </div>

          {{-- Doença cardíaca --}}
          <div class="mb-3">
            <label>Doença cardíaca?</label>
            <input type="hidden" name="tem_doenca_cardiaca" value="0">
            <input type="checkbox" name="tem_doenca_cardiaca" value="1" {{ $historico->tem_doenca_cardiaca ? 'checked' : '' }}>
          </div>

          {{-- Doença infecciosa --}}
          <div class="mb-3">
            <label>Doença infecciosa</label>
            <input type="text" name="tem_doenca_infecciosa" class="form-control" value="{{ $historico->tem_doenca_infecciosa }}">
          </div>

          {{-- Peso --}}
          <div class="mb-3">
            <label>Peso (kg)</label>
            <input type="number" step="0.01" name="peso" class="form-control" value="{{ $historico->peso }}">
          </div>

          {{-- Medicamentos --}}
          <div class="mb-3">
            <label>Medicamentos em uso</label>
            <textarea name="usa_medicamentos" class="form-control">{{ $historico->usa_medicamentos }}</textarea>
          </div>

          {{-- Data da transfusão --}}
          <div class="mb-3">
            <label>Data da última transfusão</label>
            <input type="date" name="data_ultima_transfusao" class="form-control" value="{{ $historico->data_ultima_transfusao }}">
          </div>

          {{-- Câncer --}}
          <div class="mb-3">
            <label>Teve câncer?</label>
            <input type="hidden" name="teve_cancer" value="0">
            <input type="checkbox" name="teve_cancer" value="1" {{ $historico->teve_cancer ? 'checked' : '' }}>
          </div>

          {{-- Autoimunes --}}
          <div class="mb-3">
            <label>Doenças autoimunes</label>
            <textarea name="doencas_autoimunes" class="form-control">{{ $historico->doencas_autoimunes }}</textarea>
          </div>

          {{-- Convulsões --}}
          <div class="mb-3">
            <label>Histórico de convulsões?</label>
            <input type="hidden" name="historico_convulsoes" value="0">
            <input type="checkbox" name="historico_convulsoes" value="1" {{ $historico->historico_convulsoes ? 'checked' : '' }}>
          </div>

          {{-- Botões --}}
          <div class="text-end mt-4">
            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="{{ route('historico.show', $usuario->id) }}" class="btn btn-secondary">Cancelar</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  @include('admin.script')
</body>
</html>
