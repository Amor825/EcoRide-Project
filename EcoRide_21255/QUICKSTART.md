# 🌱 EcoRide - Quick Start Guide

## 🔐 Dane Logowania

```
👤 ADMIN
  Email: admin@ecoride.com
  Password: Admin123!
  Dostęp: Panel administracyjny (/admin/dashboard)

👷 PRACOWNIK (Employee)
  Email: mechanik@ecoride.com
  Password: Mechanik123!
  Dostęp: Dashboard pracownika (/employee/dashboard)

👥 KLIENT (Client)
  Email: klient@ecoride.com
  Password: Klient123!
  Dostęp: Przeglądanie pojazdów i opinii

👥 DODATKOWI UŻYTKOWNICY
  Email: maria@example.com
  Password: Maria123!
  
  Email: piotr@example.com
  Password: Piotr123!
```

## 🚀 Start

```bash
# 1. Przejdź do folderu projektu
cd EcoRide_21255

# 2. Instalacja zależności (jeśli potrzeba)
composer install
npm install

# 3. Migracja bazy danych + dane testowe
php artisan migrate --seed

# 4. Uruchomienie serwera
php artisan serve

# 5. Otwórz w przeglądarce
http://localhost:8000
```

## 📍 Główne Linki

| Strona | URL | Dostęp |
|--------|-----|--------|
| Start | `/` | Wszyscy |
| Pojazdy | `/vehicles` | Zalogowani |
| Opinie Pojazdu | `/vehicles/{id}/reviews` | Zalogowani |
| Panel Admin | `/admin/dashboard` | Admin |
| Użytkownicy | `/admin/users` | Admin |
| Pojazdy Admin | `/admin/vehicles` | Admin |
| Dashboard Pracownika | `/employee/dashboard` | Employee/Admin |
| Profil | `/profile` | Zalogowani |

## 🎨 Funkcje Główne

### 1️⃣ Strona Start (Home)
- Powitanie użytkownika
- Opis usługi EcoRide
- Przyciski do logowania/rejestracji
- Akcjoby do wynajmu pojazdu

### 2️⃣ Lista Pojazdów
- Tabela ze wszystkimi hulajnogami
- Informacje: model, bateria, lokalizacja, cena
- Przycisk "Opinie" - przejście do opinii pojazdu
- Przycisk "Wypożycz" - wynajęcie pojazdu

### 3️⃣ Opinie Pojazdu
- Średnia ocena (gwiazdki)
- Formularz dodawania opinii
  - Wybór oceny 1-5
  - Opcjonalny komentarz (max 500 znaków)
- Lista wszystkich opinii
  - Autor, data, ocena, komentarz

### 4️⃣ Panel Administracyjny
**Dashboard** (`/admin/dashboard`)
- Statystyki na gorze:
  - Liczba użytkowników
  - Liczba pojazdów
  - Otwarte zgłoszenia serwisowe
  - Całkowite płatności
- Ostatnie zgłoszenia serwisowe
- Ostatnie płatności
- Przyciski do zarządzania

**Użytkownicy** (`/admin/users`)
- Lista wszystkich użytkowników
- Zmiana ról (Admin, Pracownik, Klient)
- Informacje: ID, imię, email, rola

**Pojazdy** (`/admin/vehicles`)
- Lista wszystkich pojazdów
- Informacje: model, lokalizacja, bateria, cena, opinie
- Średnia ocena pojazdu
- Link do pełnej listy opinii

### 5️⃣ Dashboard Pracownika
- 🔧 Zgłoszenia serwisowe
  - Tabela ze statusami (otwarte, w toku, zamknięte)
  - Pojazd, opis problemu, data
- ⭐ Ostatnie opinie użytkowników
  - Pojazd, autor, ocena, komentarz
  - Czas publikacji
- 📊 Statystyki
  - Liczba otwartych zgłoszeń
  - Liczba opinii

## 🔧 Akcje Użytkownika

### Wynajmij Pojazd
1. Zaloguj się
2. Przejdź do "Pojazdy"
3. Kliknij "Wypożycz" przy wybranym pojazdem
4. Wprowadź liczbę minut
5. Potwierdź

### Dodaj Opinię
1. Zaloguj się
2. Przejdź do "Pojazdy"
3. Kliknij "⭐ Opinie" przy pojazdem
4. Wypełnij formularz
5. Kliknij "Dodaj opinię"

### Zmień Rolę Użytkownika (ADMIN)
1. Zaloguj się jako Admin
2. Przejdź do "Panel Admin" → "👥 Zarządzaj Użytkownikami"
3. Kliknij przycisk z nową rolą (Admin/Pracownik/Klient)
4. Rola zostanie zmieniona

## 🎨 Wsparcie Dostępności

Aplikacja posiada wsparcie dla użytkowników z niepełnosprawnościami:
- 📏 Zmiana rozmiaru czcionki (A-, A, A+)
- 👁️ Tryb wysokiego kontrastu (żółty tekst na czarnym tle)

## ⚙️ Resetowanie Bazy Danych

Jeśli chcesz zacząć od nowa:

```bash
# Usunięcie wszystkich tabel i ponowna migracja
php artisan migrate:refresh --seed

# Lub bardziej drastycznie
php artisan migrate:fresh --seed
```

## 🐛 Debugging

Jeśli coś nie działa:

```bash
# Sprawdź logi
tail -f storage/logs/laravel.log

# Sprawdź status migracji
php artisan migrate:status

# Czyść cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Wygeneruj klucz aplikacji
php artisan key:generate
```

## 📚 Dokumentacja Pełna

Szczegółową dokumentację znajdziesz w:
- `NOWE_FUNKCJE.md` - Nowe funkcje
- `IMPLEMENTACJA.md` - Zmiany w kodzie

## 💡 Porady

1. **Dla testowania admin panelu**: Zaloguj się jako `admin@ecoride.com`
2. **Dla testowania dashboard pracownika**: Zaloguj się jako `mechanik@ecoride.com`
3. **Zmiana opinii**: Każdy użytkownik może dodać jedną opinię dla pojazdu
4. **Statystyki**: Są aktualizowane w real-time

## 🆘 Pomoc

Jeśli napotkasz problemy:

1. Sprawdź czy wszystkie migracje przeszły: `php artisan migrate:status`
2. Sprawdź czy seeder się wykonał: czy w bazie istnieją dane?
3. Czyszczenie cache'u: `php artisan cache:clear`
4. Reload strony: `Ctrl+Shift+Del` (hard refresh)

---

**Wersja**: 1.0  
**Data**: 14.01.2026  
**Status**: ✅ Gotowe do użytku
