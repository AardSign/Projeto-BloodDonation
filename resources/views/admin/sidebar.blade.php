<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doação de Sangue</title>
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> 
    <style>
        /* Ajuste geral */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #3c4b68; /* Pequeno fundo claro */
        }

        .sidebar {
            position: fixed;
            width: 245px;
            height: 100%;
            background-color: #2f3b52;
            color: white;
        }

        .sidebar .nav-item {
            margin: 10px 0;
        }

        .sidebar .nav-link {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 10px;
        }

        .sidebar .nav-link:hover {
            background-color: #3c4b68;
        }

        .menu-icon {
            margin-right: 10px;
        }

        .profile {
            display: flex;
            align-items: center;
            padding: 10px;
        }

        .profile-pic {
            margin-right: 10px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .profile-name h5 {
            margin: 0;
            font-weight: normal;
        }

        .profile-name span {
            font-size: 12px;
            color: #bbb;
        }

        /* Conteúdo principal */
        #content-area {
            margin-left: 244px; /* Para respeitar a sidebar */
            padding: 40px 20px;
            max-width: 800px; /* Limitar largura igual ao estático */
            margin-top: 40px;
        }

        form input, form select, form input[type="date"], form input[type="time"], form button {
            padding: 8px;
            width: 100%; /* Botões e inputs com largura 100% */
            margin-bottom: 15px;
            font-size: 14px;
            background-color: #fff; /* Cor de fundo para todos os campos */
            border: 1px solid #ccc; /* Borda padrão */
            border-radius: 4px; /* Bordas arredondadas para todos os campos */
            color: #aaa; /* Cor do texto padrão */
        }

        /* Placeholder */
        form input::placeholder, form select::placeholder {
            color: #aaa; /* Cor cinza para o placeholder */
        }

        form select {
            background-color: #fff; /* Garantir que o select também tenha fundo branco */
            border: 1px solid #ccc; /* Borda para o select */
        }

        form input[type="date"], form input[type="time"] {
            background-color: #fff; /* Cor de fundo para data e hora */
            border: 1px solid #ccc; /* Borda para data e hora */
        }

        /* Botões - ajustando o estilo dos botões grandes */
        form button {
            background-color:#4CAF50; /* Verde claro */
            color: white;
            padding: 10px;
            width: 100%; /* Largura do botão é 100% */
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 4px; /* Bordas arredondadas */
            box-sizing: border-box; /* Garantir que o tamanho do botão esteja correto */
        }

        form button:hover {
            background-color: #45a049; /* Verde escuro quando passa o mouse */
        }

        /* Estilo dos botões "Editar" e "Excluir" na tabela */
        .actions button {
            margin-right: 5px;
            padding: 6px 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 14px;
            border-radius: 4px;
        }

        .actions button:hover {
            background-color: #45a049; /* Verde mais escuro quando passa o mouse */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: white;
            color: #333; /* Mudando a cor para melhorar a visibilidade */
        }
    </style>
</head>

<body>

    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
            <a class="sidebar-brand brand-logo" href="{{ url('/') }}"><img src="{{ asset('admin/assets/images/logo.png') }}" alt="logo" /></a>
            <a class="sidebar-brand brand-logo-mini" href="{{ url('/') }}"><img src="{{ asset('admin/assets/images/logo-mini.png') }}" alt="logo" /></a>
        </div>

<ul class="nav">
  <li class="nav-item profile">
    <div class="profile-desc">
      <div class="profile-pic">
        <div class="count-indicator">
          <img class="img-xs rounded-circle" 
               src="{{ Auth::user()->image ? asset('donorphotos/' . Auth::user()->image) : asset('admin/assets/images/faces/placeholder.jpg') }}" 
               alt="Foto de perfil" />
          <span class="count bg-success"></span>
        </div>
      </div>
      <div class="profile-name">
        <h5 class="mb-0 font-weight-normal">{{ Auth::user()->name }}</h5>
        <span>
          @if(Auth::user()->usertype == '1')
            Administrador
          @elseif(Auth::user()->usertype == '0')
            Doador
          @else
            Usuário
          @endif
        </span>
      </div>
    </div>
  </li>


  @if(Auth::user()->usertype == '1')
  <li class="nav-item menu-items">
    <a class="nav-link" href="{{ url('add_donor_view') }}">
      <span class="menu-icon"><i class="mdi mdi-file-document-box"></i></span>
      <span class="menu-title">Adicionar Doadores</span>
    </a>
  </li>

  <li class="nav-item menu-items">
    <a class="nav-link" href="{{ url('usuarios') }}">
      <span class="menu-icon"><i class="mdi mdi-database"></i></span>
      <span class="menu-title">Gerenciar Doadores</span>
    </a>
  </li>
    
  <li class="nav-item menu-items">
    <a class="nav-link" href="{{ url('agendamentos') }}">
      <span class="menu-icon"><i class="mdi mdi-calendar-text"></i></span>
      <span class="menu-title">Agendamentos</span>
    </a>
  </li>
    @endif
  <li class="nav-item menu-items">
    <a class="nav-link" href="{{ url('agendar') }}">
      <span class="menu-icon"><i class="mdi mdi-calendar-plus"></i></span>
      <span class="menu-title">Novo Agendamento</span>
    </a>
  </li>

  @if(Auth::user()->usertype == '0') {{-- Usuário normal --}}
  <li class="nav-item menu-items">
    <a class="nav-link" href="{{ url('/meus-agendamentos') }}">
      <span class="menu-icon"><i class="mdi mdi-calendar-text"></i></span>
      <span class="menu-title">Meus Agendamentos</span>
    </a>
  </li>
    @endif

    @if(Auth::user()->usertype == '0')
  <li class="nav-item menu-items">
    <a class="nav-link" href="{{ url('/perfil/editar') }}">
      <span class="menu-icon"><i class="mdi mdi-account-edit"></i></span>
      <span class="menu-title">Editar Informações</span>
    </a>
  </li>
    @endif



    @if(Auth::user()->usertype == '1')
  <li class="nav-item menu-items {{ Request::is('locais-doacao*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('/locais-doacao') }}">
      <span class="menu-icon"><i class="mdi mdi-hospital-building"></i></span>
      <span class="menu-title">Locais de Doação</span>
    </a>
  </li>
    @endif
</ul>
    </nav>

    <div id="content-area">
        <!-- Aqui carrega o conteúdo dinamicamente -->
    </div>
</body>
</html>

