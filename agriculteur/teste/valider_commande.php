<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=hydroculture;charset=utf8', 'root', '');

// Vérifie les champs
if (!isset($_POST['nom'], $_POST['email'], $_POST['adresse'])) {
    echo "Formulaire incomplet.";
    exit;
}

// Insère la commande
$stmt = $pdo->prepare("INSERT INTO commandes (nom_client, email_client, adresse) VALUES (?, ?, ?)");
$stmt->execute([$_POST['nom'], $_POST['email'], $_POST['adresse']]);
$commande_id = $pdo->lastInsertId();

// Insère les détails de commande
foreach ($_SESSION['panier'] as $produit_id => $quantite) {
    $stmt = $pdo->prepare("INSERT INTO details_commande (commande_id, produit_id, quantite) VALUES (?, ?, ?)");
    $stmt->execute([$commande_id, $produit_id, $quantite]);
}

// Vide le panier
unset($_SESSION['panier']);

// Message
echo "<h2>Merci pour votre commande !</h2>";
echo "<p>Votre commande n°$commande_id a été enregistrée avec succès.</p>";
echo "<a href='categorie.php'>← Retour à la boutique</a>";
