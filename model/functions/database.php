<?php
//******************/
// * Nom et prénom : CAMPANHA Romain
// * Date : 18mai 2022
// * Version : 1.0
// * Fichier : database.php
// * Description : Permet la connexion à la base de donnée
//**************** */

    // Connexion à la DB
    function connect()
    {
        static $myDb = null;
        $dbName = "db_tshirts";
        $dbUser = "user";
        $dbPass = "password";
        $host = "localhost";
        if ($myDb === null) {
            try {
                $myDb = new PDO(
                    "mysql:host=$host;dbname=$dbName;charset=utf8",
                    $dbUser,
                    $dbPass,
                    array(
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_PERSISTENT => true
                    )
                );
            } catch (Exception $e) {
                die("Impossible de se connecter à la base " . $e->getMessage());
            }
        }
        return $myDb;
    }
?>