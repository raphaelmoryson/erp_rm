@extends('layouts.app')

@section('title', 'Immeuble')
@section('marge', 30)

@section('content')
    @livewire('properties', ['building' => $building, 'units' => $units])
@endsection
