<div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_navbar.html -->
         
        <nav class="navbar p-0 fixed-top d-flex flex-row">
          <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
            <a class="navbar-brand brand-logo-mini" href="index.html"> <img src="admin/assets/images/logo-mini.png" alt="logo" /></a>
          </div>
          <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
           {{--  <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
              <span class="mdi mdi-menu"></span>
            </button> --}}
            @if(Auth::user()->usertype == '1')
            <ul class="navbar-nav w-100">
              <li class="nav-item w-100">
                <form action="{{ url('/buscar') }}" method="GET" class="form-inline" style="margin-left: auto;">
                  <input class="form-control mr-sm-2" type="search" name="q" placeholder="Buscar doador..." aria-label="Search" required>
                </form>
              </li>
            </ul>
            @endif
            <ul class="navbar-nav navbar-nav-right">
              <li class="nav-item dropdown d-none d-lg-block">
                <!--  -->
              </li>
           
              <li class="nav-item dropdown border-left">
                <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                  <i class="mdi mdi-bell"></i>
                  @if($notificacoes->where('lida', false)->count() > 0)
                    <span class="count bg-danger">{{ $notificacoes->where('lida', false)->count() }}</span>
                  @endif
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                  <h6 class="p-3 mb-0">Notificações</h6>
                  <div class="dropdown-divider"></div>

                  @foreach($notificacoes as $n)
                    <a class="dropdown-item preview-item notificacao" data-id="{{ $n->id }}" href="{{ route('notificacoes.visualizar', $n->id) }}">
                      <div class="preview-thumbnail">
                        <div class="preview-icon bg-dark rounded-circle">
                          <i class="mdi mdi-information text-warning"></i>
                        </div>
                      </div>
                      <div class="preview-item-content">
                        <p class="preview-subject mb-1">{{ $n->titulo }}</p>
                        <p class="text-muted ellipsis mb-0">{{ $n->mensagem }}</p>
                      </div>
                    </a>
                    <div class="dropdown-divider"></div>
                  @endforeach


                </div>
              </li>
              <x-app-layout>

              </x-app-layout>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
              <span class="mdi mdi-format-line-spacing"></span>
            </button>
          </div>
        </nav>

        <script>
        document.addEventListener('DOMContentLoaded', function () {
          const notifBtn = document.getElementById('notificationDropdown');
          notifBtn.addEventListener('click', function () {
            fetch("{{ route('notificacoes.marcarTodas') }}", {
              method: 'POST',
              headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
              }
            }).then(() => {
              const contador = notifBtn.querySelector('.count');
              if (contador) {
                contador.style.display = 'none';
              }

            
              document.querySelectorAll('.notificacao').forEach(function (el) {
                const id = el.getAttribute('data-id');
                setTimeout(() => {
                  fetch(`/notificacoes/${id}`, {
                    method: 'DELETE',
                    headers: {
                      'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                  }).then(res => {
                    if (res.ok) {
                      el.remove();
                    }
                  });
                }, 180000); 
              });
            });
          });
        });
        </script>



      <style>
        #notificationDropdown + .dropdown-menu {
          min-width: 300px;
          padding: 10px;
        }

        .preview-item-content p {
          white-space: normal !important;
          overflow: visible !important;
          text-overflow: unset;
        }
      </style>