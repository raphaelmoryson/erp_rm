@extends('layouts.app')

@section('title', 'Liste des immeubles')
@section('link', 'properties/create')

@section('content')
    <div class="container m-0">
        <div class="row">
            <div class="col-md-8">
                <div class="properties-container">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="input-group">
                            <input type="search" class="form-control rounded" placeholder="Chercher un immeuble"
                                aria-label="Search" aria-describedby="search-addon" />
                            <button type="button" class="btn bg-primary text-light" data-mdb-rippe-init>Rechercher</button>
                        </div>
                    </div>
                    <table class="table table-striped table-hover">
                        <thead class="table-immoFlow">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Adresse</th>
                                <th scope="col">Code Postal</th>
                                <th scope="col">Ville</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($properties as $index => $property)
                                <tr>
                                    <th scope="row">{{ $index + 1 }}</th>
                                    <td>{{ $property['name'] }}</td>
                                    <td>{{ $property['address'] }}</td>
                                    <td>{{ $property['zip_code'] }}</td>
                                    <td>{{ $property['city'] }}</td>
                                    <td>
                                        <a href="{{ url('properties/edit/' . $property['id']) }}"
                                            class="btn btn-primary btn-sm">
                                            Voir Détails
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>

            <div class="col-md-2">
                <div class="map-container">
                    <h3>Emplacement</h3>
                    <div id="map"></div>
                </div>
            </div>
            
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var map = L.map('map').setView([46.20813364904721, 6.155216646162519], 9);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);


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
                var icon;
                var latitude = "{{ $property->latitude }}";
                var longitude = "{{ $property->longitude }}";
                console.log(latitude, longitude)
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

                L.marker([latitude, longitude], { icon: icon })
                    .addTo(map)
                    .bindPopup("<b>{{ $property->name }}</b><br>{{ $property->address }}");
            @endforeach
        });

    </script>


@endsection