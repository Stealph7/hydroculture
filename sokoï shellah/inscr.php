<?php
// Connexion à la base de données MySQL
$host = 'localhost';
$dbname = 'hydroculture';
$user = 'Ismael_kone';         // à adapter si tu as un mot de passe
$pass = 'Kone@0075350#';             // mettre le mot de passe ici si tu en as un

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    // Active les erreurs PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérifie que le formulaire est bien envoyé
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Nettoyage des champs
    $nom         = htmlspecialchars(trim($_POST['nom']));
    $prenom      = htmlspecialchars(trim($_POST['prenom']));
    $username    = htmlspecialchars(trim($_POST['username']));
    $email       = htmlspecialchars(trim($_POST['email']));
    $contact     = htmlspecialchars(trim($_POST['contact']));
    $password    = $_POST['password'];
    $confirm     = $_POST['confirm_password'];
    $role        = $_POST['choix'];

    // Vérifications
    if (empty($nom) || empty($prenom) || empty($username) || empty($email) || empty($contact) || empty($password) || empty($confirm)) {
        die("Tous les champs sont obligatoires.");
    }

    if ($password !== $confirm) {
        die("Les mots de passe ne correspondent pas.");
    }

    // Hachage du mot de passe
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Préparation de la requête SQL
    $sql = "INSERT INTO utilisateurs (nom, prenom, username, email, contact, mot_de_passe, role)
            VALUES (:nom, :prenom, :username, :email, :contact, :mot_de_passe, :role)";

    // Exécution sécurisée avec PDO
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute([
            ':nom'          => $nom,
            ':prenom'       => $prenom,
            ':username'     => $username,
            ':email'        => $email,
            ':contact'      => $contact,
            ':mot_de_passe' => $hashedPassword,
            ':role'         => $role
        ]);

        echo "<h2>Inscription réussie !</h2>";
        echo "<a href='index.html'>Retour au formulaire</a>";
    } catch (PDOException $e) {
        // Gestion des erreurs (ex: doublons)
        echo "Erreur : " . $e->getMessage();
    }
} else {
    echo "Méthode non autorisée.";
}
?>
