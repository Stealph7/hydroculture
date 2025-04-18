<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Hydroculture225</title>
    <link rel="stylesheet" href="inscription.css">
</head>
<body>
    <div class="container">
        <!-- Partie gauche avec image et message de bienvenue -->
        <div class="left">
            <h1><span>Bienvenue</span> sur Hydroculture225</h1>
        </div>

        <!-- Formulaire d'inscription -->
        <div class="right">
            <form action="inscr.php" method="post">
                <p>
                    <label for="nom">Nom :</label>
                    <input type="text" id="nom" name="nom" required>
                </p>
                <p>
                    <label for="prenom">Prénom :</label>
                    <input type="text" id="prenom" name="prenom" required>
                </p>
                <p>
                    <label for="username">Nom d'utilisateur :</label>
                    <input type="text" id="username" name="username" required>
                </p>
                <p>
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" required>
                </p>
                <p>
                    <label for="contact">Contact :</label>
                    <input type="tel" id="contact" name="contact" required>
                </p>
                <p>
                    <label for="password">Mot de passe :</label>
                    <input type="password" id="password" name="password" required>
                </p>
                <p>
                    <label for="confirm-password">Confirmation de mot de passe :</label>
                    <input type="password" id="confirm-password" name="confirm_password" required>
                </p>
                <p>
                   
                    <label for="client">Client</label>
                    <input type="radio" id="client" name="choix" value="client" checked>
                </p>
                <p>
  
                    <label for="agriculteur">Agriculteur</label>
                    <input type="radio" id="agriculteur" name="choix" value="agriculteur">
                </p>
                <div class="nom">
                    <button type="submit" class="button">Valider</button>
                </div>
                <p class="link">
                    Déjà inscrit ? 
                    <a href="login.php">Connectez-Vous</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>
