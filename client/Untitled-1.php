<?php
session_start();

// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=hydroculture;charset=utf8', 'root', '');

// Récupération du filtre de catégorie depuis l'URL
$categorie_filter = isset($_GET['categorie']) ? $_GET['categorie'] : null;

// Configuration de la pagination
$items_par_page = 8;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $items_par_page;

// Construction de la requête SQL avec filtres
$sql = "SELECT * FROM produits";
$params = [];

if ($categorie_filter) {
    $sql .= " WHERE categorie = ?";
    $params[] = $categorie_filter;
}

$sql .= " ORDER BY date_ajout DESC LIMIT ? OFFSET ?";
$params[] = $items_par_page;
$params[] = $offset;

// Préparation et exécution de la requête
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupération du nombre total de produits pour la pagination
$count_sql = "SELECT COUNT(*) FROM produits";
if ($categorie_filter) {
    $count_sql .= " WHERE categorie = ?";
}

$count_stmt = $pdo->prepare($count_sql);
$count_stmt->execute($categorie_filter ? [$categorie_filter] : []);
$total_produits = $count_stmt->fetchColumn();
$total_pages = ceil($total_produits / $items_par_page);

// Récupération des catégories distinctes pour le filtre
$categories = $pdo->query("SELECT DISTINCT categorie FROM produits")->fetchAll(PDO::FETCH_COLUMN);
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Catalogue Hydro Culture</title>
    <link href="../agriculteur/teste/categorie.css" rel="stylesheet" type="text/css">
    <style>
        .pagination {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }
        .pagination a {
            margin: 0 5px;
            padding: 5px 10px;
            border: 1px solid #ddd;
            text-decoration: none;
        }
        .pagination a.active {
            background-color: #2ecc71;
            color: white;
        }
        .filter-nav {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin: 20px 0;
        }
        .filter-nav a {
            margin: 5px 10px;
            padding: 5px 15px;
            background: #f4f4f4;
            border-radius: 20px;
            text-decoration: none;
        }
        .filter-nav a.active {
            background: #2ecc71;
            color: white;
        }
    </style>
</head>
<body>
<?php include('en_tete.php'); ?>

<main class="product-list">
    

    <!-- Grille des produits -->
    <div class="grid">
        <?php foreach ($produits as $p): ?>
        <div class="card">
            <img src="uploads/<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['nom']) ?>">
            <h3><?= htmlspecialchars($p['nom']) ?></h3>
            <p><?= htmlspecialchars($p['description']) ?></p>
            <p><strong><?= number_format($p['prix'], 0, ',', ' ') ?> FCFA</strong></p>
            <p><small>Catégorie: <?= htmlspecialchars($p['categorie']) ?></small></p>
            <form method="post" action="ajouter_panier.php">
                <input type="hidden" name="produit_id" value="<?= $p['id'] ?>">
                <button class="btn">Ajouter au panier</button>
            </form>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Filtres par catégorie -->
    <div class="filter-nav">
        <a href="?page=1" class="<?= !$categorie_filter ? 'active' : '' ?>">Tous</a>
        <?php foreach ($categories as $cat): ?>
            <a href="?categorie=<?= urlencode($cat) ?>&page=1" 
               class="<?= $categorie_filter === $cat ? 'active' : '' ?>">
                <?= htmlspecialchars($cat) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <?php if ($total_pages > 1): ?>
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?<?= $categorie_filter ? "categorie=$categorie_filter&" : '' ?>page=<?= $page-1 ?>">Précédent</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?<?= $categorie_filter ? "categorie=$categorie_filter&" : '' ?>page=<?= $i ?>" 
               class="<?= $i == $page ? 'active' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
            <a href="?<?= $categorie_filter ? "categorie=$categorie_filter&" : '' ?>page=<?= $page+1 ?>">Suivant</a>
        <?php endif; ?>
    </div>
    <?php endif; ?>

</main>


<?php
// Démarre la session pour accéder aux variables de session
session_start();

// Connexion à la base de données MySQL avec PDO
$pdo = new PDO('mysql:host=localhost;dbname=hydroculture;charset=utf8', 'root', '');

// Récupère tous les produits de la base de données triés par date d'ajout (du plus récent au plus ancien)
$produits = $pdo->query("SELECT * FROM produit ORDER BY date_ajout DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="grid">
        <?php foreach ($produits as $p): ?>
        <div class="card">
            <img src="uploads/<?= htmlspecialchars($p['image']) ?>" alt="Produit">
            <h3><?= htmlspecialchars($p['nom']) ?></h3>
            <p><?= htmlspecialchars($p['description']) ?></p>
            <p><strong><?= number_format($p['prix'], 0, ',', ' ') ?> FCFA</strong></p>
            <form method="post" action="ajouter_panier.php">
                <input type="hidden" name="produit_id" value="<?= $p['id'] ?>">
                <button class="btn">Ajouter au panier</button>
            </form>
        </div>
        <?php endforeach; ?>
      </div>

<footer class="secondary_header footer">
    <div class="copyright">&copy;2025 - <strong>Hydro Culture</strong></div>
</footer>
</body>
</html>