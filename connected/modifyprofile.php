<?php
session_start();
require '../configs/db.php';

if (!$_SESSION['pseudo'])  
{  
    header('location: ../login.php');  
    exit;  
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <link rel="stylesheet" type="text/css" href="../style_GBAF.css"/>
        <title>Extranet GBAF</title>
    </head>
    <body>
        <header>
            <div class="profil_connected">
                <?php include("../php/logo.php"); ?>
            </div>
                <div class="title">
                    <h1>Modifiez votre profile</h1>
                </div>
                <div>
                    <?php include("../php/profile.php"); ?>
                </div>
                <div class="topnav">
                    <a href="homepage.php">Acceuil</a>
                    <a class="active" href="modifyprofile.php">Modifier votre profile</a>
                    <a href="logout.php">Déconnexion</a>
                </div>
        </header>
        
        <div class="title_box">
            <h2>Pour modifier votre profile, veuillez remplir les formulaires suivants :</h2>
        </div>   
        <section class="edit_box"> 
<!-- formulaire de modification des informations personnelles-->   
            <div class="modify_profile">
                <h2 class="title_edit">Mes informations personnelles</h2>
                    <form action="modifyprofile.php" method="post">
                        <div>
                            <label for="lastame" class="names"><strong>Veuillez inserter votre nouvel NOM :</strong></label>
                            <br>
                            <input type="text" id="name" name="lastname" 
                            value="<?php echo isset($_POST['lastname'])? strtoupper($_POST['lastname']) : $_SESSION['lastname'];?>" 
                            class="insert_box_mobile" autofocus required>
                        </div>
                        <br>
                        <div>
                            <label for="firstname" class="names"><strong>Veuillez inserter votre nouvel PRÉNOM :</strong></label>
                            <br>
                            <input type="text" id="firstname" name="firstname"
                            value="<?php echo isset($_POST['firstname'])? $_POST['firstname'] : $_SESSION['firstname'];?>" 
                            class="insert_box_mobile" required>
                        </div>
                        <br>
                        <input id="ancre_name" type="submit" value="Modifier" class="submit_button">
                            <?php 
                            if (isset ($_POST['lastname']) && ($_POST['firstname']))
                            {
                                $reponse = $pdo->prepare('UPDATE users SET lastname = upper(:lastname), firstname = :firstname 
                                                        WHERE pseudo = :pseudo');
                                $reponse->execute(array(
                                    'lastname' => $_POST['lastname'],
                                    'firstname' => $_POST['firstname'],
                                    'pseudo' => $_SESSION['pseudo']));
                                $reponse->closeCursor(); // libère la connexion au serveur, permettant ainsi à d'autres requêtes SQL d'être exécutées 
                        
                                $reponse = $pdo->prepare('SELECT * FROM users WHERE pseudo = :pseudo');
                                $reponse->execute(array('pseudo' => $_SESSION['pseudo']));
                                $donnees = $reponse->fetch();
                                // met à jour la session avec les nouvelles variables (si l'utilisateur à fait des modifications dans ses infos perso)
                        
                                $lastname = $donnees['lastname'];
                                $_SESSION['lastname'] = $lastname;
                                $firstname = $donnees['firstname'];
                                $_SESSION['firstname'] = $firstname;                
                            ?>
                            <br>
                            <br>
                            <div class="msg_success">
                                <p style="color:green;">Les modifications ont été apportées avec succès!</p>
                            </div>
                            <?php
                            $reponse->closeCursor(); // libère la connexion au serveur, permettant ainsi à d'autres requêtes SQL d'être exécutées 
                            }  
                            ?>
                    </form>
            </div>
            <hr>
<!-- formulaire de modification pseudo et mot de passe--> 
            <div class="modify_profile">
                <h2 class="title_edit"> Mes informations de connexion</h2>
                    <form action="modifyprofile.php" method="post">
                        <div>
                            <label for="identifiant" class="names"><strong>Veuillez inserter votre nouvel IDENTIFIANT :  </strong></label>
                            <br>
                            <input type="text" id="identifiant" name="pseudo" value="<?php echo isset($_POST['pseudo'])? $_POST['pseudo'] : $_SESSION['pseudo'];?>"
                            class="insert_box_mobile" required>
                        </div>
                        <br>
                        <div class="pass">
                            <label for="pass" class="names"><strong>Mot de passe ACTUEL : </strong></label>
                            <br>
                            <input type="password" id="actualpass" name="actualpass" class="insert_box_mobile" required>
                        </div>
                        <br>
                        <div class="pass">
                            <label for="pass" class="names"><strong>NOUVEAU mot de passe :</strong></label>
                            <br>
                            <input type="password" id="pass" name="password" class="insert_box_mobile" required>
                        </div>
                        <br>
                        <div class="repass">
                            <label for="repass" class="names"><strong>Retapez votre NOUVEAU mot de passe :  </strong></label>
                            <br>
                            <input type="password" id="repass" name="repassword" class="insert_box_mobile" required>
                        </div>
                        <br>
                        <input type="submit" value="Modifier" class="submit_button">
                            <?php 
                            if (isset ($_POST['pseudo']) && ($_POST['actualpass']) && ($_POST['password']) && ($_POST['repassword']))
                            {
                                if ($_POST['password'] === $_POST['repassword'])
                                // vérifie si les mots de passe entrés dans les deux champs sont identiques.
                                {
                                    $password = $_POST['password']; 
                                    
                                    $reponse = $pdo->prepare('SELECT pseudo, password FROM users WHERE pseudo = :pseudo');
                                    $reponse->execute(array('pseudo' => $_POST['pseudo']));
                                    $donnees = $reponse->fetch();
                                        
                                    $passcheck = password_verify($_POST['actualpass'], $donnees['password']);
                                    // compare le mot de passe actuel avec celui en base

                                    if ($passcheck) // si la comparaison est ok
                                    {
                                        if (($donnees == false) || ($donnees['pseudo'] === $_SESSION['pseudo']))
                                        {
                                            $reponse->closeCursor(); // libère la connexion au serveur, permettant ainsi à d'autres requêtes SQL d'être exécutées 
                                            
                                            $pass_hache = password_hash($_POST['password'], PASSWORD_DEFAULT);
                                            $reponse = $pdo->prepare('UPDATE users SET pseudo = :pseudo, password = :password WHERE id_user = :id_user');
                                            $reponse->execute(array(
                                                'pseudo' => $_POST['pseudo'],
                                                'password' => $pass_hache,
                                                'id_user' => $_SESSION['id_user']));
                                            $reponse->closeCursor(); // libère la connexion au serveur, permettant ainsi à d'autres requêtes SQL d'être exécutées 
                                                
                                            $reponse = $pdo->prepare('SELECT * FROM users WHERE id_user = :id_user');
                                            $reponse->execute(array('id_user' => $_SESSION['id_user']));
                                            $donnees = $reponse->fetch();
                                            // met à jour la session avec les nouvelles variables (si l'utilisateur à fait des modifications dans ses infos de connexion)
                    
                                            $pseudo = $donnees['pseudo'];
                                            $_SESSION['pseudo'] = $pseudo;
                                                
                                            ?> 
                                            <br>
                                            <br>
                                            <div class="msg_success">
                                                <p style="color:green;">Les modifications ont été apportées avec succès!</p>
                                            </div>
                                            <?php
                                        }
                                    else
                                    {
                                        ?> 
                                        <br>
                                        <br>
                                        <div class="msg_error">
                                            <p style="color:red;">Cet identifiant est déjà pris, merci d'en choisir un autre</p>
                                        </div>
                                        <?php    
                                    }   
                                }
                                else
                                {
                                    ?> 
                                    <br>
                                    <br>
                                    <div class="msg_error">
                                        <p style="color:red;">Votre mot de passe actuel n'est pas bon, merci de corriger votre saisie.</p>
                                    </div>
                                    <?php  
                                }        
                            }  
                        else
                        {
                            ?> 
                            <br>
                            <br>
                            <div class="msg_error">
                                <p style="color:red;">Vos mots de passe ne sont pas identiques, merci de corriger votre saisie.</p>
                            </div>
                            <br>
                            <?php      
                            }
                        }  
                            ?>
                    </form>
            </div>
            <hr>
<!-- formulaire de modification question secrete--> 
            <div class="modify_profile">
                <h2 class="title_edit"> Question / réponse secrète</h2>
                    <form action="modifyprofile.php" method="post">
                        <div>
                            <label for="question" class="names"><strong>Veuillez inserter une nouvelle QUESTION :</strong></label>
                            <br>
                            <textarea id="question" name="question" cols="30" rows="3" 
                            placeholder="Par exemple 'Le nom de mon premier prof de maths?'" class="insert_box" required></textarea>
                        </div>
                        <br>
                        <div class="formulaire_reponse">
                            <label for="reponse" class="names"><strong>Veuillez inserter une nouvelle RÉPONSE :</strong></label>
                            <br>
                            <input type="text" id="reponse" name="reponse" class="insert_box_mobile" required>
                        </div>
                        <br>
                        <input id="ancre_name" type="submit" value="Modifier" class="submit_button">
                            <?php 
                            if (isset ($_POST['question']) && ($_POST['reponse']))
                            {
                                $reponse = $pdo->prepare('UPDATE users SET question = :question, reponse = :reponse 
                                                        WHERE pseudo = :pseudo');
                                $reponse->execute(array(
                                    'question' => $_POST['question'],
                                    'reponse' => $_POST['reponse'],
                                    'pseudo' => $_SESSION['pseudo']));
                                $reponse->closeCursor(); // libère la connexion au serveur, permettant ainsi à d'autres requêtes SQL d'être exécutées 
                        
                                $reponse = $pdo->prepare('SELECT * FROM users WHERE pseudo = :pseudo');
                                $reponse->execute(array('pseudo' => $_SESSION['pseudo']));
                                $donnees = $reponse->fetch();
                                // met à jour la session avec les nouvelles variables (si l'utilisateur à fait des modifications dans ses infos perso)
                        
                                $question = $donnees['question'];
                                $_SESSION['question'] = $question;
                                $reponse = $donnees['reponse'];
                                $_SESSION['reponse'] = $reponse;    
                                
                            ?>
                        <br>
                        <br>
                        <div class="msg_success">
                            <p style="color:green;">Les modifications ont été apportées avec succès!</p>
                        </div>
                        <?php
                        $reponse->closeCursor(); // libère la connexion au serveur, permettant ainsi à d'autres requêtes SQL d'être exécutées 
                        }          
                        ?>
                    </form>
            </div>
        </section>
        <?php include("../php/footer.php"); ?>
    </body>
</html>