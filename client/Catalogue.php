<?php 
    require('config.php');
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Simple Theme</title>
<link href="../agriculteur/teste/categorie.css" rel="stylesheet" type="text/css">
<style>
  /* la mise en forme du bouton vendre un produit */
  .add-product-button {
      text-align: right;
      margin: 20px 0;
    }
    .btn-sell-product {
      display: inline-block;
      padding: 10px 20px;
      background-color: #28a745;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
      font-size: 16px;
    }
    .btn-sell-product:hover {
      background-color: #218838;
    }

    /* Style du bouton hamburger */
    .menu-btn {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            width: 30px;
            height: 21px;
            cursor: pointer;
            position: relative;
            z-index: 100;
        }
        
        .menu-btn span {
            display: block;
            width: 100%;
            height: 3px;
            background-color: #333;
            transition: all 0.3s ease;
        }
        
        /* Animation du bouton quand le menu est ouvert */
        .menu-btn.active span:nth-child(1) {
            transform: translateY(9px) rotate(45deg);
        }
        
        .menu-btn.active span:nth-child(2) {
            opacity: 0;
        }
        
        .menu-btn.active span:nth-child(3) {
            transform: translateY(-9px) rotate(-45deg);
        }
        
        /* Style du menu déroulant */
        .dropdown-menu {
            position: absolute;
            top: 50px;
            left: 0;
            width: 200px;
            background-color: white;
            box-shadow: 0 5px 10px rgba(0,0,0,0.1);
            border-radius: 5px;
            padding: 10px 0;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }
        
        .dropdown-menu.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .dropdown-menu ul {
            list-style: none;
        }
        
        .dropdown-menu li {
            padding: 10px 20px;
            transition: background-color 0.3s;
        }
        
        .dropdown-menu li:hover {
            background-color: #f0f0f0;
        }
        
        .dropdown-menu a {
            text-decoration: none;
            color: #333;
            font-size: 16px;
        }
        
        /* Conteneur pour le positionnement */
        .menu-container {
            position: relative;
            display: inline-block;
        }

  </style>
</head>
<body>
<?php 
    include('en_tete.php');
?>
    <div class="menu-container">
      <!-- Bouton hamburger -->
      <div class="menu-btn" id="menuBtn">
          <span></span>
          <span></span>
          <span></span>
      </div>
      
      <!-- Menu déroulant -->
      <div class="dropdown-menu" id="dropdownMenu">
          <ul>
              <li><a href="#">Accueil</a></li>
              <li><a href="#">Services</a></li>
              <li><a href="#">Produits</a></li>
              <li><a href="#">Contact</a></li>
              <li><a href="#">À propos</a></li>
          </ul>
      </div>
  </div>

  <script>
      // Récupération des éléments
      const menuBtn = document.getElementById('menuBtn');
      const dropdownMenu = document.getElementById('dropdownMenu');
      
      // Gestion du clic sur le bouton
      menuBtn.addEventListener('click', function() {
          // Basculer la classe 'active' sur le bouton et le menu
          this.classList.toggle('active');
          dropdownMenu.classList.toggle('active');
      });
      
      // Fermer le menu quand on clique ailleurs
      document.addEventListener('click', function(e) {
          if (!menuBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
              menuBtn.classList.remove('active');
              dropdownMenu.classList.remove('active');
          }
      });
  </script>
  <div class="add-product-button">
    <a href="ajouter_produit.php" class="btn-sell-product">Vendre un produit</a>
  </div>
  
  <main class="product-list">
  
      

  <div class="product-card">
    <img src="../images/image_catal/basilic.jfif" alt="Basilic">
    <h3>BASILIC</h3>
    <p>300 FCFA / pièce</p>
    
    <form method="POST" action="ajouter_panier.php">
        <input type="hidden" name="produit_id" value="1"> <!-- ID réel du produit -->
        <input type="hidden" name="produit_nom" value="BASILIC">
        <input type="hidden" name="produit_prix" value="300">
        <input type="hidden" name="quantite" value="1">
        <button type="submit" name="ajouter_panier">Ajouter au panier</button>
    </form>
  </div>

      <div class="product-card">
        <img src="../images/image_catal/epinard2.jpg" alt="Epinard">
        <h3>Epinard</h3>
        <p>300 FCFA / pièce</p>
        <button class="add-to-cart" name="ajouter_panier">Ajouter au panier</button>
      </div>
      

      <div class="product-card">
        <img src="../images/image_catal/kale(chou frise).jfif" alt="Kale(Chou frise)">
        <h3>KALE(CHOU FRISE)</h3>
        <p>300 FCFA / pièce</p>
        <button class="add-to-cart">Ajouter au panier</button>
      </div>
    
      <div class="product-card">
        <img src="../images/image_catal/coriandre2.webp" alt="coriandre">
        <h3>Coriandre</h3>
        <p>300 FCFA / pièce</p>
        <button class="add-to-cart">Ajouter au panier</button>
      </div>

      <!-- Section Légumes Feuilles -->

    
      <div class="product-card">
        <img src="../images/image_catal/laitue 1.jpg" alt="" class="product-image">
        <h4>LAITUE</h4>
        <p>500 FCFA / pièce</p>
        <button class="add-to-cart">Ajouter au panier</button>
      </div>

      <div class="product-card">
        <img src="../images/image_catal/menthes2.jfif" alt="" class="product-image">
        <h4>MENTHE</h4>
        <p>400 FCFA / bouquet</p>
        <button class="add-to-cart">Ajouter au panier</button>
      </div>

      <div class="product-card">
        <img src="../images/image_catal/persil.jfif" alt="" class="product-image">
        <h4>PERSIL</h4>
        <p>350 FCFA / bouquet</p>
        <button class="add-to-cart">Ajouter au panier</button>
      </div>

      <div class="product-card">
        <img src="../images/image_catal/roquette.jpg" alt="" class="product-image">
        <h4>ROQUETTE</h4>
        <p>450 FCFA / portion</p>
        <button class="add-to-cart">Ajouter au panier</button>
      </div>



  <!-- Section Fruits et Légumes -->

    
      <div class="product-card">
        <img src="../images/image_catal/plante de tomates1.jpg" alt="" class="product-image">
        <h4>TOMATE</h4>
        <p>800 FCFA / kg</p>
        <button class="add-to-cart">Ajouter au panier</button>
      </div>

      <div class="product-card">
        <img src="../images/image_catal/concombre3.jpg" alt="" class="product-image">
        <h4>CONCOMBRE</h4>
        <p>600 FCFA / pièce</p>
        <button class="add-to-cart">Ajouter au panier</button>
      </div>

      <div class="product-card">
        <img src="../images/image_catal/poivron plante.jpg" alt="" class="product-image">
        <h4>POIVRON</h4>
        <p>700 FCFA / pièce</p>
        <button class="add-to-cart">Ajouter au panier</button>
      </div>

      <div class="product-card">
        <img src="../images/image_catal/radis.webp" alt="" class="product-image">
        <h4>RADIS</h4>
        <p>300 FCFA / botte</p>
        <button class="add-to-cart">Ajouter au panier</button>
      </div>
    
  </section>

  <!-- Section Plantes Ornementales -->

    
      <div class="product-card">
        <img src="../images/image_catal/fougeres1.jpg" alt="" class="product-image">
        <h4>FOUGERES</h4>
        <p>2500 FCFA / pot</p>
        <button class="add-to-cart">Ajouter au panier</button>
      </div>

      <div class="product-card">
        <img src="../images/image_catal/orchidees2.jpg" alt="" class="product-image">
        <h4>ORCHIDÉES</h4>
        <p>5000 FCFA / pot</p>
        <button class="add-to-cart">Ajouter au panier</button>
      </div>

      <div class="product-card">
        <img src="../images/image_catal/pothos.jpg" alt="" class="product-image">
        <h4>POTHOS</h4>
        <p>3500 FCFA / pot</p>
        <button class="add-to-cart">Ajouter au panier</button>
      </div>

      <div class="product-card">
        <img src="../images/image_catal/lys.jfif" alt="" class="product-image">
        <h4>LYS DE PAIX</h4>
        <p>4000 FCFA / pot</p>
        <button class="add-to-cart">Ajouter au panier</button>
      </div>
    
  </section>

  <!-- Section Plantes Médicinales -->

    
      <div class="product-card">
        <img src="../images/image_catal/aloevera1.jfif" alt="" class="product-image">
        <h4>ALOE VERA</h4>
        <p>3000 FCFA / pot</p>
        <button class="add-to-cart">Ajouter au panier</button>
      </div>

      <div class="product-card">
        <img src="../images/image_catal/melisse.jfif" alt="" class="product-image">
        <h4>MÉLISSE</h4>
        <p>1500 FCFA / pot</p>
        <button class="add-to-cart">Ajouter au panier</button>
      </div>

      <div class="product-card">
        <img src="../images/image_catal/thym2.jfif" alt="" class="product-image">
        <h4>THYM</h4>
        <p>1200 FCFA / pot</p>
        <button class="add-to-cart">Ajouter au panier</button>
      </div>

      <div class="product-card">
        <img src="../images/image_catal/romarin.jpg" alt="" class="product-image">
        <h4>ROMARIN</h4>
        <p>1500 FCFA / pot</p>
        <button class="add-to-cart">Ajouter au panier</button>
      </div>
    
      

      
  </main>

  <script>
        // Animation clic sur "Ajouter au panier"
        const buttons = document.querySelectorAll('.add-to-cart');
        buttons.forEach(btn => {
            btn.addEventListener('click', () => {
                btn.textContent = "✔️ Ajouté !";
                btn.disabled = true;
                setTimeout(() => {
                    btn.textContent = "Ajouter au panier";
                    btn.disabled = false;
                }, 1500);
            });
        });
    </script>
  
<footer class="secondary_header footer">
    <div class="copyright">&copy;2025 - <strong>Hydro Culture</strong></div>
</footer>
</body>
</html>
