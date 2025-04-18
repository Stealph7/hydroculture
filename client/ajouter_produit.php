<?php
// Démarre la session pour accéder aux variables de session
session_start();

// Connexion à la base de données MySQL avec PDO
require('config.php');
/*  // Vérifie si l'utilisateur est connecté et a le rôle 'agriculteur'
if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] != 'agriculteur') {
    // Redirige vers la page de login si non authentifié ou mauvais rôle
    header('Location: login.php');
    exit; // Arrête l'exécution du script
} */

// Vérifie si la requête est de type POST (formulaire soumis)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupère les données du formulaire
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $stock = $_POST['stock'];
    $categorie = $_POST['categorie'];
    $id_agriculteur = $_SESSION['utilisateur']['id']; // Récupère l'ID de l'agriculteur connecté

    $image = ''; // Initialise le nom de l'image
    
    // Gestion du fichier image uploadé
    if (!empty($_FILES['image']['name'])) {
        // Génère un nom unique pour l'image (évite les conflits de noms)
        $image = uniqid() . '_' . $_FILES['image']['name'];
        // Déplace le fichier uploadé vers le dossier 'uploads'
        move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $image);
    }

    // Prépare la requête SQL d'insertion
    $stmt = $pdo->prepare("INSERT INTO produits (nom, description, prix, stock, image, categorie, id_agriculteur)
        VALUES (?, ?, ?, ?, ?, ?, ?)");
    // Exécute la requête avec les valeurs du formulaire
    $stmt->execute([$nom, $description, $prix, $stock, $image, $categorie, $id_agriculteur]);

    // Redirige vers la page des catégories après l'insertion
    header("Location: page_categorie.php");
    exit; // Arrête l'exécution
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mettre en vente un produit</title>
    <style>
        body { font-family: sans-serif; background-color: #f0f8f0; padding: 30px; }
        form { max-width: 500px; margin: auto; background: #fff; padding: 20px; border-radius: 10px; }
        input, textarea, select {
            width: 100%; padding: 10px; margin: 10px 0;
            border: 1px solid #ccc; border-radius: 5px;
        }
        button { padding: 10px 20px; background-color: #2ecc71; color: white; border: none; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <?php
        include('en_tete.php');
    ?>
    <h2 align="center">🛒 Mettre un produit en vente</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="tel" name="id" placeholder="Id vendeur" required>
        <input type="text" name="nom" placeholder="Nom du produit" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <input type="number" step="0.01" name="prix" placeholder="Prix en FCFA" required>
        <input type="number" name="stock" placeholder="Stock disponible" required>
        <input type="file" name="image" accept="image/*" required>
        <select name="categorie" required>
            <option value="">-- Catégorie --</option>
            <option value="fruits">Fruits</option>
            <option value="légumes">Légumes</option>
            <option value="grains">Grains</option>
            <option value="autres">Autres</option>
        </select>
        <button type="submit">Mettre en vente</button>
    </form>
    <!-- Début du traitement PHP -->
    
           
</body>
</html>
