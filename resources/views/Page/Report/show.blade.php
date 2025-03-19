@extends('layouts.app')

@section('title', 'Détails de l\'intervention')

@section('content')
    <div class="container-fluid mt-4">
        <a href="javascript:history.back()" class="btn btn-primary w-25 m-2">Retour</a>

        <div class="card">

            <div class="card-body">
                <h2>{{ $report->title }}</h2>
                <p class="text-muted">Par {{ $report->company->name }} - {{ $report->created_at->format('d/m/Y H:i') }}</p>
                <p>{{ $report->description }}</p>
                <hr>
                <h5>Propriété concernée :</h5>
                <p><strong>{{ $report->property->name }}</strong></p>
                
                @if ($report->fileQuote)
                    <a href="{{ Storage::url($report->fileQuote) }}" target="_blank">
                        <button class="btn bg-primary text-light">Voir le devis</button>
                    </a>
                @endif
            </div>

        </div>
    </div>
@endsection
