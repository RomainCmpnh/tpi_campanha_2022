<?php
//******************/
// * Nom et prénom : CAMPANHA Romain
// * Date : 18mai 2022
// * Version : 1.0
// * Fichier : add_user.php
// * Description : page d'ajout d'un utilisateur, accessible que par les admins
//**************** */
session_start();

include("../model/functions/utilisateurs_functions.php");

// Verification d'accès
if(!isset($_SESSION["role"])){
    header("Location: connexion.php");
    exit;
}
else if($_SESSION["role"]!="admin"){
    header("Location: accueil.php");
    exit;
}

// Récupération des données du nouvel utilisateur
$pseudo = filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_STRING);
$mdp = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
$mdp = hash('sha256', $mdp);
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING);
$confirmation = filter_input(INPUT_POST, "envois", FILTER_SANITIZE_STRING);
$succes = 0;

// Ajout de l'utilisateur
if($confirmation==1){
    $checkEmail = getAllUsersByEmail($email);
        if ($checkEmail == null) {
            try {
                addUser($pseudo, $mdp, $email);
                $succes = 1;
                $msg = '<div class="alert alert-success" role="alert">
            L\'utilisateur a été ajouté!
          </div>';
            } catch (Exception $e) {
                $succes = 1;
                $msg = '<div class="alert alert-danger" role="alert">
            Erreur : '.$e.'!
          </div>';
            }
        }
        else{
            $succes = 1;
                $msg = '<div class="alert alert-danger" role="alert">
            L\'email est déjà utilisé!
          </div>';
        }
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Contact Us - E-Tshirt</title>
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
    <main class="page contact-us-page">
        <section class="clean-block clean-form dark">
            <div class="container">
                <div class="block-heading"></div>
                <p style="font-family: 'Roboto Slab', serif;font-size: 35px;color: rgb(0,0,0);text-align: center;">Ajouter un utilisateur</p>

                <form action="#" method="POST">
                    <?php
                        if($succes==1){
                            echo $msg;
                        }
                    ?>
                        <input type="hidden" name="envois" value="1">
                        <div class="form-group"><label for="name">Pseudo</label><input class="form-control" type="text" id="name" name="pseudo" required></div>
                        <div class="form-group"><label for="subject">Email</label><input class="form-control" type="text" id="subject" name="email" required></div>
                        <div class="form-group"><label for="subject">Mot de passe</label><input class="form-control" type="password" name="password" required></div>
                        <div class="form-group"><button class="btn btn-primary btn-block" type="submit" style="background: rgb(0,0,0);border-color: rgb(0,0,0);" >Ajouter</button></div>
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