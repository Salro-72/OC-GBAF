<?php
session_start();
require '../configs/db.php';


$req = $pdo->prepare('SELECT * FROM comments WHERE id_acteur = ? AND id_user = ?');
$req->execute(array($_GET['billet'], $_POST['id_user']));
$number = $req->rowCount();

if (!$number) {
    // Insertion du message à l'aide d'une requête préparée
    $req = $pdo->prepare('INSERT INTO comments (id_acteur, id_user, comment, date_comment) VALUES(?, ?, ?, NOW())');
    $req->execute(array($_GET['billet'], $_POST['id_user'], $_POST['comment']));

    // Redirection du visiteur vers la liste des commentaires
    header('Location: acteurs.php?billet=' . $_GET['billet']);
}

else {
   echo "Vous avez déjà commenté! <br> <a href='acteurs.php?billet=". $_GET['billet'] ."'> Retour arriere</a>";
}