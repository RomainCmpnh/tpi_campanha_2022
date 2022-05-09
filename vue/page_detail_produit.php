<?php
session_start();

include("../model/functions/produits_functions.php");


// Récupère le t-shirt via l'id
$idtshirt = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);
$alltshirts = null;
$erreur = false;
if (isset($idtshirt) && isset($idtshirt) != null) {
    $alltshirts = getAllTshirtsById($idtshirt);
}
if ($alltshirts == null) {
    $erreur = true;
} else {
    // Récupère le model du t-shirt
    $model = getAllModelsById($alltshirts[0]["id_model"]);
    // Récupère la marque de la t-shirt
    $marque = getAllBrandsById($model[0]["id_brand"]);
    // Regarde s'il reste des t-shirts ou non
    $epuise = false;
    if ($alltshirts[0]["quantity"] < 1) {
        $messageQuantity = '<p style="color: rgb(255, 0, 0);">Non disponible</p>';
        $epuise = true;
    } else if ($alltshirts[0]["quantity"] < 5) {
        $messageQuantity = '<p style="color: rgb(255, 132, 0);">' . $alltshirts[0]["quantity"] . ' réstante.</p>';
    } else {
        $messageQuantity = '<p style="color: rgb(35,174,0);">Disponible</p>';
    }
}

$isAdd = false;
// Ajoutte au panier
$ajoutPanier = filter_input(INPUT_POST, "add-panier", FILTER_SANITIZE_STRING);
if (isset($ajoutPanier) == 1) {
    if (isset($_SESSION["panier"])) {
        array_push($_SESSION["panier"], $idtshirt);
    } else {
        $_SESSION["panier"] = array($idtshirt);
    }
    $newQuantity = ($alltshirts[0]["quantity"])-1;
    updateQuantitytshirts($newQuantity, $idtshirt);
    $isAdd = true;
    $alltshirts = getAllTshirtsById($idtshirt);
    if ($alltshirts[0]["quantity"] < 1) {
        $messageQuantity = '<p style="color: rgb(255, 0, 0);">Non disponible</p>';
        $epuise = true;
    } else if ($alltshirts[0]["quantity"] < 5) {
        $messageQuantity = '<p style="color: rgb(255, 132, 0);">' . $alltshirts[0]["quantity"] . ' réstante.</p>';
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Product - TshirtShop</title>
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
            <div class="container"><a class="navbar-brand logo" href="accueil.php">TShirtShop</a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Activer la navigation</span><span class="navbar-toggler-icon"></span></button>
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
                        <li class="nav-item"><a class="nav-link" href="panier.php"><i class="la la-shopping-cart"></i>Panier</a></li>
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
    <main class="page product-page">
        <section class="clean-block clean-product dark">
            <div class="container">
                <div class="block-heading"></div>
                <div class="block-content">
                    <div class="product-info">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="gallery">
                                    <div class="sp-wrap"><a href="assets/img/my-images/product/tshirt.jpg"><img class="img-fluid d-block mx-auto" src="assets/img/my-images/product/tshirt.jpg"></a><a href="assets/img/my-images/product/tshirt.jpg"><img class="img-fluid d-block mx-auto" src="assets/img/my-images/product/tshirt.jpg"></a><a href="assets/img/my-images/product/tshirt.jpg"><img class="img-fluid d-block mx-auto" src="assets/img/my-images/product/tshirt.jpg"></a></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info">
                                <?php
                                        if($isAdd==true){
                                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Le produit a été ajouté!</strong>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>';
                                        }
                                    ?>
                                        <h3><?php echo $model[0]["name"]; ?></h3>
                                        <h5><?php echo $marque[0]["name"]; ?></h5>
                                        <div class="rating">
                                            <?php echo $messageQuantity; ?>
                                        </div>
                                        <div class="price">
                                            <h3><?php echo $alltshirts[0]["price"] . ' CHF'; ?></h3>
                                        </div>
                                        <form action="page_detail_produit.php?id=<?php echo $idtshirt; ?>" method="POST">
                                            <input type="hidden" name="add-panier" value="1">
                                            <button class="btn btn-<?php if ($epuise == true) {
                                                                        echo "danger";
                                                                    } else {
                                                                        echo "primary";
                                                                    } ?>" type="submit" <?php if ($epuise == true) {
                                                     echo "disabled";
                                            } ?>><i class="icon-basket"></i>Ajouter au panier</button>
                                        </form>
                                        <div class="summary">
                                            <p><?php echo $alltshirts[0]["description"]; ?></p>
                                        </div>
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