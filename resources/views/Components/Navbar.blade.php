<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP System - Navbar</title>
    
</head>

<body>
    <div>
        <div class="sidebar ">
            <div class="logo">ImmoFlow</div>
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
                <button class="toggle-sidebar" id="toggleSidebar"></button>


            </nav>

            <div class="bottom-navbar">
                @auth
                    <div class="profil">
                        <p>{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}{{ strtoupper(substr(auth()->user()->name, strpos(auth()->user()->name, ' ') + 1, 1)) }}</p>
                    </div>
                    <div class="user-info">
                        <p><strong>{{ auth()->user()->name }}</strong></p>
                        <p>{{ auth()->user()->role }}</p>
                    </div>
                @endauth
            </div>
            
        </div>

    </div>

    <script>
        const toggleButton = document.getElementById('toggleSidebar');
        const sidebar = document.querySelector('.sidebar');

        toggleButton.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
        });
    </script>
</body>

</html>