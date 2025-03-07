@extends('layouts.app')

@section('title', 'Entreprise')
@section('link', 'company/create')

@section('content')
<div class="container-fluid">
    <div class="row">
        <table class="table table-striped table-hover">
            <thead class="table-immoFlow">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Email</th>
                    <th scope="col">Téléphone</th>
                    <th scope="col">Adresse</th>
                    <th scope="col">Ville</th>
                    <th scope="col">SIREN</th>
                    <th scope="col">Actions</th>
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
                        {{-- <a href="{{ route('company.show', $company->id) }}" class="btn btn-info btn-sm">Voir</a>
                        <a href="{{ route('company.edit', $company->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                        <form action="{{ route('company.destroy', $company->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer cette entreprise ?')">Supprimer</button>
                        </form> --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
