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
    @include('Components.Navbar')
    <div class="app" style="margin:@yield('marge', 30)px">
        <div class="d-flex justify-content-between align-items-center">
            <h1>@yield('title', 'Document')</h1>
            @hasSection('link')
                <a href="@yield('link', '/')" class="btn btn-primary bg-primary">Ajouter</a>
            @endif
        </div>
        @yield('content')
    </div>

</body>

</html>