@extends('layouts.app')

@section('title', 'Tableau de Bord')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Cartes de résumé -->
            <div class="col-md-3">
                <div class="card shadow-sm bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Biens Immobiliers</h5>
                        <h3>{{ $numberProperties }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Locataires</h5>
                        <h3>{{ $numberTenants }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm bg-warning text-dark">
                    <div class="card-body">
                        <h5 class="card-title">Interventions</h5>
                        <h3>{{ $numberInterventions }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm bg-danger text-white">
                    <div class="card-body">
                        <h5 class="card-title">Devis en attente</h5>
                        <h3>{{ $numberQuotes }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activités récentes -->
        <div class="row mt-4">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-secondary text-white">
                        Dernières Activités
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @forelse ($latestActivities as $activity)
                                <li class="list-group-item">
                                    {{ $activity->detail }} - <small
                                        class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                </li>
                            @empty
                                <li class="list-group-item text-muted">Aucune activité récente.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>


            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        Revenus Locatifs
                    </div>
                    <div class="card-body">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('revenueChart').getContext('2d');
            let table = JSON.parse('{!! $allPayments !!}');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sept', 'Oct',
                        'Nov', 'Déc'
                    ],
                    datasets: [{
                        label: 'Revenus (€)',
                        data: table,
                        backgroundColor: 'rgba(0, 123, 255, 0.7)',
                        borderColor: 'rgba(0, 123, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>

@endsection
