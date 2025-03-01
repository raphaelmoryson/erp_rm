@extends('layouts.app')

@section('title', 'Liste des immeubles')
@section('link', 'properties/create')

@section('content')
    <div class="container m-0">
        <div class="row">
            <!-- Colonne 1 - Liste des Immeubles -->
            <div class="col-md-8">
                <div class="properties-container">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="input-group">
                            <input type="search" class="form-control rounded" placeholder="Chercher un immeuble"
                                aria-label="Search" aria-describedby="search-addon" />
                            <button type="button" class="btn bg-primary text-light" data-mdb-rippe-init>Rechercher</button>
                        </div>
                    </div>
                    <div class="properties-grid mt-3">
                        @foreach($properties as $property)
                            <div class="property-card">
                                <div class="property-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                                        class="bi bi-building" viewBox="0 0 16 16">
                                        <path
                                            d="M4 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM7.5 5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM4.5 8a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z" />
                                        <path
                                            d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1zm11 0H3v14h3v-2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V15h3z" />
                                    </svg>
                                </div>
                                <div class="property-info">
                                    <h2 class="property-name">{{ $property['name'] }}</h2>
                                    <p class="property-address">{{ $property['address'] }}, {{ $property['zip_code'] }}
                                        {{ $property['city'] }}
                                    </p>
                                    <a href="properties/{{ $property['id'] }}" class="btn-details">Voir Détails</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Colonne 2 - Carte interactive -->
            <div class="col-md-4">
                <div class="map-container w-100">
                    <h3>Emplacement</h3>
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </div>
    @foreach($properties as $property)
        @if($property->latitude && $property->longitude)
            L.marker([{{ $property->latitude }}, {{ $property->longitude }}])
            .addTo(map)
            .bindPopup("<b>{{ $property->name }}</b><br>{{ $property->address }}<br>{{ $property->zip_code }}
            {{ $property->city }}");
        @endif
    @endforeach
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var map = L.map('map').setView([46.18904335573905, 6.075419262357862], 11);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            function geocodeAddress(address, callback) {
                var url = 'https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(address);

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.length > 0) {
                            var lat = data[0].lat;
                            var lon = data[0].lon;
                            callback(lat, lon);
                        }
                    })
                    .catch(error => console.error('Erreur de géocodage:', error));
            }

            // Définir des icônes personnalisées
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

            @foreach($properties as $property)
                var address = "{{ $property->address }}, {{ $property->zip_code }} {{ $property->city }}";
                geocodeAddress(address, function (lat, lon) {
                    var icon;
                    console.log(type)
                    
                    var type = "{{ $property->type }}"; // Assurez-vous que le type est bien défini dans votre modèle
                    if (type === "entreprise") {
                        icon = redIcon;
                    } else if (type === "locatif") {
                        icon = blueIcon;
                    } else if (type === "propriétaire") {
                        icon = greenIcon;
                    } else {
                        icon = L.marker(); // Par défaut, un marqueur normal
                    }

                    L.marker([lat, lon], { icon: icon })
                        .addTo(map)
                        .bindPopup("<b>{{ $property->name }}</b><br>{{ $property->address }}");
                });
            @endforeach
        });

    </script>


@endsection