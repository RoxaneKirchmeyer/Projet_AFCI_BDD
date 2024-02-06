<?php
// Gestion Rôles
if (isset($_GET["page"]) && $_GET["page"] == "roles") {
?>

    <main>
        <h1>Gestion des rôles</h1>
        <form method="POST">
            <fieldset>
                <legend>Ajouter des rôles</legend>

                <label for="nomRole">Nom du rôle</label>
                <input type="text" name="nomRole" id="nomRole">

                <input type="submit" name="submitRole" value="Ajouter">
            </fieldset>
        </form>

        <?php
        if (isset($_GET['type']) && $_GET['type'] == "modifier") {

            $id = $_GET["id"];
            $sqlId = "SELECT * FROM role WHERE id_role = $id";
            $requeteId = $bdd->query($sqlId);
            $resultsId = $requeteId->fetch(PDO::FETCH_ASSOC);
        ?>
            <form method="POST">
                <input type="hidden" name="updateIdRole" value="<?php echo $resultsId['id_role']; ?>">
                <input type="text" name="updateNomRole" value="<?php echo $resultsId['nom_role']; ?>">
                <input type="submit" name="updateRole" value="Modifier">
            </form>
        <?php
            if (isset($_POST["updateRole"])) {
                $updateIdRole = $_POST["updateIdRole"];
                $updateNomRole = $_POST["updateNomRole"];
                $sqlUpdate = "UPDATE `role` SET `nom_role`='$updateNomRole' WHERE id_role = $updateIdRole";

                $bdd->query($sqlUpdate);
                echo "Données modifiées";
            }
        }

        if (isset($_POST['submitRole'])) {

            $sql = "INSERT INTO `role`(`nom_role`) VALUES (:nomRole)";
            $nomRole = $_POST['nomRole'];
            $requete = $bdd->prepare($sql);

            $requete->bindParam(':nomRole', $nomRole);

            $requete->execute();

            echo "données ajoutées à la bdd";
        }
        ?>

        <article>
            <h2>Rôles</h2>

            <?php

            // Lire des données dans la BDD
            $sql = "SELECT `id_role`, `nom_role` FROM `role`";
            $requete = $bdd->query($sql);
            $results = $requete->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <form method="POST">
                <fieldset>
                    <legend>Les rôles</legend>
                    <table>
                        <thead>
                            <tr>
                                <th>Nom rôle</th>
                                <th>Modification</th>
                                <th>Suppression</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            foreach ($results as $value) {
                                echo '
                                <input type="hidden" name="idRole' . $value['id_role'] . '" value="' . $value['id_role'] . '">
                                <tr>
                                <td>' . $value['nom_role'] . '</td>    
                                <td><button type="button" onclick="window.location.href=\'?page=roles&type=modifier&id=' . $value['id_role'] . '\'">Modifier</button></td>                                  
                                <td><button type="submit" name="deleteRole" value="' . $value['id_role'] . '" class="supprimer">Supprimer</button></td>';
                            }
                            ?>


                        <?php
                        if (isset($_POST['deleteRole'])) {
                            $idRoleDelete = $_POST['deleteRole'];
                            $sql = "DELETE FROM `role` WHERE `role`.`id_role` = $idRoleDelete";
                            if ($bdd->query($sql)) {
                                echo "Le rôle a été supprimé dans la BDD.";
                            } else {
                                echo "Erreur lors de la suppression du rôle.";
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