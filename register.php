<?php
include 'database/config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_utilisateur = $_POST['nom_utilisateur'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $role = 'client'; 

    $stmt = $pdo->prepare("INSERT INTO client (nom_utilisateur, email, mdp, role) VALUES (?, ?, ?, ?)");
    $stmt->bindValue(1, $nom_utilisateur, PDO::PARAM_STR);
    $stmt->bindValue(2, $email, PDO::PARAM_STR);
    $stmt->bindValue(3, $hashed_password, PDO::PARAM_STR);
    $stmt->bindValue(4, $role, PDO::PARAM_STR);

    if ($stmt->execute()) {
        header("Location: connexion.php");
        exit();
    } else {
        $error = "Erreur lors de la création du compte.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Inscription</title>
</head>
<body>
    <form method="POST" action="register.php">
        <h2>Inscription</h2>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <label>Nom d'utilisateur :</label>
        <input type="text" name="nom_utilisateur" required>
        <label>Email :</label>
        <input type="email" name="email" required>
        <label>Mot de passe :</label>
        <input type="password" name="password" required>
        <button type="submit">S'inscrire</button>
        <p>Déjà inscrit ? <a href="connexion.php">Se connecter</a></p>
    </form>
</body>
</html>