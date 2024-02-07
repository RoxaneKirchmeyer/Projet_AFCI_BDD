<?php
// Gestion formation
if (isset($_GET["page"]) && $_GET["page"] == "formations") {
?>
    <main>
        <h1>Gestion des formations</h1>
        <form method="POST">
            <fieldset>
                <legend>Ajouter des formations</legend>

                <label for="nomFormation">Nom :</label>
                <input type="text" name="nomFormation" id="nomFormation">

                <label for="dureeFormation">Durée :</label>
                <input type="text" name="dureeFormation" id="dureeFormation">

                <label for="niveauSortieFormation">Niveau de sortie :</label>
                <input type="text" name="niveauSortieFormation" id="niveauSortieFormation">

                <label for="descriptionFormation">Description :</label>
                <input type="text" name="descriptionFormation" id="descriptionFormation">

                <input type="submit" name="submitFormation" value="Ajouter">
            </fieldset>
        </form>

        <?php
        if (isset($_POST['submitFormation'])) {
            $sql = "INSERT INTO `formations`(`nom_formation`, `duree_formation`, `niveau_sortie_formation`, `description`) VALUES (:nomFormation, :dureeFormation, :niveauSortieFormation, :descriptionFormation)";
            $requete = $bdd->prepare($sql);

            $nomFormation = $_POST['nomFormation'];
            $dureeFormation = $_POST['dureeFormation'];
            $niveauSortieFormation = $_POST['niveauSortieFormation'];
            $descriptionFormation = $_POST['descriptionFormation'];

            $requete->bindParam(':nomFormation', $nomFormation, PDO::PARAM_STR);
            $requete->bindParam(':dureeFormation', $dureeFormation, PDO::PARAM_STR);
            $requete->bindParam(':niveauSortieFormation', $niveauSortieFormation, PDO::PARAM_STR);
            $requete->bindParam(':descriptionFormation', $descriptionFormation, PDO::PARAM_STR);
            $requete->execute();

            echo "Données ajoutées à la BDD";
        }

        if (isset($_GET['type']) && $_GET['type'] == "modifier") {

            $id = $_GET["id"];
            $sqlId = "SELECT * FROM formations WHERE id_formation = :id";
            $requeteId = $bdd->prepare($sqlId);
            $requeteId->bindParam(':id', $id, PDO::PARAM_INT);
            $requeteId->execute();
            $resultsId = $requeteId->fetch(PDO::FETCH_ASSOC);
        ?>
            <form method="POST">
                <input type="hidden" name="updateIdFormation" value="<?php echo htmlspecialchars($resultsId['id_formation'], ENT_QUOTES, 'UTF-8'); ?>">
                <input type="text" name="updateNomFormation" value="<?php echo htmlspecialchars($resultsId['nom_formation'], ENT_QUOTES, 'UTF-8'); ?>">
                <input type="text" name="updateDureeFormation" value="<?php echo htmlspecialchars($resultsId['duree_formation'], ENT_QUOTES, 'UTF-8'); ?>">
                <input type="text" name="updateNiveauSortieFormation" value="<?php echo htmlspecialchars($resultsId['niveau_sortie_formation'], ENT_QUOTES, 'UTF-8'); ?>">
                <input type="text" name="updateDescriptionFormation" value="<?php echo htmlspecialchars($resultsId['description'], ENT_QUOTES, 'UTF-8'); ?>">
                <input type="submit" name="updateFormation" value="Modifier">
            </form>
        <?php
            if (isset($_POST["updateFormation"])) {
                $updateIdFormation = $_POST["updateIdFormation"];
                $updateNomFormation = $_POST["updateNomFormation"];
                $updateDureeFormation = $_POST["updateDureeFormation"];
                $updateNiveauSortieFormation = $_POST["updateNiveauSortieFormation"];
                $updateDescriptionFormation = $_POST["updateDescriptionFormation"];
                $sqlUpdate = "UPDATE `formations` 
                                SET 
                                `nom_formation`=:updateNomFormation,
                                `duree_formation`=:updateDureeFormation,
                                `niveau_sortie_formation`=:updateNiveauSortieFormation,
                                `description`=:updateDescriptionFormation
                                WHERE id_formation = :updateIdFormation";

                $requeteUpdate = $bdd->prepare($sqlUpdate);
                $requeteUpdate->bindParam(':updateNomFormation', $updateNomFormation, PDO::PARAM_STR);
                $requeteUpdate->bindParam(':updateDureeFormation', $updateDureeFormation, PDO::PARAM_STR);
                $requeteUpdate->bindParam(':updateNiveauSortieFormation', $updateNiveauSortieFormation, PDO::PARAM_STR);
                $requeteUpdate->bindParam(':updateDescriptionFormation', $updateDescriptionFormation, PDO::PARAM_STR);
                $requeteUpdate->bindParam(':updateIdFormation', $updateIdFormation, PDO::PARAM_INT);
                $requeteUpdate->execute();

                echo "Données modifiées";
            }
        }
        ?>

        <article>
            <h2>Formations</h2>

            <?php
            // Lire des données dans la BDD formations
            $sql = "SELECT `id_formation`,`nom_formation`, `duree_formation`, `niveau_sortie_formation`, `description` FROM formations";
            $requete = $bdd->query($sql);
            $results = $requete->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <form method="POST">
                <fieldset>
                    <legend>Nos formations</legend>
                    <table>
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Durée</th>
                                <th>Niveau de sortie</th>
                                <th>Description</th>
                                <th>Modification</th>
                                <th>Suppression</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($results as $value) {
                                echo '<tr>
                                        <input type="hidden" name="idFormation' . $value['id_formation'] . '" value="' . $value['id_formation'] . '">
                                        <td>' . htmlspecialchars($value['nom_formation'], ENT_QUOTES, 'UTF-8') . '</td>    
                                        <td>' . htmlspecialchars($value['duree_formation'], ENT_QUOTES, 'UTF-8') . '</td>    
                                        <td>' . htmlspecialchars($value['niveau_sortie_formation'], ENT_QUOTES, 'UTF-8') . '</td>    
                                        <td>' . htmlspecialchars($value['description'], ENT_QUOTES, 'UTF-8') . '</td>    
                                        <td><button type="button" onclick="window.location.href=\'?page=formations&type=modifier&id=' . $value['id_formation'] . '\'">Modifier</button></td>                                  
                                        <td><button type="submit" name="deleteFormation" value="' . $value['id_formation'] . '" class="supprimer">Supprimer</button></td>';
                            }

                            if (isset($_POST['deleteFormation'])) {
                                $idFormationDelete = $_POST['deleteFormation'];
                                $sql = "DELETE FROM formations WHERE `formations`.`id_formation` = :idFormationDelete";
                                $requeteDelete = $bdd->prepare($sql);
                                $requeteDelete->bindParam(':idFormationDelete', $idFormationDelete, PDO::PARAM_INT);
                                if ($requeteDelete->execute()) {
                                    echo "La formation a été supprimée de la BDD.";
                                } else {
                                    echo "Erreur lors de la suppression de la formation.";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </fieldset>
            </form>
        </article>
    </main>
<?php
}
?>