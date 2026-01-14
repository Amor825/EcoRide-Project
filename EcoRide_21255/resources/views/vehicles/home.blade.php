@extends('layouts.app')

@section('content')
<div class="p-5 mb-4 bg-white rounded-3 shadow text-center">
    <h1 class="display-4 fw-bold text-success">Witaj w EcoRide 🌿</h1>
    <p class="lead">Najnowocześniejszy system wypożyczania pojazdów elektrycznych.</p>
    <hr class="my-4">
    <p>Zaloguj się, aby zobaczyć dostępne hulajnogi w Twojej okolicy.</p>
    
    @auth
        <a class="btn btn-success btn-lg px-5" href="{{ route('vehicles.index') }}" role="button">Przeglądaj Flotę</a>
    @else
        <a class="btn btn-primary btn-lg px-5" href="{{ route('login') }}" role="button">Zaloguj się</a>
    @endauth
</div>
@endsection