<?php
require 'database/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_raw']) && !empty($_POST['nom']) && isset($_POST['quantite'], $_POST['unite'])) {
        $nom = htmlspecialchars($_POST['nom']);
        $quantite = intval($_POST['quantite']);
        $unite = htmlspecialchars($_POST['unite']);
        $stmt = $pdo->prepare("INSERT INTO matiere_prem (nom, quantite, unite) VALUES (?, ?, ?)");
        $stmt->execute([$nom, $quantite, $unite]); // Ajout d'une nouvelle matière première
    } elseif (isset($_POST['update_raw']) && !empty($_POST['nom']) && isset($_POST['quantite'], $_POST['unite'], $_POST['id'])) {
        $id = intval($_POST['id']);
        $nom = htmlspecialchars($_POST['nom']);
        $quantite = intval($_POST['quantite']);
        $unite = htmlspecialchars($_POST['unite']);
        $stmt = $pdo->prepare("UPDATE matiere_prem SET nom = ?, quantite = ?, unite = ? WHERE id = ?");
        $stmt->execute([$nom, $quantite, $unite, $id]); // Mise à jour d'une matière première
    } elseif (isset($_POST['delete_raw']) && isset($_POST['id'])) {
        $id = intval($_POST['id']);
        $stmt = $pdo->prepare("DELETE FROM matiere_prem WHERE id = ?");
        $stmt->execute([$id]); // Suppression d'une matière première
    }
}

$stmt = $pdo->query("SELECT * FROM matiere_prem");
$raw_materials = $stmt->fetchAll(PDO::FETCH_ASSOC); // Récupération des matières premières
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Stocks - Matières Premières</title>
    <a href="brasseurs_dashboard.php">Retour au tableau de bord</a>

    <link rel="stylesheet" href="public/style.css">
    <style>
        body { background-color: #f8f1e5; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 8px; text-align: left; }
        form { margin: 20px 0; }
        button { background-color: #3e2723; color: white; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background-color: #5a3e1b; }
    </style>
</head>
<body>
    <h1>Gestion des Stocks - Matières Premières</h1>

    <form method="POST">
        <input type="text" name="nom" placeholder="Nom de la matière" required>
        <input type="number" name="quantite" placeholder="Quantité" required>
        <input type="text" name="unite" placeholder="Unité (kg, g, L...)" required>
        <button type="submit" name="add_raw">Ajouter</button> <!-- Bouton pour ajouter une matière première -->
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Quantité</th>
                <th>Unité</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($raw_materials as $material): ?>
                <tr>
                    <td><?= htmlspecialchars($material['id'] ?? ''); ?></td>
                    <td><?= htmlspecialchars($material['nom'] ?? ''); ?></td>
                    <td><?= htmlspecialchars($material['quantite'] ?? ''); ?></td>
                    <td><?= htmlspecialchars($material['unite'] ?? ''); ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($material['id'] ?? ''); ?>">
                            <input type="text" name="nom" value="<?= htmlspecialchars($material['nom'] ?? ''); ?>" required>
                            <input type="number" name="quantite" value="<?= htmlspecialchars($material['quantite'] ?? ''); ?>" required>
                            <input type="text" name="unite" value="<?= htmlspecialchars($material['unite'] ?? ''); ?>" required>
                            <button type="submit" name="update_raw">Modifier</button> <!-- Bouton pour modifier une matière première -->
                        </form>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($material['id'] ?? ''); ?>">
                            <button type="submit" name="delete_raw">Supprimer</button> <!-- Bouton pour supprimer une matière première -->
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>