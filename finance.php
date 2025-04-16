<?php
require 'database/config.php';

$currentMonth = isset($_GET['month']) ? intval($_GET['month']) : date('m');
$currentYear = isset($_GET['year']) ? intval($_GET['year']) : date('Y');

$salesStmt = $pdo->prepare("
    SELECT reservations.biere AS biere, SUM(reservations.quantite) AS total_quantite, SUM(reservations.quantite * stock.prix) AS total_revenue
    FROM reservations
    JOIN stock ON reservations.biere = stock.biere
    WHERE status = 'finalise' AND MONTH(date_reservation) = ? AND YEAR(date_reservation) = ?
    GROUP BY reservations.biere
");
$salesStmt->execute([$currentMonth, $currentYear]);
$sales = $salesStmt->fetchAll(PDO::FETCH_ASSOC);

$financeStmt = $pdo->prepare("
    SELECT type, description, montant, DATE_FORMAT(date, '%d/%m/%Y') AS formatted_date
    FROM finances
    WHERE MONTH(date) = ? AND YEAR(date) = ?
");
$financeStmt->execute([$currentMonth, $currentYear]);
$finances = $financeStmt->fetchAll(PDO::FETCH_ASSOC);

$totalRevenue = array_sum(array_column($sales, 'total_revenue'));
$totalExpenses = array_sum(array_column(array_filter($finances, fn($f) => $f['type'] === 'expense'), 'montant'));
$totalBalance = $totalRevenue - $totalExpenses;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'];
    $description = htmlspecialchars($_POST['description']);
    $montant = floatval($_POST['montant']);
    $date = $_POST['date'];

    $stmt = $pdo->prepare("INSERT INTO finances (type, description, montant, date) VALUES (?, ?, ?, ?)");
    $stmt->execute([$type, $description, $montant, $date]);

    header("Location: finance.php?month=$currentMonth&year=$currentYear");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Direction - Bilan Financier</title>
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

        h2, h3 {
            color: #3e2723;
        }

        .stats-container, .finance-container, .add-finance-container, .navigation-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            width: 100%;
            margin: 20px 0;
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

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input, select, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #3e2723;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background-color: #5a3e1b;
        }

        .actions-container button {
            width: auto;
            margin: 10px;
        }
    </style>
</head>
<body>
<h2>Page Direction - Bilan Financier</h2>

<div class="stats-container">
    <h3>Statistiques de Vente - <?= sprintf('%02d/%d', $currentMonth, $currentYear) ?></h3>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Nom de la Bière</th>
            <th>Quantité Totale Vendue</th>
            <th>Revenu Total (€)</th>
        </tr>
        <?php foreach ($sales as $sale): ?>
            <tr>
                <td><?= htmlspecialchars($sale['biere']) ?></td>
                <td><?= htmlspecialchars($sale['total_quantite']) ?></td>
                <td><?= number_format($sale['total_revenue'], 2) ?> €</td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p><strong>Total Général : </strong><?= number_format($totalRevenue, 2) ?> €</p>
</div>

<div class="finance-container">
    <h3>Dépenses et Recettes</h3>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Type</th>
            <th>Description</th>
            <th>Montant (€)</th>
            <th>Date</th>
        </tr>
        <?php foreach ($finances as $finance): ?>
            <tr>
                <td><?= htmlspecialchars($finance['type'] === 'expense' ? 'Dépense' : 'Recette') ?></td>
                <td><?= htmlspecialchars($finance['description']) ?></td>
                <td><?= number_format($finance['montant'], 2) ?> €</td>
                <td><?= htmlspecialchars($finance['formatted_date']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p><strong>Total Dépenses : </strong><?= number_format($totalExpenses, 2) ?> €</p>
    <p><strong>Bilan : </strong><?= number_format($totalBalance, 2) ?> €</p>
</div>

<div class="navigation-container">
    <form method="GET" action="finance.php">
        <label for="month">Mois :</label>
        <select name="month" id="month">
            <?php for ($m = 1; $m <= 12; $m++): ?>
                <option value="<?= $m ?>" <?= $m == $currentMonth ? 'selected' : '' ?>><?= $m ?></option>
            <?php endfor; ?>
        </select>
        <label for="year">Année :</label>
        <select name="year" id="year">
            <?php for ($y = date('Y') - 5; $y <= date('Y'); $y++): ?>
                <option value="<?= $y ?>" <?= $y == $currentYear ? 'selected' : '' ?>><?= $y ?></option>
            <?php endfor; ?>
        </select>
        <button type="submit">Afficher</button>
    </form>
</div>

<div class="add-finance-container">
    <h3>Ajouter une Dépense ou une Recette</h3>
    <form method="POST" action="finance.php?month=<?= $currentMonth ?>&year=<?= $currentYear ?>">
        <label for="type">Type :</label>
        <select name="type" id="type" required>
            <option value="expense">Dépense</option>
            <option value="revenue">Recette</option>
        </select>
        <label for="description">Description :</label>
        <input type="text" name="description" id="description" required>
        <label for="montant">Montant (€) :</label>
        <input type="number" step="0.01" name="montant" id="montant" required>
        <label for="date">Date :</label>
        <input type="date" name="date" id="date" required>
        <button type="submit">Ajouter</button>
    </form>
</div>

<div class="actions-container">
    <button onclick="window.location.href='direction_dashboard.php'">Retour à la Direction</button>
    <button onclick="window.location.href='index.php'">Retour à l'Accueil</button>
</div>

</body>
</html>
