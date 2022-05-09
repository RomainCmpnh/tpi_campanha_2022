<?php
session_start();

include("../model/functions/utilisateurs_functions.php");
include("../model/functions/produits_functions.php");

// Vérification des accès
if (!isset($_SESSION["role"])) {
    header("Location: connexion.php");
    exit;
}

// Deconnexion
$deco = filter_input(INPUT_GET, "deco", FILTER_SANITIZE_STRING);
if (isset($deco) == 1) {
    unset($_SESSION["role"]);
    unset($_SESSION["idUser"]);
    header("Location: connexion.php");
    exit;
}

// Changement de mot de passe
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
if($password !=null){
    $password = hash('sha256', $password);
    changePassword($_SESSION["idUser"], $password);
}

// Suppression du compte
$delete = filter_input(INPUT_POST, "delete", FILTER_SANITIZE_STRING);
if($delete!=null){
    disableUser($_SESSION["idUser"]);
    header("Location: profile.php?deco=1");
}

$order = getAllOrderdByUserId($_SESSION["idUser"]);
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
            <div class="container"><a class="navbar-brand logo" href="accueil.php">TshirtShop</a><button
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
                            echo '<li class="nav-item"><a class="nav-link active" href="profile.php">Profile</a></li>';
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
    <main class="page contact-us-page">
        <section class="clean-block clean-form dark">
            <div class="container">
                <div class="block-heading">
                    <p style="font-family: 'Roboto Slab', serif;font-size: 32px;color: rgb(0,0,0);">Profile</p>
                   
                    </div>
                    <form method="POST" action="#">
                        <div class="form-group"><label for="email">Changer votre mot de passe</label><input
                                class="form-control" type="password" name="password" required></div>
                        <div class="form-group"><button class="btn btn-primary btn-block" type="submit">Changer</button>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col">
                            <p></p>
                        </div>
                    </div>
                    <form action="#" method="GET">
                        <input type="hidden" value="1" name="deco">
                        <div class="form-group"><button class="btn btn-warning btn-block"
                                type="submit">Déconnexion</button></div>
                    </form>
                    <div class="row">
                        <div class="col">
                            <p></p>
                        </div>
                    </div>
                    <!-- Fenetre de confirmaton pour la suppression du compte -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Attention</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Êtes vous sûr de vouloir supprimer votre compte?
                                </div>
                                <div class="modal-footer">
                                    <form action="#" method="POST">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                        <input type="hidden" name="delete" value="1">
                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        </div>
                        <form>
                            <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#exampleModal">Supprimer mon compte</button>
                        </form>
                        <div class="row">
                            <div class="col">
                                <p></p>
                            </div>
                        </div>
                <p style="font-family: 'Roboto Slab', serif;font-size: 32px;color: rgb(0,0,0);">Historique des commandes</p>
                <?php
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

                                    echo '<div class="items">
                                    <div class="product">
                                        <div class="row justify-content-center align-items-center">
                                            <div class="col-md-3">
                                                <div class="product-image"><img class="img-fluid d-block mx-auto image" src="../model/assets/img/my-images/product/tshirt.jpg"></div>
                                            </div>
                                            <div class="col-md-5 product-info"><a class="product-name" href="page_detail_produit.php?id=' . $thistshirt[0]["id_tshirt"] . '">'.$model[0]["name"].'</a>
                                                <div class="product-specs">
                                                    <div><span><b>Marque: </b></span><span class="value">'.$marque[0]["name"].'</span></div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-2 quantity"><label class="d-none d-md-block" for="quantity">Quantité</label><b>'.$tshirtItem["quantity"].'</b></div>
                                            <div class="col-6 col-md-2 price"><span>'.$tshirtItem["unit_price"].'.-</span></div>
                                        </div>
                                    </div>
                                </div>';
                                }
                                if($item["is_confirmed"]==0){
                                    $messageEtat = "<p style='color:red'>Non confirmé</p>";
                                }
                                else{
                                    $messageEtat = "<p style='color:lime'>Confirmé</p>";
                                }
                                echo '</div>
                                <div class="col-md-12 col-lg-4">
                                    <div class="summary">
                                        <h3>Résumé</h3>
                                        <h4><span class="text">État de la commande: </span><span class="price">'.$messageEtat.'</span></h4>
                                        <h4><span class="text">Total&nbsp;</span><span class="price">'.$item["total_price"].'.-</span></h4>
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