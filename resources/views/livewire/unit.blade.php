<div>
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link {{ $currentTab === 'info' ? 'active' : '' }}" wire:click="setTab('info')"
                style="cursor: pointer">
                Information locataire
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $currentTab === '' ? 'active' : '' }}" wire:click="setTab('juridique')"
                style="cursor: pointer">
                Fiche juridique
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $currentTab === 'compta' ? 'active' : '' }}" wire:click="setTab('compta')"
                style="cursor: pointer">
                Fiche comptable
            </a>
        </li>
    </ul>

    <div wire:loading.remove>
        @if ($currentTab === 'info')
            <div class=".container-fluid p-0 m-0" style="overflow-x: hidden">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Détails de l'Appartement</h3>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $units->name }}</h5>
                        <p class="card-text"><strong>Type :</strong> {{ ucfirst($units->type) }}</p>
                        <p class="card-text"><strong>Superficie :</strong> {{ $units->area }} m²</p>
                        <p class="card-text"><strong>Étage :</strong> {{ $units->floor }}</p>
                        <p class="card-text"><strong>Statut :</strong>
                            <span class="badge bg-{{ $units->status == 'libre' ? 'success' : 'danger' }}">
                                {{ ucfirst($units->status) }}
                            </span>
                        </p>
                        <hr>

                        <!-- Informations sur la propriété -->
                        <h4>Immeuble</h4>
                        <p><strong>Nom :</strong> {{ $units->property->name }}</p>
                        <p><strong>Adresse :</strong> {{ $units->property->address }}, {{ $units->property->zip_code }}
                            {{ $units->property->city }}</p>
                        <p><strong>Capacité max :</strong> {{ $units->property->max_units }} unités</p>
                        <hr>

                        <!-- Locataire -->
                        <h4>Locataire</h4>
                        @if($units->tenant)
                            <p><strong>Nom :</strong> {{ $units->tenant->firstName }} {{ $units->tenant->lastName }}</p>
                            <p><strong>Email :</strong> {{ $units->tenant->email }}</p>
                            <p><strong>Téléphone :</strong> {{ $units->tenant->mobile }}</p>
                            <form action="{{ route('unit.remove_tenant', $units->id) }}" method="POST">
                                @csrf
                                @method('POST')
                                <button class="btn btn-danger">Désattribuer ce locataire</button>
                            </form>
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
        @endif
    </div>


</div>