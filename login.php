<?php
session_start();
require('client/config.php');

// Initialisation des variables
$erreur = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification que tous les champs requis sont présents
    if (!isset($_POST['username']) || !isset($_POST['password'])) {
        $erreur = "Tous les champs doivent être remplis";
    } else {
        $nom_utilisateur = trim($_POST['username']);
        $mot_de_passe = $_POST['password'];

        // Vérification que les champs ne sont pas vides
        if (empty($nom_utilisateur) || empty($mot_de_passe)) {
            $erreur = "Veuillez remplir tous les champs";
        } else {
            // Requête préparée pour plus de sécurité
            $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE nom_utilisateur = ?");
            $stmt->execute([$nom_utilisateur]);
            $user = $stmt->fetch();

            if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
                $_SESSION['utilisateur'] = [
                    'id' => $user['id'],
                    'nom' => $user['nom'],
                    'email' => $user['email'],
                ];
                header('Location: index.php');
                exit;
            } else {
                $erreur = "Nom d'utilisateur ou mot de passe incorrect";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Hydroculture225</title>
    <style>
        /* Mise en page responsive + moderne */
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-image: url('images/img6.png.JPG');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 400px;
            animation: fadeIn 1.2s ease-in-out;
        }

        .form-box h2 {
            margin-bottom: 20px;
            color: #2f4f4f;
            text-align: center;
        }

        label {
            display: block;
            text-align: left;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        input:focus {
            outline: none;
            border-color: #4caf50;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
        }

        .button {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #388e3c;
        }

        .link {
            margin-top: 15px;
            font-size: 14px;
            text-align: center;
        }

        .link a {
            color: #2e7d32;
            text-decoration: none;
            font-weight: bold;
        }

        .link a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: #d32f2f;
            background-color: #ffebee;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
            font-size: 14px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <form method="POST" action="login.php" class="form-box">
            <h2>Connexion</h2>
            
            <?php if ($erreur): ?>
                <div class="error-message"><?= htmlspecialchars($erreur) ?></div>
            <?php endif; ?>

            <label for="username">Nom d'utilisateur :</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" class="button">Valider</button>

            <p class="link">
                Pas encore inscrit ? 
                <a href="inscription.php">Créer un compte</a>
            </p>
        </form>
    </div>
</body>
</html>