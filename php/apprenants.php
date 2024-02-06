<?php
// Gestion Apprenants
if (isset($_GET["page"]) && $_GET["page"] == "apprenants") {
?>
    <main>
        <h1>Gestion des Apprenants</h1>
        <form method="POST">
            <fieldset>
                <legend>Ajouter des Apprenants</legend>

                <label for="nomApprenant">Nom</label>
                <input type="text" name="nomApprenant" id="nomApprenant">

                <label for="prenomApprenant">Prénom</label>
                <input type="text" name="prenomApprenant" id="prenomApprenant">

                <label for="emailApprenant">Email</label>
                <input type="email" name="emailApprenant" id="emailApprenant">

                <label for="adresseApprenant">Adresse</label>
                <input type="text" name="adresseApprenant" id="adresseApprenant">

                <label for="villeApprenant">Ville</label>
                <input type="text" name="villeApprenant" id="villeApprenant">

                <label for="codePostalApprenant">Code Postal</label>
                <input type="number" name="codePostalApprenant" id="codePostalApprenant">

                <label for="telephoneApprenant">Télephone</label>
                <input type="tel" name="telephoneApprenant" id="telephoneApprenant">

                <label for="dateDeNaissanceApprenant">Date de naissance</label>
                <input type="date" name="dateDeNaissanceApprenant" id="dateDeNaissanceApprenant">

                <label for="niveauApprenant">Niveau</label>
                <input type="text" name="niveauApprenant" id="niveauApprenant">

                <label for="numeroPoleEmploiApprenant">N° Pôle Emploi</label>
                <input type="text" name="numeroPoleEmploiApprenant" id="numeroPoleEmploiApprenant">

                <label for="numeroSecuriteSocialeApprenant">N° Sécurité sociale</label>
                <input type="number" name="numeroSecuriteSocialeApprenant" id="numeroSecuriteSocialeApprenant">

                <label for="ribApprenant">RIB</label>
                <input type="text" name="ribApprenant" id="ribApprenant">

                <label for="idSessionApprenant">Session</label>
                <select name="sessionApprenant" id="idSessionApprenant">
                    <option value="" hidden>Choissisez une session</option>

                    <?php
                    $sql = "SELECT `id_session`, `nom_session` FROM `session`";
                    $requete = $bdd->query($sql);
                    $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($results as $value) {
                        echo '<option value="' . $value['id_session'] .  '">' . $value['nom_session'] . '</option>';
                    }
                    ?>
                </select>

                <input type="submit" name="submitApprenant" value="Ajouter">
            </fieldset>
        </form>

        <?php
        if (isset($_GET['type']) && $_GET['type'] == "modifier") {

            $id = $_GET["id"];
            $sqlId = "SELECT * FROM `apprenants` WHERE id_apprenant = $id";
            $requeteId = $bdd->query($sqlId);
            $resultsId = $requeteId->fetch(PDO::FETCH_ASSOC);
        ?>
            <form method="POST">
                <input type="hidden" name="updateIdApprenant" value="<?php echo $resultsId['id_apprenant']; ?>">
                <input type="text" name="updateNomApprenant" value="<?php echo $resultsId['nom_apprenant']; ?>">
                <input type="text" name="updatePrenomApprenant" value="<?php echo $resultsId['prenom_apprenant']; ?>">
                <input type="mail" name="updateMailApprenant" value="<?php echo $resultsId['mail_apprenant']; ?>">
                <input type="text" name="updateAdresseApprenant" value="<?php echo $resultsId['adresse_apprenant']; ?>">
                <input type="text" name="updateVilleApprenant" value="<?php echo $resultsId['ville_apprenant']; ?>">
                <input type="text" name="updateCpApprenant" value="<?php echo $resultsId['code_postal_apprenant']; ?>">
                <input type="text" name="updateTelApprenant" value="<?php echo $resultsId['tel_apprenant']; ?>">
                <input type="date" name="updateDateApprenant" value="<?php echo $resultsId['date_naissance_apprenant']; ?>">
                <input type="text" name="updateNiveauApprenant" value="<?php echo $resultsId['niveau_apprenant']; ?>">
                <input type="text" name="updateNumPEApprenant" value="<?php echo $resultsId['num_PE_apprenant']; ?>">
                <input type="text" name="updateNumSecuApprenant" value="<?php echo $resultsId['num_secu_apprenant']; ?>">
                <input type="text" name="updateRibApprenant" value="<?php echo $resultsId['rib_apprenant']; ?>">
                <select name="roleApprenant" id="idroleApprenant">
                    <?php
                    $sql = "SELECT `id_role`, `nom_role` FROM `role`";
                    $requete = $bdd->query($sql);
                    $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($results as $value) {
                        $selected = ($value['id_role'] == $resultsId['id_role']) ? 'selected' : '';
                        echo '<option value="' . $value['id_role'] . '" ' . $selected . '>' . $value['nom_role'] . '</option>';
                    }
                    ?>
                </select>

                <select name="sessionApprenant" id="idSessionApprenant">
                    <?php
                    $sql = "SELECT `id_session`, `nom_session` FROM `session`";
                    $requete = $bdd->query($sql);
                    $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($results as $value) {
                        $selected = ($value['id_session'] == $resultsId['id_session']) ? 'selected' : '';
                        echo '<option value="' . $value['id_session'] . '" ' . $selected . '>' . $value['nom_session'] . '</option>';
                    }
                    ?>
                </select>

                <input type="submit" name="updateApprenant" value="Modifier">
            </form>
        <?php
            if (isset($_POST["updateApprenant"])) {
                $updateIdApprenant = $_POST["updateIdApprenant"];
                $updateNomApprenant = $_POST["updateNomApprenant"];
                $updatePrenomApprenant = $_POST["updatePrenomApprenant"];
                $updateMailApprenant = $_POST["updateMailApprenant"];
                $updateAdresseApprenant = $_POST["updateAdresseApprenant"];
                $updateVilleApprenant = $_POST["updateVilleApprenant"];
                $updateCpApprenant = $_POST["updateCpApprenant"];
                $updateTelApprenant = $_POST["updateTelApprenant"];
                $updateDateApprenant = $_POST["updateDateApprenant"];
                $updateNiveauApprenant = $_POST["updateNiveauApprenant"];
                $updateNumPEApprenant = $_POST["updateNumPEApprenant"];
                $updateNumSecuApprenant = $_POST["updateNumSecuApprenant"];
                $updateRibApprenant = $_POST["updateRibApprenant"];
                // 
                $sqlUpdate = "UPDATE `apprenants` 
    SET 
    `nom_apprenant`='$updateNomApprenant',
    `prenom_apprenant`='$updatePrenomApprenant',
    `mail_apprenant`='$updateMailApprenant',
    `adresse_apprenant`='$updateAdresseApprenant',
    `ville_apprenant`='$updateVilleApprenant',
    `code_postal_apprenant`='$updateCpApprenant',
    `tel_apprenant`='$updateTelApprenant',
    `date_naissance_apprenant`='$updateDateApprenant',
    `niveau_apprenant`='$updateNiveauApprenant',
    `num_PE_apprenant`='$updateNumPEApprenant',
    `num_secu_apprenant`='$updateNumSecuApprenant',
    `rib_apprenant`='$updateRibApprenant'

    WHERE `id_apprenant` = $updateIdApprenant";

                $bdd->query($sqlUpdate);
                echo "Données modifiées";
            }
        }
        if (isset($_POST['submitApprenant'])) {
            $nomApprenant = $_POST['nomApprenant'];
            $prenomApprenant = $_POST['prenomApprenant'];
            $emailApprenant = $_POST['emailApprenant'];
            $adresseApprenant = $_POST['adresseApprenant'];
            $villeApprenant = $_POST['villeApprenant'];
            $codePostalApprenant = $_POST['codePostalApprenant'];
            $telephoneApprenant = $_POST['telephoneApprenant'];
            $dateDeNaissanceApprenant = $_POST['dateDeNaissanceApprenant'];
            $niveauApprenant = $_POST['niveauApprenant'];
            $numeroPoleEmploiApprenant = $_POST['numeroPoleEmploiApprenant'];
            $numeroSecuriteSocialeApprenant = $_POST['numeroSecuriteSocialeApprenant'];
            $ribApprenant = $_POST['ribApprenant'];
            $sessionApprenant = $_POST['sessionApprenant'];
            $ribApprenant = $_POST['ribApprenant'];

            $sql =
                "INSERT INTO `apprenants`(
                    `nom_apprenant`, 
                    `prenom_apprenant`, 
                    `mail_apprenant`, 
                    `adresse_apprenant`, 
                    `ville_apprenant`, 
                    `code_postal_apprenant`, 
                    `tel_apprenant`, 
                    `date_naissance_apprenant`, 
                    `niveau_apprenant`, 
                    `num_PE_apprenant`, 
                    `num_secu_apprenant`, 
                    `id_role`,
                    `id_session`,
                    `rib_apprenant`
                ) 
                VALUES (
                    '$nomApprenant',
                    '$prenomApprenant',
                    '$emailApprenant',
                    '$adresseApprenant',
                    '$villeApprenant',
                    '$codePostalApprenant',
                    '$telephoneApprenant',
                    '$dateDeNaissanceApprenant',
                    '$niveauApprenant',
                    '$numeroPoleEmploiApprenant',
                    '$numeroSecuriteSocialeApprenant',
                    4,
                    '$sessionApprenant',
                    '$ribApprenant'
                )";

            $bdd->query($sql);

            echo "data ajoutée dans la bdd";
        }
        ?>

        <article>
            <h2>Apprenants</h2>
            <?php
            // Lire des données dans la BDD
            $sql = "SELECT apprenants.*, role.nom_role, session.nom_session
                                                FROM apprenants
                                                INNER JOIN role ON apprenants.id_role = role.id_role
                                                INNER JOIN session ON apprenants.id_session = session.id_session;";
            $requete = $bdd->query($sql);
            $results = $requete->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <form method="POST">
                <fieldset>
                    <legend>Nos sessions</legend>
                    <table>
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Email</th>
                                <th>Adresse</th>
                                <th>Ville</th>
                                <th>Code Postal</th>
                                <th>Téléphone</th>
                                <th>Date de naissance</th>
                                <th>Niveau</th>
                                <th>N° Pôle Emploi</th>
                                <th>N° Sécurité sociale</th>
                                <th>RIB</th>
                                <th>Rôle</th>
                                <th>Session</th>
                                <th>Modification</th>
                                <th>Suppression</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($results as $value) {
                            echo '
                                <input type="hidden" name="' . 'idApprenant' . $value['id_apprenant'] . '"value="' . $value['id_apprenant'] . '">
                                <tr>
                                <td>' . $value['nom_apprenant'] . '</td>    
                                <td>' . $value['prenom_apprenant'] . '</td>    
                                <td>' . $value['mail_apprenant'] . '</td>    
                                <td>' . $value['adresse_apprenant'] . '</td>    
                                <td>' . $value['ville_apprenant'] . '</td>    
                                <td>' . $value['code_postal_apprenant'] . '</td>    
                                <td>' . $value['tel_apprenant'] . '</td>    
                                <td>' . $value['date_naissance_apprenant'] . '</td>    
                                <td>' . $value['niveau_apprenant'] . '</td>    
                                <td>' . $value['num_PE_apprenant'] . '</td>    
                                <td>' . $value['num_secu_apprenant'] . '</td>    
                                <td>' . $value['rib_apprenant'] . '</td> 
                                <td>' . $value['nom_role'] . '</td>
                                <td>' . $value['nom_session'] . '</td>  
                                <td><button type="button" onclick="window.location.href=\'?page=apprenants&type=modifier&id=' . $value['id_apprenant'] . '\'">Modifier</button></td>                                  
                                <td><button type="submit" name="deleteApprenant" value="' . $value['id_apprenant'] . '" class="supprimer">Supprimer</button></td>';
                        }


                        if (isset($_POST['deleteApprenant'])) {
                            $idApprenantDelete = $_POST['deleteApprenant'];
                            $sql = "DELETE FROM apprenants WHERE `apprenants`.`id_apprenant` = $idApprenantDelete";
                            if ($bdd->query($sql)) {
                                echo "Le membre a été supprimé de la BDD.";
                            } else {
                                echo "Erreur lors de la suppression du membre.";
                            }
                        }
                    }
                        ?>
                        </tr>
                        </tbody>
                    </table>
                </fieldset>
            </form>
        </article>
    </main>