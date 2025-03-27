@extends('layouts.app')

@section('title', 'Immeuble n°' . $building->id)
@section('marge', 30)

@section('content')
    <div>
        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#tab1">Informations de l'immeuble</a>
            </li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab2">Aspect technique</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab3">Aspect comptable</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab4">Demande de devis</a></li>
        </ul>
        <div class="tab-content">
            <div id="tab1" class="tab-pane fade show active">
                <div class=".container-fluid p-0 m-0" style="overflow-x: hidden">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <p><strong>Nom :</strong> <span class="text-muted">{{ $building->name }}</span></p>
                                    <p><strong>Adresse :</strong> <span class="text-muted">{{ $building->address }}</span>
                                    </p>
                                    <p><strong>Ville :</strong> <span class="text-muted">{{ $building->city }}</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100">
                                <div class="card-body d-flex flex-column">
                                    <p><strong>Gérant technique :</strong> <span
                                            class="text-muted">{{ $building->manager->name }}</span></p>
                                    <p><strong>Email Gérant :</strong> <span
                                            class="text-muted">{{ $building->manager->email }}</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mt-3">
                            <div class="card p-3 bg-success text-light text-center">
                                <p class="fs-5">Nombre d'appartements</p>
                                <p class="fs-1">{{ count($units) }}</p>
                            </div>
                        </div>

                        <div class="col-md-3 mt-3">
                            <div class="card p-3 bg-primary text-light text-center">
                                <p class="fs-5">Taux d'occupation</p>
                                <p class="fs-1">?</p>
                            </div>
                        </div>

                        <div class="col-md-3 mt-3">
                            <div class="card p-3 bg-warning text-dark text-center">
                                <p class="fs-5">?</p>
                                <p class="fs-1">?</p>
                            </div>
                        </div>

                        <div class="col-md-3 mt-3">
                            <div class="card p-3 bg-danger text-light text-center">
                                <p class="fs-5">?</p>
                                <p class="fs-1">?</p>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p>Liste des appartements</p>
                                            <a href="{{ route('properties.tenants_add', $building->id) }}">
                                                <button class="btn btn-primary">Ajouter</button>
                                            </a>
                                        </div>
                                        <div style="height: 500px;overflow-y:scroll">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Nom de l'appartement</th>
                                                        <th scope="col">Étage</th>
                                                        <th scope="col">Prénom & Nom</th>
                                                        <th scope="col">Action</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($units->sortBy('floor') as $index => $unit)
                                                        <tr>
                                                            <th scope="row" wire:key="unit-{{ $unit['id'] }}">
                                                                {{ $index + 1 }}</th>
                                                            <td>{{ $unit->name }}</td>
                                                            <td>{{ $unit->floor }}</td>
                                                            @if ($unit->tenant)
                                                                <td>{{ $unit->tenant->firstName }}
                                                                    {{ $unit->tenant->lastName }}</td>
                                                            @else
                                                                <td>Aucun locataire</td>
                                                            @endif
                                                            <td class="d-flex align-items-center">
                                                                <button type="button" class="btn btn-danger p-1"
                                                                    data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                                    Supprimer
                                                                </button>

                                                                <a
                                                                    href="{{ route('properties.show_units', ['properties' => $building->id, 'id' => $unit->id]) }}">
                                                                    <button class="btn btn-primary p-1 ms-1">Voir</button>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Voulez-vous vraiment supprimer cet appartement ?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Fermer</button>
                                            <form action="{{ route('properties.units_delete', $unit->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('POST')
                                                <button class="btn btn-danger me-2">Supprimer</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p>Liste des interventions</p>
                                        </div>
                                        <div style="height: 500px;overflow-y:scroll">
                                            @foreach ($reports as $report)
                                                <div
                                                    class="card mb-3 p-2 shadow-sm 
                                            @if ($report->status == 'pending') bg-warning 
                                            @elseif ($report->status == 'in_progress') bg-info 
                                            @elseif ($report->status == 'completed') bg-success 
                                            @elseif ($report->status == 'refused') bg-danger 
                                            @elseif ($report->status == 'abandoned') bg-secondary @endif">
                                                    <div class="card-body">
                                                        <h5 class="card-title">{{ $report->title }}</h5>
                                                        <p class="card-text text-muted">Par {{ $report->company->name }} -
                                                            {{ $report->created_at->format('d/m/Y H:i') }}</p>
                                                        <p class="card-text">
                                                            {{ Str::limit($report->description, 100, '...') }}</p>
                                                        <a href="{{ route('reports.show', $report->id) }}"
                                                            class="btn btn-sm btn-light">Voir détail</a>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <div id="tab2" class="tab-pane fade">
                <div class="container-fluid p-0 m-0 d-flex">
                    <!-- COLONNE GAUCHE : GESTION DES DOSSIERS -->
                    <div class="col-md-6">

                        <!-- FORMULAIRE DE CRÉATION DE DOSSIER -->
                        <form method="POST" action="{{ route('technical_folders.store', $building->id) }}"
                            class="mb-3">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="name" class="form-control" placeholder="Nom du dossier"
                                    required>
                                <button class="btn btn-success">Créer</button>
                            </div>
                        </form>

                        <hr>

                        <!-- TABLEAU DES DOSSIERS ET FICHIERS -->
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nom du Dossier</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($technicalFolders as $folder)
                                    <tr class="table-primary">
                                        <td colspan="2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <strong>{{ $folder->name }}</strong>
                                                <form method="POST"
                                                    action="{{ route('technical_folder.delete', $folder->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm">Supprimer</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2">
                                            <form method="POST"
                                                action="{{ route('technical_files.store', $folder->id) }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="input-group">
                                                    <input type="file" name="file" class="form-control" required>
                                                    <button class="btn btn-primary">Uploader</button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>

                                    @foreach ($folder->files as $file)
                                        <tr id="row-{{ $file->id }}">
                                            <td class="col-6">
                                                <a href="{{ Storage::url($file->file_path) }}"
                                                    target="_blank">{{ $file->file_name }}</a>
                                            </td>
                                            <td class="col-6 d-flex justify-content-end">
                                                @if (Str::endsWith($file->file_name, '.pdf'))
                                                    <button class="btn btn-info btn-sm me-2"
                                                        onclick="showPdf('{{ Storage::url($file->file_path) }}')">PDF</button>
                                                @endif
                                                <form method="POST"
                                                    action="{{ route('technical_files.delete', $file->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm">Supprimer</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6 vh-100" id="pdf-container" style="display: none; height: 700px;">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <strong>Prévisualisation PDF</strong>
                            <button class="btn btn-warning btn-sm" onclick="hidePdf()">Fermer</button>
                        </div>
                        <iframe id="pdf-iframe" src="" width="100%" height="800px" class="border"></iframe>
                    </div>
                </div>

                <script>
                    function showPdf(pdfUrl) {
                        document.getElementById("pdf-container").style.display = "block";
                        document.getElementById("pdf-iframe").src = pdfUrl;
                    }

                    function hidePdf() {
                        document.getElementById("pdf-container").style.display = "none";
                        document.getElementById("pdf-iframe").src = "";
                    }
                </script>


            </div>
            <div id="tab3" class="tab-pane fade">
                @php
                    $total = $payments->where('status', 'payé')->sum('amount');
                    $totalEstimate = $payments->sum('amount');
                @endphp
                <div class="container-fluid ">

                    <div class="d-flex align-items-start mb-4">
                        <div class="col-md-6 me-2">
                            <div class="card p-3 bg-success text-light text-center">
                                <p class="fs-5">Montant total payé de l'immeuble</p>
                                <p class="fs-1">{{ number_format($total, 2) }}€</p>
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <div class="card p-3 bg-primary text-light text-center">
                                <p class="fs-5">Montant estimé de l'immeuble</p>
                                <p class="fs-1">{{ number_format($totalEstimate, 2) }}€</p>
                            </div>
                        </div>
                    </div>


                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Locataire</th>
                                <th>Appartement</th>
                                <th>Montant (€)</th>
                                <th>Statut</th>
                                <th>Date limite</th>
                                <th>Paiement</th>
                                <th>Actions</th>
                                <th>Facture</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr 
                                    class="
                                                                                                        @if ($payment->status == 'payé') table-success
                                                                                                            @else table-danger @endif" style="height: 25px">
                                    <td>
                                        <a href="/properties/show/{{ $building->id }}/units/{{ $payment->tenant->id }}/">
                                            {{ $payment->tenant->firstName }} {{ $payment->tenant->lastName }}
                                        </a>
                                    </td>
                                    <td>{{ $payment->unit->name }}</td>
                                    <td>{{ number_format($payment->amount, 2) }} €</td>
                                    <td>{{ ucfirst($payment->status) }}</td>
                                    <td>{{ date('d/m/Y', strtotime($payment->due_date)) }}</td>
                                    <td>{{ $payment->paid_at ? date('d/m/Y', strtotime($payment->paid_at)) : 'Non payé' }}
                                    </td>
                                    <td>
                                        @if ($payment->status != 'payé')
                                            <form action="{{ route('payments.markAsPaid', $payment->id) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm p-0 ps-2 pe-2">Marquer comme
                                                    payé</button>
                                            </form>
                                        @else
                                            <span class="text-muted">✔ Déjà payé</span>
                                        @endif
                                    </td>
                                    <td><a class="btn btn-primary p-0 ps-2 pe-2"
                                            href="{{ route('invoice.pdf', $payment->invoice_id) }}">Voir</a></td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="tab4" class="tab-pane fade">
                <div class="container-fluid ">
                    <div class="mt-3"></div>
                    <h4 class="mb-3">Demande de devis</h4>

                    <form action="{{ route('report.store') }}" method="POST" enctype="multipart/form-data">

                        @csrf
                        <div class="mb-3">
                            <label for="unit_id" class="form-label">Lot concerné (optionnel)</label>
                            <select class="form-select" name="unit_id">
                                <option value="">Aucun, concerne l’immeuble entier</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->name }} ({{ $unit->type }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="company_id" class="form-label">Entreprise en charge</label>
                            <select class="form-select" name="company_id" required>
                                <option value="">Sélectionnez une entreprise</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Détails du problème</label>
                            <textarea class="form-control" name="description" rows="3" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo (optionnel)</label>
                            <input type="file" class="form-control" name="photo">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Signaler le problème</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
