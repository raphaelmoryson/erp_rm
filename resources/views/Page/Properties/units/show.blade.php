@extends('layouts.app')
@section('title', 'Appartement : ' . $units->name)

@section('content')
    <div>
        <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button"
                    role="tab" aria-controls="info" aria-selected="true">
                    Information locataire
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link " id="juridique-tab" data-bs-toggle="tab" data-bs-target="#juridique" type="button"
                    role="tab" aria-controls="juridique" aria-selected="false">
                    Fiche juridique
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link " id="compta-tab" data-bs-toggle="tab" data-bs-target="#compta" type="button"
                    role="tab" aria-controls="compta" aria-selected="false">
                    Fiche comptable
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link " id="inventory-tab" data-bs-toggle="tab" data-bs-target="#inventory" type="button"
                    role="tab" aria-controls="inventory" aria-selected="false">
                    État des lieux
                </button>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            {{-- ONGLET 1 --}}
            <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                <div class="container-fluid p-0 m-0" style="overflow-x: hidden">
                    @if ($monthPayment)
                        <div class="col-md-3 mt-3 mb-3">
                            <div
                                class="card p-3 {{ $monthPayment->status == 'en attente' ? 'bg-warning' : 'bg-success' }} text-light text-center">
                                <p class="fs-5">Montant loyer du mois</p>
                                <p class="fs-1">{{ number_format($monthPayment->amount, 2) }}€</p>
                            </div>
                        </div>
                    @endif
                    <div class="card shadow-lg">
                        <div class="card-header bg-primary text-white">
                            <h3 class="mb-0">Détails de l'Appartement</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text"><strong>Type :</strong> {{ ucfirst($units->type) }}</p>
                            <p class="card-text"><strong>Superficie :</strong> {{ $units->area }} m²</p>
                            <p class="card-text"><strong>Étage :</strong> {{ $units->floor }}</p>
                            <p class="card-text"><strong>Statut :</strong>
                                <span class="badge bg-{{ $units->status == 'libre' ? 'success' : 'danger' }}">
                                    {{ ucfirst($units->status) }}
                                </span>
                            </p>
                            <hr>

                            <h4>Immeuble</h4>
                            <p><strong>Nom :</strong> {{ $units->property->name }}</p>
                            <p><strong>Adresse :</strong> {{ $units->property->address }}, {{ $units->property->zip_code }}
                                {{ $units->property->city }}
                            </p>
                            <hr>

                            <h4>Locataire</h4>
                            @if ($units->tenant)
                                <p><strong>Nom :</strong> {{ $units->tenant->firstName }} {{ $units->tenant->lastName }}
                                </p>
                                <p><strong>Email :</strong> {{ $units->tenant->email }}</p>
                                <p><strong>Téléphone :</strong> {{ $units->tenant->mobile }}</p>
                                <button class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteUnitModal">Désattribuer ce locataire</button>
                            @else
                                <p class="text-muted">Aucun locataire attribué</p>
                                <form action="{{ route('unit.assign_tenant', $units->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Attribuer un locataire :</label>
                                        <select name="tenant_id" class="form-select">
                                            @foreach ($tenants as $tenant)
                                                <option value="{{ $tenant->id }}">{{ $tenant->firstName }}
                                                    {{ $tenant->lastName }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-success">Attribuer</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>



            </div>

            <x-confirmation-modal id="deleteUnitModal" title="Supprimer l'appartement"
                message="Voulez-vous vraiment désattribuer ce locataire ?"
                route="{{ route('unit.remove_tenant', $units->id) }}" method="POST" />


            <div class="tab-pane fade " id="compta" role="tabpanel" aria-labelledby="compta-tab">
                <div class="container-fluid p-0 m-0" style="overflow-x: hidden">
                    <h3>Tous les loyers</h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Nom de l'unité</th>
                                <th scope="col">Montant</th>
                                <th scope="col">Nom prénom</th>
                                <th scope="col">Date de paiement</th>
                                <th scope="col">Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allPayment as $payment)
                                <tr>
                                    <td>{{ $payment->unit->name }}</td>
                                    <td>{{ number_format($payment->amount, 2) }} €</td>
                                    <td>{{ $payment->tenant->lastName }} {{ $payment->tenant->firstName }}</td>
                                    <td>{{ $payment->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        @if ($payment->status === 'payé')
                                            <span class="badge bg-success">Payé</span>
                                        @else
                                            <span class="badge bg-warning">En attente</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade show" id="inventory" role="tabpanel" aria-labelledby="inventory-tab">
                <div class="container-fluid">
                    <form action="{{ route('inventory.store') }}" method="POST" enctype="multipart/form-data"
                        class="mt-4 p-4 border rounded bg-light">
                        @csrf

                        <div class="mb-3">
                            <label for="unit_id" class="form-label">Appartement</label>
                            <select name="unit_id" id="unit_id" class="form-select" required>
                                @foreach ($unitsList as $unit)
                                    <option value="{{ $unit->id }}" @if($units->id == $unit->id) selected @endif>{{ $unit->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" name="date" id="date" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Type</label>
                            <select name="type" id="type" class="form-select">
                                <option value="entrée">Entrée</option>
                                <option value="sortie">Sortie</option>
                            </select>
                        </div>

                        <h4 class="mt-4">Détails :</h4>
                        <div id="elements" class="mb-3">
                            <div class="element row g-2">
                                <div class="col-md-4">
                                    <input type="text" name="elements[0][name]" class="form-control"
                                        placeholder="Élément (Ex: Murs)">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="elements[0][etat]" class="form-control"
                                        placeholder="État (Ex: Bon)">
                                </div>
                                <div class="col-md-4">
                                    <input type="file" name="elements[0][photo]" class="form-control">
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-secondary mb-3" onclick="ajouterElement()">Ajouter un
                            élément</button>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Créer</button>
                        </div>
                    </form>

                    <script>
                        let index = 1;

                        function ajouterElement() {
                            let elementsDiv = document.getElementById("elements");
                            let newElement = document.createElement("div");
                            newElement.classList.add("element", "row", "g-2", "mt-2");
                            newElement.innerHTML = `
                        <div class="col-md-4">
                            <input type="text" name="elements[${index}][name]" class="form-control" placeholder="Élément (Ex: Murs)">
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="elements[${index}][etat]" class="form-control" placeholder="État (Ex: Bon)">
                        </div>
                        <div class="col-md-4">
                            <input type="file" name="elements[${index}][photo]" class="form-control">
                        </div>
                    `;
                            elementsDiv.appendChild(newElement);
                            index++;
                        }
                    </script>
                </div>
            </div>

        </div>
    </div>
@endsection
