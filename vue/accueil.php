<?php
session_start();
include("../model/functions/produits_functions.php");

// Regarde si on doit afficher un message pour confirmer l'inscription d'un nouveau membre (voir inscription.php)
$new = filter_input(INPUT_GET, "new", FILTER_SANITIZE_STRING);
$newmessage = false;
if (isset($new) == 1) {
    $newmessage = true;
}

// Ajoute au favoris
//if(isset($_SESSION["role"])){
//$favId = filter_input(INPUT_GET, "add-fav", FILTER_SANITIZE_STRING);
//if(isset($favId)){
//    if($favId!=null){
//        $verifTshirt = getSpecificFav($_SESSION["idUser"], $favId);
//        if($verifTshirt==null){
//            addFav($_SESSION["idUser"], $favId);
//        }
//        else{
//            deleteFav($_SESSION["idUser"], $favId);
//        }
 //   }
//}
//}

// Récupère les tshirts selon le filtre
$filtre = filter_input(INPUT_GET, "filter", FILTER_SANITIZE_STRING);
if ($filtre == "marque") {
    $allTshirts = getAllTshirtsOrderMarque();
} else if ($filtre == "prixA") {
    $allTshirts = getAllTshirtsOrderPriceA();
} else if ($filtre == "prixB") {
    $allTshirts = getAllTshirtsOrderPriceB();
} else if($filtre == "favoris"){
    if(isset($_SESSION["role"])){
        $allTshirts = getAllTshirtsOrderFav($_SESSION["idUser"]);
    }
} else {
    $allTshirts = getAllTshirtsOrderNew();
}

// Recherche d'article
$rien = false;
$recherche = filter_input(INPUT_GET, "recherche", FILTER_SANITIZE_STRING);
if ($recherche != null || $recherche != "") {
    $allTshirts = getAllTshirtsBySearch($recherche);
    if ($allTshirts == null) {
        $rien = true;
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Home - TshirtShop</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Slab&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/line-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.css">
    <link rel="stylesheet" href="assets/css/smoothproducts.css">
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-white clean-navbar">
            <div class="container"><a class="navbar-brand logo" href="accueil.php">TshirtShop</a><button
                    data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Activer
                        la navigation</span><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link active" href="accueil.php">accueil</a></li>
                        <li class="nav-item"><a class="nav-link" href="produits.php">produits</a></li>
                        <?php if (!isset($_SESSION["role"])) {
                            echo '<li class="nav-item"><a class="nav-link" href="connexion.php">Connexion</a></li>
                        <li class="nav-item"><a class="nav-link" href="inscription.php">Inscription</a></li>';
                        } else {
                            echo '<li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>';
                        }
                        ?>
                        <li class="nav-item"><a class="nav-link" href="panier.php"><i
                                    class="la la-shopping-cart"></i>Panier</a></li>
                        <?php
                        if (isset($_SESSION["role"])) {
                            if($_SESSION["role"]== "admin"){
                            echo '<li class="nav-item"><a class="nav-link" href="utilisateurs.php">Utilisateurs</a></li>
                        <li class="nav-item"><a class="nav-link" href="commandes.php">Commandes</a></li>';
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
    <main class="page landing-page">
        <section class="clean-block clean-hero" style="color: rgba(0,0,0,0.85);background: url(&quot;assets/img/my-images/banner.jpg&quot;);">
            <div class="text">
                <h2 style="font-family: 'Roboto Slab', serif;height: 49px;width: 215.641px;font-size: 38px;">T-shirtShop</h2>
                <p style="font-family: 'Roboto Slab', serif;">Disponible maintenant !</p><button class="btn btn-outline-light btn-lg" type="button">Voir nos articles</button>
            </div>
        </section>
        <section class="clean-block clean-catalog dark">
            <div class="container">
                <div class="block-heading">
                    <p style="font-family: 'Roboto Slab', serif;font-size: 32px;color: rgb(0,0,0);">T-shirtShop</p>
                    <p style="font-family: 'Roboto Slab', serif;">Voici nos super T-shirts !</p>
                </div>
                <div class="content">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="d-none d-md-block">
                                <div class="filters">
                                    <div class="filter-item">
      
                                        <h3>Trier</h3>
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle" aria-expanded="false" data-toggle="dropdown" type="button" style="background: rgb(0,0,0);border-color: rgb(0,0,0);">
                                                    <?php 
                                                    if ($filtre == "marque" || $filtre == "prixA" || $filtre == "prixB" || $filtre == "favoris") {
                                                        echo $filtre;
                                                        } 
                                                        else {
                                                            echo "Date";
                                                    } ?>
                                                </button>
                                                <div class="dropdown-menu"><a class="dropdown-item"
                                                        href="accueil.php?filter=prixA">Prix &gt;</a><a
                                                        class="dropdown-item" href="accueil.php?filter=prixB">Prix
                                                        &lt;</a><a class="dropdown-item"
                                                        href="accueil.php?filter=marque">Marque</a><?php if(isset($_SESSION["role"])){ echo '<a
                                                        class="dropdown-item"
                                                        href="accueil.php?filter=favoris">Favoris</a>';}?></div>
                                            </div>
                                    </div>
                                    <div class="filter-item">
                                        
                                        <form action="#" method="GET">
                                                    <h3>Rechercher</h3><input type="text" name="recherche"><input
                                                        type="submit" class="btn btn-primary" type="button"
                                                        style="margin-top: 3%;background: rgb(0,0,0);border-color: rgb(0,0,0);" value="Rechercher">
                                                </form>
                                    </div>
                                    <div class="filter-item">
                                    <?php
                                        if (isset($_SESSION["role"])) {
                                            if($_SESSION["role"]=="admin"){
                                                echo '<div class="filter-item">
                                    <h3>Admin</h3><a href="add_tshirt.php"><button class="btn btn-warning" type="button">Ajouter un produit</button></a>
                                </div>';
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="d-md-none"><a class="btn btn-link d-md-none filter-collapse" data-toggle="collapse" aria-expanded="false" aria-controls="filters" href="#filters" role="button">Filters<i class="icon-arrow-down filter-caret"></i></a>
                                <div class="collapse" id="filters">
                                    <div class="filters">
                                        <div class="filter-item">
                                            <h3 style="font-size: 24px;">Trier</h3>
                                            <div class="dropdown"><button class="btn btn-primary dropdown-toggle" aria-expanded="false" data-toggle="dropdown" type="button" style="background: rgb(0,0,0);border-color: rgb(0,0,0);">Date</button>
                                                <div class="dropdown-menu"><a class="dropdown-item" href="#">Prix &gt;</a><a class="dropdown-item" href="#">Prix &lt;</a><a class="dropdown-item" href="#">Marque</a><a class="dropdown-item" href="#">Favoris</a></div>
                                            </div>
                                        </div>
                                        <div class="filter-item">
                                            <h3 style="font-size: 24px;">Rechercher</h3><input type="text"><button class="btn btn-primary" type="button" style="margin-top: 3%;background: rgb(0,0,0);border-color: rgb(0,0,0);">Rechercher</button>
                                        </div>
                                        <?php
                                        if (isset($_SESSION["role"])) {
                                            if($_SESSION["role"]=="admin"){
                                                echo '<div class="filter-item">
                                    <h3>Admin</h3><a href="add_tshirt.php"><button class="btn btn-warning" type="button">Ajouter un produit</button></a>
                                </div>';
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                                <div class="products">
                                    <div class="row no-gutters">
                                        <?php
                                        if ($rien == true) {
                                            echo "<p>Nous n’avons trouvé aucun résultat pour <b>'" . $recherche . "'</b></p>";
                                        }
                                        foreach ($allTshirts as $item) {

                                            // Récupère le model de la casquette
                                            $model = getAllModelsById($item["id_model"]);

                                            // Récupère la marque de la casquette
                                            $marque = getAllBrandsById($model[0]["id_brand"]);

                                            // Regarde s'il reste des tshirts ou non
                                            if ($item["quantity"] < 1) {
                                                $messageQuantity = '<p style="color: rgb(255, 0, 0);">Non disponible</p>';
                                            } else if ($item["quantity"] < 5) {
                                                $messageQuantity = '<p style="color: rgb(255, 132, 0);">' . $item["quantity"] . ' réstante.</p>';
                                            } else {
                                                $messageQuantity = '<p style="color: rgb(35,174,0);">Disponible</p>';
                                            }

                                            // Regarde si le tshirt est en favoris
                                            if(isset($_SESSION["role"])){
                                            $veriftshirt = getSpecificFav($_SESSION["idUser"], $item["id_tshirt"]);
                                            if($veriftshirt!=null){
                                                $fav = "";
                                            }
                                            else{
                                                $fav = "-o";
                                            }
                                        }
                                        else{
                                            $fav="-o";
                                        }

                                            // Affiche le tshirt
                                            echo '<div class="col-12 col-md-6 col-lg-4">
                                        <div class="clean-product-item">
                                            <div class="image"><a href="page_detail_produit.php?id=' . $item["id_tshirt"] . '"><img class="img-fluid d-block mx-auto" src="assets/img/my-images/product/tshirt.jpg"></a></div>
                                            <div class="product-name"><a href="page_detail_produit.php?id=' . $item["id_tshirt"] . '">' . $model[0]["name"] . '</a>
                                                <p>' . $marque[0]["name"] . '</p>
                                            </div>
                                            <div class="about">
                                                <div class="rating">
                                                    ' . $messageQuantity . '<p><a href="';
                                                    if(isset($_SESSION["role"]))
                                                    { echo "accueil.php?add-fav=".$item["id_tshirt"];}
                                                    else{
                                                        echo "connexion.php";
                                                    }
                                                    echo '"><i class="fa fa-star'.$fav.'" style="color: var(--warning);"></i></a>';
                                                echo '</div>
                                                <div class="price">
                                                    <h3>' . $item["price"] . '.-</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="clean-block clean-info dark">
            <div class="container">
                <div class="block-heading">
                    <p style="font-family: 'Roboto Slab', serif;font-size: 32px;color: rgb(0,0,0);">Informations</p>
                    <p>Qui sommes nous ?</p>
                </div>
                <div class="row align-items-center">
                    <div class="col-md-6"><img class="img-thumbnail" src="assets/img/my-images/home/who-are.jpg"></div>
                    <div class="col-md-6">
                        <h3>T-shirtShop</h3>
                        <div class="getting-started-info">
                            <p>T-shirtShop est une super boutique qui ouvre enfin ses portes à Genève ! Vous y trouverez un gigantesque choix de T-shirts. Commandez vos T-shirts sur notre site.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="clean-block features">
            <div class="container">
                <div class="block-heading">
                    <p style="font-family: 'Roboto Slab', serif;font-size: 32px;color: rgb(0,0,0);">Nous vous garantissons</p>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-5 feature-box">
                        <h4>La rapidité</h4>
                        <p>Notre site web est très performant et assure une disponibilité instantanée des produits sélectionné</p>
                    </div>
                    <div class="col-md-5 feature-box">
                        <h4>La plus vaste sélection&nbsp;</h4>
                        <p>Notre boutique de T-shirt possède le plus grand choix de Genève.</p>
                    </div>
                    <div class="col-md-5 feature-box">
                        <h4>Le prix</h4>
                        <p>C'est moins chère qu'ailleurs !</p>
                    </div>
                    <div class="col-md-5 feature-box">
                        <h4>Un service efficace</h4>
                        <p>Une question ? notre équipe sera heureuse de vous répondre et de vous aider</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="clean-block about-us"></section>
    </main>
    <footer class="page-footer dark">
        <div class="footer-copyright">
            <p>© 2022 TshirtShop - All right reserved</p>
        </div>
    </footer>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.js"></script>
    <script src="assets/js/smoothproducts.min.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>