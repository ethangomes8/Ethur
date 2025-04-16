<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reservation_id = $_POST['reservation_id'];

    require 'database/config.php';

    $stmt = $pdo->prepare("UPDATE reservations SET status = 'annule' WHERE id = ? AND user_id = ?");
    $stmt->execute([$reservation_id, $_SESSION['user_id']]);

    $_SESSION['message'] = "Réservation annulée avec succès.";
    header("Location: user_dashboard.php");
    exit;
}
?>