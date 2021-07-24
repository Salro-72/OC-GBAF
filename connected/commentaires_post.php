<?php
session_start();
require '../configs/db.php';

// Insertion du message à l'aide d'une requête préparée
$req = $pdo->prepare('INSERT INTO commentaires (id_billet, auteur, commentaire, date_commentaire) VALUES(?, ?, ?, NOW())');
$req->execute(array($_GET['billet'], $_POST['auteur'], $_POST['commentaire']));

 
// Redirection du visiteur vers la liste des commentaires
header('Location: acteurs.php?billet=' . $_GET['billet']);
?>