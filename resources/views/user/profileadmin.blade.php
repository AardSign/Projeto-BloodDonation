<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <meta name="copyright" content="MACode ID, https://macodeid.com/">

  <title>HemoCentro.com</title>

  <link rel="stylesheet" href="../assets/css/maicons.css">

  <link rel="stylesheet" href="../assets/css/bootstrap.css">

  <link rel="stylesheet" href="../assets/vendor/owl-carousel/css/owl.carousel.css">

  <link rel="stylesheet" href="../assets/vendor/animate/animate.css">

  <link rel="stylesheet" href="../assets/css/theme.css">
  <link rel="manifest" href="{{ asset('manifest.json') }}">
  <meta name="theme-color" content="#0d6efd">
  <link rel="icon" href="/icons/icon-192.png" type="image/png">
</head>
<body>

  <div class="back-to-top"></div>

  <header>
    <div class="topbar">
      <div class="container">
        <div class="row">
          <div class="col-sm-8 text-sm">
            <div class="site-info">
              <a href="#"><span style="color: red;" class="mai-call text-500-red"></span> +55 00 000000000</a>
              <span class="divider">|</span>
              <a href="#"><span style="color: red;" class="mai-mail text-500-red"></span> HemoCentro@gmail.com</a>
            </div>
          </div>
          <div class="col-sm-4 text-right text-sm">
            <div class="social-mini-button">
              <a href="https://www.facebook.com/?locale=pt_BR"><span style="color: red;" class="mai-logo-facebook-f"></span></a>
              <a href="https://x.com/?lang=pt-br"><span style="color: red;" class="mai-logo-twitter"></span></a>
              <a href="https://dribbble.com/"><span style="color: red;" class="mai-logo-dribbble"></span></a>
              <a href="https://www.instagram.com/"><span style="color: red;" class="mai-logo-instagram"></span></a>
            </div>
          </div>
        </div> 
      </div> 
    </div> 

    <nav class="navbar navbar-expand-lg navbar-light shadow-sm">
      <div class="container">
        <a class="navbar-brand" href="#"><span style="color: red;" class="text-500-red">Hemo</span>Centro+</a>

        <form action="#">
          <div class="input-group input-navbar">
            <div class="input-group-prepend">
              <span style="color: red;" class="input-group-text" id="icon-addon1"><span style="color: red;"  class="mai-search"></span></span>
            </div>
            <input type="text" class="form-control" placeholder="Pesquisar" aria-label="Username" aria-describedby="icon-addon1">
          </div>
        </form>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupport" aria-controls="navbarSupport" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupport">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a style="color: red;" class="nav-link" href="#">Início</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#donors">Doadores</a>
            </li>
            @if(Route::has('login'))

            @auth
            
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary ml-lg-3 bg-red-500">
                        {{ __('Logout') }}
                    </button>
                </form>
            </li>
            {{-- <x-app-layout>
            </x-app-layout> --}}

            @else

            <li class="nav-item">
              <a class="btn btn-primary ml-lg-3 bg-red-500" href="{{route('login')}}">Entrar</a>
            </li>
            <li class="nav-item">
              <a class="btn btn-primary ml-lg-3 bg-red-500" href="{{route('register')}}">Registrar-se</a>
            </li>

            @endauth

            @endif

          </ul>
        </div> 
      </div> 
    </nav>
  </header>
  
<body>