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
                        <li class="nav-item"><a class="nav-link active" href="accueil.php">accueil</a></li>
                        <li class="nav-item"><a class="nav-link" href="produits.php">produits</a></li>
                        <?php if (!isset($_SESSION["role"])) {
                            echo '<li class="nav-item"><a class="nav-link" href="connexion.php">Connexion</a></li>
                        <li class="nav-item"><a class="nav-link" href="inscription.php">Inscription</a></li>';
                        } else {
                            echo '<li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>';
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
                    <p>Ici, vous pouvez retrouver vos commandes, changer votre mot de passe ou encore supprimer votre compte.</p>
                </div>
                <form>
                    <div class="form-group"><label for="email">Changer votre mot de passe</label><input class="form-control" type="password" name="password"></div>
                    <div class="form-group"><button class="btn btn-primary btn-block" type="submit" style="background: rgb(0,0,0);border-color: rgb(0,0,0);">Changer</button></div>
                </form>
                <div class="row">
                    <div class="col">
                        <p></p>
                    </div>
                </div>
                <form>
                    <div class="form-group"><button class="btn btn-danger btn-block" type="submit">Supprimer mon compte</button></div>
                </form>
                <div class="row">
                    <div class="col">
                        <p></p>
                    </div>
                </div>
                <p style="font-family: 'Roboto Slab', serif;font-size: 32px;color: rgb(0,0,0);">Historique des commandes</p>
                <div class="content">
                    <div class="row no-gutters">
                        <div class="col-md-12 col-lg-8">
                            <div class="items">
                                <div class="product">
                                    <div class="row justify-content-center align-items-center">
                                        <div class="col-md-3">
                                            <div class="product-image"><img class="img-fluid d-block mx-auto image" src="assets/img/my-images/product/cap.jpg"></div>
                                        </div>
                                        <div class="col-md-5 product-info"><a class="product-name" href="#" style="color: rgb(0,0,0);">T-shirt noir</a>
                                            <div class="product-specs">
                                                <div><span>Marque:&nbsp;</span><span class="value">5 inch</span></div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-2 quantity"><label class="d-none d-md-block" for="quantity">Quantité</label><input type="number" id="number-1" class="form-control quantity-input" value="1" disabled=""></div>
                                        <div class="col-6 col-md-2 price"><span>30 CHF</span></div>
                                    </div>
                                </div>
                                <div class="product">
                                    <div class="row justify-content-center align-items-center">
                                        <div class="col-md-3">
                                            <div class="product-image"><img class="img-fluid d-block mx-auto image" src="assets/img/my-images/product/cap.jpg"></div>
                                        </div>
                                        <div class="col-md-5 product-info"><a class="product-name" href="#" style="color: rgb(0,0,0);">T-shirt noir</a>
                                            <div class="product-specs">
                                                <div><span>Marque:&nbsp;</span><span class="value">5 inch</span></div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-2 quantity"><label class="d-none d-md-block" for="quantity">Quantité</label><input type="number" id="number-2" class="form-control quantity-input" value="1" disabled=""></div>
                                        <div class="col-6 col-md-2 price"><span>30 CHF</span></div>
                                    </div>
                                </div>
                                <div class="product">
                                    <div class="row justify-content-center align-items-center">
                                        <div class="col-md-3">
                                            <div class="product-image"><img class="img-fluid d-block mx-auto image" src="assets/img/my-images/product/cap.jpg"></div>
                                        </div>
                                        <div class="col-md-5 product-info"><a class="product-name" href="#" style="color: rgb(0,0,0);">T-shirt noir</a>
                                            <div class="product-specs">
                                                <div><span>Marque:&nbsp;</span><span class="value">5 inch</span></div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-2 quantity"><label class="d-none d-md-block" for="quantity">Quantité</label><input type="number" id="number-3" class="form-control quantity-input" value="1" disabled=""></div>
                                        <div class="col-6 col-md-2 price"><span>30 CHF</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <div class="summary">
                                <h3>Aperçu</h3>
                                <h4><span class="text">Montant de la commande&nbsp;</span><span class="price">90 CHF</span></h4>
                                <h4><span class="text">Total&nbsp;</span><span class="price">90 CHF</span></h4>
                            </div>
                        </div>
                    </div>
                </div>
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