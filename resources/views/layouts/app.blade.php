<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
        <link rel="manifest" href="{{ asset('manifest.json') }}">
        <meta name="theme-color" content="#0d6efd">
        <link rel="icon" href="/icons/icon-192.png" type="image/png">

    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
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
