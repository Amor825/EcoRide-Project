@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card-custom mb-4">
                <h2>⭐ Opinie o: {{ $vehicle->model }}</h2>
                <hr>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5>Średnia Ocena</h5>
                        <h3 class="text-warning">
                            {{ number_format($averageRating ?? 0, 1) }}/5
                        </h3>
                        <p class="text-muted">
                            Na podstawie {{ $reviews->count() }} opinii
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h5>Szczegóły Pojazdu</h5>
                        <p>
                            <strong>Lokalizacja:</strong> {{ $vehicle->station->name }}<br>
                            <strong>Bateria:</strong> {{ $vehicle->battery_level }}%<br>
                            <strong>Cena:</strong> {{ $vehicle->price_per_minute }} zł/min<br>
                            <strong>Status:</strong> 
                            @if($vehicle->is_available)
                                <span class="badge bg-success">Dostępny</span>
                            @else
                                <span class="badge bg-secondary">Niedostępny</span>
                            @endif
                        </p>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <!-- Formularz dodawania opinii -->
                @auth
                <div class="card bg-light mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Dodaj swoją opinię</h5>
                        <form action="{{ route('reviews.store', $vehicle->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="rating" class="form-label">Ocena (1-5 gwiazdek)</label>
                                <select class="form-select" id="rating" name="rating" required>
                                    <option value="">Wybierz ocenę</option>
                                    <option value="5">⭐⭐⭐⭐⭐ Doskonały</option>
                                    <option value="4">⭐⭐⭐⭐ Bardzo dobry</option>
                                    <option value="3">⭐⭐⭐ Dobry</option>
                                    <option value="2">⭐⭐ Słaby</option>
                                    <option value="1">⭐ Bardzo słaby</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="comment" class="form-label">Komentarz (opcjonalnie)</label>
                                <textarea class="form-control" id="comment" name="comment" rows="3" placeholder="Podziel się swoją opinią..."></textarea>
                                <small class="text-muted">Maksymalnie 500 znaków</small>
                            </div>
                            <button type="submit" class="btn btn-success">Dodaj opinię</button>
                        </form>
                    </div>
                </div>
                @else
                <div class="alert alert-info">
                    <a href="{{ route('login') }}">Zaloguj się</a>, aby dodać opinię
                </div>
                @endauth
            </div>

            <!-- Lista opinii -->
            <div class="card-custom">
                <h4 class="mb-4">Opinie Użytkowników ({{ $reviews->count() }})</h4>

                @if($reviews->count() > 0)
                    @foreach($reviews as $review)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="card-title mb-1">{{ $review->user->name }}</h6>
                                        <p class="text-muted small mb-2">
                                            {{ $review->created_at->format('d.m.Y H:i') }}
                                        </p>
                                    </div>
                                    <span class="badge bg-warning text-dark">
                                        @for($i = 0; $i < $review->rating; $i++)
                                            ⭐
                                        @endfor
                                    </span>
                                </div>
                                @if($review->comment)
                                    <p class="card-text mt-2">{{ $review->comment }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-info">
                        Brak opinii dla tego pojazdu. Bądź pierwszy i dodaj opinię!
                    </div>
                @endif
            </div>

            <div class="mt-4">
                <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">← Wróć do pojazdów</a>
            </div>
        </div>
    </div>
</div>
@endsection
