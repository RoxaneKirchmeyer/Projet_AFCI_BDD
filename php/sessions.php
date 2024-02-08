<?php
// Gestion sessions
if (isset($_GET["page"]) && $_GET["page"] == "sessions") {
?>
    <main>
        <h1>Gestion des sessions</h1>
        <form method="POST">
            <fieldset>
                <legend>Ajouter des sessions</legend>

                <label for="nomSession">Nom de la session :</label>
                <input type="text" name="nomSession" id="nomSession">

                <label for="debutSession">Date de début :</label>
                <input type="date" name="debutSession" id="debutSession">

                <label for="idCentre">Sélectionnez un centre</label>
                <select name="centre" id="idCentre">
                    <option value="" hidden>Nom du centre</option>
                    <?php

                    $sql = "SELECT `id_centre`, `ville_centre` FROM centres";
                    $requete = $bdd->query($sql);
                    $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($results as $value) {
                        echo '<option value="' . htmlspecialchars($value['id_centre'], ENT_QUOTES, 'UTF-8') . '">' . 'AFCI' . ' - ' . htmlspecialchars($value['ville_centre'], ENT_QUOTES, 'UTF-8') . '</option>';
                    }
                    ?>
                </select>

                <label for="idFormation">Sélectionnez une formation</label>
                <select name="formation" id="idFormation">
                    <option value="" hidden>Nom de la formation</option>
                    <?php


                    $sql = "SELECT `id_formation`, `nom_formation` FROM formations";
                    $requete = $bdd->query($sql);
                    $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($results as $value) {
                        echo '<option value="' . htmlspecialchars($value['id_formation'], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($value['nom_formation'], ENT_QUOTES, 'UTF-8') . '</option>';
                    }
                    ?>
                </select>

                <label for="idFormateur">Sélectionner un formateur</label>
                <select name="formateur" id="idFormateur">
                    <option value="" hidden>Formateur</option>
                    <?php

                    $sql = "SELECT `id_pedagogie`, CONCAT(`nom_pedagogie`, ' ', `prenom_pedagogie`) 
                                            AS `formateur`
                                            FROM `pedagogie`
                                            INNER JOIN `role` 
                                            ON pedagogie.id_role = role.id_role
                                            WHERE role.id_role = 3";
                    $requete = $bdd->query($sql);
                    $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($results as $value) {
                        echo '<option value="' . htmlspecialchars($value['id_pedagogie'], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($value['formateur'], ENT_QUOTES, 'UTF-8') . '</option>';
                    }
                    ?>
                </select>

                <input type="submit" name="submitSession" value="Ajouter">
            </fieldset>
        </form>

        <?php
        if (isset($_POST['submitSession'])) {
            $sql = "INSERT INTO `session`(`nom_session`, `date_debut`, `id_centre`, `id_pedagogie`, `id_formation` ) VALUES (:nomSession, :debutSession, :centre, :formateur, :formation)";
            $requete = $bdd->prepare($sql);

            $nomSession = $_POST['nomSession'];
            $debutSession = $_POST['debutSession'];
            $centre = $_POST['centre'];
            $formation = $_POST['formation'];
            $formateur = $_POST['formateur'];

            $requete->bindParam(':nomSession', $nomSession, PDO::PARAM_STR);
            $requete->bindParam(':debutSession', $debutSession, PDO::PARAM_STR);
            $requete->bindParam(':centre', $centre, PDO::PARAM_INT);
            $requete->bindParam(':formation', $formation, PDO::PARAM_INT);
            $requete->bindParam(':formateur', $formateur, PDO::PARAM_INT);
            $requete->execute();

            echo "Données ajoutées à la BDD";
        }

        if (isset($_GET['type']) && $_GET['type'] == "modifier") {

            $id = $_GET["id"];
            $sqlId = "SELECT * FROM `session` WHERE id_session = :id";
            $requeteId = $bdd->prepare($sqlId);
            $requeteId->bindParam(':id', $id, PDO::PARAM_INT);
            $requeteId->execute();
            $resultsId = $requeteId->fetch(PDO::FETCH_ASSOC);
        ?>
            <form method="POST">
                <input type="hidden" name="updateIdSession" value="<?php echo htmlspecialchars($resultsId['id_session'], ENT_QUOTES, 'UTF-8'); ?>">
                <input type="text" name="updateNomSession" value="<?php echo htmlspecialchars($resultsId['nom_session'], ENT_QUOTES, 'UTF-8'); ?>">
                <input type="date" name="updateDateSession" value="<?php echo htmlspecialchars($resultsId['date_debut'], ENT_QUOTES, 'UTF-8'); ?>">
                <select name="updateCentreSession" id="idCentre">
                    <?php

                    $sql = "SELECT `id_centre`, `ville_centre` FROM centres";
                    $requete = $bdd->query($sql);
                    $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($results as $value) {
                        $selected = ($value['id_centre'] == $resultsId['id_centre']) ? 'selected' : '';
                        echo '<option value="' . htmlspecialchars($value['id_centre'], ENT_QUOTES, 'UTF-8') . '" ' . $selected . '>' . 'AFCI' . ' - ' . htmlspecialchars($value['ville_centre'], ENT_QUOTES, 'UTF-8') . '</option>';
                    }
                    ?>
                </select>

                <select name="updateFormationSession" id="idFormation">
                    <?php


                    $sql = "SELECT `id_formation`, `nom_formation` FROM formations";
                    $requete = $bdd->query($sql);
                    $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($results as $value) {
                        $selected = ($value['id_formation'] == $resultsId['id_formation']) ? 'selected' : '';
                        echo '<option value="' . htmlspecialchars($value['id_formation'], ENT_QUOTES, 'UTF-8') . '" ' . $selected . '>' . htmlspecialchars($value['nom_formation'], ENT_QUOTES, 'UTF-8') . '</option>';
                    }
                    ?>
                </select>

                <select name="updatePedagogieSession" id="idFormateur">
                    <?php

                    $sql = "SELECT `id_pedagogie`, CONCAT(`nom_pedagogie`, ' ', `prenom_pedagogie`) AS `formateur`
                                            FROM `pedagogie`
                                            INNER JOIN `role` ON pedagogie.id_role = role.id_role
                                            WHERE role.id_role = 3";
                    $requete = $bdd->query($sql);
                    $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($results as $value) {
                        $selected = ($value['id_pedagogie'] == $resultsId['id_pedagogie']) ? 'selected' : '';
                        echo '<option value="' . htmlspecialchars($value['id_pedagogie'], ENT_QUOTES, 'UTF-8') . '" ' . $selected . '>' . htmlspecialchars($value['formateur'], ENT_QUOTES, 'UTF-8') . '</option>';
                    }
                    ?>
                </select>
                <input type="submit" name="updateSession" value="Modifier">
            </form>
        <?php
            if (isset($_POST["updateSession"])) {
                $updateIdSession = $_POST["updateIdSession"];
                $updateNomSession = $_POST["updateNomSession"];
                $updateDateSession = $_POST["updateDateSession"];
                $updateCentreSession = $_POST['updateCentreSession'];
                $updatePedagogieSession = $_POST['updatePedagogieSession'];
                $updateFormationSession = $_POST['updateFormationSession'];
                $sqlUpdate = "UPDATE `session` 
                                SET 
                                `nom_session`=:updateNomSession,
                                `date_debut`=:updateDateSession,
                                `id_centre`=:updateCentreSession,
                                `id_formation`=:updateFormationSession,
                                `id_pedagogie`=:updatePedagogieSession
                                WHERE id_session = :updateIdSession";

                $requeteUpdate = $bdd->prepare($sqlUpdate);
                $requeteUpdate->bindParam(':updateIdSession', $updateIdSession, PDO::PARAM_INT);
                $requeteUpdate->bindParam(':updateNomSession', $updateNomSession, PDO::PARAM_STR);
                $requeteUpdate->bindParam(':updateDateSession', $updateDateSession, PDO::PARAM_STR);
                $requeteUpdate->bindParam(':updateCentreSession', $updateCentreSession, PDO::PARAM_INT);
                $requeteUpdate->bindParam(':updateFormationSession', $updateFormationSession, PDO::PARAM_INT);
                $requeteUpdate->bindParam(':updatePedagogieSession', $updatePedagogieSession, PDO::PARAM_INT);

                if ($requeteUpdate->execute()) {
                    echo "Données modifiées";
                } else {
                    echo "Erreur lors de la modification des données.";
                }
            }
        }
        ?>
        
        <article>
            <h2>Sessions</h2>

            <?php

            // Lire des données dans la BDD formations
            $sql = "SELECT `id_session`, `nom_session`, `date_debut`, `ville_centre`, `nom_formation`, CONCAT(`nom_pedagogie`, ' ', `prenom_pedagogie`) AS `formateur` FROM session
                            INNER JOIN centres ON session.id_centre = centres.id_centre
                            INNER JOIN formations ON session.id_formation = formations.id_formation
                            INNER JOIN pedagogie ON session.id_pedagogie = pedagogie.id_pedagogie";
            $requete = $bdd->query($sql);
            $results = $requete->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <form method="POST">
                <fieldset>
                    <legend>Nos sessions</legend>
                    <table>
                        <thead>
                            <tr>
                                <th>Nom de la session</th>
                                <th>Date session</th>
                                <th>Centre</th>
                                <th>Formation</th>
                                <th>Formateur</th>
                                <th>Modification</th>
                                <th>Suppression</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($results as $value) {
                            echo '
                                <input type="hidden" name="' . 'idSession' . $value['id_session'] . '"value="' . $value['id_session'] . '">
                                <tr>
                                <td>' . htmlspecialchars($value['nom_session'], ENT_QUOTES, 'UTF-8') . '</td>    
                                <td>' . htmlspecialchars($value['date_debut'], ENT_QUOTES, 'UTF-8') . '</td>    
                                <td>' . htmlspecialchars($value['ville_centre'], ENT_QUOTES, 'UTF-8') . '</td>    
                                <td>' . htmlspecialchars($value['nom_formation'], ENT_QUOTES, 'UTF-8') . '</td> 
                                <td>' . htmlspecialchars($value['formateur'], ENT_QUOTES, 'UTF-8') . '</td> 
                                <td><button type="button" onclick="window.location.href=\'?page=sessions&type=modifier&id=' . $value['id_session'] . '\'">Modifier</button></td>                                  
                                <td><button type="submit" name="deleteSession" value="' . $value['id_session'] . '" class="supprimer">Supprimer</button></td>';
                        }

                        if (isset($_POST['deleteSession'])) {
                            $idSessionDelete = $_POST['deleteSession'];
                            $sql = "DELETE FROM `session` WHERE `session`.`id_session` = :idSessionDelete";
                            $requeteDelete = $bdd->prepare($sql);
                            $requeteDelete->bindParam(':idSessionDelete', $idSessionDelete, PDO::PARAM_INT);
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