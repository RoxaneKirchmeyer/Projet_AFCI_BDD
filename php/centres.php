<?php
// Gestion centres
if (isset($_GET["page"]) && $_GET["page"] == "centres") {
?>

    <main>
        <h1>Gestion des centres</h1>
        <form method="POST">
            <fieldset>
                <legend>Ajouter des centres</legend>

                <label for="villeCentre">Nom de la ville :</label>
                <input type="text" name="villeCentre" id="villeCentre">

                <label for="adresseCentre">Adresse :</label>
                <input type="text" name="adresseCentre" id="adresseCentre">

                <label for="cpCentre">Code postal :</label>
                <input type="number" name="cpCentre" id="cpCentre">

                <input type="submit" name="submitCentre" value="Ajouter">
            </fieldset>
        </form>

        <?php
        if (isset($_GET['type']) && $_GET['type'] == "modifier") {

            $id = $_GET["id"];
            $sqlId = "SELECT * FROM centres WHERE id_centre = :id";
            $requeteId = $bdd->prepare($sqlId);
            $requeteId->bindParam(':id', $id, PDO::PARAM_INT);
            $requeteId->execute();
            $resultsId = $requeteId->fetch(PDO::FETCH_ASSOC);
        ?>
            <form method="POST">
                <input type="hidden" name="updateIdCentre" value="<?php echo htmlspecialchars($resultsId['id_centre'], ENT_QUOTES, 'UTF-8'); ?>">
                <input type="text" name="updateVilleCentre" value="<?php echo htmlspecialchars($resultsId['ville_centre'], ENT_QUOTES, 'UTF-8'); ?>">
                <input type="text" name="updateAdresseCentre" value="<?php echo htmlspecialchars($resultsId['adresse_centre'], ENT_QUOTES, 'UTF-8'); ?>">
                <input type="text" name="updateCpCentre" value="<?php echo htmlspecialchars($resultsId['code_postal_centre'], ENT_QUOTES, 'UTF-8'); ?>">
                <input type="submit" name="updateCentre" value="Modifier">
            </form>
        <?php
            if (isset($_POST["updateCentre"])) {
                $updateIdCentre = $_POST["updateIdCentre"];
                $updateVilleCentre = $_POST["updateVilleCentre"];
                $updateAdresseCentre = $_POST["updateAdresseCentre"];
                $updateCpCentre = $_POST["updateCpCentre"];
                $sqlUpdate = "UPDATE `centres` 
                        SET 
                        `ville_centre`=:updateVilleCentre, 
                        `adresse_centre`=:updateAdresseCentre, 
                        `code_postal_centre`=:updateCpCentre
                        WHERE id_centre = :updateIdCentre";

                $requeteUpdate = $bdd->prepare($sqlUpdate);
                $requeteUpdate->bindParam(':updateVilleCentre', $updateVilleCentre, PDO::PARAM_STR);
                $requeteUpdate->bindParam(':updateAdresseCentre', $updateAdresseCentre, PDO::PARAM_STR);
                $requeteUpdate->bindParam(':updateCpCentre', $updateCpCentre, PDO::PARAM_STR);
                $requeteUpdate->bindParam(':updateIdCentre', $updateIdCentre, PDO::PARAM_INT);
                $requeteUpdate->execute();

                echo "Données modifiées";
            }
        }

        if (isset($_POST['submitCentre'])) {
            $sql = "INSERT INTO `centres`(`ville_centre`, `adresse_centre`, `code_postal_centre`) VALUES (:villeCentre, :adresseCentre, :cpCentre)";
            $requete = $bdd->prepare($sql);

            $villeCentre = $_POST['villeCentre'];
            $adresseCentre = $_POST['adresseCentre'];
            $cpCentre = $_POST['cpCentre'];

            $requete->bindParam(':villeCentre', $villeCentre, PDO::PARAM_STR);
            $requete->bindParam(':adresseCentre', $adresseCentre, PDO::PARAM_STR);
            $requete->bindParam(':cpCentre', $cpCentre, PDO::PARAM_STR);
            $requete->execute();

            echo "données ajoutées à la bdd";
        }
        ?>

        <article>
            <h2>Centres</h2>

            <?php
            // Lire des données dans la BDD centre
            $sql = "SELECT `id_centre`,`ville_centre`, `adresse_centre`, `code_postal_centre` FROM centres";
            $requete = $bdd->query($sql);
            $results = $requete->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <form method="POST">
                <fieldset>
                    <legend>Nos centres</legend>
                    <table>
                        <thead>
                            <tr>
                                <th>Ville</th>
                                <th>Adresse</th>
                                <th>Code Postal</th>
                                <th>Modification</th>
                                <th>Suppression</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($results as $value) {
                                echo '
                                <input type="hidden" name="idCentre' . $value['id_centre'] . '" value="' . $value['id_centre'] . '">
                                <tr>
                                <td>' . htmlspecialchars($value['ville_centre'], ENT_QUOTES, 'UTF-8') . '</td>    
                                <td>' . htmlspecialchars($value['adresse_centre'], ENT_QUOTES, 'UTF-8') . '</td>    
                                <td>' . htmlspecialchars($value['code_postal_centre'], ENT_QUOTES, 'UTF-8') . '</td>    
                                <td><button type="button" onclick="window.location.href=\'?page=centres&type=modifier&id=' . $value['id_centre'] . '\'">Modifier</button></td>                                  
                                <td><button type="submit" name="deleteCentre" value="' . $value['id_centre'] . '" class="supprimer">Supprimer</button></td>';
                            }
                            ?>

                        <?php
                        if (isset($_POST['deleteCentre'])) {
                            $idCentreDelete = $_POST['deleteCentre'];
                            $sql = "DELETE FROM centres WHERE `centres`.`id_centre` = :idCentreDelete";
                            $requeteDelete = $bdd->prepare($sql);
                            $requeteDelete->bindParam(':idCentreDelete', $idCentreDelete, PDO::PARAM_INT);
                            if ($requeteDelete->execute()) {
                                echo "Le centre a été supprimé de la BDD.";
                            } else {
                                echo "Erreur lors de la suppression du centre.";
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