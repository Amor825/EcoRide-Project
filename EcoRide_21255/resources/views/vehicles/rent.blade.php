@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card-custom text-center">
            <h3 class="text-success mb-3">Potwierdź Wypożyczenie</h3>
            
            <div class="alert alert-info">
                Wybrałeś: <strong>{{ $vehicle->model }}</strong><br>
                Stawka: <strong>{{ $vehicle->price_per_minute }} zł / min</strong>
            </div>

            <form action="{{ route('vehicles.store') }}" method="POST">
                @csrf
                <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">

                <div class="mb-4 text-start">
                    <label class="form-label fw-bold">Czas jazdy:</label>
                    <select name="minutes" class="form-select form-select-lg">
                        <option value="1">⏱️ 1 minuta (Szybki TEST)</option>
                        <option value="5">5 minut (Szybki dojazd)</option>
                        <option value="15">15 minut (Dojazd do pracy)</option>
                        <option value="30">30 minut (Standard)</option>
                        <option value="60">1 godzina (Wycieczka)</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success w-100 btn-lg">Zapłać i Jedź 🛴</button>
                <a href="{{ route('vehicles.index') }}" class="btn btn-link text-muted mt-2">Anuluj</a>
            </form>
        </div>
    </div>
</div>
@endsection