<?php
session_start();

include("../model/functions/produits_functions.php");

// Verification de l'accès
if(!isset($_SESSION["role"])){
    header("Location: connexion.php");
}
else if($_SESSION["role"]!="admin"){
    header("Location: accueil.php");
}

// Récupération des données de le tshirt
$tshirtId = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);

$modele = filter_input(INPUT_POST, "modele", FILTER_SANITIZE_STRING);
$marque = filter_input(INPUT_POST, "marque", FILTER_SANITIZE_STRING);
$prix = filter_input(INPUT_POST, "prix", FILTER_SANITIZE_STRING);
$quantity = filter_input(INPUT_POST, "quantity", FILTER_SANITIZE_STRING);
$description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);

// Modification de le tshirt
$succes=0;
if($modele != null && $marque != null && $prix != null && $quantity != null && $description != null){

    $checkMarque = getBrandsByName($marque);
    $idModel = getAlltshirtsById($tshirtId);
    $idModel = $idModel[0]["id_model"];

    if($checkMarque==null)
    {
        $idBrand = addBrand($marque);
        updateModels($idModel, $modele, $idBrand);
        updatetshirt($tshirtId, $prix, $description, $quantity);
    }
    else{
        updatebrands($checkMarque[0]["id_brand"], $marque);
        updateModels($idModel, $modele, $checkMarque[0]["id_brand"]);
        updatetshirt($tshirtId, $prix, $description, $quantity);
    }
    $modelValue = $modele;
    $marqueValue = $marque;
    $priceValue = $prix;
    $quantityValue = $quantity;
    $descriptionValue = $description;
    $succes=1;
}
else{
    $anctshirt = getAlltshirtsById($tshirtId);
    $ancModel = getAllModelsById($anctshirt[0]["id_model"]);
    $ancBrand = getAllBrandsById($ancModel[0]["id_brand"]);

    $modelValue = $ancModel[0]["name"];
    $marqueValue = $ancBrand[0]["name"];
    $priceValue = $anctshirt[0]["price"];
    $quantityValue = $anctshirt[0]["quantity"];
    $descriptionValue = $anctshirt[0]["description"];
}


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Contact Us - TshirtShop</title>
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
            <div class="container"><a class="navbar-brand logo" href="accueil.php">TshirtShop</a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Activer la navigation</span><span class="navbar-toggler-icon"></span></button>
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
                <div class="block-heading"></div>
                <p style="font-family: 'Roboto Slab', serif;font-size: 31px;color: rgb(0,0,0);text-align: center;margin-bottom: 11px;">Modification</p>
                <form action="#" method="POST">
                        <?php
                            if($succes==1){ 
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Succès!</strong> La modification a été sauvegardée.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            }
                        ?>
                        <div class="form-group"><label for="name">Modèle</label><input class="form-control" type="text" id="name" name="modele" required value=<?php echo '"'.$modelValue.'"'; ?>></div>
                        <div class="form-group"><label for="subject">Marque</label><input class="form-control" type="text" id="subject" name="marque" required value=<?php echo '"'.$marqueValue.'"'; ?>></div>
                        <div class="form-group"><label for="prix">Prix</label><input class="form-control" type="number" name="prix" id="prix" min="0.05" step="0.05" required value=<?php echo '"'.$priceValue.'"'; ?>></div>
                        <div class="form-group"><label for="quantity">Quantity</label><input class="form-control" type="number" name="quantity" id="quantity" min="1" step="1" required value=<?php echo '"'.$quantityValue.'"'; ?>></div>
                        <div class="form-group"><label for="message">Description</label><textarea class="form-control" id="message" name="description" required><?php echo $descriptionValue; ?></textarea></div>
                        <div class="form-group"><button class="btn btn-primary btn-block" type="submit" style="background: rgb(0,0,0);border-color: rgb(0,0,0);">Modifier</button></div>
                    </form>
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