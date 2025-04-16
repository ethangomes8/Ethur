<?php
session_start(); // Démarrage de la session
require 'database/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $volume = max(0, floatval($_POST['volume']));
    $alcohol = max(0, floatval($_POST['alcohol']));
    $ebc = max(0, floatval($_POST['ebc']));
    $malt = ($volume * $alcohol) / 20; // Calcul du malt
    $brassage  = $malt * 2.8; // Calcul de l'eau de brassage
    $eaurince = ($volume * 1.25) - ($brassage * 0.7); // Calcul de l'eau de rinçage
    $mcu = (4.23 * ($ebc * $malt)) / $volume; // Calcul du MCU
    $ebcresultat = 2.9396 * pow($mcu, 0.6859); // Calcul de l'EBC
    $srm = 0.508 * $ebcresultat; // Conversion EBC en SRM
    $levure = $volume / 2; // Calcul de la levure
    $houblon = $volume * 3; // Calcul du houblon
    $arome = $volume * 1; // Calcul de l'arôme

    if (isset($_POST['save_recipe'])) {
        if (!isset($_SESSION['user_id'])) { // Vérification de l'utilisateur connecté
            echo "<p style='color:red;'>Erreur : Vous devez être connecté pour sauvegarder une recette.</p>";
            exit;
        }

        $recipe_name = htmlspecialchars($_POST['recipe_name']);
        try {
            $stmt = $pdo->prepare("INSERT INTO recette (brasseur_id, nom, volume, alcool, ebc, malt, brassage, eaurince, mcu, ebcresultat, srm, levure, houblon, arome, creer_le) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)");
            $stmt->execute([
                $_SESSION['user_id'], $recipe_name, $volume, $alcohol, $ebc, $malt, $brassage, $eaurince, $mcu, $ebcresultat, $srm, $levure, $houblon, $arome
            ]); // Sauvegarde de la recette dans la base de données
            echo "<p style='color:green;'>Recette sauvegardée avec succès.</p>";
        } catch (PDOException $e) { 
            echo "<p style='color:red;'>Erreur lors de la sauvegarde : " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    }
}

// Récupération des recettes de l'utilisateur connecté
$recipes = [];
if (isset($_SESSION['user_id'])) {
    try {
        $stmt = $pdo->prepare("SELECT nom, volume, alcool, ebc, creer_le FROM recette WHERE brasseur_id = ? ORDER BY creer_le DESC");
        $stmt->execute([$_SESSION['user_id']]);
        $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erreur lors de la récupération des recettes : " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Calculateur de Bière</title>
    <a href="brasseurs_dashboard.php">Retour au tableau de bord</a> <!-- Lien vers le tableau de bord des brasseurs -->
    <style>
        body { background-color: #f8f1e5; } 
    </style>
</head>
<body>
    <h1>Calculateur de Bière</h1>
    <form method="POST">
        Volume de bière voulu (L) : <input type="number" step="0.01" name="volume" min="0" required>
        <br><br>
        Degrès d'alcool (%) : <input type="number" step="0.01" name="alcohol" min="0" required>
        <br><br>
        EBC moyen des grains : <input type="number" step="0.01" name="ebc" min="0" required> 
        <p>L'EBC comme le MCU et le SRM sont des unités de mesures afin d'estimer quel genre de bière on va concevoir. Ici en norme Européenne nous sommes en EBC, un EBC supérieur à 40 sera une bière foncée, à 20 elle sera ambrée et 6 ou moins elle sera blonde.</p>
        <br><br>
        <input type="submit" value="Calculer"> <!-- Calculs -->
    </form>
    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
    <h2>Résultats :</h2>
    <p>Malt : <?= floor($malt * 100) / 100 ?> kg</p>
    <p>Eau de brassage : <?= floor($brassage * 100) / 100 ?> L</p>
    <p>Eau de rinçage : <?= floor($eaurince * 100) / 100 ?> L</p>
    <p>MCU : <?= floor($mcu * 10000) / 10000 ?></p>
    <p>EBC : <?= floor($ebcresultat * 10000) / 10000 ?></p>
    <p>SRM : <?= floor($srm * 10000) / 10000 ?></p>
    <p>Levure : <?= floor($levure * 100) / 100 ?> g</p>
    <p>Houblon voulu : <?= floor($houblon * 100) / 100 ?> g</p>
    <p>Arome voulu : <?= floor($arome * 100) / 100 ?> g</p>
    <form method="POST">
        <input type="hidden" name="volume" value="<?= $volume ?>">
        <input type="hidden" name="alcohol" value="<?= $alcohol ?>">
        <input type="hidden" name="ebc" value="<?= $ebc ?>">
        <input type="hidden" name="malt" value="<?= $malt ?>">
        <input type="hidden" name="brassage" value="<?= $brassage ?>">
        <input type="hidden" name="eaurince" value="<?= $eaurince ?>">
        <input type="hidden" name="mcu" value="<?= $mcu ?>">
        <input type="hidden" name="ebcresultat" value="<?= $ebcresultat ?>">
        <input type="hidden" name="srm" value="<?= $srm ?>">
        <input type="hidden" name="levure" value="<?= $levure ?>">
        <input type="hidden" name="houblon" value="<?= $houblon ?>">
        <input type="hidden" name="arome" value="<?= $arome ?>">
        <label>Nom de la recette :</label>
        <input type="text" name="recipe_name" required>
        <button type="submit" name="save_recipe">Sauvegarder la recette</button> <!-- Sauvegarder la recette -->
    </form>
    <?php endif; ?>

    <h2>Vos Recettes :</h2>
    <?php if (!empty($recipes)): ?>
        <ul>
            <?php foreach ($recipes as $recipe): ?>
                <li>
                    <strong><?= htmlspecialchars($recipe['nom']) ?></strong> - 
                    Volume : <?= htmlspecialchars($recipe['volume']) ?> L, 
                    Alcool : <?= htmlspecialchars($recipe['alcool']) ?> %, 
                    EBC : <?= htmlspecialchars($recipe['ebc']) ?>, 
                    Créée le : <?= htmlspecialchars($recipe['creer_le']) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Aucune recette sauvegardée pour le moment.</p> <!-- Affichage des recettes -->
    <?php endif; ?>
</body>
</html>
