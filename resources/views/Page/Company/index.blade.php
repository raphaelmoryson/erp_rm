@extends('layouts.app')

@section('title', 'Entreprise')
@section('link', 'company/create')

@section('content')
    <div class="container-fluid px-3 px-md-4 mt-4">
        <div class="row mb-3">
            <div class="col-12 col-md-6">
                <form method="GET" action="{{ url('/company') }}">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Rechercher une entreprise..."
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">Rechercher</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Tableau classique pour desktop --}}
        <div class="table-responsive d-none d-md-block">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-immoFlow">
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Adresse</th>
                        <th>Ville</th>
                        <th>SIREN</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($companies as $company)
                        <tr>
                            <td>{{ $company->id }}</td>
                            <td>{{ $company->name }}</td>
                            <td>{{ $company->email }}</td>
                            <td>{{ $company->phone }}</td>
                            <td>{{ $company->address }}</td>
                            <td>{{ $company->city }}</td>
                            <td>{{ $company->siren }}</td>
                            <td>
                                {{-- Actions pour chaque entreprise --}}
                                {{-- <a href="{{ route('company', $company->id) }}" class="btn btn-info btn-sm">Voir</a> --}}
                                {{-- <a href="{{ route('company.edit', $company->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                                <form action="{{ route('company.destroy', $company->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Voulez-vous vraiment supprimer cette entreprise ?')">Supprimer</button>
                                </form> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Version mobile : cartes --}}
        <div class="d-md-none">
            @foreach ($companies as $company)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-1">{{ $company->name }}</h5>
                        <p class="mb-1"><strong>Email :</strong> {{ $company->email }}</p>
                        <p class="mb-1"><strong>Téléphone :</strong> {{ $company->phone }}</p>
                        <p class="mb-1"><strong>Adresse :</strong> {{ $company->address }}</p>
                        <p class="mb-1"><strong>Ville :</strong> {{ $company->city }}</p>
                        <p class="mb-2"><strong>SIREN :</strong> {{ $company->siren }}</p>
                        <div class="d-flex gap-2">
                            {{-- <a href="{{ route('company.show', $company->id) }}" class="btn btn-sm btn-info flex-fill">Voir</a>
                            <a href="{{ route('company.edit', $company->id) }}" class="btn btn-sm btn-warning flex-fill">Modifier</a>
                            <form action="{{ route('company.destroy', $company->id) }}" method="POST" class="flex-fill">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger w-100"
                                    onclick="return confirm('Voulez-vous vraiment supprimer cette entreprise ?')">Supprimer</button>
                            </form> --}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


    </div>
@endsection
