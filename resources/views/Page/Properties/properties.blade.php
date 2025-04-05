@extends('layouts.app')

@section('title', 'Immeubles')
@section('link', 'properties/create')

@section('content')
    <div class="container-fluid px-3 px-md-4 mt-4">
        <div class="row g-4">
            <!-- Contenu principal -->
            <div class="col-12 col-lg-9">
                <div class="mb-3">
                    <form method="GET" action="{{ url('/properties') }}">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Chercher un immeuble"
                                value="{{ request('search') }}">
                            <button type="submit" class="btn bg-primary text-light">Rechercher</button>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-immoFlow">
                            <tr>
                                <th>#</th>
                                <th>Nom</th>
                                <th>Adresse</th>
                                <th>Code Postal</th>
                                <th>Ville</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($properties as $index => $property)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $property->name }}</td>
                                    <td>{{ $property->address }}</td>
                                    <td>{{ $property->zip_code }}</td>
                                    <td>{{ $property->city }}</td>
                                    <td>
                                        <a href="{{ url('properties/edit/' . $property->id) }}" class="btn btn-primary btn-sm">
                                            Voir Détails
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    {{ $properties->links() }}
                </div>
            </div>

            <!-- Carte (en dessous sur mobile) -->
            <div class="col-12 col-lg-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Emplacement</h5>
                        <div id="map" style="height: 400px; width: 100%;" class="rounded border"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Leaflet Map Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var map = L.map('map').setView([46.2081, 6.1552], 9);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            var redIcon = L.icon({
                iconUrl: 'https://maps.google.com/mapfiles/ms/icons/red-dot.png',
                iconSize: [32, 32],
                iconAnchor: [16, 32],
                popupAnchor: [0, -32]
            });

            var blueIcon = L.icon({
                iconUrl: 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png',
                iconSize: [32, 32],
                iconAnchor: [16, 32],
                popupAnchor: [0, -32]
            });

            var greenIcon = L.icon({
                iconUrl: 'https://maps.google.com/mapfiles/ms/icons/green-dot.png',
                iconSize: [32, 32],
                iconAnchor: [16, 32],
                popupAnchor: [0, -32]
            });

            @foreach ($properties as $property)
                var icon;
                var latitude = "{{ $property->latitude }}";
                var longitude = "{{ $property->longitude }}";
                var type = "{{ $property->type }}";

                if (type === "entreprise") {
                    icon = redIcon;
                } else if (type === "locatif") {
                    icon = blueIcon;
                } else if (type === "propriétaire") {
                    icon = greenIcon;
                } else {
                    icon = L.marker();
                }

                if (latitude && longitude) {
                    L.marker([latitude, longitude], { icon: icon })
                        .addTo(map)
                        .bindPopup("<b>{{ $property->name }}</b><br>{{ $property->address }}");
                }
            @endforeach
        });
    </script>
@endsection
