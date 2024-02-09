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
                        echo '<option value="' . htmlspecialchars($value['id_session'], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($value['nom_session'], ENT_QUOTES, 'UTF-8') . '</option>';
                    }
                    ?>
                </select>

                <input type="submit" name="submitApprenant" value="Ajouter">
            </fieldset>
        </form>

        <?php
        if (isset($_GET['type']) && $_GET['type'] == "modifier") {

            $id = $_GET["id"];
            $sqlId = "SELECT * FROM `apprenants` WHERE id_apprenant = :id";
            $requeteId = $bdd->prepare($sqlId);
            $requeteId->bindParam(':id', $id, PDO::PARAM_INT);
            $requeteId->execute();
            $resultsId = $requeteId->fetch(PDO::FETCH_ASSOC);
        ?>
            <form method="POST">
                <input type="hidden" name="updateIdApprenant" value="<?php echo htmlspecialchars($resultsId['id_apprenant'], ENT_QUOTES, 'UTF-8'); ?>">
                <input type="text" name="updateNomApprenant" value="<?php echo htmlspecialchars($resultsId['nom_apprenant'], ENT_QUOTES, 'UTF-8'); ?>">
                <input type="text" name="updatePrenomApprenant" value="<?php echo htmlspecialchars($resultsId['prenom_apprenant'], ENT_QUOTES, 'UTF-8'); ?>">
                <input type="mail" name="updateMailApprenant" value="<?php echo htmlspecialchars($resultsId['mail_apprenant'], ENT_QUOTES, 'UTF-8'); ?>">
                <input type="text" name="updateAdresseApprenant" value="<?php echo htmlspecialchars($resultsId['adresse_apprenant'], ENT_QUOTES, 'UTF-8'); ?>">
                <input type="text" name="updateVilleApprenant" value="<?php echo htmlspecialchars($resultsId['ville_apprenant'], ENT_QUOTES, 'UTF-8'); ?>">
                <input type="text" name="updateCpApprenant" value="<?php echo htmlspecialchars($resultsId['code_postal_apprenant'], ENT_QUOTES, 'UTF-8'); ?>">
                <input type="text" name="updateTelApprenant" value="<?php echo htmlspecialchars($resultsId['tel_apprenant'], ENT_QUOTES, 'UTF-8'); ?>">
                <input type="date" name="updateDateApprenant" value="<?php echo htmlspecialchars($resultsId['date_naissance_apprenant'], ENT_QUOTES, 'UTF-8'); ?>">
                <input type="text" name="updateNiveauApprenant" value="<?php echo htmlspecialchars($resultsId['niveau_apprenant'], ENT_QUOTES, 'UTF-8'); ?>">
                <input type="text" name="updateNumPEApprenant" value="<?php echo htmlspecialchars($resultsId['num_PE_apprenant'], ENT_QUOTES, 'UTF-8'); ?>">
                <input type="text" name="updateNumSecuApprenant" value="<?php echo htmlspecialchars($resultsId['num_secu_apprenant'], ENT_QUOTES, 'UTF-8'); ?>">
                <input type="text" name="updateRibApprenant" value="<?php echo htmlspecialchars($resultsId['rib_apprenant'], ENT_QUOTES, 'UTF-8'); ?>">

                <select name="roleApprenant" id="idroleApprenant">
                    <?php
                    $sql = "SELECT `id_role`, `nom_role` FROM `role`";
                    $requete = $bdd->query($sql);
                    $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($results as $value) {
                        $selected = ($value['id_role'] == $resultsId['id_role']) ? 'selected' : '';
                        echo '<option value="' . htmlspecialchars($value['id_role'], ENT_QUOTES, 'UTF-8') . '" ' . $selected . '>' . htmlspecialchars($value['nom_role'], ENT_QUOTES, 'UTF-8') . '</option>';
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
                        echo '<option value="' . htmlspecialchars($value['id_session'], ENT_QUOTES, 'UTF-8') . '" ' . $selected . '>' . htmlspecialchars($value['nom_session'], ENT_QUOTES, 'UTF-8') . '</option>';
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

                $sqlUpdate = "UPDATE `apprenants` 
                SET 
                `nom_apprenant`=:updateNomApprenant,
                `prenom_apprenant`=:updatePrenomApprenant,
                `mail_apprenant`=:updateMailApprenant,
                `adresse_apprenant`=:updateAdresseApprenant,
                `ville_apprenant`=:updateVilleApprenant,
                `code_postal_apprenant`=:updateCpApprenant,
                `tel_apprenant`=:updateTelApprenant,
                `date_naissance_apprenant`=:updateDateApprenant,
                `niveau_apprenant`=:updateNiveauApprenant,
                `num_PE_apprenant`=:updateNumPEApprenant,
                `num_secu_apprenant`=:updateNumSecuApprenant,
                `rib_apprenant`=:updateRibApprenant

                WHERE `id_apprenant` = :updateIdApprenant";

                $requeteUpdate = $bdd->prepare($sqlUpdate);
                $requeteUpdate->bindParam(':updateNomApprenant', $updateNomApprenant, PDO::PARAM_STR);
                $requeteUpdate->bindParam(':updatePrenomApprenant', $updatePrenomApprenant, PDO::PARAM_STR);
                $requeteUpdate->bindParam(':updateMailApprenant', $updateMailApprenant, PDO::PARAM_STR);
                $requeteUpdate->bindParam(':updateAdresseApprenant', $updateAdresseApprenant, PDO::PARAM_STR);
                $requeteUpdate->bindParam(':updateVilleApprenant', $updateVilleApprenant, PDO::PARAM_STR);
                $requeteUpdate->bindParam(':updateCpApprenant', $updateCpApprenant, PDO::PARAM_STR);
                $requeteUpdate->bindParam(':updateTelApprenant', $updateTelApprenant, PDO::PARAM_STR);
                $requeteUpdate->bindParam(':updateDateApprenant', $updateDateApprenant, PDO::PARAM_STR);
                $requeteUpdate->bindParam(':updateNiveauApprenant', $updateNiveauApprenant, PDO::PARAM_STR);
                $requeteUpdate->bindParam(':updateNumPEApprenant', $updateNumPEApprenant, PDO::PARAM_STR);
                $requeteUpdate->bindParam(':updateNumSecuApprenant', $updateNumSecuApprenant, PDO::PARAM_STR);
                $requeteUpdate->bindParam(':updateRibApprenant', $updateRibApprenant, PDO::PARAM_STR);
                $requeteUpdate->bindParam(':updateIdApprenant', $updateIdApprenant, PDO::PARAM_INT);

                if ($requeteUpdate->execute()) {
                    echo "Données modifiées";
                } else {
                    echo "Erreur lors de la modification des données.";
                }
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
                    :nomApprenant,
                    :prenomApprenant,
                    :emailApprenant,
                    :adresseApprenant,
                    :villeApprenant,
                    :codePostalApprenant,
                    :telephoneApprenant,
                    :dateDeNaissanceApprenant,
                    :niveauApprenant,
                    :numeroPoleEmploiApprenant,
                    :numeroSecuriteSocialeApprenant,
                    4,
                    :sessionApprenant,
                    :ribApprenant
                )";

            $requeteInsert = $bdd->prepare($sql);
            $requeteInsert->bindParam(':nomApprenant', $nomApprenant, PDO::PARAM_STR);
            $requeteInsert->bindParam(':prenomApprenant', $prenomApprenant, PDO::PARAM_STR);
            $requeteInsert->bindParam(':emailApprenant', $emailApprenant, PDO::PARAM_STR);
            $requeteInsert->bindParam(':adresseApprenant', $adresseApprenant, PDO::PARAM_STR);
            $requeteInsert->bindParam(':villeApprenant', $villeApprenant, PDO::PARAM_STR);
            $requeteInsert->bindParam(':codePostalApprenant', $codePostalApprenant, PDO::PARAM_STR);
            $requeteInsert->bindParam(':telephoneApprenant', $telephoneApprenant, PDO::PARAM_STR);
            $requeteInsert->bindParam(':dateDeNaissanceApprenant', $dateDeNaissanceApprenant, PDO::PARAM_STR);
            $requeteInsert->bindParam(':niveauApprenant', $niveauApprenant, PDO::PARAM_STR);
            $requeteInsert->bindParam(':numeroPoleEmploiApprenant', $numeroPoleEmploiApprenant, PDO::PARAM_STR);
            $requeteInsert->bindParam(':numeroSecuriteSocialeApprenant', $numeroSecuriteSocialeApprenant, PDO::PARAM_STR);
            $requeteInsert->bindParam(':sessionApprenant', $sessionApprenant, PDO::PARAM_STR);
            $requeteInsert->bindParam(':ribApprenant', $ribApprenant, PDO::PARAM_STR);

            if ($requeteInsert->execute()) {
                echo "Données ajoutées dans la BDD";
            } else {
                echo "Erreur lors de l'ajout des données dans la BDD.";
            }
        }
        ?>

        <article>
            <h2>Apprenants</h2>

            <?php
            // Lire des données dans la BDD
            function affichage($table){
                return "SELECT *, role.nom_role, session.nom_session FROM $table
                INNER JOIN role ON apprenants.id_role = role.id_role
                INNER JOIN session ON apprenants.id_session = session.id_session;";
            }
            $sql = affichage("`apprenants`");

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
                                <input type="hidden" name="' . 'idApprenant' . htmlspecialchars($value['id_apprenant'], ENT_QUOTES, 'UTF-8') . '"value="' . htmlspecialchars($value['id_apprenant'], ENT_QUOTES, 'UTF-8') . '">
                                <tr>
                                <td>' . htmlspecialchars($value['nom_apprenant'], ENT_QUOTES, 'UTF-8') . '</td>    
                                <td>' . htmlspecialchars($value['prenom_apprenant'], ENT_QUOTES, 'UTF-8') . '</td>    
                                <td>' . htmlspecialchars($value['mail_apprenant'], ENT_QUOTES, 'UTF-8') . '</td>    
                                <td>' . htmlspecialchars($value['adresse_apprenant'], ENT_QUOTES, 'UTF-8') . '</td>    
                                <td>' . htmlspecialchars($value['ville_apprenant'], ENT_QUOTES, 'UTF-8') . '</td>    
                                <td>' . htmlspecialchars($value['code_postal_apprenant'], ENT_QUOTES, 'UTF-8') . '</td>    
                                <td>' . htmlspecialchars($value['tel_apprenant'], ENT_QUOTES, 'UTF-8') . '</td>    
                                <td>' . htmlspecialchars($value['date_naissance_apprenant'], ENT_QUOTES, 'UTF-8') . '</td>    
                                <td>' . htmlspecialchars($value['niveau_apprenant'], ENT_QUOTES, 'UTF-8') . '</td>    
                                <td>' . htmlspecialchars($value['num_PE_apprenant'], ENT_QUOTES, 'UTF-8') . '</td>    
                                <td>' . htmlspecialchars($value['num_secu_apprenant'], ENT_QUOTES, 'UTF-8') . '</td>    
                                <td>' . htmlspecialchars($value['rib_apprenant'], ENT_QUOTES, 'UTF-8') . '</td> 
                                <td>' . htmlspecialchars($value['nom_role'], ENT_QUOTES, 'UTF-8') . '</td>
                                <td>' . htmlspecialchars($value['nom_session'], ENT_QUOTES, 'UTF-8') . '</td>  
                                <td><button type="button" onclick="window.location.href=\'?page=apprenants&type=modifier&id=' . htmlspecialchars($value['id_apprenant'], ENT_QUOTES, 'UTF-8') . '" class="modifier">Modifier</button></td>                                  
                                <td><button type="submit" name="deleteApprenant" value="' . htmlspecialchars($value['id_apprenant'], ENT_QUOTES, 'UTF-8') . '" class="supprimer">Supprimer</button></td>';
                        }

                        if (isset($_POST['deleteApprenant'])) {
                            $idApprenantDelete = $_POST['deleteApprenant'];
                            $sql = "DELETE FROM apprenants WHERE `apprenants`.`id_apprenant` = :idApprenantDelete";
                            $requeteDelete = $bdd->prepare($sql);
                            $requeteDelete->bindParam(':idApprenantDelete', $idApprenantDelete, PDO::PARAM_INT);

                            if ($requeteDelete->execute()) {
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