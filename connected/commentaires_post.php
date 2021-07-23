<?php
session_start();
require '../configs/db.php';

if(isset($_POST['commentSubmit'])){

        $id_auteur = !empty($_POST['id_auteur']) ? trim($_POST['id_auteur']) : null;
        $commentaire = !empty($_POST['commentaire,']) ? trim($_POST['commentaire,']) : null;
    
        $sql = "SELECT COUNT(pseudo) AS num FROM users WHERE pseudo = :pseudo";
        $stmt = $pdo->prepare($sql);
    
        $stmt->bindValue(':id_auteur', $id_auteur);
    
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        $sql = "INSERT INTO commentaires (id_auteur, commentaire, date_commentaire) VALUES (:id_auteur, :commentaire, CURRENT_TIMESTAMP)";
        $stmt = $pdo->prepare($sql);
    
        $stmt->bindValue(':commentaire,', $commentaire);
    
        $result = $stmt->execute();
    
    if($result){
        echo 'Commentaire bien ajouté !';
    }  
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
            <title>Mon blog</title>
        <link href="style.css" rel="stylesheet" /> 
    </head>
            
        <body>
            <h1>Mon super blog !</h1>
            <p><a href="protectpeople.php">Retour à la liste des billets</a></p>
    
        <form action="commentaires_post.php" method="POST">
            <input type="text" id="pseudo" name="pseudo" placeholder="Votre identifiant" required><br>
            <textarea name="comment" placeholder="Votre commentaire" required></textarea><br>
            <button type="submit" name="commentSubmit">Comment</button>
        </form>
    </body>
</html>