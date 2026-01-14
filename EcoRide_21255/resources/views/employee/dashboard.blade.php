@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <h2 class="mb-4">👷 Dashboard Pracownika</h2>

    <!-- Zgłoszenia serwisowe -->
    <div class="mb-5">
        <h3 class="mb-3">🔧 Zgłoszenia Serwisowe ({{ $maintenanceTickets->count() }})</h3>

        @if($maintenanceTickets->count() > 0)
            <div class="card-custom">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Pojazd</th>
                            <th>Opis Problemu</th>
                            <th>Status</th>
                            <th>Data Zgłoszenia</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($maintenanceTickets as $ticket)
                        <tr>
                            <td>#{{ $ticket->id }}</td>
                            <td class="fw-bold">{{ $ticket->vehicle->model }}</td>
                            <td>{{ Str::limit($ticket->issue_description, 50) }}</td>
                            <td>
                                @if($ticket->status === 'open')
                                    <span class="badge bg-danger">Otwarte</span>
                                @elseif($ticket->status === 'in_progress')
                                    <span class="badge bg-warning text-dark">W toku</span>
                                @else
                                    <span class="badge bg-success">Zamknięte</span>
                                @endif
                            </td>
                            <td>{{ $ticket->created_at->format('d.m.Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">
                Brak aktualnych zgłoszeń serwisowych
            </div>
        @endif
    </div>

    <!-- Opinie użytkowników -->
    <div class="mb-5">
        <h3 class="mb-3">⭐ Ostatnie Opinie Użytkowników ({{ $recentReviews->count() }})</h3>

        @if($recentReviews->count() > 0)
            <div class="row">
                @foreach($recentReviews as $review)
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="card-title mb-0">{{ $review->vehicle->model }}</h6>
                                        <small class="text-muted">od {{ $review->user->name }}</small>
                                    </div>
                                    <span class="badge bg-warning text-dark">
                                        @for($i = 0; $i < $review->rating; $i++)
                                            ⭐
                                        @endfor
                                    </span>
                                </div>
                                
                                <p class="card-text">{{ $review->comment }}</p>
                                
                                <small class="text-muted">
                                    {{ $review->created_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info">
                Brak opinii do wyświetlenia
            </div>
        @endif
    </div>

    <!-- Statystyki -->
    <div class="row">
        <div class="col-md-6">
            <div class="card-custom text-center">
                <h6 class="text-muted">Otwarte Zgłoszenia Serwisowe</h6>
                <h2 class="text-danger">
                    {{ $maintenanceTickets->where('status', 'open')->count() }}
                </h2>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-custom text-center">
                <h6 class="text-muted">Całkowita Liczba Opinii</h6>
                <h2 class="text-info">
                    {{ $recentReviews->count() }}
                </h2>
            </div>
        </div>
    </div>
</div>
@endsection
