<?php
session_start();
require '../configs/db.php';

if (isset($_POST['vote'])){
    $vote = $_POST['vote'];

if ($number == 1) {
// Insertion du vote à l'aide d'une requête préparée
$req = $pdo->prepare('INSERT INTO votes (id_acteur, id_user, vote) VALUES(?, ?, 1)');
$req->execute(array($_GET['billet'], $_SESSION['id_user'], $_POST['vote']));

echo "Votre vote a été validé.";
}

elseif ($number == 0) {
// Insertion du vote à l'aide d'une requête préparée
$req = $pdo->prepare('UPDATE votes SET vote = :vote WHERE id_acteur = ? AND id_user = ? AND vote = 0');
$req->execute(array($_GET['billet'], $_SESSION['id_user'], $_POST['vote']));
$dislikes = $req->fetch(PDO::FETCH_ASSOC)['dislikes'];
                
echo "Votre vote a été validé.";
}
}