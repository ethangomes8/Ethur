<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bieres = $_POST['beer'];
    $quantites = $_POST['quantity'];
    $nom_reservation = $_POST['reservation_name'];

    require 'database/config.php';

    $errors = [];
    $pdo->beginTransaction();

    try {
        foreach ($bieres as $index => $biere) {
            $quantite = $quantites[$index];

            $stmt = $pdo->prepare("SELECT quantite FROM stock WHERE biere = ?");
            $stmt->execute([$biere]);
            $stock = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($stock && $stock['quantite'] >= $quantite) {
                $stmt = $pdo->prepare("UPDATE stock SET quantite = quantite - ? WHERE biere = ?");
                $stmt->execute([$quantite, $biere]);

                $stmt = $pdo->prepare("INSERT INTO reservations (utilisateur_id, biere, quantite, nom_reservation, date_reservation, status) VALUES (?, ?, ?, ?, NOW(), 'en-cours')");
                $stmt->execute([$_SESSION['user_id'], $biere, $quantite, $nom_reservation]);
            } else {
                $errors[] = "Stock insuffisant pour la bière : $biere.";
            }
        }

        if (empty($errors)) {
            $pdo->commit();
            $_SESSION['message'] = "Réservation effectuée avec succès.";
            $_SESSION['message_type'] = "success";
        } else {
            $pdo->rollBack();
            $_SESSION['message'] = implode('<br>', $errors);
            $_SESSION['message_type'] = "error";
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        $_SESSION['message'] = "Une erreur est survenue lors de la réservation.";
        $_SESSION['message_type'] = "error";
    }

    header("Location: user_dashboard.php");
    exit;
}
?>