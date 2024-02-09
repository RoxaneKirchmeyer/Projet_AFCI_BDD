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
        if (isset($_POST['submitRole'])) {

            $sql = "INSERT INTO `role`(`nom_role`) VALUES (:nomRole)";
            $nomRole = $_POST['nomRole'];
            $requete = $bdd->prepare($sql);
            $requete->bindParam(':nomRole', $nomRole, PDO::PARAM_STR);
            $requete->execute();

            echo "données ajoutées à la bdd";
        }

        if (isset($_GET['type']) && $_GET['type'] == "modifier") {

            $id = $_GET["id"];
            $sqlId = "SELECT * FROM role WHERE id_role = :id";
            $requeteId = $bdd->prepare($sqlId);
            $requeteId->bindParam(':id', $id, PDO::PARAM_INT);
            $requeteId->execute();
            $resultsId = $requeteId->fetch(PDO::FETCH_ASSOC);
        ?>
            <form method="POST">
                <input type="hidden" name="updateIdRole" value="<?php echo htmlspecialchars($resultsId['id_role'], ENT_QUOTES, 'UTF-8'); ?>">
                <input type="text" name="updateNomRole" value="<?php echo htmlspecialchars($resultsId['nom_role'], ENT_QUOTES, 'UTF-8'); ?>">
                <input type="submit" name="updateRole" value="Modifier">
            </form>
        <?php
            if (isset($_POST["updateRole"])) {
                $updateIdRole = $_POST["updateIdRole"];
                $updateNomRole = $_POST["updateNomRole"];
                $sqlUpdate = "UPDATE `role` SET `nom_role`=:updateNomRole WHERE id_role = :updateIdRole";

                $requeteUpdate = $bdd->prepare($sqlUpdate);
                $requeteUpdate->bindParam(':updateNomRole', $updateNomRole, PDO::PARAM_STR);
                $requeteUpdate->bindParam(':updateIdRole', $updateIdRole, PDO::PARAM_INT);
                $requeteUpdate->execute();

                echo "Données modifiées";
            }
        }


        ?>

        <article>
            <h2>Rôles</h2>

            <?php

            // Lire des données dans la BDD
            function affichage($table){
                return "SELECT * FROM $table";
                }
                
                $sql= affichage("`role`");

            
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
                                <td>' . htmlspecialchars($value['nom_role'], ENT_QUOTES, 'UTF-8') . '</td>    
                                <td><button type="button" onclick="window.location.href=\'?page=roles&type=modifier&id=' . $value['id_role'] . '" class="modifier">Modifier</button></td>                                  
                                <td><button type="submit" name="deleteRole" value="' . $value['id_role'] . '" class="supprimer">Supprimer</button></td>';
                            }
                            ?>


                        <?php
                        if (isset($_POST['deleteRole'])) {
                            $idRoleDelete = $_POST['deleteRole'];
                            $sql = "DELETE FROM `role` WHERE `role`.`id_role` = :idRoleDelete";
                            $requeteDelete = $bdd->prepare($sql);
                            $requeteDelete->bindParam(':idRoleDelete', $idRoleDelete, PDO::PARAM_INT);
                            if ($requeteDelete->execute()) {
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