@extends('layouts.app')

@section('content')
    @livewire('unit', ["units"=> $units, 'tenants' => $tenants])
@endsection