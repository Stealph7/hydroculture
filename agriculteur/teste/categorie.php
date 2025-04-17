<?php
session_start();

// Connexion à la BDD
$pdo = new PDO('mysql:host=localhost;dbname=hydroculture;charset=utf8', 'root', '');

// Récupération des produits
$stmt = $pdo->query("SELECT * FROM produits");
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Catégorie - Produits</title>
    <link rel="stylesheet" href="categorie.css">
</head>
<body>
    <h1>Nos Produits</h1>

    <?php if (isset($_SESSION['message'])): ?>
        <p style="color: green;"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
    <?php endif; ?>

    <div class="product-list">
        <?php foreach ($produits as $produit): ?>
            <div class="product-card">
                <img src="<?= $produit['image'] ?>" alt="<?= $produit['nom'] ?>">
                <h3><?= $produit['nom'] ?></h3>
                <p><?= $produit['prix'] ?> FCFA</p>

                <!-- Formulaire d'ajout au panier -->
                <form method="post" action="ajouter_panier.php">
                    <input type="hidden" name="id" value="<?= $produit['id'] ?>">
                    <button type="submit" class="add-to-cart">Ajouter au panier</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
