<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit;
}

require 'database/config.php';

$stmt = $pdo->prepare("SELECT * FROM reservations WHERE utilisateur_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stockStmt = $pdo->query("SELECT * FROM stock");
$stocks = $stockStmt->fetchAll(PDO::FETCH_ASSOC);

$pointsStmt = $pdo->prepare("SELECT points FROM client WHERE id = ?");
$pointsStmt->execute([$_SESSION['user_id']]);
$loyaltyPoints = $pointsStmt->fetchColumn();

$purchasesStmt = $pdo->prepare("
    SELECT 
        r.date_reservation AS date, 
        r.biere AS item, 
        r.quantite, 
        (r.quantite * s.prix) AS total_price 
    FROM reservations r
    JOIN stock s ON r.biere = s.biere
    WHERE r.utilisateur_id = ? AND r.status = 'finalise'
");
$purchasesStmt->execute([$_SESSION['user_id']]);
$purchases = $purchasesStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Compte</title>
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

        header {
            width: 100%;
            background-color: #3e2723;
            color: white;
            padding: 20px;
            text-align: center;
        }

        main {
            width: 100%;
            max-width: 800px;
            padding: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #3e2723;
            color: white;
            padding: 15px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            margin: 10px 0;
        }

        button:hover {
            background-color: #5a3e1b;
        }

        .cancel-button {
            padding: 10px 15px; 
            font-size: 14px; 
            width: auto; 
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

        .status {
            font-weight: bold;
        }

        .status.en-cours {
            color: orange;
        }

        .status.finalise {
            color: green;
        }

        .status.annule {
            color: red;
        }

        .stock-info {
            font-size: 12px;
            color: #888;
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
    </style>
</head>
<body>
    <header>
        <h1>Bonjour, <?= htmlspecialchars($_SESSION['nom_utilisateur'] ?? 'Utilisateur'); ?> !</h1>
        <a href="logout.php">Déconnexion</a>
    </header>
    <main>
        <p>Vous êtes connecté en tant que <strong><?= htmlspecialchars($_SESSION['role'] ?? ''); ?></strong>.</p>
        <h2>Réserver des Bières</h2>
        <form method="POST" action="reserve_biere.php">
            <div id="beer-selection-container">
                <div class="beer-selection">
                    <label for="beer">Bière :</label>
                    <select name="beer[]" required>
                        <?php foreach ($stocks as $stock): ?>
                            <option value="<?= htmlspecialchars($stock['biere']); ?>">
                                <?= htmlspecialchars($stock['biere']); ?> (Stock restant : <?= htmlspecialchars($stock['quantite']); ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <label for="quantity">Quantité :</label>
                    <input type="number" name="quantity[]" min="1" required>
                </div>
            </div>
            <button type="button" id="add-beer">Ajouter une autre bière</button>
            <label for="reservation_name">Nom de réservation :</label>
            <input type="text" name="reservation_name" id="reservation_name" required>
            <button type="submit">Réserver</button>
            <?php if (isset($_SESSION['message'])): ?>
            <div class="alert <?= $_SESSION['message_type'] === 'error' ? 'alert-error' : 'alert-success'; ?>">
                <?= $_SESSION['message']; ?>
            </div>
            <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
            <?php endif; ?>
        </form>

        <h2>Vos Réservations</h2>
        <table>
            <tr>
                <th>Bière</th>
                <th>Quantité</th>
                <th>Nom de réservation</th>
                <th>Statut</th>
                <th>Action</th>
            </tr>
            <?php foreach ($reservations as $reservation): ?>
                <tr>
                    <td><?= htmlspecialchars($reservation['biere']) ?></td>
                    <td><?= htmlspecialchars($reservation['quantite']) ?></td>
                    <td><?= htmlspecialchars($reservation['nom_reservation']) ?></td>
                    <td class="status <?= htmlspecialchars($reservation['status']) ?>"><?= htmlspecialchars($reservation['status']) ?></td>
                    <td>
                        <?php if ($reservation['status'] !== 'annule'): ?>
                            <form method="POST" action="annule_reservation.php" style="display:inline;">
                                <input type="hidden" name="reservation_id" value="<?= $reservation['id'] ?>">
                                <button type="submit" class="cancel-button">Annuler</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h2>Vos Points de Fidélité</h2>
        <p>Vous avez <strong><?= htmlspecialchars($loyaltyPoints); ?></strong> points de fidélité.</p>

        <h2>Vos Achats Passés</h2>
        <table>
            <tr>
                <th>Date</th>
                <th>Article</th>
                <th>Quantité</th>
                <th>Prix Total</th>
            </tr>
            <?php foreach ($purchases as $purchase): ?>
                <tr>
                    <td><?= htmlspecialchars($purchase['date']) ?></td>
                    <td><?= htmlspecialchars($purchase['item']) ?></td>
                    <td><?= htmlspecialchars($purchase['quantite']) ?></td>
                    <td><?= htmlspecialchars($purchase['total_price']) ?> €</td>
                </tr>
            <?php endforeach; ?>
        </table>
    </main>
    <script>
        document.getElementById('add-beer').addEventListener('click', function () {
            const container = document.getElementById('beer-selection-container');
            const newSelection = document.createElement('div');
            newSelection.classList.add('beer-selection');
            newSelection.innerHTML = `
                <label for="beer">Bière :</label>
                <select name="beer[]" required>
                    <?php foreach ($stocks as $stock): ?>
                        <option value="<?= htmlspecialchars($stock['biere']); ?>">
                            <?= htmlspecialchars($stock['biere']); ?> (Stock restant : <?= htmlspecialchars($stock['quantite']); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <label for="quantity">Quantité :</label>
                <input type="number" name="quantity[]" min="1" required>
            `;
            container.appendChild(newSelection);
        });
    </script>
</body>
</html>