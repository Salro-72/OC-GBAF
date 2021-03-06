<?php
session_start();
require 'configs/db.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <link rel="stylesheet" type="text/css" href="style_GBAF.css"/>
        <title>Extranet GBAF</title>
    </head>
        <body>
            <header>
                <img src="GBAF_img/GBAF_logo.png" alt="Logo de GBAF" class="center"/>
                <div class="title">
                    <h1>Changez votre mot de passe</h1><br>
                </div>
                <p class="retour"><a href="index.php">Retour à l'arriere</a>
            </header>
    <section>
        <div class="title_box">
            <h2>Vous avez oublié votre mot de passe ?<br>Veuillez remplir les formulaires suivants pour le changer :</h2>
        </div> 
        <div>
            <form action="forgotpassword.php" method="post" class="option_box">
                <div class="names">
                    <label for="identifiant">Identifiant : </label>
                    <input type="text" id="identifiant" name="pseudo" 
                    value="<?php echo isset($_POST['pseudo'])? $_POST['pseudo'] : ''?>" class="insert_box" required> 
                </div>
                <br>
                    <?php
                    if (isset($_POST['pseudo'])) // vérifie si la variable est déclarée et est différente de null.
                    {
                        $reponse = $pdo->prepare('SELECT pseudo, question, reponse, password FROM users WHERE pseudo = :pseudo');
                        // va chercher dans la BDD la ligne corresponsant au pseudo entré dans le formulaire de connexion
                        $reponse->execute(array('pseudo' => $_POST['pseudo']));
                        $donnees = $reponse->fetch();

                        if ($donnees) // si l'pseudo correspond alors il affiche la question correspondante
                        { 
                    ?>
                    <div class="names">
                        <p>Répondez à la question suivante et saisissez votre nouveau mot de passe : <br>
                            <em><?php echo ($donnees['question']) ?></em>
                        </p>
                    </div>
                    <div class="names">
                        <label for="reponse">Votre réponse : </label>
                        <input type="text" id="reponse" name="reponse" required>
                    </div>
                    <br>
                    <div class="names">
                        <label for="pass">Votre nouveau mot de passe :</em></label>
                        <br>
                        <input type="password" id="pass" name="password" required> 
                    </div>
                    <br>
                     <div class="names">
                        <label for="repass">Retapez votre nouveau mot de passe : </label>
                        <br>
                    <input type="password" id="repass" name="repassword" required> 
                    </div>
                    <br>
                        <?php
                        if (isset($_POST['reponse']))
                        {
                            $reponse_user = strtolower($_POST['reponse']);
                            if ($reponse_user === $donnees['reponse'])
                            // si la réponse saisie est identique à la réponse stockée en base
                            {
                                if ($_POST['password'] === $_POST['repassword'])
                                // vérifie si les mots de passe entrés dans les deux champs sont identiques.
                                {
                                    $password = $_POST['password']; 

                                    $pass_hache = password_hash($_POST['password'], PASSWORD_DEFAULT);
                                    $reponse->closeCursor(); // libère la connexion au serveur, permettant ainsi à d'autres requêtes SQL d'être exécutées 
                            
                                    $reponse = $pdo->prepare('UPDATE users SET password = :password WHERE pseudo = :pseudo'); // insère le nouveau mot de passe en base dans la table "user"
                                    $reponse->execute(array(
                                        'password' => $pass_hache,
                                        'pseudo' => $_POST['pseudo']));
                        ?> 
                        <div class="msg_success">  <!-- message pour informer l'utilisateur que son mot de passe a été changé-->
                            <p style="color:green;">Félicitation, votre mot de passe a été changé avec succès! <a href="login.php" target="_blank" rel="noopener noreferrer">Cliquez ici</a> pour vous connecter à l'extranet GBAF.</p>
                        </div>
                        <?php
                                }
                            }
                        else
                        {
                        ?> 
                        <div class="msg_error">
                            <p style="color:red;">Vos mots de passe ne sont pas identiques, merci de corriger votre saisie.</p>
                        </div>
                        <br>
                        <?php     
                        }
                    }
                    else
                    {
                        ?> 
                        <div class="msg_error">
                            <p style="color:red;">La réponse à la question n'est pas bonne, merci de corriger votre saisie.</p>
                        </div>
                        <br>
                        <?php     
                    }
                }
                else
                {
                        ?>
                        <br>
                        <div class="msg_error">
                            <p style="color:red;">Votre identfiant n'est pas bon, merci de corriger votre saisie.</p>
                        </div>
                        <br>
                        <?php    
                }
            }
                        ?> 
                <input type="submit" value="Envoyer" class="submit_button">
            </form>
        </div>
    </section>
    <?php include("php/footer.php"); ?>
</body>
</html>