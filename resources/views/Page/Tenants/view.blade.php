@extends('layouts.app')
@section('title', 'Locataire')
@section('link', '/tenants/create')

@section('content')
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-md-6">
                <form method="GET" action="{{ url('/tenants') }}">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" 
                            placeholder="Rechercher un locataire..." 
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">Rechercher</button>
                    </div>
                </form>
            </div>
        </div>

        <table class="table table-striped table-hover">
            <thead class="table-immoFlow">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">Email</th>
                    <th scope="col">Téléphone</th>
                    <th scope="col">Appartement</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tenants as $index => $tenant)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $tenant->lastName }}</td>
                        <td>{{ $tenant->firstName }}</td>
                        <td>{{ $tenant->email }}</td>
                        <td>{{ $tenant->mobile }}</td>

                        <td>
                            @if ($tenant->unit)
                                <span class="text-muted">Attribué</span>
                            @else
                                <span class="text-muted">Non attribué</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ url('tenants/edit/' . $tenant->id) }}"
                                class="btn btn-primary btn-sm">Modifier</a>
                            <form action="{{ url('tenants/delete/' . $tenant->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Êtes-vous sûr ?')">
                                    Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center w-100">
            {{ $tenants->links() }}
        </div>
    </div>
@endsection
