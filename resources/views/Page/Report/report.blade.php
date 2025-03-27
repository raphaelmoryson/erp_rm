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
<style>
    body {
        overflow-y: scroll;

    }
</style>

<body class="bg-light">
    <div class="container-fluid">
        <h2 class="text-center mb-4">Déposer un Devis</h2>
        <div class="d-flex justify-content-between vh-75">
            <div class="col-md-4">
                <div class="card h-100 me-2 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5><i class="fas fa-building"></i> Informations de l'immeuble</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Nom de la propriété :</strong> {{ $report->property->name }}</p>
                        <p><strong>Adresse :</strong> {{ $report->property->address }}, {{ $report->property->city }},
                            {{ $report->property->zip_code }}</p>
                        <p><strong>Étage :</strong> {{ $report->unit->floor }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 me-2 shadow-sm mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5><i class="fas fa-user"></i> Vos Informations</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Nom :</strong> {{ $report->company->name }}</p>
                        <p><strong>Email :</strong> {{ $report->company->email }}</p>
                        <p><strong>Téléphone :</strong> {{ $report->company->phone }}</p>
                        <p><strong>Ville :</strong> {{ $report->company->city }}</p>
                        <p><strong>SIREN :</strong> {{ $report->company->siren }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 me-2 shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5><i class="fas fa-file-alt"></i> Soumettre un Devis</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('report.accepted', $slug) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="description" class="form-label"><i class="fas fa-pencil-alt"></i>
                                    Description du devis</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="photo" class="form-label"><i class="fas fa-paperclip"></i> Joindre un
                                    document</label>
                                <input type="file" class="form-control" id="fileQuote" name="fileQuote">
                            </div>
                            <button type="submit" class="btn btn-success w-100"><i class="fas fa-check-circle"></i>
                                Soumettre le devis</button>
                        </form>



                        <button data-bs-toggle="modal" data-bs-target="#refusedReportModal" type="button"
                            class="btn btn-danger w-100 mt-2"><i class="fas fa-check-circle"></i>
                            Refuser l'intervention</button>
                    </div>
                </div>
            </div>
        </div>
        <x-confirmation-modal id="refusedReportModal" title="Ne pas attribuer l'intervention"
            message="Voulez-vous vraiment refuser cette intervention ?" route="{{ route('report.refused', $slug) }}"
            method="POST" />

        <!-- CARROUSEL DES IMAGES -->
        @if ($report->photo)
            <div class="card h-100 me-2 shadow-sm mt-3">
                <div class="card-header bg-danger text-white">
                    <h5><i class="fas fa-file-alt"></i> Photo : </h5>
                </div>
                <div class="card-body">

                    <img src="{{ Storage::url($report->photo) }}" class="d-block w-25" alt="Photo du rapport">

                </div>
            </div>
        @endif

    </div>
</body>

</html>
