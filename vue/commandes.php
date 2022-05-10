<?php
session_start();

include("../model/functions/utilisateurs_functions.php");
include("../model/functions/produits_functions.php");

// Verification d'accès
if(isset($_SESSION["role"]))
{
    if($_SESSION["role"]!="admin"){
        header("Location: accueil.php");
        exit;
    }
}
else{
    header("Location: connexion.php");
    exit;
}

// Récupération des actions sur une commande
$confMsg = 0;
$confirm = filter_input(INPUT_GET, "confirm", FILTER_SANITIZE_STRING);
$unconfirm = filter_input(INPUT_GET, "unconfirm", FILTER_SANITIZE_STRING);
$idEditOrder = filter_input(INPUT_GET, "idOrder", FILTER_SANITIZE_STRING);
$idDelItem = filter_input(INPUT_GET, "idItem", FILTER_SANITIZE_STRING);
$delOrder = filter_input(INPUT_GET, "delOrder", FILTER_SANITIZE_STRING);
$delItem = filter_input(INPUT_GET, "delItem", FILTER_SANITIZE_STRING);
$newPrice = filter_input(INPUT_GET, "newPrice", FILTER_SANITIZE_STRING);

// Action sur les commandes
if($confirm!=null){
    changeEtatOrder($idEditOrder, true);
}
if($unconfirm!=null){
    changeEtatOrder($idEditOrder, false);
}
if($delItem!=null){
    $allItems = getAllOrderItemsdByOrderId($idEditOrder);
    if(count($allItems)>1){
        delOrderItem($idEditOrder, $idDelItem);
        updateOrderPrice($idEditOrder, $newPrice);
    }
    else{
        delOrderItem($idEditOrder, $idDelItem);
        delOrder($idEditOrder);
    }
    $confMsg = 1;
}
if($delOrder!=null){
    delOrderItemByOrderId($idEditOrder);
    delOrder($idEditOrder);
    $confMsg = 1;
}

$order = getAllOrders();
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
    <link rel="stylesheet" href="../model/Css-custom/custom-footer.css">
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
                        <li class="nav-item"><a class="nav-link active" href="commandes.php">Commandes</a></li>';
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
                    <p style="font-family: 'Roboto Slab', serif;font-size: 31px;color: rgb(0,0,0);text-align: center;margin-bottom: 11px;">Commandes</p><a href="produits.php"><button class="btn btn-success" type="button">Ajouter une commande</button>
                </div>
                <form>
                    <div class="products">
                        <h3 class="title">Commandes</h3>
                        <?php
                            if($confMsg==1){
                                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Succès!</strong> L\'action a été éxécutée!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>';
                            }

                        if($order!=null){
                            foreach($order as $item){
                                echo '<div class="row">
                                <div class="col">
                                    <p></p>
                                </div>
                            </div>
                            <div class="content">
                                <div class="row no-gutters">
                                    <div class="col-md-12 col-lg-8">';
                                $tshirt = getAllOrderItemsdByOrderId($item["id_order"]);
                                foreach($tshirt as $tshirtItem){
                                    $thistshirt = getAlltshirtsById($tshirtItem["id_tshirt"]);

                                    // Récupère le model de la tshirt
                                    $model = getAllModelsById($thistshirt[0]["id_model"]);

                                    // Récupère la marque de la tshirt
                                    $marque = getAllBrandsById($model[0]["id_brand"]);

                                    $newPrice = ($item["total_price"])-($tshirtItem["quantity"]*$tshirtItem["unit_price"]);

                                    echo '<div class="items">
                                    <div class="product">
                                        <div class="row justify-content-center align-items-center">
                                            <div class="col-md-3">
                                                <div class="product-image"><img class="img-fluid d-block mx-auto image" src="assets/img/my-images/product/tshirt.jpg"></div>
                                            </div>
                                            <div class="col-md-5 product-info"><a class="product-name" href="page-du-produit.php?id=' . $thistshirt[0]["id_tshirt"] . '">'.$model[0]["name"].'</a>
                                                <div class="product-specs">
                                                    <div><span><b>Marque: </b></span><span class="value">'.$marque[0]["name"].'</span></div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-2 quantity"><label class="d-none d-md-block" for="quantity">Quantité</label><b>'.$tshirtItem["quantity"].'</b></div>
                                            <div class="col-6 col-md-2 price"><span>'.$tshirtItem["unit_price"].'.-</span>Action : <a href="commandes.php?idItem='.$tshirtItem["id_tshirt"].'&idOrder='.$item["id_order"].'&delItem=1&newPrice='.$newPrice.'"><i class="fa fa-trash" style="color: red;"></i></a></div>
                                        </div>
                                    </div>
                                </div>';
                                }
                                if($item["is_confirmed"]==0){
                                    $messageEtat = "<p style='color:red'>Non confirmé</p>";
                                    $logoEtat = '<a href="commandes.php?idOrder='.$item["id_order"].'&confirm=1"><i class="fa fa-check" style="color: lime;"></i></a>';
                                }
                                else{
                                    $messageEtat = "<p style='color:lime'>Confirmé</p>";
                                    $logoEtat = '<a href="commandes.php?idOrder='.$item["id_order"].'&unconfirm=1"><i class="fa fa-remove" style="color: red;"></i></a>';
                                }
                                $user = getAllUsersById($item["id_user"]);
                                echo '</div>
                                <div class="col-md-12 col-lg-4">
                                    <div class="summary">
                                        <h3>Résumé</h3>
                                        <h4><span class="text">État de la commande: </span><span class="price">'.$messageEtat.'</span></h4>
                                        <h4><span class="text">Utilisateur:</span><span class="price"><b> '.$user[0]["username"].'</b></span></h4>
                                        <h4><span class="text">Total&nbsp;</span><span class="price">'.$item["total_price"].'.-</span></h4>
                                        Action : <a href="commandes.php?idOrder='.$item["id_order"].'&delOrder=1"><i class="fa fa-trash" style="color: red;"></i></a>   '.$logoEtat.'
                                    </div>
                                </div>
                            </div>
                        </div>';
                            }
                        }
                        else{
                            echo "<h2>Vous n'avez pas encore passé de commande.";
                        }
                    ?>
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