<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=hydroculture;charset=utf8', 'root', '');

// Si le panier est vide
if (!isset($_SESSION['panier']) || count($_SESSION['panier']) == 0) {
    echo "<h2>Votre panier est vide.</h2>";
    echo "<a href='categorie.php'>← Retour aux produits</a>";
    exit;
}

// Récupère les produits du panier
$ids = implode(',', array_keys($_SESSION['panier']));
$stmt = $pdo->query("SELECT * FROM produits WHERE id IN ($ids)");
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Panier</title>
    <link rel="stylesheet" href="categorie.css">
</head>
<body>
    <h1>Votre panier</h1>

    <table border="1" cellpadding="10">
        <tr>
            <th>Produit</th>
            <th>Prix</th>
            <th>Quantité</th>
            <th>Sous-total</th>
        </tr>

        <?php
        $total = 0;
        foreach ($produits as $produit):
            $qte = $_SESSION['panier'][$produit['id']];
            $sous_total = $produit['prix'] * $qte;
            $total += $sous_total;
        ?>
        <tr>
            <td><?= $produit['nom'] ?></td>
            <td><?= $produit['prix'] ?> FCFA</td>
            <td><?= $qte ?></td>
            <td><?= $sous_total ?> FCFA</td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h3>Total : <?= $total ?> FCFA</h3>

    <!-- Formulaire de finalisation -->
    <h2>Finaliser l'achat</h2>
    <form action="valider_commande.php" method="post">
        <p><input type="text" name="nom" placeholder="Nom complet" required></p>
        <p><input type="email" name="email" placeholder="Email" required></p>
        <p><textarea name="adresse" placeholder="Adresse de livraison" required></textarea></p>
        <button type="submit">Valider la commande ✅</button>
    </form>
</body>
</html>
