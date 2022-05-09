<?php
session_start();

include("../model/functions/utilisateurs_functions.php");

// Vérification de l'accès
if(!isset($_SESSION["role"])){
    header("Location: connexion.php");
    exit;
}
else if($_SESSION["role"]!="admin"){
    header("Location: accueil.php");
    exit;
}

// Récupération des informations de l'utilisateur
$getId = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);

$user = getAllUsersById($getId);

$envois = filter_input(INPUT_POST, "envois", FILTER_SANITIZE_STRING);

// Modification de l'utilisateur
if($envois == 1){
    try{
        $username = filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        $checkEmail = getAllUsersByEmail($email);
        if($checkEmail==null){
            changeUsernameAndEmail($getId, $username, $email);
            $succes = 1;
            $msg = '<div class="alert alert-success" role="alert">
            L\'utilisateur a été modifié!
          </div>';
        }
        else{
            $succes = 1;
            $msg = '<div class="alert alert-danger" role="alert">
            L\'email est déjà utilisé!
          </div>';
        }
    }
    catch(Exception $e){
        $msg = '<div class="alert alert-danger" role="alert">
        Une erreur est surevenue : '.$e.'
      </div>';
      $succes = 1;
    }
    
}
else{
    $username = $user[0]["username"];
    $email = $user[0]["email"];
    $succes = 0;
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
                <p style="font-family: 'Roboto Slab', serif;font-size: 31px;color: rgb(0,0,0);text-align: center;margin-bottom: 11px;">Modification</p>
                <form method="POST" action="#">
                        <?php
                            if($succes==1){
                                echo $msg;
                            }
                        ?>
                        <input type="hidden" value="1" name="envois">
                        <div class="form-group"><label for="name">Pseudo</label><input class="form-control" type="text" id="name" name="pseudo" value="<?php echo $username; ?>" required></div>
                        <div class="form-group"><label for="subject">Email</label><input class="form-control" type="text" id="subject" name="email" value="<?php echo $email; ?>" required></div>
                        <div class="form-group"><button class="btn btn-primary btn-block" type="submit" style="background: rgb(0,0,0);">Modifier</button></div>
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