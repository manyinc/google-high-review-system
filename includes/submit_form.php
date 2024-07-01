<?php
// includes/submit_form.php

include 'db_config.php';

$email = $conn->real_escape_string($_POST['email']);
$rating = (int)$_POST['rating'];
$services = isset($_POST['services']) ? $conn->real_escape_string(implode(", ", $_POST['services'])) : '';
$dissatisfaction = $conn->real_escape_string($_POST['dissatisfaction']);
$sales_dissatisfaction = $conn->real_escape_string($_POST['sales-dissatisfaction']);
$installation_dissatisfaction = $conn->real_escape_string($_POST['installation-dissatisfaction']);
$functionality_dissatisfaction = $conn->real_escape_string($_POST['functionality-dissatisfaction']);

// Check if the email is allowed to submit feedback
$sql_check_email = "SELECT * FROM allowed_emails WHERE email='$email'";
$result_check_email = $conn->query($sql_check_email);

if ($result_check_email->num_rows == 0) {
    // Redirect to the page that indicates the email is not allowed to submit feedback
    header("Location: ../the-opinion-has-already-been-issued.html");
    exit();
}

// Check if the email has already submitted feedback
$sql = "SELECT * FROM feedback WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Redirect to the page that indicates the opinion has already been issued
    header("Location: ../the-opinion-has-already-been-issued.html");
    exit();
} else {
    // Insert the new feedback into the database
    $sql = "INSERT INTO feedback (email, rating, services, dissatisfaction, sales_dissatisfaction, installation_dissatisfaction, functionality_dissatisfaction)
    VALUES ('$email', '$rating', '$services', '$dissatisfaction', '$sales_dissatisfaction', '$installation_dissatisfaction', '$functionality_dissatisfaction')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to the thank you page
        header("Location: ../thank-you-for-leaving-your-opinion.html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>