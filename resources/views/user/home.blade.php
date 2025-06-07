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


        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupport" aria-controls="navbarSupport" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupport">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a style="color: red;" class="nav-link" href="#">Início</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#sobre">Sobre nós</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#doutores">Doutores</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#noticias">Notícias</a>
            </li>
           

           @auth
            <li class="nav-item">
              <a class="nav-link" href="/agendar">Agendar</a>
            </li>
          @endauth
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

  <div class="page-hero bg-image" style="background-image: url(../assets/img/bg_image_1.jpg);">
    <div class="hero-section">
      <div class="container text-center wow zoomIn">
        <span class="subhead">Faça a diferença na vida de alguém</span>
        <h1 class="display-4">Doe Sangue!</h1>
        
      </div>
    </div>
  </div>



    <div class="page-section pb-0" id="sobre"> 
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6 py-3 wow fadeInUp">
            <h1>Bem-vindo ao HemoCentro+</h1>
            <p class="text-grey mb-4">Acreditamos no poder da doação de sangue para salvar vidas e causar um impacto positivo em nossa comunidade. Nossa missão é conectar doadores de sangue com aqueles que precisam, proporcionando uma plataforma conveniente e eficiente para gerenciar o processo de doação de sangue.</p>
          </div>
          <div class="col-lg-6 wow fadeInRight" data-wow-delay="400ms">
            <div class="img-place custom-img-1">
              <img src="../assets/img/bg-doctor.png" alt="">
            </div>
          </div>
        </div>
      </div>
    </div> 
  </div> 

  <div class="page-section" id="doutores">
    <div class="container">
      <h1 class="text-center mb-5 wow fadeInUp">Alguns dos nossos Doutores</h1>

      <div class="owl-carousel wow fadeInUp" id="doctorSlideshow">
        <div class="item">
          <div class="card-doctor">
            <div class="header">
              <img src="../assets/img/doctors/doctor_1.jpg" alt="">
            </div>
            <div class="body">
              <p class="text-xl mb-0">Dra. Jéssica Lopes</p>
              <span class="text-sm text-grey">Cardiologista</span>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="card-doctor">
            <div class="header">
              <img src="../assets/img/doctors/doctor_2.jpg" alt="">
              <div class="meta">
              </div>
            </div>
            <div class="body">
              <p class="text-xl mb-0">Dr. Miharo Shen</p>
              <span class="text-sm text-grey">Dentista</span>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="card-doctor">
            <div class="header">
              <img src="../assets/img/doctors/doctor_3.jpg" alt="">
              <div class="meta">
              </div>
            </div>
            <div class="body">
              <p class="text-xl mb-0">Dra. Rebecca Steffany</p>
              <span class="text-sm text-grey">Saúde Geral</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>



  <div class="page-section bg-light" id="noticias">
    <div class="container">
      <h1 class="text-center wow fadeInUp">Notícias</h1>
      <div class="row mt-5">
        <div class="col-lg-4 py-2 wow zoomIn">
          <div class="card-blog">
            <div class="header">
              <div class="post-category">
                <a href="#">Covid19</a>
              </div>
              <a href="blog-details.html" class="post-thumb">
                <img src="../assets/img/blog/blog_1.jpg" alt="">
              </a>
            </div>
            <div class="body">
              <h5 class="post-title"><a href="blog-details.html">Lista de países sem casos de Coronavírus</a></h5>
              <div class="site-info">
                <div class="avatar mr-2">
                  <div class="avatar-img">
                    <img src="../assets/img/person/person_1.jpg" alt="">
                  </div>
                  <span>Roger Adams</span>
                </div>
                <span class="mai-time"></span> 1 mês atrás
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 py-2 wow zoomIn">
          <div class="card-blog">
            <div class="header">
              <div class="post-category">
                <a href="#">Covid19</a>
              </div>
              <a href="blog-details.html" class="post-thumb">
                <img src="../assets/img/blog/blog_2.jpg" alt="">
              </a>
            </div>
            <div class="body">
              <h5 class="post-title"><a href="blog-details.html">Sala de Recuperação: Notícias da Pandemia</a></h5>
              <div class="site-info">
                <div class="avatar mr-2">
                  <div class="avatar-img">
                    <img src="../assets/img/person/person_1.jpg" alt="">
                  </div>
                  <span>Roger Adams</span>
                </div>
                <span class="mai-time"></span> 4 semanas atrás
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 py-2 wow zoomIn">
          <div class="card-blog">
            <div class="header">
              <div class="post-category">
                <a href="#">Covid19</a>
              </div>
              <a href="blog-details.html" class="post-thumb">
                <img src="../assets/img/blog/blog_3.jpg" alt="">
              </a>
            </div>
            <div class="body">
              <h5 class="post-title"><a href="blog-details.html">Qual é o impacto de comer muito açúcar?</a></h5>
              <div class="site-info">
                <div class="avatar mr-2">
                  <div class="avatar-img">
                    <img src="../assets/img/person/person_2.jpg" alt="">
                  </div>
                  <span>Diego Simmons</span>
                </div>
                <span class="mai-time"></span> 2 meses atrás
              </div>
            </div>
          </div>
        </div>

        <div class="col-12 text-center mt-4 wow zoomIn">
        </div>

      </div>
    </div>
  </div> 

  


  <footer class="page-footer">
    <div class="container">
      
        
        <div class="col-sm-6 col-lg-3 py-3">
          <h5>Contato</h5>
          <a href="#" class="footer-link">+55 00 000000000</a> <br>
          <a href="#" class="footer-link">HemoCentro@gmail.com</a>

          <h5 class="mt-3">Redes Sociais</h5>
          <div class="footer-sosmed mt-3">
            <a href="https://www.facebook.com/?locale=pt_BR" target="_blank"><span class="mai-logo-facebook-f"></span></a>
            <a href="https://x.com/?lang=pt-br" target="_blank"><span class="mai-logo-twitter"></span></a>
            <a href="#" target="_blank"><span class="mai-logo-google-plus-g"></span></a>
            <a href="https://www.instagram.com/" target="_blank"><span class="mai-logo-instagram"></span></a>
            <a href="https://www.linkedin.com/uas/login?session_redirect=https%3A%2F%2Fwww.linkedin.com%2Ffeed%2F" target="_blank"><span class="mai-logo-linkedin"></span></a>
          </div>
        </div>
      </div>
      
      <hr>

      
    </div>
  </footer>

<script src="../assets/js/jquery-3.5.1.min.js"></script>

<script src="../assets/js/bootstrap.bundle.min.js"></script>

<script src="../assets/vendor/owl-carousel/js/owl.carousel.min.js"></script>

<script src="../assets/vendor/wow/wow.min.js"></script>

<script src="../assets/js/theme.js"></script>

        <script>
          if ("serviceWorker" in navigator) {
              navigator.serviceWorker.register("/service-worker.js")
                  .then(() => console.log("Service Worker registrado!"))
                  .catch(err => console.error("Erro ao registrar o Service Worker:", err));
          }
        </script>

        <button id="btnInstall" style="display:none;">Instalar App</button>

        <script>
          let deferredPrompt;

          window.addEventListener("beforeinstallprompt", (e) => {
            // Evita o prompt automático
            e.preventDefault();
            deferredPrompt = e;

            // Mostra o botão
            const installBtn = document.getElementById("btnInstall");
            installBtn.style.display = "block";

            installBtn.addEventListener("click", () => {
              installBtn.style.display = "none";
              deferredPrompt.prompt();
              deferredPrompt.userChoice.then((choiceResult) => {
                if (choiceResult.outcome === "accepted") {
                  console.log("Usuário aceitou instalar o PWA");
                } else {
                  console.log("Usuário recusou instalar o PWA");
                }
                deferredPrompt = null;
              });
            });
          });
        </script>  
  
</body>
</html>