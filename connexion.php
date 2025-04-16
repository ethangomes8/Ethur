<?php
include 'database/config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT id, nom_utilisateur, email, mdp, role, mdp_reset FROM client WHERE email = ?");
    $stmt->execute([$email]); // Vérification de l'email dans la base de données
    
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (password_verify($password, $user['mdp'])) { // Vérification du mot de passe
            if ($user['mdp_reset']) {
                $_SESSION['user_id'] = $user['id'];
                header("Location: reset_password.php");
                exit();
            }

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['nom'];
            $_SESSION['role'] = $user['role'];

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
            $error = "Mot de passe incorrect."; // Message d'erreur pour mot de passe incorrect
        }
    } else {
        $error = "Aucun utilisateur trouvé avec cet email."; // Message d'erreur pour email introuvable
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Connexion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f1e5; 
            color: #3e2723; 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        h2 {
            color: #3e2723; 
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            text-align: left;
        }

        input {
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

        a {
            color: #3e2723; 
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        p {
            margin: 10px 0;
        }

        .error {
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <form method="POST" action="connexion.php">
        <h2>Connexion</h2>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <label>Email :</label>
        <input type="email" name="email" required>
        <label>Mot de passe :</label>
        <input type="password" name="password" required>
        <button type="submit">Se connecter</button> <!-- Bouton de connexion -->
        <p>Pas encore inscrit ? <a href="info-register.php">Créer un compte</a></p> <!-- Lien vers la création de compte -->
    </form>
</body>
</html>