@extends('layouts.app')

@section('title', 'Détails du bon de travail')

@section('content')
    <div class="container-fluid mt-4">
        <form action="{{ route('reports.storeWorkOrder', $id) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="execution_deadline" class="form-label">Délais d'exécution</label>
                <input type="text" class="form-control" id="execution_deadline" name="execution_deadline"
                    placeholder="Entrez le délais d'exécution" required>
            </div>

            <div class="mb-3">
                <label for="quotePrice" class="form-label">Prix du devis (CHF)</label>
                <input type="number" class="form-control" id="quotePrice" name="quotePrice"
                    placeholder="Entrez le prix du devis" step="0.01" required>
            </div>

            <div class="mb-3">
                <label for="quoteReceivedDate" class="form-label">Date de réception du devis</label>
                <input type="date" class="form-control" id="quoteReceivedDate" name="quoteReceivedDate" required>
            </div>

            <div class="mb-3">
                <label for="workReason" class="form-label">Raison des travaux</label>
                <textarea class="form-control" id="workReason" name="workReason" rows="3"
                    placeholder="Entrez la raison des travaux" required></textarea>
            </div>

            <div class="mb-3">
                <label for="assignedTo" class="form-label">Travaux assignés à</label>
                <input type="text" class="form-control" id="assignedTo" name="assignedTo"
                    placeholder="Nom du responsable ou entreprise" required>
            </div>

            <div class="mb-3">
                <label for="scheduledDate" class="form-label">Date prévue pour les travaux</label>
                <input type="date" class="form-control" id="scheduledDate" name="scheduledDate" required>
            </div>

            <button type="submit" class="btn btn-primary">Soumettre</button>
        </form>
    </div>
@endsection
