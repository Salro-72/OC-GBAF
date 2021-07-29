<?php
session_start();
require '../configs/db.php';

if (isset($_POST['vote'])){
    $vote = $_POST['vote'];

if ($vote === "J'aime") {
// Insertion du vote à l'aide d'une requête préparée
$req = $pdo->prepare('INSERT INTO votes (id_acteur, id_user, vote) VALUES(?, ?, 1)');
$req->execute(array($_GET['billet'], $_SESSION['id_user'], $_POST['vote']));

echo "Votre vote a été validé. (like)";
}

if ($vote === "Je n'aime pas") {
    // Insertion du vote à l'aide d'une requête préparée
    $req = $pdo->prepare('INSERT INTO votes (id_acteur, id_user, vote) VALUES(?, ?, 0)');
    $req->execute(array($_GET['billet'], $_SESSION['id_user'], $_POST['vote']));
    
    echo "Votre vote a été validé. (dislike)";
    }
}