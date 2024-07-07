# Opis Działania Aplikacji do Wystawiania Opinii

## Pomysł i Cel
Celem aplikacji jest zbieranie opinii od klientów w sposób, który pozwala na konstruktywny feedback, jednocześnie zwiększając liczbę pozytywnych opinii widocznych w sieci. Aplikacja umożliwia:

- Zbieranie negatywnych i neutralnych opinii bez publikacji, co pozwala firmie na reakcję i poprawę jakości usług.
- Zachęcanie zadowolonych klientów do publikowania pozytywnych opinii na Google.

## Funkcjonalności
1. Krótki Link do Wystawienia Opinii:
    - Generowanie przyjaznych linków, które można wysłać do klientów.

2. Gotowa Wiadomość z Prośbą o Wystawienie Opinii:
    - Szablonowa wiadomość e-mail/SMS, którą można masowo wysyłać do klientów, zawierająca link do wystawienia opinii.

3. Strona Zbierająca Opinie:
    - Strona, na której klienci mogą wybrać ocenę w skali od 1 do 5 gwiazdek.
    - Dla ocen od 1 do 4 gwiazdek, klienci są przekierowywani do formularza feedbacku, który jest widoczny tylko dla firmy.
    - Dla ocen 5-gwiazdkowych, klienci są przekierowywani do strony Google, gdzie mogą opublikować swoją opinię.

## Scenariusze Działania
1. Klient Otrzymuje Wiadomość:
    - Klient otrzymuje wiadomość e-mail/SMS z prośbą o wystawienie opinii wraz z linkiem.
2. Klient Wystawia Opinię:
    - Klient klika w link i zostaje przekierowany na stronę z wyborem oceny.
    - Klient wybiera ocenę:
      - 1-4 gwiazdki: Klient jest przekierowywany do formularza feedbacku, gdzie może pozostawić szczegółowe uwagi. Te opinie są przesyłane wyłącznie do firmy i nie są publicznie widoczne.
      - 5 gwiazdek: Klient jest przekierowywany do okienka Google, gdzie może opublikować swoją opinię.
3. Firma Otrzymuje Feedback:
    - Negatywne i neutralne opinie są przesyłane do bazy danych firmy, gdzie mogą być analizowane i wykorzystywane do poprawy usług.
4. Publikacja Pozytywnych Opinii:
    - Pozytywne opinie (5-gwiazdkowe) są publikowane w Google, co zwiększa widoczność firmy w sieci.

### Konfiguracja Bazy Danych

1. Utwórz bazę danych MySQL.
2. Utwórz tabelę users z następującymi kolumnami:
``` sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    is_active BOOLEAN DEFAULT FALSE
);
```

3. Utwórz tabelę feedback do przechowywania opinii:
```sql

CREATE TABLE feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    rating INT NOT NULL,
    comment TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

4. Konfiguracja Pliku db_config.php:
Skonfiguruj połączenie z bazą danych w pliku includes/db_config.php:
```php
<?php
$servername = "localhost";
$username = "your_db_username";
$password = "your_db_password";
$dbname = "your_db_name";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
```

### Użytkowanie Systemu
1. Rejestracja Użytkownika:
 - Użytkownicy mogą rejestrować się za pomocą formularza rejestracji dostępnego na stronie register.html.
 - Po rejestracji, konto użytkownika musi być aktywowane przez administratora.

2. Aktywacja Użytkowników przez Administratora:
 - Administratorzy mogą aktywować nowych użytkowników w bazie danych, ustawiając wartość is_active na TRUE dla odpowiednich kont.

3. Wyświetlanie Zebranych Opinii:   
 - Administratorzy mogą wyświetlać zebrane opinie na stronie 'login.html'.
 - Opinie są wyświetlane w formie kart z oceną, komentarzem i informacjami o użytkowniku.

4. Wystawianie Opinii:
 - Użytkownicy mogą wystawiać opinie na stronie 'index.html', wybierając ocenę od 1 do 5 gwiazdek.
 - Dla ocen od 1 do 4 gwiazdek, użytkownicy mogą pozostawić komentarz w formularzu feedbacku.
 - Dla ocen 5-gwiazdkowych, użytkownicy są przekierowywani do strony Google, gdzie mogą opublikować swoją opinię.

### Uzupełnienie linku do przekierowania na opinie google po wybraniu 5 gwiazdek
1. Go to website 'https://developers.google.com/maps/documentation/javascript/examples/places-placeid-finder'
2. Enter your company name
3. Copy your PlaceID
4. Combine your google link 'https://search.google.com/local/writereview?placeid=PLACE_ID' replace PLACE_ID with your company's place ID
5. Go to 'js/rating.js', 'js/contact-form.js' and edit:
 - "window.location.href = 'your_company_link_placeID';" paste here your company link with placeID
