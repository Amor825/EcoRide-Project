@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-warning fw-bold mb-4">🔧 Panel Mechanika</h1>

    @if(session('success'))
        <div class="alert alert-success fw-bold">{{ session('success') }}</div>
    @endif

    @if($reports->isNotEmpty())
        <div class="alert alert-danger shadow-sm mb-4">
            <h4 class="alert-heading fw-bold mb-0">⚠️ Awarie do naprawy ({{ $reports->count() }})</h4>
        </div>
        
        <div class="row mb-5">
            @foreach($reports as $report)
            <div class="col-md-6 mb-3">
                <div class="card border-danger shadow h-100">
                    <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                        <strong>#{{ $report->vehicle->id }} {{ $report->vehicle->model }}</strong>
                        <span class="badge bg-white text-danger">Ocena: {{ $report->rating }}/5</span>
                    </div>
                    <div class="card-body">
                        <p class="fst-italic mb-2">"{{ $report->comment ?? 'Brak opisu' }}"</p>
                        <div class="small text-muted mb-3">Zgłosił: {{ $report->user->name }} | {{ $report->created_at->diffForHumans() }}</div>
                        <form action="{{ route('mechanic.fix', $report->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-success w-100 fw-bold">⚡ NAPRAW I NAŁADUJ</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-success shadow-sm mb-5">
            <h4 class="alert-heading fw-bold mb-0">✅ Brak zgłoszonych awarii. Dobra robota!</h4>
        </div>
    @endif

    <hr class="my-5" style="border-top: 3px solid #bbb;">

    <h3 class="mb-3 fw-bold text-dark">🔋 Zarządzanie Flotą (Pojedyncze ładowanie)</h3>
    
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Model</th>
                        <th style="width: 25%;">Bateria</th>
                        <th>Status</th>
                        <th>Szybkie Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vehicles as $vehicle)
                    <tr>
                        <td>#{{ $vehicle->id }}</td>
                        <td class="fw-bold">{{ $vehicle->model }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress flex-grow-1" style="height: 20px;">
                                    <div class="progress-bar {{ $vehicle->battery_level < 30 ? 'bg-danger' : ($vehicle->battery_level < 70 ? 'bg-warning' : 'bg-success') }}" 
                                         style="width: {{ round($vehicle->battery_level) }}%">
                                    </div>
                                </div>
                                <span class="fw-bold">{{ round($vehicle->battery_level) }}%</span>
                            </div>
                        </td>
                        <td>
                            @if(!$vehicle->is_available)
                                <span class="badge bg-danger">Zajęta / Awaria</span>
                            @else
                                <span class="badge bg-success">Dostępna</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('mechanic.charge', $vehicle->id) }}" method="POST" class="d-flex gap-1">
                                @csrf
                                <button name="amount" value="10" class="btn btn-outline-primary btn-sm">+10%</button>
                                <button name="amount" value="50" class="btn btn-outline-primary btn-sm">+50%</button>
                                <button name="amount" value="100" class="btn btn-success btn-sm fw-bold">FULL</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection