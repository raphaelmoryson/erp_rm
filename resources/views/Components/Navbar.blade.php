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
            <div class="logo">ImmoFlow</div>
            <nav>
                <a href="{{ url('/') }}" class="{{ Request::is('/') ? 'active' : '' }}">Accueil</a>
                <a href="{{ url('/properties') }}" class="{{ Request::is('properties') ? 'active' : '' }}">Immeuble</a>
            </nav>
        </div>
    </div>
</body>

</html>
