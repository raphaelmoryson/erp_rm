<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @vite(['resources/js/app.js'])
    <style>
        body {
            visibility: hidden;
        }
    </style>
    <!-- CDN pour Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    @livewireStyles

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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.body.style.visibility = 'visible';
        });
    </script>
</body>

</html>