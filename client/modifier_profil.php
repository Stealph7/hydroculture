<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=hydroculture;charset=utf8', 'root', '');

if (!isset($_SESSION['utilisateur'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['utilisateur'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $role = $_POST['role'];

    // Gestion de la photo
    $photo = $user['photo_profil'];
    if (!empty($_FILES['photo_profil']['name'])) {
        $fichier = $_FILES['photo_profil']['name'];
        $tmp = $_FILES['photo_profil']['tmp_name'];
        $chemin = 'uploads/' . $fichier;
        move_uploaded_file($tmp, $chemin);
        $photo = $fichier;
    }

    // Mise à jour SQL
    if (!empty($mot_de_passe)) {
        $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        $sql = "UPDATE utilisateurs SET nom=?, email=?, mot_de_passe=?, photo_profil=?, role=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom, $email, $mot_de_passe_hash, $photo, $role, $user['id']]);
    } else {
        $sql = "UPDATE utilisateurs SET nom=?, email=?, photo_profil=?, role=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom, $email, $photo, $role, $user['id']]);
    }

    // Mise à jour session
    $_SESSION['utilisateur']['nom'] = $nom;
    $_SESSION['utilisateur']['email'] = $email;
    $_SESSION['utilisateur']['role'] = $role;
    $_SESSION['utilisateur']['photo_profil'] = $photo;

    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier Profil</title>
    <style>
        body { font-family: sans-serif; background: #f0f8f0; padding: 30px; }
        .form-container {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        input, select, button {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        button {
            background-color: #27ae60;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover { background-color: #219150; }
        img { width: 120px; border-radius: 50%; margin-top: 15px; }
    </style>
</head>
<body>

<div class="form-container">
    <h2>🛠️ Modifier mon profil</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" required>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        <input type="password" name="mot_de_passe" placeholder="Nouveau mot de passe (laisser vide pour garder)">
        
        <label>📤 Photo de profil :</label>
        <input type="file" name="photo_profil" accept="image/*">
        <img src="uploads/<?= htmlspecialchars($user['photo_profil']) ?>" alt="Photo Profil">

        <label>👤 Rôle :</label>
        <select name="role" required>
            <option value="client" <?= $user['role'] == 'client' ? 'selected' : '' ?>>Client</option>
            <option value="agriculteur" <?= $user['role'] == 'agriculteur' ? 'selected' : '' ?>>Agriculteur</option>
        </select>

        <button type="submit">💾 Enregistrer</button>
    </form>
</div>

</body>
</html>
