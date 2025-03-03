<div>
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link {{ $currentTab === 'info' ? 'active' : '' }}" wire:click="setTab('info')"
                style="cursor: pointer">
                Informations de l’immeuble
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $currentTab === 'lots' ? 'active' : '' }}" wire:click="setTab('lots')"
                style="cursor: pointer">
                Liste des appartements
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $currentTab === 'compta' ? 'active' : '' }}" wire:click="setTab('compta')"
                style="cursor: pointer">
                Aspect comptable
            </a>
        </li>
    </ul>
    <div wire:loading.remove>
        @if ($currentTab === 'info')
            <div class=".container-fluid p-0 m-0">
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
                        <div class="card">
                            <div class="card-body d-flex flex-column">
                                <p><strong>Gérent technique :</strong> <span
                                        class="text-muted">{{ $building->manager->name }}</span></p>
                                <p><strong>Email gérent :</strong> <span
                                        class="text-muted">{{ $building->manager->email }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mt-3">
                        <div class="card p-3 bg-success text-light text-center">
                            <p class="fs-5">Nombre d'appartement</p>
                            <p class="fs-1">{{ count($units) }}</p>
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                        <div class="card p-3 bg-primary text-light text-center">
                            <p class="fs-5">Taux d'occupation</p>
                            <p class="fs-1">{{ number_format($occupancyRate, 2) }}%</p> 
                        </div>
                    </div>
                    
{{--                     

                    <div class="col-md-3 mt-3">
                        <div class="card p-3 bg-danger text-light text-center">
                            <p class="fs-5">Nombre d'appartement</p>
                            <p class="fs-1">{{ count($units) }}</p>

                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                        <div class="card p-3 bg-info text-light text-center">
                            <p class="fs-5">Nombre d'appartement</p>
                            <p class="fs-1">{{ count($units) }}</p>

                        </div>
                    </div> --}}

                </div>
        @elseif ($currentTab === 'lots')
                <a href="{{route('properties.tenants_add', $building->id)}}">
                    <button class="btn btn-primary mb-3"><i class="fas fa-plus"></i> Ajouter </button>
                </a>
                <div class="d-flex flex-wrap justify-content-start">
                    @foreach ($units->sortBy('floor') as $index => $unit)
                                @php
                                    $status = strtolower($unit->status);
                                    $styles = [
                                        'libre' => ['bg' => 'bg-success', 'icon' => 'fa-check-circle', 'text' => 'Libre'],
                                        'loué' => ['bg' => 'bg-primary', 'icon' => 'fa-user', 'text' => 'Loué'],
                                        'en travaux' => ['bg' => 'bg-warning text-dark', 'icon' => 'fa-tools', 'text' => 'En Travaux']
                                    ];
                                    $style = $styles[$status] ?? ['bg' => 'bg-secondary', 'icon' => 'fa-question-circle', 'text' => 'Inconnu'];
                                @endphp

                                <div class="col-md-3 me-3 mb-3">
                                    <div class="card border-0 rounded-lg text-center p-3 position-relative unit-card">
                                        <div class="position-absolute top-0 end-0 m-2">
                                            <span class="badge {{ $style['bg'] }}">
                                                <i class="fas {{ $style['icon'] }}"></i> {{ $style['text'] }}
                                            </span>
                                        </div>
                                        <div class="card-body">
                                            <div class="icon-box mb-3">
                                                <x-heroicon-o-home class="units-icon text-secondary" style="font-size: 40px;" />
                                            </div>
                                            <h5 class="card-title text-dark fw-bold">{{ $unit->name }}</h5>
                                            @if($unit->tenant)
                                                <p class="text-muted m-0">{{ $unit->tenant->firstName }} {{ $unit->tenant->lastName }}</p>
                                            @else
                                                <p class="text-muted m-0">Aucun locataire</p>
                                            @endif
                                            <p class="text-muted m-0">Étage : {{ $unit->floor }}</p>
                                            <p class="badge bg-secondary">Appartement n°{{ $index + 1 }}</p>
                                            <div class="d-flex justify-content-center ">
                                            <form action="{{route('properties.units_delete', $unit->id)}}" method="POST">
                                                @csrf
                                                @method('POST')
                                                <button class="btn btn-danger me-2">Supprimer</button>
                                            </form>
                                            </a>
                                            <a href="{{route('properties.show_units', $unit->id)}}">
                                                <button class="btn btn-primary">Voir</button>
                                            </a>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                    @endforeach
                </div>



        @elseif ($currentTab === 'compta')
            <p>Informations financières et décomptes pour l'immeuble...</p>
        @endif
        </div>
        @livewireScripts


    </div>