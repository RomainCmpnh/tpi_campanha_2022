<?php
session_start();

include("../model/functions/utilisateurs_functions.php");

// Si l'utilisateur est déjà connecté, il est renvoyé sur la page d'accueil
if (isset($_SESSION["role"])) {
    header("Location: accueil.php");
}

// Récupération des données de connexion
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$mdp = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
$mdp = hash('sha256', $mdp);

$erreur = false;

// Essayes la connexion
if (isset($email) != null && isset($mdp) != null) {
    $user = GetUserByEmailAndPassword($email, $mdp);
    if ($user != null) {
        try {
            if($user[0]["actif"]==1){
                if($user[0]["admin"]==0){
                    $_SESSION["role"] = "user";
                }
                else{
                    $_SESSION["role"] = "admin";
                }
                $_SESSION["idUser"] = $user[0]["id_user"];
                header("Location: accueil.php");
            }
            else{
                $erreur = true;
                $txtErreur = "Email ou mot de passe incorrecte.";
            }
        } catch (Exception $e) {
            $erreur = true;
            $txtErreur = "Merci de contacter un administrateur : " . $e;
        }
    } else {
        $erreur = true;
        $txtErreur = "Email ou mot de passe incorrecte.";
    }
}


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login - TshirtShop</title>
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
            <div class="container"><a class="navbar-brand logo" href="accueil.php">T-ShirtShop</a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Activer la navigation</span><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link" href="accueil.php">accueil</a></li>
                        <li class="nav-item"><a class="nav-link" href="produits.php">produits</a></li>
                        <?php if (!isset($_SESSION["role"])) {
                            echo '<li class="nav-item"><a class="nav-link active" href="connexion.php">Connexion</a></li>
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
    <main class="page login-page">
        <section class="clean-block clean-form dark">
            <div class="container">
                <div class="block-heading">
                    <p style="font-family: 'Roboto Slab', serif;font-size: 31px;color: rgb(0,0,0);text-align: center;margin-bottom: 11px;">Connexion</p>
                    <p style="font-family: 'Roboto Slab', serif;">Connectez-vous à votre compte utilisateur.</p>
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
                        <div class="form-group"><label for="email">Email</label><input class="form-control item" type="email" id="email" name="email" required <?php if($erreur==true){echo 'value="'.$email.'"';} ?>></div>
                        <div class="form-group"><label for="password">Mot de passe</label><input class="form-control" type="password" id="password" name="password" required></div><button class="btn btn-primary btn-block" type="submit" style="background: rgb(0,0,0);border-color: rgb(0,0,0);">Connexion</button>
                    </form>
            </div>
        </section>
    </main>
    <footer class="page-footer dark">
        <div class="footer-copyright">
            <p><br>© 2022 TshirtShop - All right reserved<br><br></p>
        </div>
    </footer>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.js"></script>
    <script src="assets/js/smoothproducts.min.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>