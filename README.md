# System Opinii z Systemem Logowania i Rejestracji

## Opis Działania Systemu
System Opinii umożliwia użytkownikom dodawanie opinii na temat produktów lub usług. System posiada funkcje rejestracji i logowania użytkowników, zarządzanie uprawnieniami (user, admin), możliwość usuwania opinii oraz aktywację użytkowników przez administratora. 

## Struktura Katalogów

```plaintext
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
Na początku tego pliku dodaj kod sprawdzający, czy użytkownik jest zalogowany:

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
Zaktualizuj plik login.php, aby przekierowywał do f1ec19ad59bf6cb605c3101fee3d56be39a41706edce120dc85b186eb1f57be2.php po pomyślnym zalogowaniu:

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
Konfiguracja Środowiska
Przenieś pliki do katalogu public_html na serwerze web.
Upewnij się, że serwer ma odpowiednie uprawnienia do odczytu plików.
Skonfiguruj bazę danych zgodnie z powyższymi instrukcjami.
Uruchom serwer web i sprawdź działanie systemu.
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
