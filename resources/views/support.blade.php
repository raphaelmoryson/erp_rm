<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>

<body>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Signaler un Problème à Support</h4>
                    </div>
                    <div class="card-body vh-100">
                        <form method="POST" action="{{ route('support.send', ['slug' => $supportUnit->slugId]) }}">

                            <h5>Informations sur l'Appartement :</h5>
                            <ul class="list-group mb-3">
                                <li class="list-group-item"><strong>ID de l'Appartement :</strong>
                                    {{ $supportUnit->id }}</li>
                                <li class="list-group-item"><strong>Appartement :</strong> {{ $supportUnit->name }}</li>
                                <li class="list-group-item"><strong>Locataire :</strong>
                                    {{ $supportUnit->tenant->firstName }} {{ $supportUnit->tenant->lastName }}</li>
                            </ul>

                            <h5>Veuillez décrire le problème rencontré :</h5>
                            @csrf
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea id="message" name="message" class="form-control" rows="4" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Envoyer au support</button>
                        </form>

                        @if(session('success'))
                            <div class="alert alert-success mt-3">{{ session('success') }}</div>
                        @elseif(session('error'))
                            <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>