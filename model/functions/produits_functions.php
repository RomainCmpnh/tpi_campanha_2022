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

        $sql = "SELECT * FROM tshirts AS c JOIN models as m ON m.id_model = c.id_model 
        JOIN brands AS b ON b.id_brand = m.id_brand ORDER BY b.name";
    
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

        // Recupere le nombre de pages qu'il faudrait pour afficher 
        // un certain nombre de t-shirts par pages
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

 

       // Recupere toutes les t-shirts ordonne par date selon le nombre demande et par pages
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
        // Met à jour la quantité disponnible d'un produit
        function updateQuantitytshirts($quantity, $tshirtId){

            $sql = "UPDATE tshirts SET quantity=:quantity WHERE id_tshirt = :tshirtId";
        
            $query = connect()->prepare($sql);
        
            $query->execute([
                ':quantity' => $quantity,
                ':tshirtId' => $tshirtId,
            ]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        
    // Récupère tous les articles d'une commande
    function getAllOrderItemsdByOrderId($orderid){

        $sql = "SELECT * FROM order_tshirts WHERE id_order = :orderId";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':orderId' => $orderid,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

     // Change l'état d'une commande 
     function changeEtatOrder($idOrder, $etat){

        if($etat==true || $etat==false){
            if($etat==true){
                $sql = "UPDATE orders SET is_confirmed=1 WHERE id_order = :id_order";
            }
            else{
                $sql = "UPDATE orders SET is_confirmed=0 WHERE id_order = :id_order";
            }
        
            $query = connect()->prepare($sql);
    
            $query->execute([
                ':id_order' => $idOrder,
            ]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        
    }

    // Supprime un article d'une commande
    function delOrderItem($idOrder, $id_tshirt){
        $sql = "DELETE FROM order_tshirts WHERE id_order = :id_order AND id_tshirt = :id_tshirt";
        
        $query = connect()->prepare($sql);

        $query->execute([
            ':id_order' => $idOrder,
            ':id_tshirt' => $id_tshirt,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Actualise le prix d'une commande
    function updateOrderPrice($idOrder, $price){

        $sql = "UPDATE orders SET total_price=:total_price WHERE id_order = :id_order";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':total_price' => $price,
            ':id_order' => $idOrder,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }



      // Supprime une commande
      function delOrder($idOrder){
        $sql = "DELETE FROM orders WHERE id_order = :id_order";
        
        $query = connect()->prepare($sql);

        $query->execute([
            ':id_order' => $idOrder,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

      // Récupère toutes les commandes
      function getAllOrders(){

        $sql = "SELECT * FROM orders";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
 // Ajoute un nouveau produit à une commande dans la DB
 function addOrder_tshirts($id_order, $id_tshirt, $quantity, $price){
    $sql = "INSERT INTO order_tshirts (id_order, id_tshirt, quantity, unit_price) VALUES (:id_order, :id_tshirt, :quantity, :price)";

    $query = connect()->prepare($sql);

    $query->execute([
        ':id_order' => $id_order,
        ':id_tshirt' => $id_tshirt,
        ':quantity' => $quantity,
        ':price' => $price,
    ]);
    $id = connect()->lastInsertId();
    return $id;
}

  // Ajoute une nouvelle commande dans la DB
  function addOrders($total, $date, $user){
    $sql = "INSERT INTO orders (total_price, order_date, id_user) VALUES (:total, :date, :user)";

    $query = connect()->prepare($sql);

    $query->execute([
        ':total' => $total,
        ':date' => $date,
        ':user' => $user,
    ]);
    $id = connect()->lastInsertId();
    return array($query->fetchAll(PDO::FETCH_ASSOC), $id);
}

    // Récupère toutes les commandes d'un utilisateurs selon son ID
    function getAllOrderdByUserId($userid){

        $sql = "SELECT * FROM orders WHERE id_user = :idUser";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':idUser' => $userid,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

      // Ajoute une marque
      function addBrand($marque){
        $sql = "INSERT INTO brands (name) VALUES (:name)";

        $query = connect()->prepare($sql);

        $query->execute([
            ':name' => $marque,
        ]);
        $id = connect()->lastInsertId();
        return array($query->fetchAll(PDO::FETCH_ASSOC), $id);
    }

    // Ajoute un model
    function addModel($nom, $idMarque){
        $sql = "INSERT INTO models (name, id_brand) VALUES (:name, :idMarque)";

        $query = connect()->prepare($sql);

        $query->execute([
            ':name' => $nom,
            ':idMarque' => $idMarque,
        ]);
        $id = connect()->lastInsertId();
        return array($query->fetchAll(PDO::FETCH_ASSOC), $id);
    }

    // Ajoute un tshirt
    function addTshirt($id_model, $price, $description, $quantity){
        $sql = "INSERT INTO tshirts (id_model, price, description, quantity) VALUES (:id_model, :price, :description, :quantity)";

        $query = connect()->prepare($sql);

        $query->execute([
            ':id_model' => $id_model,
            ':price' => $price,
            ':description' => $description,
            ':quantity' => $quantity,
        ]);
        $id = connect()->lastInsertId();
        return array($query->fetchAll(PDO::FETCH_ASSOC), $id);
    }

     // Récupère la marque via le nom de celle ci
     function getBrandsByName($name){

        $sql = "SELECT * FROM brands WHERE name = :name";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':name' => $name,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

   

               // Supprime un tshirt
               function delTshirt($idtshirt){
                $sql = "DELETE FROM tshirts WHERE id_tshirt = :id_tshirt";
                
                $query = connect()->prepare($sql);
        
                $query->execute([
                    ':id_tshirt' => $idtshirt,
                ]);
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }

       // Supprime un model
       function delModel($idModel){
        $sql = "DELETE FROM models WHERE id_model = :id_model";
        
        $query = connect()->prepare($sql);

        $query->execute([
            ':id_model' => $idModel,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Supprime un favoris
    function delFavorisByIdtshirt($idtshirt){
        $sql = "DELETE FROM favorite WHERE id_tshirt = :id_tshirt";
        
        $query = connect()->prepare($sql);

        $query->execute([
            ':id_tshirt' => $idtshirt,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Supprime une commande
    function delOrdertshirtByIdtshirt($idtshirt){
        $sql = "DELETE FROM order_tshirts WHERE id_tshirt = :id_tshirt";
        
        $query = connect()->prepare($sql);

        $query->execute([
            ':id_tshirt' => $idtshirt,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    
       // Récupère un tshirt favorite spécifique d'un utilisateur
       function getSpecificFav($idUser, $idtshirt){

        $sql = "SELECT * FROM favorite WHERE id_user = :idUser AND id_tshirt = :idtshirt";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':idUser' => $idUser,
            ':idtshirt' => $idtshirt,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

     // Modifie les données d'un T-shirt
     function updatetshirt($idtshirt, $price, $description, $quantity){

        $sql = "UPDATE tshirts SET price=:price, description=:description, quantity=:quantity WHERE id_tshirt = :id_tshirt";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':id_tshirt' => $idtshirt,
            ':price' => $price,
            ':description' => $description,
            ':quantity' => $quantity,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
      // Modifie les données d'un model
      function updateModels($idModel, $nom, $marqueId){

        $sql = "UPDATE models SET name=:name, id_brand=:id_brand WHERE id_model = :id_model";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':id_model' => $idModel,
            ':name' => $nom,
            ':id_brand' => $marqueId,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Modifie les données d'une marque
    function updatebrands($idBrand, $nom){

        $sql = "UPDATE models SET name=:name WHERE id_brand = :id_brand";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':id_brand' => $idBrand,
            ':name' => $nom,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Ajoute un produit au favoris d'un utilisateur
    function addFav($idUser, $idtshirt){
        $sql = "INSERT INTO favorite (id_user, id_tshirt) VALUES (:id_user, :id_tshirt)";

        $query = connect()->prepare($sql);

        $query->execute([
            ':id_user' => $idUser,
            ':id_tshirt' => $idtshirt,
        ]);
        $id = connect()->lastInsertId();
        return array($query->fetchAll(PDO::FETCH_ASSOC), $id);
    }

    // Récupère  favorite d'un utilisateur
    function getAllFavByUserId($id){

        $sql = "SELECT * FROM favorite WHERE id_user = :id";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':id' => $id,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Supprime une tshirt favorite d'un utilisateur
    function deleteFav($idUser, $idtshirt){
        $sql = "DELETE FROM favorite WHERE id_user = :id_user AND id_tshirt = :id_tshirt";

        $query = connect()->prepare($sql);

        $query->execute([
            ':id_user' => $idUser,
            ':id_tshirt' => $idtshirt,
        ]);
        $id = connect()->lastInsertId();
        return array($query->fetchAll(PDO::FETCH_ASSOC), $id);
    }

    // Récupère tous les t-shirts ordonné par favoris d'un utilisateur selon le nombre demandé et par pages
    function getAlltshirtsOrderFavPage($userid, $page_first_result, $results_par_page){

        $sql = "SELECT * FROM tshirts AS c JOIN favorite as f ON f.id_tshirt = c.id_tshirt WHERE f.id_user = :id_user LIMIT :page_first_result , :results_par_page";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':id_user' => $userid,
            ':page_first_result' => $page_first_result,
            ':results_par_page' => $results_par_page,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    ?>