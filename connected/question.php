<!-- forumulaire de modification des informations personnelles-->   
<div class="infos_perso">
            <h2> Changer mon question secrete</h2>
            <p>Vous trouverez ci-dessous un formulaire vous permettant de changer votre question secrète. 
                Celle-ci est utilisée pour changer de mot de passe lorsque vous oubliez ce dernier.
            </p>
            <div class="formulaire_infos_perso">
                <form action="modifyprofile_copy.php" method="post">
                
                <div class="formulaire_question">
                        <label for="question"><strong>Votre ancien question : </strong></label>
                        <br>
                        <input type="text" id="question" name="question" value="<?php echo isset($_POST['question'])? strtoupper($_POST['question']) : $_SESSION['question'];?>" autofocus required>
                        <!-- champ pour le question avec préremplissage du champ avec les informations déjà remplis (en cas de rechargement du formulaire)-->
                    </div>
                    <br>

                    <div class="formulaire_reponse">
                        <label for="reponse"><strong>Votre ancienne reponse : </strong></label>
                        <br>
                        <input type="text" id="reponse" name="reponse" value="<?php echo isset($_POST['reponse'])? $_POST['reponse'] : $_SESSION['reponse'];?>" required>
                        <!-- champ pour le reponse avec préremplissage du champ avec les informations déjà remplis (en cas de rechargement du formulaire)-->
                    </div>
                        <br>
                    <input id="ancre_name" type="submit" value="Modifier" class="button_submit">
                    <?php 
                    if (isset ($_POST['question']) && ($_POST['reponse']))
                    // vérifie si les variables sont déclarées et sont différentes de null.
                    {
                        $reponse = $pdo->prepare('UPDATE users SET question = :question, reponse = :reponse 
                                                WHERE pseudo = :pseudo');
                        // met à jour toutes les informations du formulaire en base dans la table "user"
                        $reponse->execute(array(
                            'question' => $_POST['question'],
                            'reponse' => $_POST['reponse'],
                            'pseudo' => $_SESSION['pseudo']
                        ));
                        $reponse->closeCursor(); // libère la connexion au serveur, permettant ainsi à d'autres requêtes SQL d'être exécutées 
                
                        $reponse = $pdo->prepare('SELECT * FROM users WHERE pseudo = :pseudo'); // va chercher dans la pdo toutes les informations de la table user de la la ligne correspondant au pseudo présent en session
                        $reponse->execute(array(
                            'pseudo' => $_SESSION['pseudo'],
                        ));
                        $donnees = $reponse->fetch();
                        
                        // met à jour la session avec les nouvelles variables (si l'utilisateur à fait des modifications dans ses infos perso)
                
                        $question = $donnees['question'];
                        $_SESSION['question'] = $question;
                        $reponse = $donnees['reponse'];
                        $_SESSION['reponse'] = $reponse;                
                    ?>
                            <br>
                    <br>
                    <div class="msg_success"> <!-- message pour informer l'utilisateur que les informations de son compte ont été modifiée-->
                    <p style="color:green;">Félicitation, vos informations ont été modifiées avec succès!</p>
                    </div>
                    <?php
                    $reponse->closeCursor(); // libère la connexion au serveur, permettant ainsi à d'autres requêtes SQL d'être exécutées 
                }              
                    ?>
                </form>
        </div>
    </div>
    
    <div class="separator"></div>