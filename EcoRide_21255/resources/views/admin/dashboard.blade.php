@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-danger fw-bold">🔒 Panel Administratora</h1>
        <ul class="nav nav-pills" id="adminTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active fw-bold" id="dashboard-tab" data-bs-toggle="tab" data-bs-target="#dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="true">📊 Pulpit</button>
            </li>
            <li class="nav-item">
                <button class="nav-link fw-bold" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button" role="tab" aria-controls="users" aria-selected="false">👥 Użytkownicy</button>
            </li>
            <li class="nav-item">
                <button class="nav-link fw-bold" id="vehicles-tab" data-bs-toggle="tab" data-bs-target="#vehicles" type="button" role="tab" aria-controls="vehicles" aria-selected="false">🛴 Flota (Hulajnogi)</button>
            </li>
        </ul>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    <div class="tab-content" id="adminTabsContent">
        
        {{-- === TAB 1: PULPIT === --}}
        <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
            <h2 class="visually-hidden">Statystyki</h2>
            <div class="row mb-4 text-center">
                <div class="col-md-4">
                    <div class="card p-4 bg-primary text-white shadow h-100">
                        <div class="display-5 fw-bold">{{ $stats['users'] }}</div><small>Użytkowników</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-4 bg-success text-white shadow h-100">
                        <div class="display-5 fw-bold">{{ $stats['vehicles'] }}</div><small>Pojazdów</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-4 bg-warning text-dark shadow h-100">
                        <div class="display-5 fw-bold">{{ $stats['rentals'] }}</div><small>Wypożyczeń</small>
                    </div>
                </div>
            </div>
            
            <div class="card shadow-sm">
                <h2 class="h6 card-header bg-white fw-bold">⭐ Ostatnie Opinie Klientów</h2>
                <ul class="list-group list-group-flush">
                    @forelse($reviews as $review)
                    <li class="list-group-item">
                        <span class="badge {{ $review->rating >= 4 ? 'bg-success' : ($review->rating <= 2 ? 'bg-danger' : 'bg-warning text-dark') }} me-2">
                            {{ $review->rating }}/5
                        </span>
                        <strong>{{ $review->vehicle->model }}:</strong> "{{ $review->comment ?? 'Brak' }}"
                        <small class="text-muted ms-2">- {{ $review->user->name }}</small>
                    </li>
                    @empty
                    <li class="list-group-item text-muted">Brak opinii w systemie.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        {{-- === TAB 2: UŻYTKOWNICY === --}}
        <div class="tab-pane fade" id="users" role="tabpanel" aria-labelledby="users-tab">
            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <h2 class="h6 card-header bg-dark text-white fw-bold">Lista Użytkowników</h2>
                        <div class="card-body p-0">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Imię</th>
                                        <th>Email</th>
                                        <th>Zmień Rolę</th>
                                        <th>Usuń</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($allUsers as $u)
                                    <tr>
                                        <td>{{ $u->id }}</td>
                                        <td class="fw-bold">{{ $u->name }}</td>
                                        <td>{{ $u->email }}</td>
                                        
                                        <td>
                                            @if($u->id === auth()->id())
                                                <span class="badge bg-danger">Ty (Admin)</span>
                                            @else
                                                <form action="{{ route('admin.users.update', $u->id) }}" method="POST">
                                                    {{-- RĘCZNE TOKENY BEZ AUTOCOMPLETE --}}
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="_method" value="PUT">
                                                    
                                                    <div class="input-group input-group-sm" style="width: 160px;">
                                                        <label for="role-{{$u->id}}" class="visually-hidden">Rola</label>
                                                        <select name="role" id="role-{{$u->id}}" class="form-select form-select-sm">
                                                            <option value="client" {{ $u->role == 'client' ? 'selected' : '' }}>Klient</option>
                                                            <option value="mechanic" {{ $u->role == 'mechanic' ? 'selected' : '' }}>Mechanik</option>
                                                            <option value="admin" {{ $u->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                                        </select>
                                                        <button class="btn btn-outline-primary" title="Zapisz rolę">💾</button>
                                                    </div>
                                                </form>
                                            @endif
                                        </td>

                                        <td>
                                            @if($u->id !== auth()->id())
                                            <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Na pewno usunąć użytkownika {{ $u->name }}?')">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button class="btn btn-sm btn-outline-danger border-0">🗑️</button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm bg-light">
                        <h2 class="h6 card-header fw-bold text-success">➕ Dodaj Użytkownika</h2>
                        <div class="card-body">
                            <form action="{{ route('admin.users.store') }}" method="POST">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                
                                <div class="mb-2">
                                    <label for="new-name">Imię</label>
                                    <input type="text" id="new-name" name="name" class="form-control" required>
                                </div>
                                <div class="mb-2">
                                    <label for="new-email">Email</label>
                                    <input type="email" id="new-email" name="email" class="form-control" required>
                                </div>
                                <div class="mb-2">
                                    <label for="new-pass">Hasło</label>
                                    <input type="password" id="new-pass" name="password" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="new-role">Rola</label>
                                    <select name="role" id="new-role" class="form-select">
                                        <option value="client">Klient</option>
                                        <option value="mechanic">Mechanik</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                                <button class="btn btn-success w-100">Utwórz konto</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- === TAB 3: FLOTA === --}}
        <div class="tab-pane fade" id="vehicles" role="tabpanel" aria-labelledby="vehicles-tab">
            
            <form id="bulkForm" action="{{ route('admin.vehicles.bulk') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="PUT">
            </form>

            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow-sm border-primary">
                        <div class="card-header bg-dark text-white fw-bold d-flex justify-content-between align-items-center">
                            <h2 class="h6 m-0 text-white">🛴 Zarządzanie Flotą</h2>
                            <button type="submit" form="bulkForm" class="btn btn-warning btn-sm fw-bold">
                                💾 ZAPISZ WSZYSTKIE ZMIANY
                            </button>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Model</th>
                                        <th>Cena (zł/min)</th>
                                        <th>Bateria (%)</th>
                                        <th>Usuń</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($allVehicles as $v)
                                    <tr>
                                        <td>#{{ $v->id }}</td>
                                        <td>
                                            <label for="model-{{$v->id}}" class="visually-hidden">Model</label>
                                            <input type="text" id="model-{{$v->id}}" form="bulkForm" name="vehicles[{{ $v->id }}][model]" 
                                                   value="{{ $v->model }}" class="form-control form-control-sm fw-bold">
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <label for="price-{{$v->id}}" class="visually-hidden">Cena</label>
                                                <input type="number" id="price-{{$v->id}}" step="0.01" form="bulkForm" name="vehicles[{{ $v->id }}][price_per_minute]" 
                                                       value="{{ $v->price_per_minute }}" class="form-control text-center">
                                                <span class="input-group-text">zł</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <label for="battery-{{$v->id}}" class="visually-hidden">Bateria</label>
                                                <input type="number" id="battery-{{$v->id}}" form="bulkForm" name="vehicles[{{ $v->id }}][battery_level]" 
                                                       value="{{ $v->battery_level }}" class="form-control text-center {{ $v->battery_level < 20 ? 'text-danger fw-bold' : '' }}">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.vehicles.destroy', $v->id) }}" method="POST" onsubmit="return confirm('Usunąć ten pojazd trwale?')">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button class="btn btn-sm btn-outline-danger border-0">🗑️</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm bg-light">
                        <h2 class="h6 card-header fw-bold text-success">➕ Dodaj Nową Hulajnogę</h2>
                        <div class="card-body">
                            <form action="{{ route('admin.vehicles.store') }}" method="POST">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="mb-2">
                                    <label for="v-model">Model</label>
                                    <input type="text" id="v-model" name="model" class="form-control" placeholder="np. Xiaomi Pro" required>
                                </div>
                                <div class="mb-2">
                                    <label for="v-station">Stacja</label>
                                    <select name="station_id" id="v-station" class="form-select">
                                        @foreach($stations as $s) <option value="{{$s->id}}">{{$s->name}}</option> @endforeach
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label for="v-price">Cena (zł/min)</label>
                                    <input type="number" id="v-price" step="0.01" name="price_per_minute" class="form-control" value="0.50" required>
                                </div>
                                <div class="mb-3">
                                    <label for="v-battery">Bateria (%)</label>
                                    <input type="number" id="v-battery" name="battery_level" class="form-control" value="100" required>
                                </div>
                                <button class="btn btn-success w-100">Dodaj do floty</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection