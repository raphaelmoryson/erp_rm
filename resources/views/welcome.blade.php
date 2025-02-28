@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Bienvenue sur notre ERP</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Gérez vos ressources efficacement et facilement.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Gestion des Projets</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Suivez l'avancement de vos projets en temps réel.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Rapports et Analyses</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Générez des rapports détaillés pour une meilleure prise de décision.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection