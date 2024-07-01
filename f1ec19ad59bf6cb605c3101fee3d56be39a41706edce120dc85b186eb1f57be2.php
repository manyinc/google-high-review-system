<!-- fetch_feedback_main.php -->
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <link rel="stylesheet" href="css/fetch.css">
</head>
<body>
    <div class="header">
        <img src="../assets/logo.png" alt="Logo" class="logo">
    </div>
    <div class="search-container">
        <input type="text" id="search-input" placeholder="Szukaj opinii...">
    </div>
    <div class="card-container">
        <?php include 'includes/fetch_feedback.php'; ?>
        <?php if (count($feedback) > 0): ?>
            <?php foreach ($feedback as $item): ?>
                <div class="card">
                    <h3><?php echo htmlspecialchars($item['email']); ?><b style="float: right;">Ocena: <span class="rating"><?php echo str_repeat('★', $item['rating']); ?></span></b></h3>
                    <p><b>Data: </b><?php echo htmlspecialchars($item['submission_date']); ?></p>
                    <p><b>Usługi: </b><?php echo htmlspecialchars($item['services']); ?></p>
                    <p><b>Zalety: </b><br><?php echo nl2br(htmlspecialchars($item['dissatisfaction'])); ?></p>
                    <p><b>Wady: </b><br><?php echo nl2br(htmlspecialchars($item['sales_dissatisfaction'])); ?></p>
                    <p><b>Do poprawy: </b><br><?php echo nl2br(htmlspecialchars($item['installation_dissatisfaction'])); ?></p>

                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Brak opinii do wyświetlenia.</p>
        <?php endif; ?>
    </div>
    <div class="counter" id="counter">Liczba wyświetlonych opinii: <?php echo count($feedback); ?></div>
    <script src="js/fetch.js"></script>
</body>
</html>
