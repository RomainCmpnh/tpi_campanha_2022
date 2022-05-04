<?php
    // Connexion à la DB
    include_once("database.php");

        // Récupère tous les t-shirts des plus récents aux plus anciens
        function getAllTshirtsOrderNew(){

            $sql = "SELECT * FROM tshirts ORDER BY id_tshirt DESC";
        
            $query = connect()->prepare($sql);
        
            $query->execute([
                
            ]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        // Récupère tous les tshirts qui correspondent à un critère de recherche (pour le modèle)
        function getAllTshirtsBySearch($search){

            $search = "%".$search."%";
    
            $sql = "SELECT * FROM tshirts  AS c JOIN models as m ON m.id_model = c.id_model WHERE m.name LIKE :search";
        
            $query = connect()->prepare($sql);
        
            $query->execute([
                ':search' => $search,
            ]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        // Récupère tous les t-shirts des moins chère au plus chère
        function getAllTshirtsOrderPriceA(){

        $sql = "SELECT * FROM tshirts ORDER BY price ASC";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

        // Récupère tous les t-shirts des plus chère au moins chère
        function getAllTshirtsOrderPriceB(){

            $sql = "SELECT * FROM tshirts ORDER BY price DESC";
        
            $query = connect()->prepare($sql);
        
            $query->execute([
                
            ]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

            // Récupère le Tshirt qui corréspond à un certain ID
        function getAllTshirtsById($id){

        $sql = "SELECT * FROM tshirts WHERE id_tshirt = :id";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':id' => $id,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

       // Récupère toutes les t-shirts dans l'ordre alphabétique des marques
       function getAllTshirtsOrderMarque(){

        $sql = "SELECT * FROM tshirts AS c JOIN models as m ON m.id_model = c.id_model JOIN brands AS b ON b.id_brand = m.id_brand ORDER BY b.name";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupère tous les t-shirt ordonné par favoris pour un utilisateur
    function getAllTshirtsOrderFav($userid){

        $sql = "SELECT * FROM tshirts AS c JOIN favorite as f ON f.id_tshirt = c.id_tshirt WHERE f.id_user = :id_user";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':id_user' => $userid,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupère un modèle qui correspond à un certain ID
    function getAllModelsById($id){

        $sql = "SELECT * FROM models WHERE id_model = :id";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':id' => $id,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

       // Récupère une marque qui correspond à un certain ID
       function getAllBrandsById($id){

        $sql = "SELECT * FROM brands WHERE id_brand = :id";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':id' => $id,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

        // Récupère le nombre de pages qu'il faudrai pour afficher un certain nombre de t-shirts par pages
        function getAllPagesProduct($nb_result_wanted){

            $sql = "SELECT * FROM tshirts";
        
            $query = connect()->prepare($sql);
        
            $query->execute([
                
            ]);
            $resultat = $query->fetchAll(PDO::FETCH_ASSOC);
            $nb_result = 0;
            foreach($resultat as $item){
                $nb_result +=1;
            }
            $number_of_page = ceil($nb_result / $nb_result_wanted);
    
            return $number_of_page;
        }

            // Supprime unn tshirt
    function delTshirt($idTshirt){
        $sql = "DELETE FROM tshirts WHERE id_tshirt = :id_tshirt";
        
        $query = connect()->prepare($sql);

        $query->execute([
            ':id_tshirt' => $idtshirt,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

       // Récupère toutes les t-shirts ordonné par date selon le nombre demandé et par pages
       function getAllProductParPagesDate($page_first_result, $results_par_page){

        $sql = "SELECT * FROM tshirts ORDER BY id_tshirt DESC LIMIT :page_first_result , :results_par_page";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':page_first_result' => $page_first_result,
            ':results_par_page' => $results_par_page,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

      // Récupère toutes les t-shirts ordonné par prix ascendant selon le nombre demandé et par pages
      function getAlltshirtsOrderPriceAPage($page_first_result, $results_par_page){

        $sql = "SELECT * FROM tshirts ORDER BY price ASC LIMIT :page_first_result , :results_par_page";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':page_first_result' => $page_first_result,
            ':results_par_page' => $results_par_page,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupère toutes les t-shirts ordonné par prix descandant selon le nombre demandé et par pages
    function getAlltshirtsOrderPriceBPage($page_first_result, $results_par_page){

        $sql = "SELECT * FROM tshirts ORDER BY price DESC LIMIT :page_first_result , :results_par_page";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':page_first_result' => $page_first_result,
            ':results_par_page' => $results_par_page,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupère toutes les t-shirts ordonné par ordre alphabétique des marques selon le nombre demandé et par pages
    function getAlltshirtsOrderMarquePage($page_first_result, $results_par_page){

        $sql = "SELECT * FROM tshirts AS c JOIN models as m ON m.id_model = c.id_model JOIN brands AS b ON b.id_brand = m.id_brand ORDER BY b.name LIMIT :page_first_result , :results_par_page";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':page_first_result' => $page_first_result,
            ':results_par_page' => $results_par_page,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    ?>