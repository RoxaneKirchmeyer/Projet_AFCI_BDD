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

                <label for="telPedago">Numéro teléphone :</label>
                <input type="tel" name="telPedago" id="telPedago">

                <label for="idRole">Séléctionnez un rôle</label>
                <select name="role" id="idRole">
                    <option value="" hidden>Rôle</option>


                    <?php
                    $sql = "SELECT `id_role`, `nom_role` FROM role";
                    $requete = $bdd->query($sql);
                    $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($results as $value) {
                        echo '<option value="' . $value['id_role'] .  '">' . $value['nom_role'] . '</option>';
                    }
                    ?>
                </select>

                <input type="submit" name="submitPedago" value="Ajouter">
            </fieldset>
        </form>

        <?php
        if (isset($_GET['type']) && $_GET['type'] == "modifier") {

            $id = $_GET["id"];
            // trouver le innerjoin à faire pour récup les datas etrangeres
            $sqlId = "SELECT * FROM pedagogie WHERE id_pedagogie = $id";
            $requeteId = $bdd->query($sqlId);
            $resultsId = $requeteId->fetch(PDO::FETCH_ASSOC);
        ?>
            <form method="POST">
                <input type="hidden" name="updateNomPedago" value="<?php echo $resultsId['id_pedagogie']; ?>">
                <input type="text" name="updateNomPedago" value="<?php echo $resultsId['nom_pedagogie']; ?>">
                <input type="text" name="updatePrenomPedago" value="<?php echo $resultsId['prenom_pedagogie']; ?>">
                <input type="mail" name="updateMailPedago" value="<?php echo $resultsId['mail_pedagogie']; ?>">
                <input type="text" name="updateTelPedago" value="<?php echo $resultsId['num_pedagogie']; ?>">
                <select name="updateRolePedago" id="updateRolePedago">
                    <option value="" hidden>Rôle</option>


                    <?php
                    $sql = "SELECT `id_role`, `nom_role` FROM role";
                    $requete = $bdd->query($sql);
                    $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($results as $value) {
                        echo '<option value="' . $value['id_role'] .  '">' . $value['nom_role'] . '</option>';
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
                                `nom_pedagogie`='$updateNomPedago',
                                `prenom_pedagogie`='$updatePrenomPedago',
                                `mail_pedagogie`='$updateMailPedago',
                                `num_pedagogie`='$updateTelPedago',
                                `id_role` = '$updateRolePedago'
                                WHERE id_pedagogie = $updateIdPedago";

                $bdd->query($sqlUpdate);
                echo "Données modifiées";
            }
        }


        if (isset($_POST['submitPedago'])) {
            $nomPedago = $_POST['nomPedago'];
            $prenomPedago = $_POST['prenomPedago'];
            $mailPedago = $_POST['mailPedago'];
            $telPedago = $_POST['telPedago'];
            $role = $_POST['role'];

            $sql = "INSERT INTO `pedagogie`(`nom_pedagogie`, `prenom_pedagogie`, `mail_pedagogie`, `num_pedagogie`, `id_role`) VALUES ('$nomPedago','$prenomPedago','$mailPedago','$telPedago','$role')";
            $bdd->query($sql);
            echo "data ajoutée dans la bdd";
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
                                <th>Numéro teléphone</th>
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
                                <td>' . $value['nom_pedagogie'] . '</td>    
                                <td>' . $value['prenom_pedagogie'] . '</td>    
                                <td>' . $value['mail_pedagogie'] . '</td>    
                                <td>' . $value['num_pedagogie'] . '</td>     
                                <td>' . $value['nom_role'] . '</td>      
                                <td><button type="button" onclick="window.location.href=\'?page=equipe-pedagogique&type=modifier&id=' . $value['id_pedagogie'] . '\'">Modifier</button></td>                                  
                                <td><button type="submit" name="deletePedago" value="' . $value['id_pedagogie'] . '" class="supprimer">Supprimer</button></td>';
                        }

                        if (isset($_POST['deletePedago'])) {
                            $idPedagoDelete = $_POST['deletePedago'];
                            $sql = "DELETE FROM pedagogie WHERE `pedagogie`.`id_pedagogie` = $idPedagoDelete";
                            if ($bdd->query($sql)) {
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