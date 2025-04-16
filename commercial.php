<?php
require 'database/config.php';

$salesStmt = $pdo->query("
    SELECT reservations.biere AS biere, SUM(reservations.quantite) AS total_quantite, SUM(reservations.quantite * stock.prix) AS total_revenue
    FROM reservations
    JOIN stock ON reservations.biere = stock.biere
    WHERE reservations.status = 'finalise'
    GROUP BY reservations.biere
");
$sales = $salesStmt->fetchAll(PDO::FETCH_ASSOC);

$totalRevenue = array_sum(array_column($sales, 'total_revenue'));
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bilan Commercial - Ventes de Bière</title>
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

        .stats-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            width: 100%;
            margin-top: 20px;
        }

        h2, h3 {
            color: #3e2723;
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

        .actions-container {
            margin-top: 20px;
        }

        button {
            background-color: #3e2723;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
        }

        button:hover {
            background-color: #5a3e1b;
        }
    </style>
</head>
<body>
<h2>Bilan Commercial - Ventes de Bière</h2>

<div class="stats-container">
    <h3>Statistiques Commerciales</h3>
    <table>
        <tr>
            <th>Catégorie de Bière</th>
            <th>Quantité Vendue</th>
            <th>Revenu (€)</th>
            <th>Pourcentage des Ventes</th>
        </tr>
        <?php foreach ($sales as $sale): ?>
            <tr>
                <td><?= htmlspecialchars($sale['biere']) ?></td>
                <td><?= htmlspecialchars($sale['total_quantite']) ?></td>
                <td><?= number_format($sale['total_revenue'], 2) ?> €</td>
                <td><?= $totalRevenue > 0 ? number_format(($sale['total_revenue'] / $totalRevenue) * 100, 2) : 0 ?> %</td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p><strong>Total des Ventes : </strong><?= number_format($totalRevenue, 2) ?> €</p>
</div>

<div class="actions-container">
    <button onclick="window.location.href='direction_dashboard.php'">Retour à la Direction</button>
    <button onclick="window.location.href='index.php'">Accueil</button>
</div>

</body>
</html>
