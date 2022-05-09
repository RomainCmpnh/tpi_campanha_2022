<?php
session_start();
include("../model/functions/produits_functions.php");


$page = filter_input(INPUT_GET, "page", FILTER_SANITIZE_STRING);

if (!isset($page) || isset($page) == null) {
    $page = 1;
}

$confMsg = 0;
$del = filter_input(INPUT_GET, "del", FILTER_SANITIZE_STRING);
if($del==1){
    if(isset($_SESSION["role"])){
        if($_SESSION["role"]=="admin"){
            $idToDelete = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);
            $idModel = getAllTshirtsById($idToDelete);
            $idModel = $idModel[0]["id_model"];
            delOrdertshirtByIdtshirt($idToDelete);
            delFavorisByIdtshirt($idToDelete);
            delTshirt($idToDelete);
            delModel($idModel);
            $confMsg = 1;
        }
    }
}



$new = filter_input(INPUT_GET, "new", FILTER_SANITIZE_STRING);
if($new == 1){
    $confMsg = 1;
}

$pageActu = $page; // Page actuelle
$result_par_page = 9; // Nombre d'article que l'on veut par page
$page_first_result = ($page - 1) * $result_par_page; // Premier article à afficher

// Récupère les T-shirt selon le filtre
$filtre = filter_input(INPUT_GET, "filter", FILTER_SANITIZE_STRING);
if ($filtre == "marque") {
    $allTshirts = getAlltshirtsOrderMarquePage($page_first_result, $result_par_page);
} else if ($filtre == "prixA") {
    $allTshirts = getAlltshirtsOrderPriceAPage($page_first_result, $result_par_page);
} else if ($filtre == "prixB") {
    $allTshirts = getAlltshirtsOrderPriceBPage($page_first_result, $result_par_page);
} else if($filtre == "favoris"){
    $allTshirts = getAlltshirtsOrderFavPage($_SESSION["idUser"], $page_first_result, $result_par_page);
} else{
    $allTshirts = getAllProductParPagesDate($page_first_result, $result_par_page);
    $filtre = "none";
}

// Ajoute au favoris
if(isset($_SESSION["role"])){
    $favId = filter_input(INPUT_GET, "add-fav", FILTER_SANITIZE_STRING);
    if(isset($favId)){
        if($favId!=null){
            $veriftshirt = getSpecificFav($_SESSION["idUser"], $favId);
            if($veriftshirt==null){
                addFav($_SESSION["idUser"], $favId);
            }
            else{
                deleteFav($_SESSION["idUser"], $favId);
            }
        }
    }
}


// Recherche d'article
$rien = false;
$recherche = filter_input(INPUT_GET, "recherche", FILTER_SANITIZE_STRING);
if ($recherche != null || $recherche != "") {
    $allTshirts = getAllTshirtsBySearch($recherche);
    if ($allTshirts == null) {
        $rien = true;
    }
    $filtre = "recherche";
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Catalogue - TshirtShop</title>
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
                        <li class="nav-item"><a class="nav-link" href="accueil.php">accueil</a></li>
                        <li class="nav-item"><a class="nav-link active" href="produits.php">produits</a></li>
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
    <main class="page catalog-page">
        <section class="clean-block clean-catalog dark">
            <div class="container">
                <div class="block-heading" style="font-family: 'Roboto Slab', serif;">
                    <p style="font-family: 'Roboto Slab', serif;font-size: 32px;color: rgb(0,0,0);">T-shirtShop</p>
                    <p>Voici nos super T-Shirts !</p>
                    <?php
                            if($confMsg==1){
                                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Succès!</strong> L\'action a été éxécutée!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>';
                            }
                        ?>
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
                                                        href="produits.php?filter=prixA">Prix &gt;</a><a
                                                        class="dropdown-item" href="produits.php?filter=prixB">Prix
                                                        &lt;</a><a class="dropdown-item"
                                                        href="produits.php?filter=marque">Marque</a><?php if(isset($_SESSION["role"])){ echo '<a
                                                        class="dropdown-item"
                                                        href="produits.php?filter=favoris">Favoris</a>';}?></div>
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

                                       // Regarde si le t-shirt est en favoris
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
                                                    { echo "produits.php?add-fav=".$item["id_tshirt"];}
                                                    else{
                                                        echo "connexion.php";
                                                    }
                                                    echo '"><i class="fa fa-star'.$fav.'" style="color: var(--warning);"></i></a>';
                                                    if (isset($_SESSION["role"])) {
                                                        if($_SESSION["role"]=="admin"){
                                                        echo '&nbsp;&nbsp;<a href="edit_tshirt.php?id='.$item["id_tshirt"].'">
                                                        <i class="fa fa-pencil" style="color: var(--orange);"></i></a>&nbsp;&nbsp;<a href="produits.php?del=1&id='.$item["id_tshirt"].'">
                                                        <i class="fa fa-trash" style="color: var(--danger);"></i></a></p>';
                                                    }
                                                }
                                                echo '</div>
                                                <div class="price">
                                                    <h3>' . $item["price"] . ' CHF</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                                        }
                                        ?>
                                    </div>
                                    <?php
                                    if ($filtre != "recherche") {
                                        echo '<nav><ul class="pagination">';

                                        $numberOfPage = getAllPagesProduct($result_par_page);
                                        if ($page >= 2) {
                                            echo '<li class="page-item"><a class="page-link" href="produits.php?filter=' . $filtre . '&page=' . ($page - 1) . '" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
                                        } else {
                                            echo '<li class="page-item disabled"><a class="page-link" href="produits.php?filter=' . $filtre . '&page=' . ($page - 1) . '" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
                                        }

                                        for ($pageN = 1; $pageN <= $numberOfPage; $pageN++) {
                                            echo '<li class="page-item';
                                            if ($pageActu == $pageN) {
                                                echo ' active';
                                            }
                                            echo '"><a class="page-link" href="produits.php?filter=' . $filtre . '&page=' . $pageN . '">' . $pageN . '</a></li>';
                                        }
                                        if ($page < $numberOfPage) {
                                            echo '<li class="page-item"><a class="page-link" href="produits.php?filter=' . $filtre . '&page=' . ($page + 1) . '" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
                                        } else {
                                            echo '<li class="page-item disabled"><a class="page-link" href="produits.php?filter=' . $filtre . '&page=' . ($page + 1) . '" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
                                        }

                                        echo '</ul></nav>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
            </div>
        </section>
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