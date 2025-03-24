@extends('layouts.app')
@section('title', 'Facture')

@section('content')
    <div class="container-fluid">
        <div class="col-md-6">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <form method="GET" action="{{ url('/invoice') }}" class="w-100">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control rounded" placeholder="Chercher une facture"
                            value="{{ request('search') }}">
                        <button type="submit" class="btn bg-primary text-light">Rechercher</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-12">
            <table class="table table-striped table-hover">
                <thead class="table-immoFlow">
                    <tr> 
                        <th scope="col">#</th>
                        <th scope="col">Libellé</th>
                        <th scope="col">Nom Prénom</th>
                        <th scope="col">Montant</th>
                        <th scope="col">Appartement</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $index => $invoice)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $invoice->name }}</td>
                            <td>{{ $invoice->tenant->lastName }} {{ $invoice->tenant->firstName }}</td>
                            <td>{{ $invoice->amount }}€</td>
                            <td>
                                <a href="{{ route('properties.show_units', ['properties' => $invoice->unit->property_id, 'id' => $invoice->unit->id]) }}">
                                    {{ $invoice->unit->name }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('invoice.pdf', $invoice->id) }}" class="btn btn-primary btn-sm">
                                    Voir PDF
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center w-100">
                {{ $invoices->links() }}
            </div>
        </div>
    </div>
@endsection
