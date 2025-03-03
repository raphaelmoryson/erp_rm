@extends('layouts.app')

@section('title', 'Immeuble')
@section('marge', 30)

@section('content')
    <a href="/properties">
        <button class="btn btn-primary mt-3 mb-3" style="width: 150px">Retour</button>
    </a>
    @if (session()->has('success'))
        <div class="alert alert-success mt-3">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    @livewire('properties', ['building' => $building, 'units' => $units, 'occupancyRate' => $occupancyRate])
@endsection