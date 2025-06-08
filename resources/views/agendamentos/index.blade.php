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
   margin-right: 8px; /* ou o quanto quiser */
  text-decoration: none;
}


      .custom-file-upload:hover {
        background-color: #005bb5 !important;
        border-color: #005bb5 !important;
        color: white;
      }

      .custom-file-upload-two {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 100px;
  height: 22px;
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


      .custom-file-upload-two:hover {
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
        width: 120px;
        height: 40px;
        background-color: #4CAF50 !important;
        border: 1px solid #4CAF50 !important;
        color: white;
      }

      .btn-primary-one {
        width: 100px;
        height: 22px;
        background-color: #4CAF50 !important;
        border: 1px solid #4CAF50 !important;
        color: white;
      }

      .btn-primary-one:hover {
        background-color: #388E3C !important;
        border-color: #388E3C !important;
        color: black;
      }

      .btn-secondary {
        width: 100px;
        height: 22px;
        background-color: #d32f2f !important;
        border: 1px solid #d32f2f !important;
        color: white !important;
      }

      .btn-primary:hover {
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

  .text-end.mb-3 {
    display: flex;
    flex-direction: column;
    gap: 10px;
    align-items: stretch;
    margin-bottom: 20px !important;
  }

  .row.g-3.mb-4 {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 20px !important;
  }

  .row.g-3.mb-4 .col-md-4 {
    width: 100%;
  }

  .form-actions {
    flex-direction: column;
    align-items: stretch;
  }

  .btn,
  .custom-file-upload {
    width: 100% !important;
  }

  .table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
  }

  table {
    width: 100%;
    border-collapse: collapse;
  }

  .table thead {
    display: none; /* Oculta o cabeçalho da tabela no mobile */
  }

  .table tbody tr {
    display: block;
    margin-bottom: 15px;
    background-color: #2f3b52;
    border-radius: 8px;
    padding: 10px;
    border: 1px solid #444;
  }

  .table tbody td {
    display: flex;
    justify-content: space-between;
    padding: 8px;
    border: none;
    border-bottom: 1px solid #444;
    font-size: 0.95rem;
  }

  .table tbody td::before {
    content: attr(data-label);
    font-weight: bold;
    color: #90caf9;
    flex-basis: 50%;
    text-align: left;
    padding-right: 10px;
  }

  .table tbody td:last-child {
    border-bottom: none;
  }

  .action-buttons {
    flex-direction: column;
    align-items: stretch;
    gap: 6px;
  }
}

.action-buttons {
  display: flex;
  flex-direction: column;
  gap: 8px;
  align-items: center;
}




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
          <div class="edit-info-title">Lista de Agendamentos</div>

          @if(session('success'))
            <div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              {{ session('success') }}
            </div>
          @endif

          <form method="GET" action="{{ url('/agendamentos') }}"
                class="form-inline mb-4 d-flex flex-column flex-md-row justify-content-start align-items-stretch align-items-md-center gap-2">
            <input type="text" name="q" class="form-control w-100 w-md-50 mr-md-2" placeholder="Buscar por doador, data, hora, status ou local..." value="{{ request('q') }}">
            <div class="d-flex flex-column flex-md-row gap-2">
              <button type="submit" class="custom-file-upload w-100 w-md-auto">Buscar</button>
              <a href="{{ url('/agendar') }}" class="btn btn-primary w-100 w-md-auto">Novo Agendamento</a>
            </div>
          </form>

          <div class="table-responsive">
            <table class="table table-bordered mt-3">
              <thead class="text-center">
                <tr>
                  <th>Doador</th>
                  <th>Data</th>
                  <th>Hora</th>
                  <th>Local</th>
                  <th>Status</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
                @foreach($appointments as $agendamento)
                  <tr class="text-center">
                    <td>{{ $agendamento->user->name ?? 'Usuário removido' }}</td>
                    <td>{{ \Carbon\Carbon::parse($agendamento->date)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($agendamento->time)->format('H:i') }}</td>
                    <td>{{ $agendamento->local->nome ?? '-' }}</td>
                    <td>{{ $agendamento->status }}</td>
                    <td>
                      @if($agendamento->status === 'Marcado')
             <td class="action-buttons">
  <a href="{{ url('/agendamento/'.$agendamento->id.'/editar') }}" class="custom-file-upload-two" style="width: 100%;">Editar</a>
  <a href="{{ url('/agendamento/'.$agendamento->id.'/concluir') }}" class="btn btn-primary-one">Concluir</a>
  <a href="{{ url('/agendamento/'.$agendamento->id.'/cancelar') }}" class="btn btn-secondary">Cancelar</a>
</td>


                      @else
                        <span class="text-muted">Ações indisponíveis</span>
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>

  @include('admin.script')
</body>

</html>