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
