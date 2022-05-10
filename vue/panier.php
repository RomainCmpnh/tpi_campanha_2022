<?php
session_start();

include("../model/functions/produits_functions.php");
include("../model/functions/utilisateurs_functions.php");

// Lors de la modification
$idModif = filter_input(INPUT_POST, "id", FILTER_SANITIZE_STRING);
$quantityModif = filter_input(INPUT_POST, "quantity", FILTER_SANITIZE_STRING);

if($idModif!==null && $quantityModif !==null){
    // Recherche dans le tableau les index
    $pos = array_search($idModif, $_SESSION["panier"]);
    while($pos!==false && isset($_SESSION["panier"])){
        if(count($_SESSION["panier"])>1){
            if($idModif==0){
                $removeIndex0 = array_shift($_SESSION["panier"]);
            }
            else{
            unset($_SESSION["panier"][$pos]);
            }
        }
        else{
            $_SESSION["panier"]=null;
        }
        if(isset($_SESSION["panier"])){
        $pos = array_search($idModif, $_SESSION["panier"]);
        }
    }

    if($quantityModif!=0){
        for($i=0;$i<$quantityModif;$i++){
            if(isset($_SESSION["panier"])){
                array_push($_SESSION["panier"], $idModif);
            }
            else{
                $_SESSION["panier"] = array($idModif);
            }
        }
    }
}


// Savoir si le panier est vide ou non
$remplie = true;
if(isset($_SESSION["panier"])){
    if($_SESSION["panier"]!=null){
        $remplie = true;
    }
    else{
        $remplie = false;
    }
}
else{
    $remplie = false;
}

// Renvois a la facture
$error = false;

$envois = filter_input(INPUT_POST, "envois", FILTER_SANITIZE_STRING);
if($envois==1){
    if($_SESSION["role"]=="admin"){
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        $check = getAllUsersByEmail($email);
        if($check!=null){
            header("Location: facture.php?user=".$email);
        }
        else{
            $error = true;
        }
    }
    else{
        header("Location: facture.php");
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Shopping Cart - E-Tshirt</title>
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
            <div class="container"><a class="navbar-brand logo" href="accueil.php">E-Tshirt</a><button
                    data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Activer
                        la navigation</span><span class="navbar-toggler-icon"></span></button>
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
                        <li class="nav-item"><a class="nav-link active" href="panier.php"><i
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
    <main class="page shopping-cart-page">
        <section class="clean-block clean-cart dark">
            <div class="container">
                <div class="block-heading">
                    <p style="font-family: 'Roboto Slab', serif;font-size: 31px;color: rgb(0,0,0);text-align: center;margin-bottom: 11px;">Panier</p>
                    <p>Vos articles vous attendent !</p>
                </div>
                <div class="content">
                    <div class="row no-gutters">
                        <div class="col-md-12 col-lg-8">
                            <div class="items">
                            <?php
                                    if($remplie==true){
                                    sort($_SESSION["panier"]);
                                    $ancItem = null;
                                    $total = 0;
                                    $occurence = array_count_values($_SESSION["panier"]);
                                    foreach ($_SESSION["panier"] as $item) {
                                        if ($ancItem != $item) {

                                            // Récupère la t-shirt
                                            $tshirt = getAlltshirtsById($item);

                                            // Récupère le model de la t-shirt
                                            $model = getAllModelsById($tshirt[0]["id_model"]);

                                            // Récupère la marque de la t-shirt
                                            $marque = getAllBrandsById($model[0]["id_brand"]);

                                            echo '<form method="POST" action="#"><div class="product">
                                            <input type="hidden" value="'.$tshirt[0]["id_tshirt"].'" name="id">
                                            <div class="row justify-content-center align-items-center">
                                                <div class="col-md-3">
                                                    <div class="product-image"><img class="img-fluid d-block mx-auto image" src="assets/img/my-images/product/tshirt.jpg"></div>
                                                </div>
                                                <div class="col-md-5 product-info"><a class="product-name" href="page-du-produit.php?id=' . $tshirt[0]["id_tshirt"] . '">' . $model[0]["name"] . '</a>
                                                    <div class="product-specs">
                                                        <div><span>Marque:&nbsp;</span><span class="value">' . $marque[0]["name"] . '</span></div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-2 quantity"><label class="d-none d-md-block" for="quantity">Quantité</label><input type="number" id="number" class="form-control quantity-input" min="0" name="quantity" value="' . $occurence[$item] . '"></div>
                                                <div class="col-6 col-md-2 price"><span>' . $tshirt[0]["price"] . '.-</span></div>
                                            </div>
                                        </div>
                                        <input class="btn btn-success btn-block btn-lg" type="submit" value="Sauvegarder les modifications">
                                    </form>';
                                            $total += ($tshirt[0]["price"] * $occurence[$item]);
                                        }
                                        $ancItem = $item;
                                    }
                                }
                                else{
                                    echo "<h3>Votre panier est vide.</h3>";
                                }
                                    ?>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <div class="summary">
                                <h3>Aperçu</h3>
                                <?php
                                    if($error==true){
                                        echo '<div class="alert alert-danger" role="alert">
                                        L\'utilisateur n\'a pas été trouvé!
                                      </div>';
                                    }
                                    ?>
                                    <h4><span class="text">Montant de la commande</span><span
                                            class="price"><?php if($remplie==true){echo $total . ".-"; }else{echo "0.-";}?></span>
                                    </h4>
                                    <h4><span class="text">Total</span><span
                                            class="price"><?php if($remplie==true){echo $total . ".-";}else{echo "0.-";} ?></span>
                                    </h4>
                                    <form action="#" method="POST">
                                    <?php if (isset($_SESSION["role"])) {
                                        if($_SESSION["role"]=="admin"){
                                        echo '<div class="form-group" style="margin-top: 1%;"><label for="email">Email de l\'utilisateur :&nbsp;</label><input type="email" id="email" class="item" name="email" required></div>';
                                        }
                                    } ?>
                                    <input type="hidden" value="1" name="envois">
                                    <button class="btn btn-primary btn-block btn-lg" type="submit" style="background: rgb(0,0,0);border-color: rgb(0,0,0);" <?php if($remplie==false){echo 'disabled';} ?>>Commander</button>  </div>
                                </form>
                        </div>
                    </div>
                </div>
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