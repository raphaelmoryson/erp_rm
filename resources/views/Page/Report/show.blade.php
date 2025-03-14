<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Déposer un Devis</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="bg-light">

    <div class="container mt-5">
        <h2 class="text-center mb-4">📜 Déposer un Devis</h2>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5><i class="fas fa-building"></i> Informations de l'immeuble</h5>
            </div>
            <div class="card-body">
                <p><strong>Nom de la propriété :</strong> {{$report->property->name}}</p>
                <p><strong>Adresse :</strong> {{$report->property->address}}, {{$report->property->city}}, {{$report->property->zip_code}}</p>
                <p><strong>Étage :</strong> {{$report->unit->floor}}</p>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-secondary text-white">
                <h5><i class="fas fa-building"></i> Vos Informations</h5>
            </div>
            <div class="card-body">
                <p><strong>Nom :</strong> {{$report->company->name}}</p>
                <p><strong>Email :</strong> {{$report->company->email}}</p>
                <p><strong>Téléphone :</strong> {{$report->company->phone}}</p>
                <p><strong>Ville :</strong> {{$report->company->city}}</p>
                <p><strong>SIREN :</strong> {{$report->company->siren}}</p>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5><i class="fas fa-file-alt"></i> Soumettre un Devis</h5>
            </div>
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="description" class="form-label"><i class="fas fa-pencil-alt"></i> Description du devis</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="photo" class="form-label"><i class="fas fa-paperclip"></i> Joindre un document</label>
                        <input type="file" class="form-control" id="photo" name="photo">
                    </div>
                    <div class="mb-3">
                        <label for="linkUrl" class="form-label"><i class="fas fa-link"></i> Lien URL (optionnel)</label>
                        <input type="url" class="form-control" id="linkUrl" name="linkUrl" placeholder="https://">
                    </div>
                    <button type="submit" class="btn btn-success w-100"><i class="fas fa-check-circle"></i> Soumettre le devis</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>
