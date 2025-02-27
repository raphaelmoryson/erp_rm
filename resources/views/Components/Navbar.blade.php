<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP System - Navbar</title>
</head>

<body>
    <div>
        <div class="sidebar">
            <div class="logo">ERP System</div>
            <nav>
                <a href="{{ url('/') }}" class="{{ Request::is('/') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ url('/properties') }}" class="{{ Request::is('properties') ? 'active' : '' }}">Immeuble</a>
                <a href="{{ url('/projects') }}" class="{{ Request::is('projects') ? 'active' : '' }}">Projets</a>
                <a href="{{ url('/settings') }}" class="{{ Request::is('settings') ? 'active' : '' }}">Paramètres</a>
            </nav>
        </div>
    </div>
</body>

</html>
