<?php
session_start();
require 'configs/db.php';

// REDIRECTION: CONNECTÉ
if (isset($_SESSION['username']) && isset($_SESSION['id_user'])) {
    header('Location: /homepage.php');
    exit();
}

    // Les Formulaires 
    $formDefault = '<label for="username">Identifiant : </label>
        <input type="text" id="username" name="username" size="20">';

    $formQuestion = '<input type="textarea" id="reponse" name="reponse">';

    $fomPasswordChange = '<label for="password">Nouveau mot de passe : </label>
        <input type="password" id="mp" name="password" size="20">';

    $formType = $formDefault;

    /*-----------------------  Si l'utilisateur existe, Affiche la question et son formulaire */

    if (isset($_POST['username'])) {

        // Cherche si l'utilisateur dans la BDD (voir account)
        $dataAccount = searchUser($sql, $_POST['username']);

        if ($dataAccount) {

            // récupère son username pour les autres formulaires
            $_SESSION['username'] = $dataAccount['username'];
            // On donne la question
            $formType = $formQuestion;
            $question = '<label for="reponse">' . $dataAccount['question'] . ' </label>';
            $message = QUESTION;
        }
        if (!$dataAccount) {

            $message = USERNAME_UNKNOWN;
        }
    }

    /*----------------------- Si on répond à la question secrète */

    if (isset($_POST['reponse'])) {

        $formType = $formQuestion;
        $dataAccount = searchUser($bdd, $_SESSION['username']);
        $questionUser = $dataAccount['question'];
        $message = QUESTION;
        $isGoodAnswer = password_verify($_POST['reponse'], $dataAccount['reponse']);

        // Si la réponse correspond
        if ($isGoodAnswer){

            unset($questionUser);
            // On affiche le formulaire de changement de mot de passe
            $formType = $fomPasswordChange;
            $message = PASSWORD_CAN_CHANGE;
        }
        if (!$isGoodAnswer) {

            $questionUser = $dataAccount['question'];
            $message = ANSWER_WRONG;
        }
    }

    /*----------------------- Si on modifie son mot de passe */

    if (isset($_POST['password'])) {

        unset($questionUser);
        $formType = $fomPasswordChange;

        // Si le nouveau mot de passe est conforme
        if (preg_match($mpValid, $_POST['password'])) {

            // On Hash le mot de passe
            $passwordHashed = password_hash($_POST['password'], PASSWORD_DEFAULT);

            // On remplace le mp dans la base de données
            $req_update_password = $bdd->prepare('UPDATE account SET
                                    password = :password
                                    WHERE username = :username');
            $req_update_password->execute(array(
                'password' => $passwordHashed,
                'username' => $_SESSION['username']));
            $req_update_password->closeCursor();

            $message = PASSWORD_UPDATE;
            $_SESSION['message'] = $message;

            header('Location: /index.php');
            exit();
        }
        if (!preg_match($mpValid, $_POST['password'])) {

            $message = PASSWORD_INVALID;
        }
    }

//  NON CONNECTÉ - page modifier son password
if (!isset($_SESSION['nom']) && !isset($_SESSION['prenom']) && !isset($_SESSION['id_user']))

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
                <?php include("php/logo.php"); ?>
            </header>

            <div class="title">
            <h2>Veuillez changer votre mot de passe</h2>
            </div>
                <div class="inscription_box">
                    <form method="POST" action="forgotpassword.php">
                        <p>
                        <?php   // affiche la question secrète
                            if (isset($questionUser)) {
                                echo $questionUser;
                            }
                                echo $formType;
                        ?>
                        
                        <input type="submit" name="dataSubmit" value="Envoyer"/>
                        </p>
                    </form>
                    <br>
                    <a href="index.php"> Retour à l'acceuil </a>
                </div>    
        </body>
    <?php include("php/footer.php"); ?>
</html>