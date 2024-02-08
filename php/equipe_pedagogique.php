<?php
// Gestion equipe pedago
if (isset($_GET["page"]) && $_GET["page"] == "equipe-pedagogique") {
?>
    <main>
        <h1>Gestion de l'équipe pédagogique</h1>
        <form method="POST">
            <fieldset>
                <legend>Ajouter des membres</legend>

                <label for="nomPedago">Nom :</label>
                <input type="text" name="nomPedago" id="nomPedago">

                <label for="prenomPedago">Prénom :</label>
                <input type="text" name="prenomPedago" id="prenomPedago">

                <label for="mailPedago">Mail :</label>
                <input type="email" name="mailPedago" id="mailPedago">

                <label for="telPedago">Numéro téléphone :</label>
                <input type="tel" name="telPedago" id="telPedago">

                <label for="idRole">Sélectionnez un rôle</label>
                <select name="role" id="idRole">
                    <option value="" hidden>Rôle</option>

                    <?php
                    $sql = "SELECT `id_role`, `nom_role` FROM role";
                    $requete = $bdd->query($sql);
                    $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($results as $value) {
                        echo '<option value="' . htmlspecialchars($value['id_role'], ENT_QUOTES, 'UTF-8') .  '">' . htmlspecialchars($value['nom_role'], ENT_QUOTES, 'UTF-8') . '</option>';
                    }
                    ?>
                </select>

                <input type="submit" name="submitPedago" value="Ajouter">
            </fieldset>
        </form>

        <?php
        if (isset($_POST['submitPedago'])) {
            $sql = "INSERT INTO `pedagogie`(`nom_pedagogie`, `prenom_pedagogie`, `mail_pedagogie`, `num_pedagogie`, `id_role`) VALUES (:nomPedago, :prenomPedago, :mailPedago, :telPedago, :role)";
            $requete = $bdd->prepare($sql);

            $nomPedago = $_POST['nomPedago'];
            $prenomPedago = $_POST['prenomPedago'];
            $mailPedago = $_POST['mailPedago'];
            $telPedago = $_POST['telPedago'];
            $role = $_POST['role'];

            $requete->bindParam(':nomPedago', $nomPedago, PDO::PARAM_STR);
            $requete->bindParam(':prenomPedago', $prenomPedago, PDO::PARAM_STR);
            $requete->bindParam(':mailPedago', $mailPedago, PDO::PARAM_STR);
            $requete->bindParam(':telPedago', $telPedago, PDO::PARAM_STR);
            $requete->bindParam(':role', $role, PDO::PARAM_INT);
            $requete->execute();

            echo "Données ajoutées à la BDD";
        }

        if (isset($_GET['type']) && $_GET['type'] == "modifier") {

            $id = $_GET["id"];
            $sqlId = "SELECT * FROM pedagogie WHERE id_pedagogie = :id";
            $requeteId = $bdd->prepare($sqlId);
            $requeteId->bindParam(':id', $id, PDO::PARAM_INT);
            $requeteId->execute();
            $resultsId = $requeteId->fetch(PDO::FETCH_ASSOC);
        ?>
            <form method="POST">
                <input type="hidden" name="updateIdPedago" value="<?php echo htmlspecialchars($resultsId['id_pedagogie'], ENT_QUOTES, 'UTF-8'); ?>">
                <input type="text" name="updateNomPedago" value="<?php echo htmlspecialchars($resultsId['nom_pedagogie'], ENT_QUOTES, 'UTF-8'); ?>">
                <input type="text" name="updatePrenomPedago" value="<?php echo htmlspecialchars($resultsId['prenom_pedagogie'], ENT_QUOTES, 'UTF-8'); ?>">
                <input type="email" name="updateMailPedago" value="<?php echo htmlspecialchars($resultsId['mail_pedagogie'], ENT_QUOTES, 'UTF-8'); ?>">
                <input type="tel" name="updateTelPedago" value="<?php echo htmlspecialchars($resultsId['num_pedagogie'], ENT_QUOTES, 'UTF-8'); ?>">
                <select name="updateRolePedago" id="updateRolePedago">
                    <option value="" hidden>Rôle</option>

                    <?php
                    $sql = "SELECT `id_role`, `nom_role` FROM role";
                    $requete = $bdd->query($sql);
                    $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($results as $value) {
                        echo '<option value="' . htmlspecialchars($value['id_role'], ENT_QUOTES, 'UTF-8') .  '">' . htmlspecialchars($value['nom_role'], ENT_QUOTES, 'UTF-8') . '</option>';
                    }
                    ?>
                </select>
                <input type="submit" name="updatePedago" value="Modifier">
            </form>
        <?php
            if (isset($_POST["updatePedago"])) {
                $updateIdPedago = $_POST["updateIdPedago"];
                $updateNomPedago = $_POST["updateNomPedago"];
                $updatePrenomPedago = $_POST["updatePrenomPedago"];
                $updateMailPedago = $_POST["updateMailPedago"];
                $updateTelPedago = $_POST["updateTelPedago"];
                $updateRolePedago = $_POST["updateRolePedago"];
                $sqlUpdate = "UPDATE `pedagogie` 
                                SET 
                                `nom_pedagogie`=:updateNomPedago,
                                `prenom_pedagogie`=:updatePrenomPedago,
                                `mail_pedagogie`=:updateMailPedago,
                                `num_pedagogie`=:updateTelPedago,
                                `id_role` = :updateRolePedago
                                WHERE id_pedagogie = :updateIdPedago";

                $requeteUpdate = $bdd->prepare($sqlUpdate);
                $requeteUpdate->bindParam(':updateNomPedago', $updateNomPedago, PDO::PARAM_STR);
                $requeteUpdate->bindParam(':updatePrenomPedago', $updatePrenomPedago, PDO::PARAM_STR);
                $requeteUpdate->bindParam(':updateMailPedago', $updateMailPedago, PDO::PARAM_STR);
                $requeteUpdate->bindParam(':updateTelPedago', $updateTelPedago, PDO::PARAM_STR);
                $requeteUpdate->bindParam(':updateRolePedago', $updateRolePedago, PDO::PARAM_INT);
                $requeteUpdate->bindParam(':updateIdPedago', $updateIdPedago, PDO::PARAM_INT);
                $requeteUpdate->execute();

                echo "Données modifiées";
            }
        }
        ?>

        <article>
            <h2>Équipe pédagogique</h2>

            <?php
            // Lire des données dans la BDD formations
            $sql = "SELECT `id_pedagogie`, `nom_pedagogie`, `prenom_pedagogie`, `mail_pedagogie`, `num_pedagogie`,`nom_role` FROM pedagogie
                        INNER JOIN `role` ON pedagogie.id_role = role.id_role";
            $requete = $bdd->query($sql);
            $results = $requete->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <form method="POST">
                <fieldset>
                    <legend>Nos membres</legend>
                    <table>
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Mail</th>
                                <th>Numéro téléphone</th>
                                <th>Rôle</th>
                                <th>Modification</th>
                                <th>Suppression</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($results as $value) {
                                echo '
                                <input type="hidden" name="' . 'idPedago' . $value['id_pedagogie'] . '"value="' . $value['id_pedagogie'] . '">
                                <tr>
                                <td>' . htmlspecialchars($value['nom_pedagogie'], ENT_QUOTES, 'UTF-8') . '</td>    
                                <td>' . htmlspecialchars($value['prenom_pedagogie'], ENT_QUOTES, 'UTF-8') . '</td>    
                                <td>' . htmlspecialchars($value['mail_pedagogie'], ENT_QUOTES, 'UTF-8') . '</td>    
                                <td>' . htmlspecialchars($value['num_pedagogie'], ENT_QUOTES, 'UTF-8') . '</td>     
                                <td>' . htmlspecialchars($value['nom_role'], ENT_QUOTES, 'UTF-8') . '</td>      
                                <td><button type="button" onclick="window.location.href=\'?page=equipe-pedagogique&type=modifier&id=' . $value['id_pedagogie'] . '" class="modifier">Modifier</button></td>                                  
                                <td><button type="submit" name="deletePedago" value="' . $value['id_pedagogie'] . '" class="supprimer">Supprimer</button></td>';
                            }

                            if (isset($_POST['deletePedago'])) {
                                $idPedagoDelete = $_POST['deletePedago'];
                                $sql = "DELETE FROM pedagogie WHERE `pedagogie`.`id_pedagogie` = :idPedagoDelete";
                                $requeteDelete = $bdd->prepare($sql);
                                $requeteDelete->bindParam(':idPedagoDelete', $idPedagoDelete, PDO::PARAM_INT);
                                if ($requeteDelete->execute()) {
                                    echo "Le membre a été supprimé de la BDD.";
                                } else {
                                    echo "Erreur lors de la suppression du membre.";
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
<?php
}
?>