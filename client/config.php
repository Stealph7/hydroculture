<?php
// Informations de connexion à la base de données
$host = 'localhost';         // hôte du serveur MySQL
$dbname = 'hydroculture';    // nom de la base
$user = 'root';              // nom d'utilisateur MySQL
$password = '';              // mot de passe MySQL

try {
    // Connexion à la base avec PDO
    $pdo = new PDO('mysql:host='.$host.';dbname='.$dbname,$user,$password);

    // Activer les erreurs PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // En cas d'erreur, afficher le message
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
