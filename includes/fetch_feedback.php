<?php
// includes/fetch_feedback.php

include 'db_config.php';

// Handle search query
$searchQuery = '';
if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
}

$searchSql = "";
if ($searchQuery) {
    $searchSql = "WHERE email LIKE '%$searchQuery%' OR services LIKE '%$searchQuery%' OR dissatisfaction LIKE '%$searchQuery%' OR sales_dissatisfaction LIKE '%$searchQuery%' OR installation_dissatisfaction LIKE '%$searchQuery%' OR functionality_dissatisfaction LIKE '%$searchQuery%' OR submission_date LIKE '%$searchQuery%'";
}

// Query to fetch feedback sorted by submission_date descending
$sql = "SELECT * FROM feedback $searchSql ORDER BY submission_date DESC";
$result = $conn->query($sql);

$feedback = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $feedback[] = $row;
    }
}

$conn->close();
?>
