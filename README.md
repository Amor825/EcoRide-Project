# 🛴 EcoRide - System Wypożyczania Hulajnóg Elektrycznych

Responsywna aplikacja internetowa oparta na frameworku **Laravel**, służąca do zarządzania flotą hulajnóg elektrycznych, ich wypożyczaniem oraz serwisowaniem.

## 📋 Opis Projektu
Projekt realizuje system obsługi miejskich hulajnóg z podziałem na role użytkowników. Aplikacja symuluje rzeczywiste zużycie baterii w czasie, pozwala zgłaszać usterki oraz zarządzać flotą pojazdów z poziomu panelu administratora.

### ✅ Spełnione Wymagania Projektowe
1.  **Struktura Bazy Danych:** System oparty na **9 tabelach** (Users, Vehicles, Stations, Rentals, Reviews + tabele systemowe Laravela).
2.  **Migracje i Seedery:** Pełna automatyzacja struktury bazy danych. Komenda `migrate:fresh --seed` tworzy kompletne środowisko testowe z użytkownikami, stacjami i historią.
3.  **Podział Uprawnień (Role):**
    * **Klient:** Wypożyczanie, podgląd baterii, zgłaszanie usterek/opinii.
    * **Mechanik:** Panel awarii, naprawa pojazdów, ładowanie baterii (pojedynczo).
    * **Administrator:** Pełne zarządzanie użytkownikami (CRUD, zmiana ról), zarządzanie flotą (CRUD + Masowa Edycja), statystyki.
4.  **Dostępność (Accessibility):** Dostosowanie interfejsu (m.in. atrybuty `aria-label`, kontrast Bootstrap 5).
5.  **Kontrola Wersji:** Projekt zarządzany w systemie **Git**.
6.  **Testy Jednostkowe:** Zaimplementowano **30 automatycznych testów** (`php artisan test`) sprawdzających logikę biznesową, bezpieczeństwo i działanie tras.

---

## 🚀 Kluczowe Funkcjonalności

### 🔋 Symulacja Baterii (Real-Time)
System nie odejmuje baterii "na sztywno". Stan naładowania spada dynamicznie w zależności od czasu, jaki upłynął od ostatniej aktywności hulajnogi.

### 🛠️ Panel Mechanika
Mechanik widzi **tylko** zgłoszenia awarii (oceny 1-2 gwiazdki). Pozytywne opinie trafiają do Administratora. Mechanik może jednym kliknięciem naprawić i naładować pojazd.

### 🔐 Panel Administratora
* **Zarządzanie Użytkownikami:** Dodawanie, usuwanie, zmiana ról (z blokadą zmiany własnej roli).
* **Masowa Edycja Floty:** Możliwość szybkiej zmiany cen lub stanu baterii dla wielu pojazdów jednocześnie (Bulk Update).
* **Statystyki:** Podgląd liczby wypożyczeń, użytkowników i floty.

---

## ⚙️ Technologie
* **Backend:** PHP, Laravel Framework
* **Baza danych:** SQLite
* **Frontend:** Blade Templates, Bootstrap 5 (Responsywność)
* **Testy:** PHPUnit

---

## 📥 Instalacja i Uruchomienie

1.  **Sklonuj repozytorium:**
    ```bash
    git clone [https://github.com/Amor825/EcoRide-Project.git](https://github.com/Amor825/EcoRide-Project.git)
    cd EcoRide-Project
    ```

2.  **Zainstaluj zależności:**
    ```bash
    composer install
    npm install
    ```

3.  **Skonfiguruj środowisko:**
    Skopiuj plik `.env.example` jako `.env` i wygeneruj klucz:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Uruchom migracje i seedery (WAŻNE!):**
    Ta komenda utworzy bazę i wypełni ją przykładowymi danymi:
    ```bash
    php artisan migrate:fresh --seed
    ```

5.  **Uruchom serwer:**
    ```bash
    php artisan serve
    ```

---

## 🔑 Dane Logowania (Demo)

System po uruchomieniu seedera posiada gotowe konta testowe:

| Rola | Email | Hasło | Opis Uprawnień |
| :--- | :--- | :--- | :--- |
| **Administrator** | `admin@ecoride.com` | `Admin123!` | Pełny dostęp do panelu Admina, edycja floty i userów. |
| **Mechanik** | `mechanik@ecoride.com` | `Mechanik123!` | Dostęp do panelu Mechanika, naprawy, ładowanie. |
| **Klient** | `klient@ecoride.com` | `Klient123!` | Wypożyczanie hulajnóg, dodawanie opinii. |

---

## 🧪 Testowanie Aplikacji

Aby sprawdzić poprawność działania wszystkich funkcji (logowanie, rejestracja, dostęp do paneli, tworzenie pojazdów), uruchom:

```bash
php artisan test
