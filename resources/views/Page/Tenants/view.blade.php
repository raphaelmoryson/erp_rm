@extends('layouts.app')
@section('title', 'Locataire')
@section('link', '/tenants/create')

@section('content')
    <div class="container-fluid px-3 px-md-4 mt-4">
        <div class="row mb-3">
            <div class="col-12 col-md-6">
                <form method="GET" action="{{ url('/tenants') }}">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control"
                            placeholder="Rechercher un locataire..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">Rechercher</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Table version desktop --}}
        <div class="table-responsive d-none d-md-block">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-immoFlow">
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Appartement</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tenants as $index => $tenant)
                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <td>{{ $tenant->lastName }}</td>
                            <td>{{ $tenant->firstName }}</td>
                            <td>{{ $tenant->email }}</td>
                            <td>{{ $tenant->mobile }}</td>
                            <td>
                                @if ($tenant->unit)
                                    <span class="text-success">Attribué</span>
                                @else
                                    <span class="text-muted">Non attribué</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ url('tenants/edit/' . $tenant->id) }}" class="btn btn-sm btn-primary">Modifier</a>
                                <form action="{{ url('tenants/delete/' . $tenant->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Êtes-vous sûr ?')">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Version mobile : cartes --}}
        <div class="d-md-none">
            @foreach ($tenants as $tenant)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-1">{{ $tenant->firstName }} {{ $tenant->lastName }}</h5>
                        <p class="mb-1"><strong>Email :</strong> {{ $tenant->email }}</p>
                        <p class="mb-1"><strong>Téléphone :</strong> {{ $tenant->mobile }}</p>
                        <p class="mb-2">
                            <strong>Appartement :</strong>
                            @if ($tenant->unit)
                                <span class="text-success">Attribué</span>
                            @else
                                <span class="text-muted">Non attribué</span>
                            @endif
                        </p>
                        <div class="d-flex gap-2">
                            <a href="{{ url('tenants/edit/' . $tenant->id) }}" class="btn btn-sm btn-primary flex-fill">Modifier</a>
                            <form action="{{ url('tenants/delete/' . $tenant->id) }}" method="POST" class="flex-fill">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger w-100"
                                    onclick="return confirm('Êtes-vous sûr ?')">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $tenants->links() }}
        </div>
    </div>
@endsection
