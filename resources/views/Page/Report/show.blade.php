@extends('layouts.app')

@section('title', 'Détails de l\'intervention')

@section('content')
    <div class="container-fluid mt-4">
        <a href="javascript:history.back()" class="btn btn-primary mb-2">Retour</a>

        <div class="card">
            <div class="card-body">
                <h2>{{ $report->title }}</h2>
                <p class="text-muted">Par {{ $report->company->name }} - {{ $report->created_at->format('d/m/Y H:i') }}</p>
                <p>{{ $report->description }}</p>
                <hr>

                <h5>Propriété concernée :</h5>
                <p><strong>{{ $report->property->name }}</strong></p>

            </div>
        </div>

        {{-- Timeline des étapes --}}
        <div class="card mt-4">
            <div class="card-body">
                <h4>Évolution de l'intervention</h4>
                <ul class="timeline">
                    @foreach ($report->reportLines as $line)
                        <li class="timeline-item">
                            <span class="timeline-date">{{ $line->created_at->format('d/m/Y H:i') }}</span>
                            <div class="timeline-content {{ $line->type == 'document' ? 'bg-light' : 'bg-white' }} d-flex align-items-center">
                                <p>{{ $line->detail }}</p>
                                @if ($line->type == 'document' && $line->file_path)
                                    <a href="{{ Storage::url($line->file_path) }}" target="_blank" class="btn btn-sm btn-primary">
                                        Voir le fichier
                                    </a>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
