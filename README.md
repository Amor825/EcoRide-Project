# System Wypożyczania Hulajnóg Elektrycznych - EcoRide (Laravel Edition)

Kompleksowa aplikacja internetowa typu E-Commerce/Rental stworzona w oparciu o framework **Laravel 10**, służąca do zarządzania flotą miejskich pojazdów elektrycznych. System oferuje dedykowane panele dla Administratorów, Mechaników oraz Klientów, zapewniając pełną obsługę procesu wypożyczania, płatności oraz serwisu technicznego.

Projekt kładzie szczególny nacisk na **dostępność cyfrową (WCAG 2.1)**, poprawność semantyczną HTML5 oraz niezawodność potwierdzoną testami.

---

## 🚀 Kluczowe Funkcjonalności

### 1. Dostępność i UX (Premium Accessibility)
Projekt wyznacza nowe standardy w dostępności aplikacji webowych:
* **Tryb Wysokiego Kontrastu:** Dedykowany styl czarno-żółty/cyjan dla maksymalnej czytelności (zgodny z WCAG), przełączany jednym kliknięciem.
* **Skalowanie Tekstu:** Widget pozwalający na dynamiczną zmianę wielkości czcionki (A-, A, A+).
* **Responsywność:** Pełna obsługa urządzeń mobilnych (RWD) dzięki **Tailwind CSS / Bootstrap 5**.
* **Semantyka:** Poprawne użycie znaczników HTML5 i atrybutów ARIA.

### 2. Panel Klienta
Interfejs dla użytkowników końcowych z walidacją biznesową:
* **Wypożyczanie Pojazdów:** Proces wyboru czasu jazdy i kalkulacji kosztów (symulacja płatności).
* **Inteligentna Dostępność:** System blokuje możliwość wypożyczenia pojazdów rozładowanych (< 10%) lub będących w serwisie.
* **Historia:** Wgląd w historię tras i poniesionych opłat.

### 3. Panel Lekarza (Mechanika) i Magazyn
Narzędzia wspierające utrzymanie floty:
* **Zgłoszenia Serwisowe (Maintenance):** Raportowanie usterek (np. "Urwane koło", "Błąd sterownika") i oznaczanie ich jako naprawione.
* **Stan Baterii:** Monitorowanie poziomu naładowania pojazdów w czasie rzeczywistym.

### 4. Panel Administratora
Pełna kontrola nad systemem:
* **Zarządzanie Użytkownikami:** Możliwość blokowania i usuwania kont.
* **Flota:** Dodawanie nowych stacji dokujących i pojazdów do systemu.

---

## 🛠 Technologie

Projekt został zrealizowany przy użyciu nowoczesnego stosu technologicznego PHP:
* **Backend:** PHP 8.2+, Laravel 10/11
* **Baza Danych:** SQLite (Lekka baza w pliku - idealna do przenoszenia projektu)
* **Frontend:** Blade Templates, Tailwind CSS / Bootstrap
* **Testy:** PHPUnit (Feature Tests)

---

## ⚙️ Instalacja i Konfiguracja

Aby uruchomić projekt w środowisku lokalnym, wykonaj następujące kroki:

1.  **Sklonuj repozytorium:**
    ```bash
    git clone [https://github.com/Amor825/EcoRide-Project.git](https://github.com/Amor825/EcoRide-Project.git)
    cd EcoRide-Laravel
    ```

2.  **Zainstaluj zależności PHP:**
    ```bash
    composer install
    ```

3.  **Skonfiguruj środowisko:**
    Skopiuj plik `.env.example` na `.env` i skonfiguruj bazę (domyślnie SQLite jest już ustawione).
    ```bash
    cp .env.example .env
    ```

4.  **Wygeneruj klucz aplikacji:**
    ```bash
    php artisan key:generate
    ```

5.  **Przygotuj bazę danych (SQLite):**
    Utwórz pusty plik bazy (jeśli nie istnieje):
    * Windows: `New-Item database/database.sqlite`
    * Mac/Linux: `touch database/database.sqlite`

6.  **Uruchom migracje i seedery:**
    To polecenie utworzy tabele i wypełni je danymi testowymi (20 hulajnóg, stacje, konta).
    ```bash
    php artisan migrate:fresh --seed
    ```

7.  **Uruchom serwer:**
    ```bash
    php artisan serve
    ```

Aplikacja będzie dostępna pod adresem: `http://127.0.0.1:8000`

---

## 🧪 Konta Testowe (Seed Data)

Po wykonaniu seedowania bazy danych, dostępne są następujące konta:
**Hasło dla wszystkich kont:** `password` (lub `Haslo123!` zależnie od seedera)

| Rola | Email | Uprawnienia |
| :--- | :--- | :--- |
| **Administrator** | `admin@ecoride.com` | Pełny dostęp, zarządzanie użytkownikami i flotą. |
| **Mechanik** | `mechanik@ecoride.com` | Obsługa zgłoszeń serwisowych, podgląd stanu technicznego. |
| **Klient** | `klient@ecoride.com` | Wypożyczanie pojazdów, historia transakcji. |

---

## 📊 Schemat Bazy Danych

System opiera się na relacyjnej bazie danych zawierającej kluczowe tabele:
1.  `users` (Role: Admin, Mechanic, Client)
2.  `stations` (Lokalizacje dokowania)
3.  `vehicles` (Hulajnogi z parametrami baterii i ceny)
4.  `rentals` (Historia wypożyczeń)
5.  `payments` (Transakcje finansowe)
6.  `maintenance_tickets` (Zgłoszenia awarii)

---

### Autor
**Michał Lepak **
Nr indeksu: **21255**
Projekt zaliczeniowy: Aplikacje Internetowe I
