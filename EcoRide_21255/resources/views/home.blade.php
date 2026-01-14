@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card-custom mb-4 text-center">
                <h1 class="mb-4 text-success">🌱 Witaj w EcoRide!</h1>
                <p class="lead mb-4">Ekologiczny system wypożyczania hulajnóg elektrycznych</p>
                
                <div class="row mt-5">
                    <div class="col-md-6 mb-3">
                        <div class="card border-success">
                            <div class="card-body">
                                <h5 class="card-title">🚄 Szybka Przejażdżka</h5>
                                <p class="card-text">Wynajmij hulajnogę i ciesz się szybką przejażdżką po mieście.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card border-success">
                            <div class="card-body">
                                <h5 class="card-title">♻️ Eco Friendly</h5>
                                <p class="card-text">Wybierz zielony transport i zmniejsz ślad węglowy.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6 mb-3">
                        <div class="card border-success">
                            <div class="card-body">
                                <h5 class="card-title">💰 Oszczędne</h5>
                                <p class="card-text">Niskie ceny i transparentne opłaty za każdą przejażdżkę.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card border-success">
                            <div class="card-body">
                                <h5 class="card-title">📱 Łatwe w użyciu</h5>
                                <p class="card-text">Prosty interfejs i szybka rejestracja konta.</p>
                            </div>
                        </div>
                    </div>
                </div>

                @auth
                    <div class="mt-5">
                        <h3 class="mb-3">Gotów do jazdy?</h3>
                        <a href="{{ route('vehicles.index') }}" class="btn btn-success btn-lg">
                            Zobacz Dostępne Pojazdy →
                        </a>
                    </div>
                @else
                    <div class="mt-5">
                        <h3 class="mb-3">Rozpocznij swoją podróż</h3>
                        <a href="{{ route('login') }}" class="btn btn-success btn-lg me-2">
                            Zaloguj się
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-outline-success btn-lg">
                            Zarejestruj się
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection