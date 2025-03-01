<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP System - Navbar</title>
    <!-- Lien vers le fichier CSS compilé -->
</head>

<body>
    <div>
        <div class="sidebar">
            <div class="logo">ImmoFlow</div>
            <div class="input-navbar">
                <x-heroicon-o-magnifying-glass class="search-icon" />
                <input type="text" placeholder="Recherche">
            </div>

            <nav>
                <a href="{{ url('/') }}" class="{{ Request::is('/') ? 'active' : '' }}">
                    <x-heroicon-o-home class="icon-navbar" />
                    Tableau de Bord
                </a>

                <a href="{{ url('/properties') }}" class="{{ Request::is('properties') ? 'active' : '' }}">
                    <x-heroicon-o-building-office class="icon-navbar" />
                    Immeuble
                </a>

                <a href="{{ url('/users') }}" class="{{ Request::is('users') ? 'active' : '' }}">
                    <x-heroicon-o-user-group class="icon-navbar" />
                    Utilisateurs
                </a>

                <a href="{{ url('/transactions') }}" class="{{ Request::is('transactions') ? 'active' : '' }}">
                    <x-heroicon-o-currency-dollar class="icon-navbar" />
                    Transactions
                </a>

                <a href="{{ url('/settings') }}" class="{{ Request::is('settings') ? 'active' : '' }}">
                    <x-heroicon-o-cog class="icon-navbar" />
                    Paramètres
                </a>
            </nav>

            <div class="bottom-navbar">
                @auth
                    <div class="profil"></div>
                    <div class="user-info">
                        <p><strong>{{ auth()->user()->name }}</strong></p>
                        <p>{{ auth()->user()->role }}</p>
                        {{-- <form action="/lgt" method="POST">
                            @csrf
                            <button type="submit" class="btn-logout">Se déconnecter</button>
                        </form> --}}
                    </div>
                @endauth
            </div>
        </div>
    </div>
</body>

</html>