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
            $sqlId = "SELECT * FROM centres WHERE id_centre = $id";
            $requeteId = $bdd->query($sqlId);
            $resultsId = $requeteId->fetch(PDO::FETCH_ASSOC);
        ?>
            <form method="POST">
                <input type="hidden" name="updateIdCentre" value="<?php echo $resultsId['id_centre']; ?>">
                <input type="text" name="updateVilleCentre" value="<?php echo $resultsId['ville_centre']; ?>">
                <input type="text" name="updateAdresseCentre" value="<?php echo $resultsId['adresse_centre']; ?>">
                <input type="text" name="updateCpCentre" value="<?php echo $resultsId['code_postal_centre']; ?>">
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
                        `ville_centre`='$updateVilleCentre', 
                        `adresse_centre`='$updateAdresseCentre', 
                        `code_postal_centre`='$updateCpCentre'
                        WHERE id_centre = $updateIdCentre";

                $bdd->query($sqlUpdate);
                echo "Données modifiées";
            }
        }


        if (isset($_POST['submitCentre'])) {
            $sql = "INSERT INTO `centres`(`ville_centre`, `adresse_centre`, `code_postal_centre`) VALUES (:villeCentre, :adresseCentre, :cpCentre)";
            $requete = $bdd->prepare($sql);

            $villeCentre = $_POST['villeCentre'];
            $adresseCentre = $_POST['adresseCentre'];
            $cpCentre = $_POST['cpCentre'];

            $requete->bindParam(':villeCentre', $villeCentre);
            $requete->bindParam(':adresseCentre', $adresseCentre);
            $requete->bindParam(':cpCentre', $cpCentre);
            $requete->execute();

            echo "data ajoutée dans la bdd";
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
                                <td>' . $value['ville_centre'] . '</td>    
                                <td>' . $value['adresse_centre'] . '</td>    
                                <td>' . $value['code_postal_centre'] . '</td>    
                                <td><button type="button" onclick="window.location.href=\'?page=centres&type=modifier&id=' . $value['id_centre'] . '\'">Modifier</button></td>                                  
                                <td><button type="submit" name="deleteCentre" value="' . $value['id_centre'] . '" class="supprimer">Supprimer</button></td>';
                            }
                            ?>

                        <?php
                        if (isset($_POST['deleteCentre'])) {
                            $idCentreDelete = $_POST['deleteCentre'];
                            $sql = "DELETE FROM centres WHERE `centres`.`id_centre` = $idCentreDelete";
                            if ($bdd->query($sql)) {
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