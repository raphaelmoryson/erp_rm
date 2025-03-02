<div>
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link {{ $currentTab === 'info' ? 'active' : '' }}" wire:click="setTab('info')"
                style="cursor: pointer">Informations de l’immeuble</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $currentTab === 'lots' ? 'active' : '' }}" wire:click="setTab('lots')"
                style="cursor: pointer">Liste des
                lots</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $currentTab === 'compta' ? 'active' : '' }}" wire:click="setTab('compta')"
                style="cursor: pointer">Aspect
                comptable</a>
        </li>
    </ul>
    <div>
        @if ($currentTab === 'info')
            <div class="container mt-4">
                <div class="card">
                    <div class="card-body">
                        <p><strong>Nom :</strong> <span class="text-muted">{{ $building->name }}</span></p>
                        <p><strong>Adresse :</strong> <span class="text-muted">{{ $building->address }}</span></p>
                        <p><strong>Ville :</strong> <span class="text-muted">{{ $building->city }}</span></p>
                    </div>
                </div>
            </div>

        @elseif ($currentTab === 'lots')
            <div class="col-md-12">
                <button class="btn btn-primary">Ajouter</button>
                <div class=" d-flex flex-wrap flex-row">
                    @foreach ($units as $unit)
                        <div class="units">
                            <x-heroicon-o-home class="units-icon" />
                            <div class="units-info p-0 m-0 d-flex flex-column align-items-center justify-content-center">
                                <p class="p-0 m-0">{{$unit->name}}</p>
                                <p class="p-0 m-0">{{$unit->tenant->firstName}} {{$unit->tenant->lastName}}</p>
                                <p class="p-0 m-0">Appartement n°{{$unit->id}} </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @elseif ($currentTab === 'compta')
            <p>Informations financières et décomptes pour l'immeuble...</p>
        @endif
    </div>
    @livewireScripts

</div>