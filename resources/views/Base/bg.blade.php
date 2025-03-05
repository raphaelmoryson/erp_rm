<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div class="container-fluid vh-100 bg-base position-relative">
        @yield('content')
        <!-- Image en arrière-plan -->
        <img src="/images/building.svg"
            class="image-background position-fixed bottom-0 start-50 translate-middle-x w-100 z-1" alt="Building">

    </div>
</body>

</html>