<div>
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link {{ $currentTab === 'info' ? 'active' : '' }}" wire:click="setTab('info')"
                style="cursor: pointer">
                Informations de l’immeuble
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $currentTab === 'compta' ? 'active' : '' }}" wire:click="setTab('compta')"
                style="cursor: pointer">
                Aspect comptable
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $currentTab === 'tech' ? 'active' : '' }}" wire:click="setTab('tech')"
                style="cursor: pointer">
                Aspect technique
            </a>
        </li>
    </ul>
    <div wire:loading.remove>
        @if ($currentTab === 'info')
            <div class=".container-fluid p-0 m-0" style="overflow-x: hidden">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <p><strong>Nom :</strong> <span class="text-muted">{{ $building->name }}</span></p>
                                <p><strong>Adresse :</strong> <span class="text-muted">{{ $building->address }}</span></p>
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
                            <p class="fs-1">{{ number_format($occupancyRate, 2) }}%</p>
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                        <div class="card p-3 bg-warning text-dark text-center">
                            <p class="fs-5">Revenu mensuel estimé</p>
                            <p class="fs-1">{{ number_format(495, 2) }} €</p>
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                        <div class="card p-3 bg-danger text-light text-center">
                            <p class="fs-5">Nombre d'unités occupées</p>
                            <p class="fs-1">{{ $occupiedUnits }}</p>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p>Liste des appartements</p>
                                        <a href="{{route('properties.tenants_add', $building->id)}}">
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
                                                        <th scope="row">{{$index + 1 }}</th>
                                                        <td>{{ $unit->name }}</td>
                                                        <td>{{ $unit->floor }}</td>
                                                        @if($unit->tenant)
                                                            <td>{{ $unit->tenant->firstName }} {{ $unit->tenant->lastName }}</td>
                                                        @else
                                                            <td>Aucun locataire</td>
                                                        @endif
                                                        <td class="d-flex align-items-center">
                                                            <form action="{{ route('properties.units_delete', $unit->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('POST')
                                                                <button class="btn btn-danger me-2 p-1">Supprimer</button>
                                                            </form>


                                                            <a
                                                                href="{{ route('properties.show_units', ['properties' => $building->id, 'id' => $unit->id]) }}">
                                                                <button class="btn btn-primary p-1">Voir</button>
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

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p>Loyer non réglé</p>
                                    </div>
                                    <div style="height: 500px;overflow-y:scroll">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Nom</th>
                                                    <th scope="col">Montant</th>
                                                    <th scope="col">Appart</th>

                                                    <th scope="col">Action</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr></tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
        @elseif ($currentTab === 'tech')
            <div class=".container-fluid p-0 m-0 d-flex " style="overflow-x: hidden">
                <div class="col-md-6">

                    <form method="POST" action="{{ route('technical_folders.store', $building->id) }}">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" name="name" class="form-control" placeholder="Nom du dossier">
                            <button class="btn btn-success">Créer</button>
                        </div>
                    </form>

                    <hr>
                    <div class="accordion" id="technicalFolders">
                        @foreach ($technicalFolders as $folder)
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <div class="d-flex">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#folder-{{ $folder->id }}">
                                            📁 {{ $folder->name }}

                                        </button>

                                        <form method="POST" action="{{ route('technical_folder.delete', $folder->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Supprimer</button>
                                        </form>
                                    </div>

                                </h2>
                                <div id="folder-{{ $folder->id }}" class="accordion-collapse collapse ">

                                    <div class="accordion-body">

                                        <form method="POST" action="{{ route('technical_files.store', $folder->id) }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="input-group mb-3">
                                                <input type="file" name="file" class="form-control">
                                                <button class="btn btn-primary">Uploader</button>
                                            </div>
                                        </form>

                                        <ul class="list-group">
                                            @foreach ($folder->files as $file)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <a href="{{ Storage::url($file->file_path) }}"
                                                        target="_blank">{{ $file->file_name }}</a>
                                                    <form method="POST"
                                                        action="{{ route('technical_files.delete', $file->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger btn-sm">Supprimer</button>
                                                    </form>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-6 ms-3">
                    <div class="card p-4 shadow-sm">
                        <h4 class="mb-3">Demande de devis</h4>

                        <form action="{{ route('report.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="unit_id" class="form-label">🏢 Lot concerné (optionnel)</label>
                                <select class="form-select" name="unit_id">
                                    <option value="">Aucun, concerne l’immeuble entier</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->name }} ({{ $unit->type }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="company_id" class="form-label">🔧 Entreprise en charge</label>
                                <select class="form-select" name="company_id" required>
                                    <option value="">Sélectionnez une entreprise</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Détails du problème -->
                            <div class="mb-3">
                                <label for="description" class="form-label">📝 Détails du problème</label>
                                <textarea class="form-control" name="description" rows="3" required></textarea>
                            </div>

                            <!-- Photo -->
                            <div class="mb-3">
                                <label for="photo" class="form-label">📸 Photo (optionnel)</label>
                                <input type="file" class="form-control" name="photo">
                            </div>

                            <!-- Bouton Soumettre -->
                            <button type="submit" class="btn btn-primary w-100">📩 Signaler le problème</button>
                        </form>
                    </div>
                </div>

            </div>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    var accordions = document.querySelectorAll(".accordion-button");
                    accordions.forEach(function (btn) {
                        btn.addEventListener("click", function () {
                            var target = this.getAttribute("data-bs-target");
                            var collapse = document.querySelector(target);
                            if (collapse.classList.contains("show")) {
                                bootstrap.Collapse.getInstance(collapse).hide();
                            } else {
                                new bootstrap.Collapse(collapse, { toggle: true });
                            }
                        });
                    });
                });
            </script>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        @elseif ($currentTab === 'compta')
            <div class="container-fluid mt-4">
                <h2>Gestion des Paiements</h2>
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Locataire</th>
                            <th>Appartement</th>
                            <th>Montant (€)</th>
                            <th>Statut</th>
                            <th>Date limite</th>
                            <th>Paiement</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                            <tr>
                                <td>{{ $payment->tenant->firstName }} {{ $payment->tenant->lastName }}</td>
                                <td>{{ $payment->unit->name }}</td>
                                <td>{{ number_format($payment->amount, 2) }} €</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $payment->status == 'payé' ? 'success' : ($payment->status == 'retard' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td>{{ date('d/m/Y', strtotime($payment->due_date)) }}</td>
                                <td>{{ $payment->paid_at ? date('d/m/Y', strtotime($payment->paid_at)) : 'Non payé' }}</td>
                                <td>
                                    @if($payment->status != 'payé')
                                        <form action="{{ route('payments.markAsPaid', $payment->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Marquer comme payé</button>
                                        </form>
                                    @else
                                        <span class="text-muted">✔ Déjà payé</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @endif
        </div>
        @livewireScripts


    </div>