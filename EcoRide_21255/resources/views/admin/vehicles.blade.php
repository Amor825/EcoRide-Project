@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <h2 class="mb-4">🚄 Zarządzanie Pojazami</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card-custom">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Model</th>
                    <th>Lokalizacja</th>
                    <th>Bateria</th>
                    <th>Cena/min</th>
                    <th>Status</th>
                    <th>Opinie</th>
                    <th>Akcje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vehicles as $vehicle)
                <tr>
                    <td>#{{ $vehicle->id }}</td>
                    <td class="fw-bold">{{ $vehicle->model }}</td>
                    <td>{{ $vehicle->station->name }}</td>
                    <td>
                        <div class="progress" style="height: 20px; width: 80px;">
                            <div class="progress-bar {{ $vehicle->battery_level < 20 ? 'bg-danger' : 'bg-success' }}" 
                                 style="width: {{ $vehicle->battery_level }}%">
                                 {{ $vehicle->battery_level }}%
                            </div>
                        </div>
                    </td>
                    <td>{{ $vehicle->price_per_minute }} zł</td>
                    <td>
                        @if($vehicle->is_available)
                            <span class="badge bg-success">Dostępny</span>
                        @else
                            <span class="badge bg-secondary">Zajęty</span>
                        @endif
                    </td>
                    <td>
                        @php
                            $avgRating = $vehicle->reviews->avg('rating');
                        @endphp
                        @if($vehicle->reviews->count() > 0)
                            <span class="badge bg-warning text-dark">
                                ⭐ {{ number_format($avgRating, 1) }}/5
                            </span>
                        @else
                            <span class="text-muted">Brak opinii</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('reviews.show', $vehicle->id) }}" class="btn btn-sm btn-info">
                            Opinie
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">← Wróć do panelu</a>
    </div>
</div>
@endsection
