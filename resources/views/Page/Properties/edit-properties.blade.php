@extends('layouts.app')

@section('title', 'Immeuble')

@section('content')
    <div class="container p-0 m-0">
        <div class="col-md-12">
            <div class="list-units d-flex flex-wrap">
                @foreach ($units as $unit)
                    
                <div class="units">
                    <x-heroicon-o-home class="units-icon" />
                    <div class="units-info p-0 m-0 d-flex flex-column align-items-center justify-content-center">
                        <p class="p-0 m-0">{{$unit->name}}</p>
                        <p>{{$unit->tenant->firstName}} {{$unit->tenant->lastName}}</p>
                        
                    </div>
                </div>
                @endforeach
 
            </div>

        </div>
    </div>
@endsection