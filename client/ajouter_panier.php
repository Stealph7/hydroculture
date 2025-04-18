<?php
session_start();

if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

if (isset($_POST['produit_id'])) {
    $id = $_POST['produit_id'];

    if (isset($_SESSION['panier'][$id])) {
        $_SESSION['panier'][$id]++; // Incrémente la quantité
    } else {
        $_SESSION['panier'][$id] = 1; // Ajoute le produit
    }
}

// Redirige vers la page des catégories
header('Location: categorie.php');
exit();
