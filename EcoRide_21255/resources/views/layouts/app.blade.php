<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EcoRide - System Wypożyczeń</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* === 1. BAZOWY UKŁAD === */
        html, body { height: 100%; }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Segoe UI', sans-serif;
            transition: background 0.3s, color 0.3s;
        }

        main {
            flex: 1; 
            padding-bottom: 40px;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .card-custom {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            padding: 25px;
        }

        footer {
            background-color: #f8f9fa;
            padding: 20px 0;
            text-align: center;
            border-top: 1px solid #dee2e6;
            margin-top: auto;
        }

        /* === 2. ROZMIAR CZCIONKI (WCAG) === */
        html.fs-small { font-size: 12px !important; }
        html.fs-medium { font-size: 16px !important; } 
        html.fs-large { font-size: 24px !important; } 

        /* === 3. WYSOKI KONTRAST (WCAG) === */
        body.high-contrast {
            background: #000000 !important;
            color: #FFFF00 !important;
        }
        
        body.high-contrast * {
            background-color: #000000 !important;
            color: #FFFF00 !important;
            border-color: #FFFF00 !important;
            background-image: none !important;
            box-shadow: none !important;
            text-shadow: none !important;
        }

        body.high-contrast a { 
            color: #00FFFF !important; 
            text-decoration: underline !important; 
            font-weight: bold;
        }
        
        body.high-contrast .btn { 
            border: 2px solid #FFFF00 !important;
            color: #FFFF00 !important;
            font-weight: bold;
        }
        
        body.high-contrast .navbar {
            border-bottom: 2px solid #FFFF00 !important;
        }
    </style>

    <script>
        function applyAccessibility() {
            // 1. Czcionka
            const size = localStorage.getItem('ecoride_fontsize') || 'medium';
            document.documentElement.className = ''; 
            document.documentElement.classList.add('fs-' + size);

            // 2. Kontrast
            const contrast = localStorage.getItem('ecoride_contrast');
            if (contrast === 'true') {
                document.body.classList.add('high-contrast');
            } else {
                document.body.classList.remove('high-contrast');
            }
        }

        function setFontSize(size) {
            localStorage.setItem('ecoride_fontsize', size);
            applyAccessibility();
        }

        function toggleContrast() {
            const current = document.body.classList.contains('high-contrast');
            localStorage.setItem('ecoride_contrast', !current);
            applyAccessibility();
        }

        window.addEventListener('DOMContentLoaded', applyAccessibility);
    </script>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold text-success" href="{{ route('home') }}">🌱 ECORIDE</a>
            
            <div class="d-flex align-items-center gap-2">
                <a class="nav-link text-dark me-2" href="{{ route('home') }}">Start</a>
                <a class="nav-link text-dark me-3" href="{{ route('vehicles.index') }}">Pojazdy</a>
                
                <div class="btn-group btn-group-sm me-2">
                    <button type="button" onclick="setFontSize('small')" class="btn btn-outline-secondary fw-bold" title="Mała">A-</button>
                    <button type="button" onclick="setFontSize('medium')" class="btn btn-outline-secondary fw-bold" title="Średnia">A</button>
                    <button type="button" onclick="setFontSize('large')" class="btn btn-outline-secondary fw-bold" title="Duża">A+</button>
                </div>

                <button type="button" onclick="toggleContrast()" class="btn btn-outline-dark btn-sm fw-bold">
                    👁️ Kontrast
                </button>

                @auth
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-danger btn-sm ms-2">Panel Admina</a>
                    @endif

                    @if(Auth::user()->role === 'mechanic')
                        <a href="{{ route('mechanic.dashboard') }}" class="btn btn-warning btn-sm ms-2">Panel Mechanika</a>
                    @endif

                    <span class="text-muted d-none d-md-block ms-2">| {{ Auth::user()->name }}</span>
                    
                    {{-- POPRAWIONY FORMULARZ WYLOGOWANIA --}}
                    <form method="POST" action="{{ route('logout') }}" class="m-0 ms-2">
                        {{-- ZAMIAST @csrf UŻYWAMY RĘCZNEGO INPUTA BEZ AUTOCOMPLETE --}}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        
                        <button type="submit" class="btn btn-link text-danger text-decoration-none fw-bold">Wyloguj</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary btn-sm rounded-pill px-4 ms-2">Zaloguj</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="container">
        @yield('content')
    </main>

    <footer class="text-muted">
        &copy; 2026 EcoRide Laravel Project
    </footer>

    <script>applyAccessibility();</script>
</body>
</html>