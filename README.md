Opis Działania Aplikacji do Wystawiania Opinii
Pomysł i Cel
Celem aplikacji jest zbieranie opinii od klientów w sposób, który pozwala na konstruktywny feedback, jednocześnie zwiększając liczbę pozytywnych opinii widocznych w sieci. Aplikacja umożliwia:

Zbieranie negatywnych i neutralnych opinii bez publikacji, co pozwala firmie na reakcję i poprawę jakości usług.
Zachęcanie zadowolonych klientów do publikowania pozytywnych opinii na Google.
Funkcjonalności
Krótki Link do Wystawienia Opinii:
Generowanie przyjaznych linków, które można wysłać do klientów.
Gotowa Wiadomość z Prośbą o Wystawienie Opinii:
Szablonowa wiadomość e-mail/SMS, którą można masowo wysyłać do klientów, zawierająca link do wystawienia opinii.
Strona Zbierająca Opinie:
Strona, na której klienci mogą wybrać ocenę w skali od 1 do 5 gwiazdek.
Dla ocen od 1 do 4 gwiazdek, klienci są przekierowywani do formularza feedbacku, który jest widoczny tylko dla firmy.
Dla ocen 5-gwiazdkowych, klienci są przekierowywani do strony Google, gdzie mogą opublikować swoją opinię.
Scenariusze Działania
Klient Otrzymuje Wiadomość:

Klient otrzymuje wiadomość e-mail/SMS z prośbą o wystawienie opinii wraz z linkiem.
Klient Wystawia Opinię:

Klient klika w link i zostaje przekierowany na stronę z wyborem oceny.
Klient wybiera ocenę:
1-4 gwiazdki: Klient jest przekierowywany do formularza feedbacku, gdzie może pozostawić szczegółowe uwagi. Te opinie są przesyłane wyłącznie do firmy i nie są publicznie widoczne.
5 gwiazdek: Klient jest przekierowywany do okienka Google, gdzie może opublikować swoją opinię.
Firma Otrzymuje Feedback:

Negatywne i neutralne opinie są przesyłane do bazy danych firmy, gdzie mogą być analizowane i wykorzystywane do poprawy usług.
Publikacja Pozytywnych Opinii:

Pozytywne opinie (5-gwiazdkowe) są publikowane w Google, co zwiększa widoczność firmy w sieci.
Struktura Katalogów
plaintext
Skopiuj kod
public_html/
├── assets/
│   ├── bgimg.png
│   ├── fetch.png
│   ├── fetch.webp
│   ├── bgimg.webp
│   ├── logo.png
├── css/
│   ├── fetch.css
│   ├── rating.css
│   ├── after-opinion.css
│   ├── contact-form.css
│   ├── registration.css
│   ├── login.css
├── includes/
│   ├── db_config.php
│   ├── fetch_feedback.php
│   ├── submit_form.php
├── js/
│   ├── fetch.js
│   ├── rating.js
│   ├── contact-form.js
├── register.php
├── login.php
├── submit_opinion.php
├── delete_opinion.php
├── f1ec19ad59bf6cb605c3101fee3d56be39a41706edce120dc85b186eb1f57be2.php
├── thank-you-for-leaving-your-opinion.html
├── contact-form.html
├── index.html
├── the-opinion-has-already-been-issued.html
├── register.html
└── login.html
Przygotowanie Środowiska
Instalacja Serwera Web i PHP:

Upewnij się, że masz zainstalowany serwer web (np. Apache) oraz PHP.
Konfiguracja Bazy Danych:

Utwórz bazę danych MySQL.
Utwórz tabelę users z następującymi kolumnami:
sql
Skopiuj kod
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    is_active BOOLEAN DEFAULT FALSE
);
Utwórz tabelę feedback do przechowywania opinii:
sql
Skopiuj kod
CREATE TABLE feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    rating INT NOT NULL,
    comment TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
Konfiguracja Pliku db_config.php:
Skonfiguruj połączenie z bazą danych w pliku includes/db_config.php:

php
Skopiuj kod
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
Stylizacja Formularzy:

Dodaj pliki registration.css i login.css do katalogu css/.
Upewnij się, że pliki register.html i login.html odwołują się do odpowiednich plików CSS.
Zabezpieczenie Strony f1ec19ad59bf6cb605c3101fee3d56be39a41706edce120dc85b186eb1f57be2.php:
Na początku tego pliku dodaj kod sprawdzający, czy użytkownik jest zalogowany.

php
Skopiuj kod
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
?>
Przekierowanie Po Zalogowaniu:
Zaktualizuj plik login.php, aby przekierowywał do f1ec19ad59bf6cb605c3101fee3d56be39a41706edce120dc85b186eb1f57be2.php po pomyślnym zalogowaniu.

php
Skopiuj kod
<?php
include 'includes/db_config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT id, password, role, is_active FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password, $role, $is_active);
    $stmt->fetch();
    
    if ($stmt->num_rows == 1 && password_verify($password, $hashed_password)) {
        if ($is_active) {
            $_SESSION['user_id'] = $id;
            $_SESSION['role'] = $role;
            header("Location: f1ec19ad59bf6cb605c3101fee3d56be39a41706edce120dc85b186eb1f57be2.php");
            exit();
        } else {
            echo "Your account is not active. Please wait for admin activation.";
        }
    } else {
        echo "Invalid username or password.";
    }
    
    $stmt->close();
    $conn->close();
}
?>
Użytkowanie Systemu
Rejestracja Użytkownika:

Użytkownicy mogą rejestrować się za pomocą formularza rejestracji dostępnego na stronie register.html.
Po rejestracji, konto użytkownika musi być aktywowane przez administratora.
Logowanie Użytkownika:

Zalogowani użytkownicy mają dostęp do funkcjonalności systemu poprzez stronę login.html.
Dodawanie i Usuwanie Opinii:

Zalogowani użytkownicy mogą dodawać opinie poprzez formularz submit_opinion.php.
Administratorzy mogą usuwać opinie za pomocą skryptu delete_opinion.php.
Aktywacja Użytkowników przez Administratora:

Administratorzy mogą aktywować nowych użytkowników w bazie danych, ustawiając wartość is_active na TRUE dla odpowiednich kont.
Uwagi Końcowe
Pamiętaj o zabezpieczeniu plików i katalogów oraz regularnym tworzeniu kopii zapasowych bazy danych i plików systemu.
