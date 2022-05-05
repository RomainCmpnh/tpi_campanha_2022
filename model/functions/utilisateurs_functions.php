<?php
    // Inclus la connexion à la DB
    include_once("database.php");

    // Récupère un utilisateur via son email
    function getAllUsersByEmail($email){

        $sql = "SELECT * FROM users WHERE email = :email";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':email' => $email,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupère un utilisateur via son id
    function getAllUsersById($id){

        $sql = "SELECT * FROM users WHERE id_user = :id";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':id' => $id,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajoute un utilisateur
    function addUser($pseudo, $mdp, $email){

        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";

        $query = connect()->prepare($sql);

        $query->execute([
            ':username' => $pseudo,
            ':email' => $email,
            ':password' => $mdp,
        ]);
        $id = connect()->lastInsertId();
        return array($query->fetchAll(PDO::FETCH_ASSOC), $id);
    }

    // Récupère tout les utilisateurs via leur email et password
    function GetUserByEmailAndPassword($email, $password){
        $sql = "SELECT * FROM users WHERE email = :email AND password = :password";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':email' => $email,
            ':password' => $password,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Modifie un password
    function changePassword($idUser, $password){
        $sql = "UPDATE users SET password = :password WHERE id_user = :id_user";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':id_user' => $idUser,
            ':password' => $password,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Désactive un utilisateur
    function disableUser($idUser){
        $sql = "UPDATE users SET actif = '0' WHERE id_user = :id_user";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':id_user' => $idUser,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Active un utilisateur
    function enableUser($mail, $username, $password){
        $sql = "UPDATE users SET actif = '1', username = :username, password = :password WHERE email = :mail";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':mail' => $mail,
            ':username' => $username,
            ':password' => $password,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupère tout les utilisateurs actifs
    function getAllActifUsers(){

        $sql = "SELECT * FROM users WHERE actif = 1";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Change le pseudo et l'email d'un utilisateur
    function changeUsernameAndEmail($idUser, $username, $email){
        $sql = "UPDATE users SET username = :username, email = :email WHERE id_user = :id_user";
    
        $query = connect()->prepare($sql);
    
        $query->execute([
            ':id_user' => $idUser,
            ':username' => $username,
            ':email' => $email,
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }¨


?>