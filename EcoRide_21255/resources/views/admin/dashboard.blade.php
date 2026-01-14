@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-danger fw-bold">🔒 Panel Administratora</h1>
        <ul class="nav nav-pills" id="adminTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active fw-bold" id="dashboard-tab" data-bs-toggle="tab" data-bs-target="#dashboard" type="button">📊 Pulpit</button>
            </li>
            <li class="nav-item">
                <button class="nav-link fw-bold" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button">👥 Użytkownicy</button>
            </li>
            <li class="nav-item">
                <button class="nav-link fw-bold" id="vehicles-tab" data-bs-toggle="tab" data-bs-target="#vehicles" type="button">🛴 Flota (Hulajnogi)</button>
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
        
        <div class="tab-pane fade show active" id="dashboard" role="tabpanel">
            <div class="row mb-4 text-center">
                <div class="col-md-4">
                    <div class="card p-4 bg-primary text-white shadow h-100">
                        <h3 class="display-5 fw-bold">{{ $stats['users'] }}</h3><small>Użytkowników</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-4 bg-success text-white shadow h-100">
                        <h3 class="display-5 fw-bold">{{ $stats['vehicles'] }}</h3><small>Pojazdów</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-4 bg-warning text-dark shadow h-100">
                        <h3 class="display-5 fw-bold">{{ $stats['rentals'] }}</h3><small>Wypożyczeń</small>
                    </div>
                </div>
            </div>
            
            <div class="card shadow-sm">
                <div class="card-header bg-white fw-bold">⭐ Ostatnie Opinie Klientów</div>
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

        <div class="tab-pane fade" id="users" role="tabpanel">
            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-dark text-white fw-bold">Lista Użytkowników</div>
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
                                                    @csrf @method('PUT')
                                                    <div class="input-group input-group-sm" style="width: 160px;">
                                                        <select name="role" class="form-select form-select-sm">
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
                                                @csrf @method('DELETE')
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
                        <div class="card-header fw-bold text-success">➕ Dodaj Użytkownika</div>
                        <div class="card-body">
                            <form action="{{ route('admin.users.store') }}" method="POST">
                                @csrf
                                <div class="mb-2"><label>Imię</label><input type="text" name="name" class="form-control" required></div>
                                <div class="mb-2"><label>Email</label><input type="email" name="email" class="form-control" required></div>
                                <div class="mb-2"><label>Hasło</label><input type="password" name="password" class="form-control" required></div>
                                <div class="mb-3"><label>Rola</label>
                                    <select name="role" class="form-select">
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

        <div class="tab-pane fade" id="vehicles" role="tabpanel">
            
            <form id="bulkForm" action="{{ route('admin.vehicles.bulk') }}" method="POST">
                @csrf @method('PUT')
            </form>

            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow-sm border-primary">
                        <div class="card-header bg-dark text-white fw-bold d-flex justify-content-between align-items-center">
                            <span>🛴 Zarządzanie Flotą</span>
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
                                            <input type="text" form="bulkForm" name="vehicles[{{ $v->id }}][model]" 
                                                   value="{{ $v->model }}" class="form-control form-control-sm fw-bold">
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <input type="number" step="0.01" form="bulkForm" name="vehicles[{{ $v->id }}][price_per_minute]" 
                                                       value="{{ $v->price_per_minute }}" class="form-control text-center">
                                                <span class="input-group-text">zł</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <input type="number" form="bulkForm" name="vehicles[{{ $v->id }}][battery_level]" 
                                                       value="{{ $v->battery_level }}" class="form-control text-center {{ $v->battery_level < 20 ? 'text-danger fw-bold' : '' }}">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.vehicles.destroy', $v->id) }}" method="POST" onsubmit="return confirm('Usunąć ten pojazd trwale?')">
                                                @csrf @method('DELETE')
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
                        <div class="card-header fw-bold text-success">➕ Dodaj Nową Hulajnogę</div>
                        <div class="card-body">
                            <form action="{{ route('admin.vehicles.store') }}" method="POST">
                                @csrf
                                <div class="mb-2"><label>Model</label><input type="text" name="model" class="form-control" placeholder="np. Xiaomi Pro" required></div>
                                <div class="mb-2"><label>Stacja</label>
                                    <select name="station_id" class="form-select">
                                        @foreach($stations as $s) <option value="{{$s->id}}">{{$s->name}}</option> @endforeach
                                    </select>
                                </div>
                                <div class="mb-2"><label>Cena (zł/min)</label><input type="number" step="0.01" name="price_per_minute" class="form-control" value="0.50" required></div>
                                <div class="mb-3"><label>Bateria (%)</label><input type="number" name="battery_level" class="form-control" value="100" required></div>
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