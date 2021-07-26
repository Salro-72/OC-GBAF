<?php
session_start();
require '../configs/db.php';

if ($_POST['like']){
   $sql = "UPDATE table set `likes` = `likes`+1 where `product_id` = '1'";
   $result=mysql_query($sql);
}
$req = $pdo->prepare('INSERT INTO billets (dislike_count) VALUES(?,?');
$req->execute(array($_GET['billet'], $_POST['id_user'], $_POST['commentaire']));
?>

<form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
   <input type = "submit" name="like" value = "like"/>
</form>