<?php
// Gestion Localisation
if (isset($_GET["page"]) && $_GET["page"] == "localisations") {
?>

    <main>
        <h1>Gestion des localisations</h1>
        <form method="POST">
            <fieldset>
                <legend>Affecter une formation à un centre</legend>

                <label for="nomFormation">Intitulé de la formation</label>
                <select name="nomFormation" id="nomFormation">
                    <option value="" hidden>Nom de la formation</option>
                    <?php

                    $sql = "SELECT `id_formation`, `nom_formation` FROM `formations`";
                    $requete = $bdd->query($sql);
                    $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($results as $value) {
                        echo '<option value="' . $value['id_formation'] . '">' . $value['nom_formation'] . '</option>';
                    }
                    ?>
                </select>

                <label for="villeCentre">Ville du centre</label>
                <select name="villeCentre" id="villeCentre">
                    <?php

                    $sql = "SELECT `id_centre`, `ville_centre` FROM centres";
                    $requete = $bdd->query($sql);
                    $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($results as $value) {
                        $selected = ($value['id_centre'] == $resultsId['id_centre']);
                        echo '<option value="' . $value['id_centre'] . '" ' . '>' . $value['ville_centre'] . '</option>';
                    }
                    ?>
                </select>

                <input type="submit" name="submitLocalisation" value="Ajouter">
            </fieldset>
        </form>


        <?php

        if (isset($_POST['submitLocalisation'])) {
            $nomFormation = $_POST['nomFormation'];
            $villeCentre = $_POST['villeCentre'];

            $sql = "INSERT INTO `localiser`(`id_formation`,`id_centre`)
                VALUES (
                '$nomFormation',
                $villeCentre
                )";
            $bdd->query($sql);

            echo "data ajoutée dans la bdd";
        }

        ?>

        <article>
            <h2>Affectations</h2>

            <?php

            // Lire des données dans la BDD
            $sql = "SELECT localiser.id_centre, localiser.id_formation, `ville_centre`,`nom_formation` FROM localiser
            INNER JOIN formations ON localiser.id_formation = formations.id_formation
            INNER JOIN centres ON localiser.id_centre = centres.id_centre";
            $requete = $bdd->query($sql);
            $results = $requete->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <form method="POST">
                <fieldset>
                    <legend>Les affectations</legend>
                    <table>
                        <thead>
                            <tr>
                                <th>Formation</th>
                                <th>Centre</th>
                                <th>Suppression</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            foreach ($results as $value) {
                                echo '
                    <tr>
                    <td>' . $value['nom_formation'] . '</td>    
                    <td>' . $value['ville_centre'] . '</td>                                     
                    <td><button type="submit" name="deleteLocalisation" value="' . $value['id_formation'] . '_' . $value['id_centre'] . '" class="supprimer">Supprimer</button></td>';
                            }
                            ?>


                        <?php
                        if (isset($_POST['deleteLocalisation'])) {
                            $idDeleteLocalisation = $_POST['deleteLocalisation'];
                            $sql = "DELETE FROM localiser WHERE `localiser`.`id_formation` = $idDeleteLocalisation AND `localiser`.`id_centre` = $idDeleteLocalisation";
                            if ($bdd->query($sql)) {
                                echo "L'affectation a été supprimée dans la BDD.";
                            } else {
                                echo "Erreur lors de la suppression de l'affectation.";
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