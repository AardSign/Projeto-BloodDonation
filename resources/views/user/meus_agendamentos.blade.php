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

      thead tr{
        background-color: #fff;
      }

      tbody tr{
        background-color: #2f3b52;
        color: white;
        border-color: white;
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

      .btn-success-custom {
  width: 120px;
  height: 40px;
  background-color: #4CAF50 !important;
  border: 1px solid #4CAF50 !important;
  color: white;
}

.btn-success-custom:hover {
  background-color: #388E3C !important;
  border-color: #388E3C !important;
  color: black;
}

.btn-danger-custom {
  width: 100px;
  height: 33px;
  background-color: #d32f2f !important;
  border: 1px solid #d32f2f !important;
  color: white;
}

.btn-danger-custom:hover {
  background-color: #b71c1c !important;
  border-color: #b71c1c !important;
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
         
          @if(session('success'))
            <div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              {{ session('success') }}
            </div>
          @endif
          <div class="card-custom">
            <div class="edit-info-title">Meus Agendamentos</div>

          @if(Auth::user()->historicoMedico && !Auth::user()->historicoMedico->pode_doar)
            <div class="alert alert-danger">
              <strong>Atenção:</strong> Você está temporariamente ou permanentemente inapto para realizar novas doações, conforme seu histórico médico.
            </div>
          @endif

                @if(Auth::user()->historicoMedico && !Auth::user()->historicoMedico->pode_doar)
          <div class="alert alert-danger">
            <strong>Atenção:</strong> Você está inapto para realizar novas doações, de acordo com seu histórico médico.
          </div>

          <div class="text-end mb-3">
            <button class="btn btn-danger" disabled>Agendamento Bloqueado</button>
          </div>
        @else
          <div class="text-end mb-3">
            <a href="{{ url('/agendar') }}" class="btn btn-success-custom">Novo Agendamento</a>
          </div>
        @endif


          <table class="table table-bordered mt-3">
            <thead>
              <tr>
                <th>Data</th>
                <th>Hora</th>
                <th>Local</th>
                <th>Status</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              @forelse($appointments as $agendamento)
                <tr>
                  <td>{{ \Carbon\Carbon::parse($agendamento->date)->format('d/m/Y') }}</td>
                  <td>{{ \Carbon\Carbon::parse($agendamento->time)->format('H:i') }}</td>
                  <td>{{ $agendamento->local->nome ?? '-' }}</td>
                  <td>{{ $agendamento->status }}</td>
                  <td>
                    @if($agendamento->status === 'Marcado')
                      <a href="{{ url('/agendamento/'.$agendamento->id.'/remarcar') }}" class="custom-file-upload">Remarcar</a>
                      <form action="{{ url('/agendamento/'.$agendamento->id.'/cancelar') }}" method="POST" style="display:inline;">
                        @csrf
                        <a href="{{ url('/agendamento/'.$agendamento->id.'/cancelar') }}" class="btn btn-danger-custom">Cancelar</a>
                      </form>
                    @else
                      <span class="text-muted">-</span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="text-center">Nenhum agendamento encontrado.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
          </div>
        </div>
      </div>
    </div>

    @include('admin.script')
  </body>
</html>
