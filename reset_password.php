<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit;
}

require 'database/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password === $confirm_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE client SET mdp = ?, mdp_reset = 0 WHERE id = ?");
        $stmt->execute([$hashed_password, $_SESSION['user_id']]);

        $stmt = $pdo->prepare("SELECT role FROM client WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        switch ($user['role']) {
            case 'admin':
                header("Location: admin_dashboard.php");
                break;
            case 'brasseurs':
                header("Location: brasseurs_dashboard.php");
                break;
            case 'direction':
                header("Location: direction_dashboard.php");
                break;
            case 'caissier':
                header("Location: caissier_dashboard.php");
                break;
            default:
                header("Location: user_dashboard.php");
                break;
        }
        exit();
    } else {
        $error = "Les mots de passe ne correspondent pas.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <form method="POST" action="reset_password.php">
        <h2>Définir un nouveau mot de passe</h2>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <label>Nouveau mot de passe :</label>
        <input type="password" name="new_password" required>
        <label>Confirmer le mot de passe :</label>
        <input type="password" name="confirm_password" required>
        <button type="submit">Enregistrer</button>
    </form>
</body>
</html>