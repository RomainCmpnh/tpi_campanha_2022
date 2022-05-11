<?php
//******************/
// * Nom et prénom : CAMPANHA Romain
// * Date : 18mai 2022
// * Version : 1.0
// * Fichier : inscription.php
// * Description : Permet au visiteur de s'inscrire sur le site
//**************** */
session_start();
include("../model/functions/utilisateurs_functions.php");

// Si l'utilisateur est déjà connecté, il est renvoyé sur la page d'accueil
if (isset($_SESSION["role"])) {
    header("Location: accueil.php");
}

// Récupération des informations
$pseudo = filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_STRING);
$mdp = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
$mdp = hash('sha256', $mdp);
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING);
$confirmation = filter_input(INPUT_POST, "envois", FILTER_SANITIZE_STRING);

$erreur = false;

// Ajout de l'utilisateur
if (isset($confirmation)) {
    if ($pseudo != null && $mdp != null && $email != null && $pseudo != " " && $mdp != " " && $email != " ") {
        $checkEmail = getAllUsersByEmail($email);
        if ($checkEmail == null) {
            try {
                $id = addUser($pseudo, $mdp, $email);
                $_SESSION["role"] = "user";
                $_SESSION["idUser"] = $id[1];
                header("Location: accueil.php?new=1");
            } catch (Exception $e) {
                $erreur = true;
                $txtErreur = "Merci de contacter un administrateur : " . $e;
            }
        } else {
            if($checkEmail[0]["actif"]==0){
                try {
                    $id = enableUser($email, $pseudo, $mdp);
                    if($checkEmail[0]["admin"]==0){
                        $_SESSION["role"] = "user";
                    }
                    else{
                        $_SESSION["role"] = "admin";
                    }
                    $_SESSION["idUser"] = $checkEmail[0]["id_user"];
                    header("Location: accueil.php?new=1");
                } catch (Exception $e) {
                    $erreur = true;
                    $txtErreur = "Merci de contacter un administrateur : " . $e;
                }
            }
            else{
                $erreur = true;
                $txtErreur = "L'email est déjà utilisé!";
            }
        }
    } else {
        $erreur = true;
        $txtErreur = "Les champs sont incomplets.";
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Register - E-Tshirt</title>
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
                        <li class="nav-item"><a class="nav-link active" href="inscription.php">Inscription</a></li>';
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
    <main class="page registration-page">
        <section class="clean-block clean-form dark">
            <div class="container">
                <div class="block-heading">
                    <p style="font-family: 'Roboto Slab', serif;font-size: 31px;color: rgb(0,0,0);text-align: center;margin-bottom: 11px;">Inscription</p>
                    <p>&nbsp;Créer votre compte rapidement et simplement !</p>
                </div>
                <form action="#" method="POST">
                        <?php if ($erreur == true) {
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Erreur!</strong> ' . $txtErreur . '
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                        }
                        ?>
                        <input type="hidden" name="envois" value="true">
                        <div class="form-group"><label for="name">Pseudo</label><input class="form-control item" type="text" id="name" name="pseudo" required <?php if($erreur==true){echo 'value="'.$pseudo.'"';} ?>></div>
                        <div class="form-group"><label for="password">Mot de passe</label><input class="form-control item" type="password" id="password" name="password" required></div>
                        <div class="form-group"><label for="email">Email</label><input class="form-control item" type="email" id="email" name="email" required <?php if($erreur==true){echo 'value="'.$email.'"';} ?>></div><input class="btn btn-primary btn-block" type="submit"  style="background: rgb(0,0,0);border-color: rgb(0,0,0);" value="S'inscrire">
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