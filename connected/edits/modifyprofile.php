<?php
session_start();
require '../configs/db.php';

// Cherche L'utilisateur dans la BDD (voir account)
$dataAccountOld = searchUsername($_SESSION['username']);

// si on envoie le formulaire
if (isset($_POST['dataSubmit'])) {

    $dataAccount = searchUsername($bdd, $_POST['username']);

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

                // Change les infos de la BDD
                $req_update_infos_user = $bdd->prepare('UPDATE account SET 
                                            username = :username,
                                            firstname = :firstname, 
                                            lastname = :lastname,
                                            question = :question,
                                            reponse = :reponse
                                            WHERE id_user = :id_user
                                            ');
                $req_update_infos_user->execute(array(
                    'username' => ($_POST['username']),
                    'firstname' => ($_POST['firstname']),
                    'lastname' => ($_POST['lastname']),
                    'question' => ($_POST['question']),
                    'reponse' => $reponseHashed,
                    'id_user' => $dataAccountOld['id_user']
                ));

                $usernameNew = $_POST['username'];
                $req_update_infos_user->closeCursor();

                // Récupère les nouvelles valeurs de SESSION (fonction voir account)
                $dataAccountNew = searchUser($bdd, $usernameNew);

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
}
?>

    <main class="inscription-connexion">
        <div class="form_container">
            <fieldset>
                <legend>Modifier son Profil</legend>

                <!-- ajoute un message erreur ?-->
                <!-- Formulaire -->
                <form method="post" action="modifyprofile.php">
                    <p>
                        <label for="username">Identifiant : </label>
                        <input 
                            type="text"
                            id="username"
                            name="username"
                            size="20" 
                            value="<?php defaultInputValue('username', $dataAccountOld['username']);?>"
                        />

                        <label for="firtsname">Prénom : </label>
                        <input
                            type="text"
                            id="firtsname"
                            name="firtsname"
                            size="30"
                            value="<?php defaultInputValue('firstname', $dataAccountOld['firstname']);?>"
                        />


                        <label for="lastname">Nom : </label>
                        <input 
                            type="text"
                            id="lastname"
                            name="lastname"
                            size="30"
                            value="<?php defaultInputValue('lastname', $dataAccountOld['lastname']);?>"
                        />


                        <label for="question">Votre question secrète : </label>
                        <input
                            type="text"
                            id="question"
                            name="question"
                            value="<?php defaultInputValue('question', $dataAccountOld['question']);?>"
                        />


                        <label for="reponse">La réponse à votre question : </label>
                        <input
                            type="text" 
                            id="reponse" 
                            name="reponse"
                            value=""
                        />

                        <label for="mp">Entrez votre mot de passe: </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            size="20"
                        />

                        <input
                            class="button_envoyer"
                            type="submit"
                            name="dataSubmit"
                            value="Envoyer"
                            onclick="unsetPreviousSession()"
                        />

                        <span>
                            <em>*</em> Tous les champs doivent être remplis
                        </span>

                    </p>
                </form>
                <a href="../connected/homepage.php"> Retour à l'accueil </a>
            </fieldset>
        </div>
    </main>