@extends('layouts.app')

@section('title', "Création d'un immeuble")

@section('content')
    <form action="{{ route('properties.create') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nom de l'immeuble</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Entrez le nom de l'immeuble"
                required>
        </div>
        <div class="form-group">
            <label for="manager">Gérant de l'immeuble</label>
            <select class="form-select" aria-label="Default select example" name="manager" id="manager">
                @foreach ($managers as $manager)
                    <option value="{{ $manager->id }}">
                        {{ $manager->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="type">Type :</label>
            <select class="form-select" aria-label="Default select example" name="type" id="type">
                <option value="entreprise">Entreprise</option>
                <option value="locatif">Locatif</option>
                <option value="propriétaire">Propriétaire</option>
            </select>
        </div>
        <div class="form-group">
            <label for="status">Statuts :</label>
            <select class="form-select" aria-label="Default select example" name="status" id="status">
                <option value="actif">Actif</option>
                <option value="inactif">Inactif</option>
            </select>
        </div>
        <div class="form-group">
            <label for="address">Adresse</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Saisissez l'adresse" required>
        </div>
        <div class="form-group">
            <label for="city">Ville</label>
            <input type="text" class="form-control" id="city" name="city" placeholder="Entrez la ville" required>
        </div>
        <div class="form-group">
            <label for="postal_code">Code Postal</label>
            <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Entrez le code postal"
                required>
        </div>
        <div class="form-group">
            <label for="max_units">Appartement max</label>
            <input type="number" class="form-control" id="max_units" name="max_units" placeholder="Entrez le nombre d'appartement dans l'immeuble"
                required>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Créer</button>
    </form>
@endsection