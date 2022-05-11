<?php
//******************/
// * Nom et prénom : CAMPANHA Romain
// * Date : 18mai 2022
// * Version : 1.0
// * Fichier : utilisateurs.php
// * Description : affiche la liste des utilisateur à l'admin, il peut les modifier ou les suprprimer
//**************** */
session_start();

include("../model/functions/utilisateurs_functions.php");

// Verification des accès
if(!isset($_SESSION["role"])){
    header("Location: connexion.php");
    exit;
}
else if($_SESSION["role"]!="admin"){
    header("Location: accueil.php");
    exit;
}

// Récupération des action admin
$confMsg = 0;
$del = filter_input(INPUT_GET, "del", FILTER_SANITIZE_STRING);
$getId = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);

// Suppression d'un compte
if($del==1){
    try{
        disableUser($getId);
        $confMsg = 1;
    }
    catch(Exception $e){
        echo 'Error : '.$e;
    }
}

$users = getAllActifUsers();

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Payment - E-Tshirt</title>
    <link rel="stylesheet" href="../model/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Slab&amp;display=swap">
    <link rel="stylesheet" href="../model/assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="../model/assets/fonts/line-awesome.min.css">
    <link rel="stylesheet" href="../model/assets/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.css">
    <link rel="stylesheet" href="../model/assets/css/smoothproducts.css">
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
                            echo '<li class="nav-item"><a class="nav-link active" href="utilisateurs.php">Utilisateurs</a></li>
                        <li class="nav-item"><a class="nav-link" href="commandes.php">Commandes</a></li>';
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
    <main class="page payment-page">
        <section class="clean-block payment-form dark">
            <div class="container">
                <div class="block-heading">
                    <p style="font-family: 'Roboto Slab', serif;font-size: 32px;color: rgb(0,0,0);">Utilisateurs<br></p><a href="add_user.php"><button class="btn btn-success" type="button">Ajouter un utilisateur</button>
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
                <form>
                    <div class="products">
                        <h3 class="title">Utilisateurs</h3>
                        <?php
                                foreach($users as $item){
                                    $pseudo = $item["username"];
                                    $mail = $item["email"];
                                    $idUser = $item["id_user"];
                                    echo '<div class="item"><span class="price"><a href="edit_user.php?id='.$idUser.'"><i class="fa fa-pencil" style="color: rgb(255,153,0);"></i></a>&nbsp;&nbsp;<a href="utilisateurs.php?id='.$idUser.'&del=1"><i class="fa fa-trash" style="color: var(--red);"></i></a></span>
                                    <p class="item-name">'.$pseudo.'</p>
                                    <p class="item-description">'.$mail.'</p>
                                </div>';
                                }
                            ?>
                            <div class="total"><span>Total</span><span class="price"><?php echo count($users); ?> utilisateurs</span></div>
                    </div>
                </form>
            </div>
        </section>
    </main>
    <footer class="page-footer dark">
        <div class="footer-copyright">
            <p>© 2022 E-Tshirt - All right reserved</p>
        </div>
    </footer>
    <script src="../model/assets/js/jquery.min.js"></script>
    <script src="../model/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.js"></script>
    <script src="../model/assets/js/smoothproducts.min.js"></script>
    <script src="../model/assets/js/theme.js"></script>
</body>

</html>