<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link href="{{ mix('scss/app.scss') }}" rel="stylesheet">
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>

<body style="display: flex; flex-direction: row; height: 100vh; margin: 0;">
    @include('Components.Navbar')
    <div class="app">
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