<?php
session_start();

include("../model/functions/produits_functions.php");
include("../model/functions/utilisateurs_functions.php");

// Verification de l'accès
if(!isset($_SESSION["role"]))
{
    header("Location: connexion.php");
    exit;
}
else if($_SESSION["role"]==null){
    header("Location: connexion.php");
    exit;
}

if($_SESSION["role"]=="admin"){
    $email = filter_input(INPUT_GET, "user", FILTER_SANITIZE_EMAIL);
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
    <main class="page shopping-cart-page">
        <section class="clean-block clean-cart dark">
            <div class="container">
                <div class="block-heading">
                    <p style="font-family: 'Roboto Slab', serif;font-size: 31px;color: rgb(0,0,0);text-align: center;margin-bottom: 11px;">Facture</p>
                    <p>Voici un résumé de votre commande.</p>
                </div>
                <div class="content">
                    <div class="row no-gutters">
                        <div class="col-md-12 col-lg-8">
                            <div class="items">
                                <?php
                                sort($_SESSION["panier"]);
                                    $ancItem = null;
                                    $total = 0;
                                    $occurence = array_count_values($_SESSION["panier"]);
                                    foreach ($_SESSION["panier"] as $item) {
                                        if ($ancItem != $item) {

                                            // Récupère la tshirt
                                            $tshirt = getAlltshirtsById($item);

                                            // Récupère le model de la tshirt
                                            $model = getAllModelsById($tshirt[0]["id_model"]);

                                            // Récupère la marque de la tshirt
                                            $marque = getAllBrandsById($model[0]["id_brand"]);

                                            echo '<div class="product">
                                            <div class="row justify-content-center align-items-center">
                                                <div class="col-md-3">
                                                    <div class="product-image"><img class="img-fluid d-block mx-auto image" src="../model/assets/img/my-images/product/tshirt.jpg"></div>
                                                </div>
                                                <div class="col-md-5 product-info"><a class="product-name" href="page-du-produit.php?id=' . $tshirt[0]["id_tshirt"] . '">' . $model[0]["name"] . '</a>
                                                    <div class="product-specs">
                                                        <div><span>Marque:&nbsp;</span><span class="value">' . $marque[0]["name"] . '</span></div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-2 quantity"><label class="d-none d-md-block" for="quantity">Quantité</label><input type="number" id="number" class="form-control quantity-input" min="0" disabled name="quantity" value="' . $occurence[$item] . '"></div>
                                                <div class="col-6 col-md-2 price"><span>' . $tshirt[0]["price"] . '.-</span></div>
                                            </div>
                                        </div>';
                                            $total += ($tshirt[0]["price"] * $occurence[$item]);
                                        }
                                        $ancItem = $item;
                                    }


                                    // Ajout a la DB
                                    if($_SESSION["role"]=="user"){
                                        $lastId = addOrders($total, date("Y-m-d"), $_SESSION["idUser"]);
                                        $ancItem = null;

                                        foreach ($_SESSION["panier"] as $item) {
                                            if($ancItem != $item){
                                                // Récupère la tshirt
                                                $tshirt = getAlltshirtsById($item);

                                                $price = $tshirt[0]["price"];
                                                $tshirtId = $tshirt[0]["id_tshirt"];
                                                $number = $occurence[$item];
                                                addOrder_tshirts($lastId[1], $tshirtId, $number, $price);
                                            }
                                            $ancItem = $item;
                                        }
                                    }
                                    else if($_SESSION["role"]=="admin"){
                                        $infoUser = getAllUsersByEmail($email);
                                        $lastId = addOrders($total, date("Y-m-d"), $infoUser[0]["id_user"]);
                                        $ancItem = null;

                                        foreach ($_SESSION["panier"] as $item) {
                                            if($ancItem != $item){
                                                // Récupère la tshirt
                                                $tshirt = getAlltshirtsById($item);

                                                $price = $tshirt[0]["price"];
                                                $tshirtId = $tshirt[0]["id_tshirt"];
                                                $number = $occurence[$item];
                                                addOrder_tshirts($lastId[1], $tshirtId, $number, $price);
                                            }
                                            $ancItem = $item;
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-4">
                                <div class="summary">
                                    <h3>Aperçu</h3>
                                    <h4><span class="text">Montant de la commande</span><span
                                            class="price"><?php echo $total . ".-";?></span>
                                    </h4>
                                    <h4><span class="text">Total</span><span
                                            class="price"><?php echo $total . ".-";?></span>
                                    </h4><button class="btn btn-primary btn-block btn-lg" type="button" onclick="printer()">Imprimer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
    <script>
        function printer() {
            window.print();
        }
    </script>
</body>

</html>
<?php
    // Vide le panier
    $_SESSION["panier"] = null;
?>