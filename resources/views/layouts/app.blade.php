<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" defer></script>
</head>

<body style="display: flex; flex-direction: row; height: 100vh; margin: 0;">
    <div>
        <div class="sidebar ">
            <div class="d-flex">
                <div class="logoName">
                    <img src="/images/logo.png" alt="">

                </div>
            </div>
            <div class="input-navbar">
                <x-heroicon-o-magnifying-glass class="search-icon" />
                <input type="text" placeholder="Recherche">
            </div>

            <nav>
                <a href="{{ url('/') }}" class="{{ Request::is('/') ? 'active' : '' }}">
                    <x-heroicon-o-home class="icon-navbar" />
                    <span>Tableau de Bord</span>
                </a>

                <a href="{{ url('/properties') }}" class="{{ Request::is('properties') ? 'active' : '' }}">
                    <x-heroicon-o-building-office class="icon-navbar" />
                    <span>Immeuble</span>
                </a>

                <a href="{{ url('/tenants') }}" class="{{ Request::is('tenants') ? 'active' : '' }}">
                    <x-heroicon-o-user-group class="icon-navbar" />
                    <span>Locataire</span>
                </a>

                <a href="{{ url('/company') }}" class="{{ Request::is('company') ? 'active' : '' }}">
                    <x-heroicon-o-briefcase class="icon-navbar" />
                    <span>Entreprise</span>
                </a>

                <a href="{{ url('/invoice') }}" class="{{ Request::is('invoice') ? 'active' : '' }}">
                    <x-heroicon-o-document-check class="icon-navbar" />
                    <span>Facture</span>
                </a>
                <button class="toggle-sidebar" id="toggleSidebar"></button>


            </nav>

            <div class="bottom-navbar">
                @auth
                    <div class="profil">
                        <p>{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}{{ strtoupper(substr(auth()->user()->name, strpos(auth()->user()->name, ' ') + 1, 1)) }}
                        </p>
                    </div>
                    <div class="user-info">
                        <p><strong>{{ auth()->user()->name }}</strong></p>
                        <p>{{ auth()->user()->role }}</p>
                    </div>
                @endauth
            </div>

        </div>

    </div>

    <div class="app" style="margin:@yield('marge', 30)px">
        <div class="d-flex justify-content-between align-items-center">
            <h1>@yield('title', 'Document')</h1>
            @hasSection('link')
                <a href="@yield('link', '/')" class="btn btn-primary bg-primary">Ajouter</a>
            @endif
        </div>
        @yield('content')
    </div>

    <script>
        const toggleButton = document.getElementById('toggleSidebar');
        const sidebar = document.querySelector('.sidebar');

        toggleButton.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
        });
        document.addEventListener('DOMContentLoaded', () => {
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed) {
                sidebar.classList.add('collapsed');
            }
        });
    </script>
</body>

</html>