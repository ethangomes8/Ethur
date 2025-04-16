<?php
require 'database/config.php';

$stmt = $pdo->query("SELECT * FROM stock");
$stocks = $stmt->fetchAll(PDO::FETCH_ASSOC); // Récupération des stocks

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $biere = $_POST['biere'];
    $quantite = $_POST['quantite'];

    $stmt = $pdo->prepare("UPDATE stock SET quantite = ? WHERE biere = ?");
    $stmt->execute([$quantite, $biere]); // Mise à jour des quantités de stock

    header("Location: brasseurs_dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Brasseurs</title>
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

        a {
            display: block;
            background-color: #3e2723;
            color: white;
            padding: 15px 20px;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            margin: 10px 0;
            width: 100%;
        }

        a:hover {
            background-color: #5a3e1b;
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

        form {
            margin-top: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
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
    </style>
</head>
<body>
    <header>
        <h1>Tableau de Bord Brasseurs</h1>
    </header>
    <main>
        <a href="calculBiere.php">Calculateur de bière</a> <!-- Lien vers le calculateur -->
        <a href="stockmat.php">Matières premières</a> <!-- Lien vers la gestion des matières premières -->
        <a href="logout.php">Déconnexion</a> <!-- Lien de déconnexion -->
    </main>

    <h2>Stock Actuel</h2>
    <table>
        <tr>
            <th>Bière</th>
            <th>Quantité</th>
        </tr>
        <?php foreach ($stocks as $stock): ?>
            <tr>
                <td><?= htmlspecialchars($stock['biere']); ?></td>
                <td><?= htmlspecialchars($stock['quantite']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Mettre à jour le stock</h2>
    <form method="POST" action="brasseurs_dashboard.php">
        <label for="biere">Bière :</label>
        <select name="biere" id="biere" required>
            <?php foreach ($stocks as $stock): ?>
                <option value="<?= htmlspecialchars($stock['biere']); ?>"><?= htmlspecialchars($stock['biere']); ?></option>
            <?php endforeach; ?>
        </select>
        <label for="quantite">Nouvelle quantité :</label>
        <input type="number" name="quantite" id="quantite" min="0" required>
        <button type="submit">Mettre à jour</button> <!-- Bouton pour mettre à jour le stock -->
    </form>
</body>
</html>