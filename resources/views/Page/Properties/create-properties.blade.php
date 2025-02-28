@extends('layouts.app')

@section('title', "Création d'un immeuble")

@section('content')
<form action="{{ route('properties.create') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="name">Nom de l'immeuble</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Entrez le nom de l'immeuble" required>
    </div>
    <div class="form-group">
        <label for="address">Adresse</label>
        <input type="text" class="form-control" id="address" name="address" placeholder="Entrez l'adresse" required>
    </div>
    <div class="form-group">
        <label for="city">Ville</label>
        <input type="text" class="form-control" id="city" name="city" placeholder="Entrez la ville" required>
    </div>
    <div class="form-group">
        <label for="postal_code">Code Postal</label>
        <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Entrez le code postal" required>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Entrez une description" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Créer</button>
</form>
@endsection