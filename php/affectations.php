<?php
// Gestion Affectations
if (isset($_GET["page"]) && $_GET["page"] == "affectations") {
?>

    <main>
        <h1>Gestion des affectations</h1>
        <form method="POST">
            <fieldset>
                <legend>Affecter un membre à un centre</legend>

                <label for="nomSession">Nom et rôle</label>
                <select name="nomSession" id="nomSession">
                    <option value="" hidden>Nom et rôle</option>
                    <?php

                    $sql = "SELECT `id_pedagogie`, `nom_pedagogie`, `prenom_pedagogie`, `nom_role`
                        FROM `pedagogie`
                        INNER JOIN `role` ON pedagogie.id_role = role.id_role
                        WHERE role.id_role BETWEEN 1 AND 3";
                    $requete = $bdd->query($sql);
                    $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($results as $value) {
                        echo '<option value="' . $value['id_pedagogie'] . '">' . $value['nom_pedagogie'] . ' ' . $value['prenom_pedagogie'] . ' - ' . $value['nom_role'] . '</option>';
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

                <input type="submit" name="submitAffectation" value="Ajouter">
            </fieldset>
        </form>


        <?php

        if (isset($_POST['submitAffectation'])) {
            $rolePedagoNomPedago = $_POST['rolePedagoNomPedago'];
            $villeCentre = $_POST['villeCentre'];

            $sql = "INSERT INTO `affecter`(`id_pedagogie`,`id_centre`)
                VALUES (
                '$rolePedagoNomPedago',
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
            $sql = "SELECT affecter.id_centre, affecter.id_pedagogie, `ville_centre`,`nom_pedagogie`,`prenom_pedagogie` FROM affecter
            INNER JOIN pedagogie ON affecter.id_pedagogie = pedagogie.id_pedagogie
            INNER JOIN centres ON affecter.id_centre = centres.id_centre
            ORDER BY `affecter`.`id_pedagogie` ASC";
            $requete = $bdd->query($sql);
            $results = $requete->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <form method="POST">
                <fieldset>
                    <legend>Les affectations</legend>
                    <table>
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Centre</th>
                                <th>Suppression</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            foreach ($results as $value) {
                                echo '
                    <tr>
                    <td>' . $value['nom_pedagogie'] . ' ' . $value['prenom_pedagogie'] . '</td>    
                    <td>' . $value['ville_centre'] . '</td>                                     
                    <td><button type="submit" name="deleteAffectation" value="' . $value['id_pedagogie'] . '_' . $value['id_centre'] . '" class="supprimer">Supprimer</button></td>';
                            }
                            ?>


                        <?php
                        if (isset($_POST['deleteAffectation'])) {
                            $idDeleteAffectation = $_POST['deleteAffectation'];
                            $sql = "DELETE FROM affecter WHERE `affecter`.`id_pedagogie` = $idDeleteAffectation AND `affecter`.`id_centre` = $idDeleteAffectation";
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