<?php
session_start();

include("../model/functions/produits_functions.php");

// Verification de l'accès
if(!isset($_SESSION["role"])){
    header("Location: connexion.php");
    exit;
}
else if($_SESSION["role"]!="admin"){
    header("Location: accueil.php");
    exit;
}

// Recuperation des données du nouveau tshirt
$modele = filter_input(INPUT_POST, "modele", FILTER_SANITIZE_STRING);
$marque = filter_input(INPUT_POST, "marque", FILTER_SANITIZE_STRING);
$prix = filter_input(INPUT_POST, "prix", FILTER_SANITIZE_STRING);
$description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);
$quantity = filter_input(INPUT_POST, "quantity", FILTER_SANITIZE_STRING);

// Ajout de du nouveau tshirt
if($modele != null && $marque != null && $prix != null && $description != null && $quantity != null){
    $checkMarque = getBrandsByName($marque);
    if($checkMarque==null)
    {
        $idBrand = addBrand($marque);
        $idModel = addModel($modele, $idBrand[1]);
        addTshirt($idModel[1], $prix, $description, $quantity);
    }
    else{
        $marqueId = $checkMarque[0]["id_brand"];
        $idModel = addModel($modele, $marqueId);
        addTshirt($idModel[1], $prix, $description, $quantity);
    }
    header("Location: produits.php?new=1");
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Contact Us - E-Tshirt</title>
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
            <div class="container"><a class="navbar-brand logo" href="accueil.php">E-Tshirt</a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Activer la navigation</span><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link" href="accueil.php">accueil</a></li>
                        <li class="nav-item"><a class="nav-link" href="produits.php">produits</a></li>
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
    <main class="page contact-us-page">
        <section class="clean-block clean-form dark">
            <div class="container">
                <div class="block-heading">
                    <p style="font-family: 'Roboto Slab', serif;font-size: 35px;color: rgb(0,0,0);text-align: center;">Ajouter un produit</p>
                </div>
                <form action="#" method="POST">
                    <div class="form-group"><label for="name">Modèle</label><input class="form-control" type="text" id="name" name="modele" required></div>
                    <div class="form-group"><label for="subject">Marque</label><input class="form-control" type="text" id="subject" name="marque" required></div>
                    <div class="form-group"><label for="email">Prix</label><input class="form-control" type="number" name="prix" required></div>
                    <div class="form-group"><label for="quantity">Quantité</label><input class="form-control" type="number" name="quantity" required min="1" step="1"></div>
                    <div class="form-group"><label for="message">Description</label><textarea class="form-control" id="message" name="description" required></textarea></div>
                    <div class="form-group"><button class="btn btn-primary btn-block" type="submit" style="background: rgb(0,0,0);border-color: rgb(0,0,0);" required>Ajouter</button></div>
                </form>
            </div>
        </section>
    </main>
    <footer class="page-footer dark">
        <div class="footer-copyright">
            <p>© 2022 E-Tshirt - All right reserved</p>
        </div>
    </footer>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.js"></script>
    <script src="assets/js/smoothproducts.min.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>