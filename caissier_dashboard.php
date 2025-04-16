<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'caissier') {
    header("Location: connexion.php");
    exit;
}

require 'database/config.php';

$clientsStmt = $pdo->query("SELECT id, nom_utilisateur, points FROM client");
$clients = $clientsStmt->fetchAll(PDO::FETCH_ASSOC); // Récupération des clients

$reservationsStmt = $pdo->query("SELECT r.id, r.utilisateur_id, r.biere, r.quantite, r.nom_reservation, r.status, c.nom_utilisateur, c.points, s.prix 
                                 FROM reservations r 
                                 JOIN client c ON r.utilisateur_id = c.id 
                                 JOIN stock s ON r.biere = s.biere
                                 WHERE r.status = 'en-cours'");
$reservations = $reservationsStmt->fetchAll(PDO::FETCH_ASSOC); // Récupération des réservations en cours

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reservation_id'])) {
    $reservationId = $_POST['reservation_id'];
    $usePoints = isset($_POST['use_points']) ? true : false;
    $discount = isset($_POST['discount']) ? (float)$_POST['discount'] : 0;

    $stmt = $pdo->prepare("SELECT r.*, c.points, s.prix FROM reservations r 
                           JOIN client c ON r.utilisateur_id = c.id 
                           JOIN stock s ON r.biere = s.biere 
                           WHERE r.id = ?");
    $stmt->execute([$reservationId]);
    $reservation = $stmt->fetch(PDO::FETCH_ASSOC); // Récupération des détails de la réservation

    if ($reservation) {
        $totalPrice = $reservation['quantite'] * $reservation['prix'];
        $pointsUsed = 0;

        if ($usePoints) {
            $pointsUsed = min($reservation['points'], $totalPrice);
            $totalPrice -= $pointsUsed;

            $stmt = $pdo->prepare("UPDATE client SET points = points - ? WHERE id = ?");
            $stmt->execute([$pointsUsed, $reservation['utilisateur_id']]); // Déduction des points utilisés
        }

        if ($discount > 0) {
            $totalPrice -= ($totalPrice * ($discount / 100)); // Application de la remise
        }

        $pointsEarned = floor($totalPrice);
        $stmt = $pdo->prepare("UPDATE client SET points = points + ? WHERE id = ?");
        $stmt->execute([$pointsEarned, $reservation['utilisateur_id']]); // Ajout des points gagnés

        $stmt = $pdo->prepare("UPDATE reservations SET status = 'finalise' WHERE id = ?");
        $stmt->execute([$reservationId]); // Mise à jour du statut de la réservation

        $_SESSION['message'] = "Réservation validée avec succès. Points utilisés : $pointsUsed. Remise appliquée : $discount%. Total payé : " . number_format($totalPrice, 2) . "€. Points gagnés : $pointsEarned.";
    } else {
        $_SESSION['message'] = "Réservation introuvable."; // Message d'erreur si la réservation est introuvable
    }

    header("Location: caissier_dashboard.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_client'])) {
    $nom_utilisateur = $_POST['nom_utilisateur'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $points = isset($_POST['points']) ? (int)$_POST['points'] : 0;

    $stmt = $pdo->prepare("INSERT INTO client (nom_utilisateur, mdp, points) VALUES (?, ?, ?)");
    $stmt->execute([$nom_utilisateur, $password, $points]); // Création d'un nouveau compte client

    $_SESSION['message'] = "Compte client créé avec succès.";
    header("Location: caissier_dashboard.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_sale'])) {
    $clientId = $_POST['client_id'];
    $biere = $_POST['biere'];
    $quantite = intval($_POST['quantite']);
    $discount = isset($_POST['discount']) ? (float)$_POST['discount'] : 0;

    $stmt = $pdo->prepare("SELECT prix, quantite AS stock_quantite FROM stock WHERE biere = ?");
    $stmt->execute([$biere]);
    $stock = $stmt->fetch(PDO::FETCH_ASSOC); // Vérification du stock disponible

    if ($stock && $stock['stock_quantite'] >= $quantite) {
        $totalPrice = $quantite * $stock['prix'];
        if ($discount > 0) {
            $totalPrice -= ($totalPrice * ($discount / 100)); // Application de la remise
        }

        $stmt = $pdo->prepare("UPDATE stock SET quantite = quantite - ? WHERE biere = ?");
        $stmt->execute([$quantite, $biere]); // Mise à jour du stock

        $stmt = $pdo->prepare("INSERT INTO reservations (utilisateur_id, biere, quantite, nom_reservation, date_reservation, status, prix) VALUES (?, ?, ?, ?, NOW(), 'finalise', ?)");
        $stmt->execute([$clientId, $biere, $quantite, 'Vente directe', $totalPrice]); // Enregistrement de la vente

        $pointsEarned = floor($totalPrice);
        $stmt = $pdo->prepare("UPDATE client SET points = points + ? WHERE id = ?");
        $stmt->execute([$pointsEarned, $clientId]); // Ajout des points gagnés

        $_SESSION['message'] = "Vente enregistrée avec succès. Total payé : " . number_format($totalPrice, 2) . "€. Points gagnés : $pointsEarned.";
    } else {
        $_SESSION['message'] = "Stock insuffisant pour la bière sélectionnée."; // Message d'erreur si le stock est insuffisant
    }

    header("Location: caissier_dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Caissier - Bière et Fidélité</title>
    <a href="logout.php">Déconnexion</a>
    <link rel="stylesheet" href="public/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f1e5; 
            color: #3e2723;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
        }

        .caisse-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            width: 100%;
            margin-top: 20px;
        }

        h2 {
            color: #3e2723;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        button {
            background-color: #3e2723;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #5a3e1b; 
        }

        .alert {
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            text-align: center;
            font-size: 16px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .form-container {
            margin-top: 30px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        .form-container label {
            display: block;
            margin: 10px 0 5px;
        }

        .form-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div class="caisse-container">
    <h2>Système de Caisse - Bière</h2>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['message']; ?>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <h3>Réservations en attente</h3>
    <table>
        <tr>
            <th>Client</th>
            <th>Bière</th>
            <th>Quantité</th>
            <th>Nom de réservation</th>
            <th>Points disponibles</th>
            <th>Prix Total</th>
            <th>Action</th>
        </tr>
        <?php foreach ($reservations as $reservation): ?>
            <tr>
                <td><?= htmlspecialchars($reservation['nom_utilisateur']); ?></td>
                <td><?= htmlspecialchars($reservation['biere']); ?></td>
                <td><?= htmlspecialchars($reservation['quantite']); ?></td>
                <td><?= htmlspecialchars($reservation['nom_reservation']); ?></td>
                <td><?= htmlspecialchars($reservation['points']); ?></td>
                <td><?= number_format($reservation['quantite'] * $reservation['prix'], 2); ?> €</td>
                <td>
                    <form method="POST" action="caissier_dashboard.php">
                        <input type="hidden" name="reservation_id" value="<?= $reservation['id']; ?>">
                        <label>
                            <input type="checkbox" name="use_points"> Utiliser les points
                        </label>
                        <label for="discount">Remise (%) :</label>
                        <input type="number" name="discount" id="discount" min="0" max="100" value="0">
                        <button type="submit">Valider</button> <!-- Système pour valider une réservation et utiliser les points -->
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<div class="form-container">
    <h3>Ajouter une vente directe</h3>
    <form method="POST" action="caissier_dashboard.php">
        <input type="hidden" name="add_sale" value="1">
        <label for="client_id">Client :</label>
        <select name="client_id" id="client_id" required>
            <?php foreach ($clients as $client): ?>
                <option value="<?= $client['id']; ?>"><?= htmlspecialchars($client['nom_utilisateur']); ?> (Points : <?= $client['points']; ?>)</option>
            <?php endforeach; ?>
        </select>
        <label for="biere">Bière :</label>
        <select name="biere" id="biere" required>
            <?php
            $stockStmt = $pdo->query("SELECT biere, quantite FROM stock");
            $stocks = $stockStmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($stocks as $stock): ?>
                <option value="<?= htmlspecialchars($stock['biere']); ?>"><?= htmlspecialchars($stock['biere']); ?> (Stock : <?= $stock['quantite']; ?>)</option>
            <?php endforeach; ?>
        </select>
        <label for="quantite">Quantité :</label>
        <input type="number" name="quantite" id="quantite" min="1" required>
        <label for="discount">Remise (%) :</label>
        <input type="number" name="discount" id="discount" min="0" max="100" value="0">
        <button type="submit">Ajouter la vente</button> <!-- Système pour ajouter une vente manuellement -->
    </form>
</div>

<div class="form-container">
    <h3>Créer un compte client</h3>
    <form method="POST" action="caissier_dashboard.php">
        <input type="hidden" name="create_client" value="1">
        <label for="nom_utilisateur">Nom d'utilisateur :</label>
        <input type="text" name="nom_utilisateur" id="nom_utilisateur" required>
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" required>
        <label for="points">Points de fidélité (optionnel) :</label>
        <input type="number" name="points" id="points" value="0" min="0">
        <button type="submit">Créer le compte</button> <!-- Système pour créer un compte client -->
    </form>
</div>
</body>
</html>































