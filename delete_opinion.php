<?php
include 'includes/db_config.php';
session_start();

if ($_SESSION['role'] == 'admin') {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $opinion_id = $_POST['opinion_id'];
        
        $stmt = $conn->prepare("DELETE FROM opinions WHERE id = ?");
        $stmt->bind_param("i", $opinion_id);
        
        if ($stmt->execute()) {
            echo "Opinion deleted successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
        
        $stmt->close();
        $conn->close();
    }
} else {
    echo "You are not authorized to delete opinions.";
}
?>
