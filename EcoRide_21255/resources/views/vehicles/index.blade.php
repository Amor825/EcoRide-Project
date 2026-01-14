@extends('layouts.app')

@section('content')
<div class="card-custom">
    <h2 class="mb-4">Dostępne Hulajnogi</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Model</th>
                <th>Bateria</th>
                <th>Stacja</th>
                <th>Status / Czas</th>
                <th>Akcja</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vehicles as $vehicle)
            <tr>
                <td class="fw-bold">{{ $vehicle->model }}</td>
                <td>
                    <div class="progress" style="height: 20px; width: 100px;">
                        <div class="progress-bar {{ $vehicle->battery_level < 20 ? 'bg-danger' : 'bg-success' }}" 
                             style="width: {{ round($vehicle->battery_level) }}%">
                             {{ round($vehicle->battery_level) }}%
                        </div>
                    </div>
                </td>
                <td>{{ $vehicle->station->name }}</td>
                
                <td>
                    @if($vehicle->is_available)
                        <span class="badge bg-success">Dostępna</span>
                        <div class="small text-muted">{{ $vehicle->price_per_minute }} zł/min</div>
                    @else
                        @if($vehicle->activeRental)
                            @php 
                                $minutesLeft = \Carbon\Carbon::now()->diffInMinutes($vehicle->activeRental->end_time, false); 
                            @endphp
                            
                            @if($minutesLeft > 0)
                                <span class="badge bg-info text-dark">⏳ Wolna za: {{ ceil($minutesLeft) }} min</span>
                            @else
                                <span class="badge bg-warning text-dark">Zaraz będzie wolna...</span>
                            @endif
                        @else
                            <span class="badge bg-danger">🔴 AWARIA / SERWIS</span>
                        @endif
                    @endif
                </td>

                <td>
                    @if($vehicle->is_available)
                        <a href="{{ route('vehicles.rent', $vehicle->id) }}" class="btn btn-primary btn-sm fw-bold">Wypożycz</a>
                    @else
                        <button class="btn btn-secondary btn-sm" disabled>Zajęty</button>
                    @endif
                    
                    <button class="btn btn-outline-warning btn-sm ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#review{{$vehicle->id}}">
                        ⚠️ Zgłoś / Oceń
                    </button>
                </td>
            </tr>
            <tr class="collapse" id="review{{$vehicle->id}}">
                <td colspan="5" class="bg-light p-3 border-start border-warning border-4">
                    <h6 class="text-warning fw-bold">Masz problem z tą hulajnogą? Zgłoś to mechanikowi!</h6>
                    
                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                        
                        <div class="input-group">
                            <select name="rating" class="form-select" style="max-width: 220px;">
                                <option value="5">⭐⭐⭐⭐⭐ (Super)</option>
                                <option value="4">⭐⭐⭐⭐ (Dobra)</option>
                                <option value="3">⭐⭐⭐ (Średnia)</option>
                                <option value="2">⭐⭐ (Słaba)</option>
                                <option value="1">⚠️ (AWARIA / ZEPSUTA)</option>
                            </select>
                            <input type="text" name="comment" class="form-control" placeholder="Opisz usterkę (np. urwane koło, nie jedzie)...">
                            <button type="submit" class="btn btn-warning fw-bold">Wyślij zgłoszenie</button>
                        </div>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection