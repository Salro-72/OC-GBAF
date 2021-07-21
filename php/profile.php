<?php 
require_once '../configs/db.php';



$reponse = $pdo->query('SELECT firstname AND lastname FROM users');

?>
    <p>
        <?php echo $donnees['firstname']; ?>
        <?php echo $donnees['lastname']; ?>
    </p>
<?php

    $reponse->closeCursor(); // Termine le traitement de la requête

?>