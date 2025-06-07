<!DOCTYPE html>
<html lang="en">
  <head>
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
        <div class="container" style="padding-top: 100px;">
          <h2>Resultados da busca por "{{ $q }}"</h2>

          <h4>Usuários</h4>
          @if($usuarios->isEmpty())
            <p>Nenhum usuário encontrado.</p>
          @else
            <ul>
              @foreach($usuarios as $usuario)
                <li>
                  {{ $usuario->name }} — {{ $usuario->email }}
                  <a href="{{ url('/usuarios/'.$usuario->id.'/editar') }}" class="btn btn-sm btn-primary">Editar Usuário</a>
                </li>
              @endforeach
            </ul>
          @endif

          <h4 class="mt-5">Agendamentos</h4>
          @if($agendamentos->isEmpty())
            <p>Nenhum agendamento encontrado.</p>
          @else
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Doador</th>
                  <th>Data</th>
                  <th>Hora</th>
                  <th>Status</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
                @foreach($agendamentos as $agendamento)
                  <tr>
                    <td>{{ $agendamento->user->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($agendamento->date)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($agendamento->time)->format('H:i') }}</td>
                    <td>
                      @if($agendamento->status == 'Agendado')
                        <span class="badge badge-warning">Agendado</span>
                      @elseif($agendamento->status == 'Concluído')
                        <span class="badge badge-success">Concluído</span>
                      @elseif($agendamento->status == 'Cancelado')
                        <span class="badge badge-danger">Cancelado</span>
                      @else
                        <span class="badge badge-secondary">{{ $agendamento->status }}</span>
                      @endif
                    </td>
                    <td>
                      @if($agendamento->status == 'Agendado')
                        <a href="{{ url('/agendamento/'.$agendamento->id.'/editar') }}" class="btn btn-sm btn-primary">Editar</a>
                        <a href="{{ url('/agendamento/'.$agendamento->id.'/concluir') }}"
                           onclick="return confirm('Deseja realmente marcar como CONCLUÍDO?')"
                           class="btn btn-sm btn-success">
                          <i class="mdi mdi-check"></i> Concluir
                        </a>
                        <a href="{{ url('/agendamento/'.$agendamento->id.'/cancelar') }}"
                           onclick="return confirm('Tem certeza que deseja CANCELAR este agendamento?')"
                           class="btn btn-sm btn-danger">
                          <i class="mdi mdi-close"></i> Cancelar
                        </a>

                      @else
                        <a href="{{ url('/agendamento/'.$agendamento->id.'/editar') }}" class="btn btn-sm btn-secondary">Ver</a>
                      @endif
                    </td>

                  </tr>
                @endforeach
              </tbody>
            </table>
          @endif

        </div>
      </div>
    </div>

    @include('admin.script')
    
  </body>
</html>
