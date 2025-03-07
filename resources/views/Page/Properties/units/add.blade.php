@extends('layouts.app')

@section('title', "Création d'un appartement")

@section('content')
    <form action="{{ route('properties.tenants_post', $building->id) }}" method="POST">
        @csrf
        <div class="form-group mb-2">
            <label for="name">Nom : </label>
            <input type="text" class="form-control" id="name" name="name" placeholder="nom de l'appartement" required>
        </div>
        <div class="form-group mb-2">
            <label for="area">Surface : </label>
            <input type="number" class="form-control" id="area" name="area" placeholder="m² de l'appartement" required>
        </div>

        <div class="form-group mb-2">
            <label for="floor">Étage : </label>
            <input type="text" class="form-control" id="floor" name="floor" placeholder="Saisissez l'étage" required>
        </div>

        <div class="form-group mb-2">
            <label for="initial_rent_price">Prix du loyer : </label>
            <input type="text" class="form-control" id="initial_rent_price" name="initial_rent_price"
                placeholder="Saisissez l'étage" required>
        </div>


        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="check" id="checkLoyer" name="checkLoyer">
            <label class="form-check-label" for="checkLoyer">
                Dans l'appartement actuellement
            </label>
        </div>


        <div class="form-group mb-2">
            <label for="type">Statuts :</label>
            <select class="form-select" aria-label="Default select example" name="type" id="type">
                <option value="appartement">Appartement</option>
                <option value="bureau">Bureau</option>
                <option value="commerce">Commerce</option>
            </select>
        </div>
        <div class="form-group mb-2">
            <label for="status">Statuts :</label>
            <select class="form-select" aria-label="Default select example" name="status" id="status">
                <option value="libre">Libre</option>
                <option value="loué">Loué</option>
                <option value="en travaux">En travaux</option>
            </select>
        </div>


        <div class="form-group mb-2" id="tenantGroup" style="display: none;">
            <label for="tenant_id">Locataire attribué :</label>
            <select class="form-select" aria-label="Default select example" name="tenant_id" id="tenant_id">
                <option value="0">Aucun pour le moment.</option>
                <option value="0">----</option>
                @foreach ($tenants as $tenant)
                    <option value="{{$tenant->id}}">{{$tenant->firstName}} {{$tenant->lastName}}</option>
                @endforeach
            </select>
        </div>


        <button type="submit" class="btn btn-primary mb-3 mt-3">Créer</button>
    </form>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let statusSelect = document.getElementById("status");
            let tenantGroup = document.getElementById("tenantGroup");

            function toggleTenantField() {
                if (statusSelect.value === "loué") {
                    tenantGroup.style.display = "block";
                } else {
                    tenantGroup.style.display = "none";
                }
            }

            statusSelect.addEventListener("change", toggleTenantField);
            toggleTenantField(); // Vérifie au chargement de la page
        });
    </script>
@endsection