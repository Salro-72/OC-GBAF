<?php
session_start();
require '../configs/db.php';
include '../configs/account.php';

$_SESSION['username'] = isset($_POST['username']) ? $_POST['username'] : ""; 

// Cherche L'utilisateur dans la bdd (voir account.php)
$dataAccountOld = searchUser($pdo, $_SESSION['username']);

// si on envoie le formulaire
if (isset($_POST['envoyer'])) {
    $dataAccount = searchUser($pdo, $_POST['username']);
}
// Si l'username n'existe pas
if (!$dataAccount OR $dataAccountOld['username'] == $_POST['username']) {

// Verification tous les champs ont été remplis
if (!empty($_POST['firstname']) && !empty($_POST['lastname'])
    && !empty($_POST['question']) && !empty($_POST['reponse'])
    && !empty($_POST['password']) && !empty($_POST['username'])) {

// et que le mot de passe est correct
$isPasswordCorrect = password_verify($_POST['password'], $dataAccountOld['password']);

if ($isPasswordCorrect) {
    $reponseHashed = password_hash($_POST['reponse'], PASSWORD_DEFAULT);

    // Change les infos de la bdd
    $req_update_infos_user = $pdo->prepare('UPDATE account SET 
                                            username = :username,
                                            firstname = :firstname, 
                                            lastname = :lastname,
                                            question = :question,
                                            reponse = :reponse
                                            WHERE id_user = :id_user');
    $req_update_infos_user->execute(array('username' => ($_POST['username']),
                                            'firstname' => ($_POST['firstname']),
                                            'lastname' => ($_POST['lastname']),
                                            'question' => ($_POST['question']),
                                            'reponse' => $reponseHashed,
                                            'id_user' => $dataAccountOld['id_user']));

    $usernameNew = $_POST['username'];
    $req_update_infos_user->closeCursor();

// Récupère les nouvelles valeurs de SESSION (fonction voir account)
    $dataAccountNew = searchUser($pdo, $usernameNew);

    $_SESSION['firstname'] = htmlspecialchars($dataAccountNew['firstname']);
    $_SESSION['lastname'] = htmlspecialchars($dataAccountNew['lastname']);
    $_SESSION['username'] = htmlspecialchars($dataAccountNew['username']);

    $message = ACCOUNT_UPDATE;
}
    if (!$isPasswordCorrect) {
        $message = PASSWORD_WRONG;
    }
} 
    if (empty($_POST['firstname']) OR empty($_POST['lastname'])
        OR empty($_POST['question']) OR empty($_POST['reponse'])
        OR empty($_POST['password']) OR empty($_POST['username'])) {            
            $message = EMPTY_FIELD;
    }
}
    if ($dataAccount AND $dataAccountOld['username'] != $_POST['username']) {
            $message = USERNAME_EXIST;
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
                <?php include("../php/logo.php"); ?>
                
                <div class="title">
                    <h1>Modifier votre profile:</h1>
                </div>
                <div class="profil_connected">
                    <img src="../GBAF_img/profile.png" alt="img_profile" class="img_profile"/>
                    <!-- ajoute ici le nom d'utilisateur connecté -->
                </div>
                <div class="topnav">
                    <a href="homepage.php">Acceuil</a>
                    <a class="active" href="modifyprofile_copy.php">TEST Modifier votre profile</a>
                    <a href="logout.php">Déconnexion</a>
                </div>

            </header>

            <main>
            <div class="message_erreur">
                <!-- message erreur -->
                <span>
                    <?php echo $message; ?>
                </span>
                    <!-- Formulaire -->
                    <form method="post" action="modifyprofile_copy.php" class="edit_box">
                        <p>
                            <label for="username">Identifiant : </label>
                            <input type="text" id="username" name="username" size="20" 
                            value="<?php defaultInputValue('username', $dataAccountOld['username']);?>" />
                        <br>
                        <br>
                            <label for="firstname">Prénom : </label>
                            <input type="text" id="firstname"name="firstname" size="30"
                            value="<?php defaultInputValue('firstname', $dataAccountOld['firstname']);?>" />
                        <br>
                        <br>
                            <label for="lastname">Nom : </label>
                            <input type="text" id="lastname" name="lastname" size="30"
                            value="<?php defaultInputValue('lastname', $dataAccountOld['lastname']);?>" />
                        <br>
                        <br>
                            <label for="question">Votre question secrète : </label>
                            <input type="text" id="question" name="question" size="40"
                            value="<?php defaultInputValue('question', $dataAccountOld['question']);?>" />
                        <br>
                        <br>
                            <label for="reponse">La réponse à votre question : </label>
                            <input type="text" id="reponse" name="reponse" size="40"/>
                        <br>
                        <br>
                            <label for="password">Entrez votre mot de passe: </label>
                            <input type="password" id="password" name="password" size="20" />
                        <br>
                        <br>
                            <input class="button-envoyer" type="submit" name="dataSubmit" value="Envoyer"
                            onclick="unsetPreviousSession()" />
                        <br>
                        <br>
                            <span>
                                <em>*</em> Tous les champs doivent être remplis
                            </span>
                        </p>
                    </form>
            </div>
            </main>

        <?php include("../php/footer.php"); ?>
    </body>
</html>