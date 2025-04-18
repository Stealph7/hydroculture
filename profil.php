<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=hydroculture;charset=utf8', 'root', '');

if (!isset($_SESSION['utilisateur'])) {
    header('Location: login.php');
    exit;
}

$id = $_SESSION['utilisateur']['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $role = $_POST['role'];

    // Traitement de la photo
    if (!empty($_FILES['photo']['name'])) {
        $photo = uniqid() . '_' . $_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/' . $photo);

        $stmt = $pdo->prepare("UPDATE utilisateurs SET nom=?, prenom=?, email=?, contact=?, role=?, photo=? WHERE id=?");
        $stmt->execute([$nom, $prenom, $email, $contact, $role, $photo, $id]);
    } else {
        $stmt = $pdo->prepare("UPDATE utilisateurs SET nom=?, prenom=?, email=?, contact=?, role=? WHERE id=?");
        $stmt->execute([$nom, $prenom, $email, $contact, $role, $id]);
    }

    // Actualiser la session
    $_SESSION['utilisateur'] = $pdo->query("SELECT * FROM utilisateurs WHERE id = $id")->fetch(PDO::FETCH_ASSOC);

    $message = "Profil mis à jour avec succès.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mon Profil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eafaf1;
            padding: 30px;
        }
        .container {
            max-width: 500px;
            background: white;
            padding: 20px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.1);
        }
        input, select {
            width: 100%; padding: 10px; margin: 10px 0;
            border: 1px solid #ccc; border-radius: 5px;
        }
        img {
            max-width: 120px; height: auto; border-radius: 50%;
            display: block; margin: 10px auto;
        }
        button {
            background-color: #2ecc71; color: white; padding: 10px;
            border: none; border-radius: 5px; cursor: pointer;
        }
        .message {
            background: #dff0d8;
            color: #3c763d;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 align="center">👤 Mon Profil</h2>

    <?php if (isset($message)): ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <input type="text" name="nom" placeholder="Nom" value="<?= $_SESSION['utilisateur']['nom'] ?>" required>
        <input type="text" name="prenom" placeholder="Prénom" value="<?= $_SESSION['utilisateur']['prenom'] ?>" required>
        <input type="email" name="email" placeholder="Email" value="<?= $_SESSION['utilisateur']['email'] ?>" required>
        <input type="text" name="contact" placeholder="Contact" value="<?= $_SESSION['utilisateur']['contact'] ?>" required>

        <select name="role" required>
            <option value="client" <?= $_SESSION['utilisateur']['role'] == 'client' ? 'selected' : '' ?>>Client</option>
            <option value="agriculteur" <?= $_SESSION['utilisateur']['role'] == 'agriculteur' ? 'selected' : '' ?>>Agriculteur</option>
        </select>

        <label>Photo de profil :</label>
        <?php if ($_SESSION['utilisateur']['photo']): ?>
            <img src="uploads/<?= $_SESSION['utilisateur']['photo'] ?>" alt="Photo de profil">
        <?php endif; ?>
        <input type="file" name="photo">

        <button type="submit">Mettre à jour</button>
        <a href="modifier_profil.php" style="float:left; padding:10px; color:#2c3e50;">✍ Modifier mon profil</a>

    </form>
</div>

</body>
</html>
