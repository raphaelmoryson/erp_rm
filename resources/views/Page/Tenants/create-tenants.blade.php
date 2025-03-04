@extends('layouts.app')
@section('title', 'Ajouter un Locataire')

@section('content')
    <div class="container-fluid">
        <form method="POST" action="{{ route('tenants.store') }}">
            @csrf

            <div class="mb-3">
                <label for="lastName" class="form-label">Nom</label>
                <input type="text" class="form-control @error('lastName') is-invalid @enderror" id="lastName"
                    name="lastName" value="{{ old('lastName') }}" required>
                @error('lastName')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="firstName" class="form-label">Prénom</label>
                <input type="text" class="form-control @error('firstName') is-invalid @enderror" id="firstName"
                    name="firstName" value="{{ old('firstName') }}" required>
                @error('firstName')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                    value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="mobile" class="form-label">Téléphone</label>
                <input type="text" class="form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile"
                    value="{{ old('mobile') }}" required>
                @error('mobile')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="adress" class="form-label">Adresse</label>
                <input type="text" class="form-control @error('adress') is-invalid @enderror" id="adress" name="adress"
                    value="{{ old('adress') }}" required>
                @error('adress')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Statut</label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                    <option value="actif" {{ old('status') == 'actif' ? 'selected' : '' }}>Actif</option>
                    <option value="inactif" {{ old('status') == 'inactif' ? 'selected' : '' }}>Inactif</option>
                    <option value="resilié" {{ old('status') == 'resilié' ? 'selected' : '' }}>Résilié</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>
@endsection