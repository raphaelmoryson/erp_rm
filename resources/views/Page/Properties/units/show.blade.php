@extends('layouts.app')
@section('title', "Appartement : " . $units->name)

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
        </ul>

        <div class="tab-content" id="myTabContent">
            {{-- ONGLET 1 --}}
            <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                <div class="container-fluid p-0 m-0" style="overflow-x: hidden">
                    @if ($monthPayment)
                        <div class="col-md-3 mt-3 mb-3">
                            <div
                                class="card p-3 {{$monthPayment->status == "en attente" ? 'bg-warning' : 'bg-success'}} text-light text-center">
                                <p class="fs-5">Montant loyer du mois</p>
                                <p class="fs-1">{{number_format($monthPayment->amount, 2) }}€</p>
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
                            @if($units->tenant)
                                <p><strong>Nom :</strong> {{ $units->tenant->firstName }} {{ $units->tenant->lastName }}</p>
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
                                            @foreach($tenants as $tenant)
                                                <option value="{{ $tenant->id }}">{{ $tenant->firstName }} {{ $tenant->lastName }}
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
                                    <td>{{$payment->tenant->lastName}} {{$payment->tenant->firstName}}</td>
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
        </div>
    </div>
@endsection