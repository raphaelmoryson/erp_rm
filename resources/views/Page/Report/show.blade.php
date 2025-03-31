@extends('layouts.app')

@section('title', 'Détails de l\'intervention')

@section('content')


    <div class="container-fluid mt-4">
        <a href="{{ route('properties.show', $report->property_id) }}" class="btn btn-primary mb-2">Retour</a>
        @if ($report->status == 'pending')
            <form action="{{ route('reports.status', $report->id) }}" method="POST" class="d-inline">
                @csrf
                @method('POST')
                <button type="submit" name="status" value="in_progress" class="btn btn-success mb-2">Accepter</button>
                <button type="submit" name="status" value="refused" class="btn btn-danger mb-2">Refuser</button>
            </form>
        @endif

        @if ($report->status == 'in_progress')
            <a href="{{ route('reports.createWorkOrder', $report->id) }}" class="btn btn-info mb-2">Crée un bons de travail</a>
        @endif

        <span
            class="badge 
        @if ($report->status == 'in_progress') bg-warning 
        @elseif ($report->status == 'completed') bg-success 
        @elseif ($report->status == 'pending') bg-secondary 
        @elseif ($report->status == 'refused') bg-danger 
        @else bg-danger @endif">
            @if ($report->status == 'in_progress')
                En cours
            @elseif ($report->status == 'completed')
                Terminée
            @elseif ($report->status == 'pending')
                En attente
            @elseif ($report->status == 'refused')
                Refusée
            @else
                Annulée
            @endif
        </span>
        @if ($report->status == 'in_progress')
            <form action="{{ route('reports.toggle', $report->id) }}" method="POST" class="d-inline">
                @csrf
                @method('POST')
                <div class="form-group">
                    <label for="status">Modifier le statut :</label>
                    <select name="status" id="status" class="form-select">
                        <option value="in_progress" @if ($report->status == 'in_progress') selected @endif>En cours</option>
                        <option value="completed" @if ($report->status == 'completed') selected @endif>Terminée</option>
                        <option value="pending" @if ($report->status == 'pending') selected @endif>En attente</option>
                        <option value="abandoned" @if ($report->status == 'abandoned') selected @endif>Annulée</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success mt-2 mb-2">Mettre à jour</button>
            </form>
        @endif

        <div class="card">
            <div class="card-body">
                <h2>{{ $report->title }}</h2>
                <p class="text-muted">Par {{ $report->company->name }} - {{ $report->created_at->format('d/m/Y H:i') }}
                </p>
                <p>{!! nl2br(e($report->description)) !!}</p>
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
                            <span class="timeline-date d-block">{{ $line->created_at->format('d/m/Y H:i') }}</span>
                            <div
                                class="timeline-content {{ $line->type == 'document' ? 'bg-light' : 'bg-white' }} d-flex flex-row ">
                                <div >
                                    <p>{{ $line->detail }}</p>

                                    @if ($line->type == 'document' && $line->file_path)
                                        <a href="{{ Storage::url($line->file_path) }}" target="_blank"
                                            class="btn btn-sm btn-primary mt-2">
                                            Voir le fichier
                                        </a>
                                    @elseif ($line->type == 'work_order' && $line->file_path)
                                        <a href="{{$line->file_path}}" target="_blank"
                                            class="btn btn-sm btn-warning mt-2">
                                            Voir le bon de travail
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
