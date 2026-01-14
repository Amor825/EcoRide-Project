@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <h2 class="mb-4">👥 Zarządzanie Użytkownikami</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card-custom">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Imię</th>
                    <th>Email</th>
                    <th>Rola</th>
                    <th>Akcje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>#{{ $user->id }}</td>
                    <td class="fw-bold">{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role === 'admin')
                            <span class="badge bg-danger">Admin</span>
                        @elseif($user->role === 'employee')
                            <span class="badge bg-warning">Pracownik</span>
                        @else
                            <span class="badge bg-info">Klient</span>
                        @endif
                    </td>
                    <td>
                        @if($user->id !== auth()->id())
                        <div class="btn-group" role="group">
                            @if($user->role !== 'admin')
                            <form action="{{ route('admin.update-role', ['user' => $user->id, 'role' => 'admin']) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Ustaw jako Admin">Admin</button>
                            </form>
                            @endif

                            @if($user->role !== 'employee')
                            <form action="{{ route('admin.update-role', ['user' => $user->id, 'role' => 'employee']) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-outline-warning" title="Ustaw jako Pracownik">Pracownik</button>
                            </form>
                            @endif

                            @if($user->role !== 'client')
                            <form action="{{ route('admin.update-role', ['user' => $user->id, 'role' => 'client']) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-outline-info" title="Ustaw jako Klient">Klient</button>
                            </form>
                            @endif
                        </div>
                        @else
                            <span class="text-muted">-</span>
                        @endif
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
