<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: connexion.php");
    exit;
}

require 'database/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_user'])) {
    $nom_utilisateur = $_POST['nom_utilisateur'];
    $email = $_POST['email'];
    $mdp = password_hash("BTS-Ethur", PASSWORD_DEFAULT); // Hashage et ajout du mot de passe par défaut
    $role = $_POST['role'];

    $stmt = $pdo->prepare("INSERT INTO client (nom_utilisateur, email, mdp, role, mdp_reset) VALUES (?, ?, ?, ?, 1)");
    $stmt->execute([$nom_utilisateur, $email, $mdp, $role]); // Insertion d'un nouvel utilisateur
    header("Location: admin_dashboard.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_user'])) {
    $id = $_POST['id'];
    $nom_utilisateur = $_POST['nom_utilisateur'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $stmt = $pdo->prepare("UPDATE client SET nom_utilisateur = ?, email = ?, role = ? WHERE id = ?");
    $stmt->execute([$nom_utilisateur, $email, $role, $id]); // Mise à jour des informations utilisateur
    header("Location: admin_dashboard.php");
    exit;
}

if (isset($_GET['delete_user'])) {
    $id = $_GET['delete_user'];
    $stmt = $pdo->prepare("DELETE FROM client WHERE id = ?");
    $stmt->execute([$id]); // Suppression d'un utilisateur
    header("Location: admin_dashboard.php");
    exit;
}

$stmt = $pdo->query("SELECT id, nom_utilisateur, email, role FROM client");
$users = $stmt->fetchAll(); // Récupération de la liste des utilisateurs
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Terroir & Savoirs</title>
</head>
<body>
    <header>
        <h1>Tableau de bord Admin</h1>
        <a href="logout.php">Déconnexion</a>
    </header>
    <main>
        <h2>Gestion des utilisateurs</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nom d'utilisateur</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td><?= htmlspecialchars($user['nom_utilisateur']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['role']) ?></td>
                    <td>
                        <form method="POST" action="admin_dashboard.php" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                            <input type="text" name="nom_utilisateur" value="<?= $user['nom_utilisateur'] ?>" required>
                            <input type="email" name="email" value="<?= $user['email'] ?>" required>
                            <select name="role" required>
                                <option value="client" <?= $user['role'] == 'client' ? 'selected' : '' ?>>Client</option>
                                <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Administrateur</option>
                                <option value="brasseurs" <?= $user['role'] == 'brasseurs' ? 'selected' : '' ?>>Brasseurs</option>
                                <option value="caissier" <?= $user['role'] == 'caissier' ? 'selected' : '' ?>>Caissier</option>
                                <option value="direction" <?= $user['role'] == 'direction' ? 'selected' : '' ?>>Direction</option>
                            </select>
                            <button type="submit" name="edit_user">Modifier</button> <!-- Bouton pour modifier un utilisateur -->
                        </form>
                        <a href="admin_dashboard.php?delete_user=<?= $user['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">Supprimer</a> <!-- Lien pour supprimer un utilisateur -->
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h2>Ajouter un utilisateur</h2>
        <form method="POST" action="admin_dashboard.php">
            <label>Nom d'utilisateur :</label>
            <input type="text" name="nom_utilisateur" required>
            <label>Email :</label>
            <input type="email" name="email" required>
            <label>Mot de passe :</label>
            <input type="password" name="password" required>
            <label>Rôle :</label>
            <select name="role" required>
                <option value="client">Client</option>
                <option value="admin">Administrateur</option>
                <option value="brasseurs">Brasseurs</option>
                <option value="caissier">Caissier</option>
                <option value="direction">Direction</option>
            </select>
            <button type="submit" name="add_user">Ajouter</button> <!-- Bouton pour ajouter un utilisateur -->
        </form>
    </main>
</body>
</html>