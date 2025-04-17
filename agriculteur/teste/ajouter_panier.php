<?php
session_start();

// Vérifie qu'un ID produit est reçu
if (isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Création du panier s’il n’existe pas
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
    }

    // Ajout ou incrémentation du produit
    if (isset($_SESSION['panier'][$id])) {
        $_SESSION['panier'][$id]++;
    } else {
        $_SESSION['panier'][$id] = 1;
    }

    $_SESSION['message'] = "Produit ajouté au panier.";
}

header("Location: categorie.php");
exit;
