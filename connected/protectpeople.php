<?php
session_start();
require '../configs/db.php';

date_default_timezone_set('Europe/Paris');

// Insertion du message à l'aide d'une requête préparée
$sql ="INSERT INTO minichat (pseudo, message) VALUES(?, ?)')";
$stmt = $pdo->prepare($sql);

// Redirection du visiteur vers la page du minichat
header('Location: protectpeople.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Mini-chat</title>
    </head>
    <style>
    form
    {
        text-align:center;
    }
    </style>
    <body>
    
    <form action="protectpeople_post.php" method="post">
        <p>
        <label for="pseudo">Pseudo</label> : <input type="text" name="pseudo" id="pseudo" /><br />
        <label for="message">Message</label> :  <input type="text" name="message" id="message" /><br />

        <input type="submit" value="Envoyer" />
	</p>
    </form>

        <?php
        // Récupération des 10 derniers messages
        $reponse = $bdd->query('SELECT pseudo, message FROM minichat ORDER BY ID DESC LIMIT 0, 10');

        // Affichage de chaque message (toutes les données sont protégées par htmlspecialchars)
        while ($donnees = $reponse->fetch())
        {
            echo '<p><strong>' . htmlspecialchars($donnees['pseudo']) . '</strong> : ' . htmlspecialchars($donnees['message']) . '</p>';
        }

        $reponse->closeCursor();

        ?>
    </body>
</html>