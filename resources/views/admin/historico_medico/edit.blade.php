<!DOCTYPE html>
<html lang="pt-BR">
<head>
  @include('admin.css')
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

input.form-control {
  background-color: #fff !important;
  color: #222 !important;
}


      tbody tr{
        background-color: #2f3b52;
        color: white;
        border-color: white;
      }

      tbody tr:hover{
        background-color: #2f3b52 !important;
        color: white !important;
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
        width: 160px;
        height: 40px;
        background-color: #4CAF50 !important;
        border: 1px solid #4CAF50 !important;
        color: white;
      }

      .btn-green {
        width: 100px;
        height: 40px;
        background-color: #4CAF50 !important;
        border: 1px solid #4CAF50 !important;
        color: white;
      }

.checkbox-container {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
}

.checkbox-container .mb-3 {
  display: flex;
  align-items: center;
  gap: 8px;
}


      .btn-secondary {
        width: 140px;
        height: 40px;
        background-color: #d32f2f !important;
        border: 1px solid #d32f2f !important;
        color: white !important;
      }

      .btn-clean {
        width:100px;
        height: 40px;
        background-color: #d32f2f !important;
        border: 1px solid #d32f2f !important;
        color: white !important;
      }

      .btn-clean:hover {
        background-color: #b71c1c !important;
        border-color: #b71c1c !important;
        color: white ;
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

      @media (max-width: 768px) {
      .form-group {
        flex: 1 1 100%;
        flex-direction: column;
        align-items: flex-start;
      }

      .form-group label {
        width: 100%;
        margin-bottom: 4px;
        text-align: left;
      }

      .form-actions {
        flex-direction: column;
        align-items: stretch;
      }

      .btn {
        width: 100% !important;
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

          <div class="edit-info-title">Editar Histórico Médico de {{ $usuario->name }}</div>

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

          {{-- Câncer --}}
          <div class="mb-3">
            <label>Teve câncer?</label>
            <input type="hidden" name="teve_cancer" value="0">
            <input type="checkbox" name="teve_cancer" value="1" {{ $historico->teve_cancer ? 'checked' : '' }}>
          </div>

          {{-- Doença cardíaca --}}
          <div class="mb-3">
            <label>Doença cardíaca?</label>
            <input type="hidden" name="tem_doenca_cardiaca" value="0">
            <input type="checkbox" name="tem_doenca_cardiaca" value="1" {{ $historico->tem_doenca_cardiaca ? 'checked' : '' }}>
          </div>

          {{-- Convulsões --}}
          <div class="mb-3">
            <label>Histórico de convulsões?</label>
            <input type="hidden" name="historico_convulsoes" value="0">
            <input type="checkbox" name="historico_convulsoes" value="1" {{ $historico->historico_convulsoes ? 'checked' : '' }}>
          </div>

          {{-- Doença infecciosa --}}
          <div class="form-group">
            <label>Doença infecciosa</label>
            <input type="text" name="tem_doenca_infecciosa" class="form-control" value="{{ $historico->tem_doenca_infecciosa }}">
          </div>

          {{-- Peso --}}
          <div class="form-group">
            <label>Peso (kg)</label>
            <input type="number" step="0.01" name="peso" class="form-control" value="{{ $historico->peso }}">
          </div>

          {{-- Data da transfusão --}}
          <div class="form-group">
            <label>Data da última transfusão</label>
            <input type="date" name="data_ultima_transfusao" class="form-control" value="{{ $historico->data_ultima_transfusao }}">
          </div>

          {{-- Medicamentos --}}
          <div class="form-group">
            <label>Medicamentos em uso:</label>
            <input name="usa_medicamentos" class="form-control">{{ $historico->usa_medicamentos }}</input>
          </div>


          {{-- Autoimunes --}}
          <div class="form-group">
            <label>Doenças autoimunes:</label>
            <input name="doencas_autoimunes" class="form-control">{{ $historico->doencas_autoimunes }}</input>
          </div>


          {{-- Botões --}}
          <div class="text-end mt-4">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('historico.show', $usuario->id) }}" class="btn btn-secondary">Cancelar</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  @include('admin.script')
  
</body>
</html>
