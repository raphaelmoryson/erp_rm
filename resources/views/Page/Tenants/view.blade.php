@extends('layouts.app')
@section('title', 'Locataire')
@section('link', '/tenants/create')

@section('content')
    <div class="container-fluid">
        <div class="row">
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
                    @foreach($tenants as $index => $tenant)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ $tenant->lastName }}</td>
                            <td>{{ $tenant->firstName }}</td>
                            <td>{{ $tenant->email }}</td>
                            <td>{{ $tenant->mobile }}</td>

                            <td>
                                @if($tenant->unit)
                                    <span class="text-muted">Attribué</span>

                                @else
                                    <span class="text-muted">Non attribué</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ url('tenants/edit/' . $tenant->id) }}" class="btn btn-primary btn-sm">Modifier</a>
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
        </div>
    </div>

@endsection