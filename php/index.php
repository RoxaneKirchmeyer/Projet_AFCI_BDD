<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion AFCI</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="?page=roles">Rôles</a></li>
                <li><a href="?page=centres">Centres</a></li>
                <li><a href="?page=formations">Formations</a></li>
                <li><a href="?page=equipe-pedagogique">Equipe Pedagogique</a></li>
                <li><a href="?page=sessions">Sessions</a></li>
                <li><a href="?page=apprenants">Apprenants</a></li>
            </ul>
        </nav>
    </header>

    <?php
    $host = "mysql"; // Remplacez par l'hôte de votre base de données
    $port = "3306"; // Remplacez par l'hôte de votre base de données
    $dbname = "afci"; // Remplacez par le nom de votre base de données
    $user = "admin"; // Remplacez par votre nom d'utilisateur
    $pass = "admin"; // Remplacez par votre mot de passe

    // Création d'une nouvelle instance de la classe PDO
    $bdd = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);

    // Configuration des options PDO
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $bdd->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

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
                $nomRole = $_POST['nomRole'];

                $sql = "INSERT INTO `role`(`nom_role`) VALUES ('$nomRole')";
                $bdd->query($sql);

                echo "data ajoutée dans la bdd";
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
                                <td><input type="submit" name="deleteRole" value="Supprimer"></td>';
                                }
                                ?>


                            <?php
                            if (isset($_POST['deleteRole'])) {
                                $idRoleDelete = $_POST['idRole' . $value['id_role']];
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
                    $villeCentre = $_POST['villeCentre'];
                    $adresseCentre = $_POST['adresseCentre'];
                    $cpCentre = $_POST['cpCentre'];

                    $sql = "INSERT INTO `centres`(`ville_centre`, `adresse_centre`, `code_postal_centre`) VALUES ('$villeCentre','$adresseCentre','$cpCentre')";
                    $bdd->query($sql);
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
                                <td><input type="submit" name="deleteCentre" value="Supprimer"></td>';
                                }

                                if (isset($_POST['deleteCentre'])) {
                                    $idCentreDelete = $_POST['idCentre' . $value['id_centre']];
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
                    if (isset($_GET['type']) && $_GET['type'] == "modifier") {

                        $id = $_GET["id"];
                        $sqlId = "SELECT * FROM formations WHERE id_formation = $id";
                        $requeteId = $bdd->query($sqlId);
                        $resultsId = $requeteId->fetch(PDO::FETCH_ASSOC);
                    ?>
                        <form method="POST">
                            <input type="hidden" name="updateIdFormation" value="<?php echo $resultsId['id_formation']; ?>">
                            <input type="text" name="updateNomFormation" value="<?php echo $resultsId['nom_formation']; ?>">
                            <input type="text" name="updateDureeFormation" value="<?php echo $resultsId['duree_formation']; ?>">
                            <input type="text" name="updateNiveauSortieFormation" value="<?php echo $resultsId['niveau_sortie_formation']; ?>">
                            <input type="text" name="updateDescriptionFormation" value="<?php echo $resultsId['description']; ?>">
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
                            SET `nom_formation`='$updateNomFormation',
                            `duree_formation`='$updateDureeFormation',
                            `niveau_sortie_formation`='$updateNiveauSortieFormation',
                            `description`='$updateDescriptionFormation'
                             WHERE id_formation = $updateIdFormation";

                            $bdd->query($sqlUpdate);
                            echo "Données modifiées";
                        }
                    }

                    if (isset($_POST['submitFormation'])) {
                        $nomFormation = $_POST['nomFormation'];
                        $dureeFormation = $_POST['dureeFormation'];
                        $niveauSortieFormation = $_POST['niveauSortieFormation'];
                        $descriptionFormation = $_POST['descriptionFormation'];

                        $sql = "INSERT INTO `formations`(`nom_formation`, `duree_formation`, `niveau_sortie_formation`, `description`) VALUES ('$nomFormation','$dureeFormation',' $niveauSortieFormation','$descriptionFormation')";
                        $bdd->query($sql);
                        echo "data ajoutée dans la bdd";
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
                                        echo '<div>
                                <input type="hidden" name="idFormation' . $value['id_formation'] . '" value="' . $value['id_formation'] . '">
                                <tr>
                                <td>' . $value['nom_formation'] . '</td>    
                                <td>' . $value['duree_formation'] . '</td>    
                                <td>' . $value['niveau_sortie_formation'] . '</td>    
                                <td>' . $value['description'] . '</td>    
                                <td><button type="button" onclick="window.location.href=\'?page=formations&type=modifier&id=' . $value['id_formation'] . '\'">Modifier</button></td>                                  
                                <td><input type="submit" name="deleteFormation" value="Supprimer"></td>';
                                    }

                                    if (isset($_POST['deleteFormation'])) {
                                        $idFormationDelete = $_POST['idFormation' . $value['id_formation']];
                                        $sql = "DELETE FROM formations WHERE `formations`.`id_formation` = $idFormationDelete";
                                        if ($bdd->query($sql)) {
                                            echo "La formation a été supprimée de la BDD.";
                                        } else {
                                            echo "Erreur lors de la suppression de la formation.";
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
                                <input type="hidden" name="updateIdPedago" value="<?php echo $resultsId['id_formation']; ?>">
                                <input type="text" name="updateNomPedago" value="<?php echo $resultsId['nom_pedagogie']; ?>">
                                <input type="text" name="updatePrenomPedago" value="<?php echo $resultsId['prenom_pedagogie']; ?>">
                                <input type="mail" name="updateMailPedago" value="<?php echo $resultsId['mail_pedagogie']; ?>">
                                <input type="text" name="updateTelPedago" value="<?php echo $resultsId['num_pedagogie']; ?>">
                                <select name="" id="">
                                    <option value=""></option>
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
                                $sqlUpdate = "UPDATE `pedagogie` 
                                SET 
                                `nom_pedagogie`='$updateNomPedago',
                                `prenom_pedagogie`='$updatePrenomPedago',
                                `mail_pedagogie`='$updateMailPedago',
                                `num_pedagogie`='$updateTelPedago'
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
                                <td>' . $value['num_pedagogie'] . '</td>     
                                <td><button type="button" onclick="window.location.href=\'?page=equipe-pedagogique&type=modifier&id=' . $value['id_pedagogie'] . '\'">Modifier</button></td>                                  
                                <td><input type="submit" name="deleteFormation" value="Supprimer"></td>';
                                        }

                                        if (isset($_POST['deletePedago'])) {
                                            $idPedagoDelete = $_POST['idPedago' . $value['id_pedagogie']];
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

                                    <label for="idCentre">Séléctionnez un centre</label>
                                    <select name="centre" id="idCentre">
                                        <option value="" hidden>Nom du centre</option>
                                        <?php

                                        $sql = "SELECT `id_centre`, `ville_centre` FROM centres";
                                        $requete = $bdd->query($sql);
                                        $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                                        foreach ($results as $value) {
                                            echo '<option value="' . $value['id_centre'] . '">' . 'AFCI' . ' - ' . $value['ville_centre'] . '</option>';
                                        }
                                        ?>
                                    </select>

                                    <label for="idFormation">Séléctionnez une formation</label>
                                    <select name="formation" id="idFormation">
                                        <option value="" hidden>Nom de la formation</option>
                                        <?php


                                        $sql = "SELECT `id_formation`, `nom_formation` FROM formations";
                                        $requete = $bdd->query($sql);
                                        $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                                        foreach ($results as $value) {
                                            echo '<option value="' . $value['id_formation'] . '">' . $value['nom_formation'] . '</option>';
                                        }
                                        ?>
                                    </select>

                                    <label for="idFormateur">Séléctionner un formateur</label>
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
                                            echo '<option value="' . $value['id_pedagogie'] . '">' . $value['formateur'] . '</option>';
                                        }
                                        ?>
                                    </select>

                                    <input type="submit" name="submitSession" value="Ajouter">
                                </fieldset>
                            </form>

                            <?php
                            if (isset($_GET['type']) && $_GET['type'] == "modifier") {

                                $id = $_GET["id"];
                                // trouver le innerjoin à faire pour récup les datas etrangeres
                                $sqlId = "SELECT * FROM `session` WHERE id_session = $id";
                                $requeteId = $bdd->query($sqlId);
                                $resultsId = $requeteId->fetch(PDO::FETCH_ASSOC);
                            ?>
                                <form method="POST">
                                    <input type="hidden" name="updateIdSession" value="<?php echo $resultsId['id_session']; ?>">
                                    <input type="text" name="updateNomSession" value="<?php echo $resultsId['nom_session']; ?>">
                                    <input type="date" name="updateDateSession" value="<?php echo $resultsId['date_debut']; ?>">
                                    <input type="text" name="updateIdCentreSession" value="<?php echo $resultsId['ville_centre']; ?>">
                                    <input type="text" name="updateIdFormationSession" value="<?php echo $resultsId['nom_formation']; ?>">
                                    <input type="text" name="updateIdPedagoSession" value="<?php echo $resultsId['formateur']; ?>">
                                    <input type="submit" name="updateSession" value="Modifier">
                                </form>
                            <?php
                                if (isset($_POST["updateSession"])) {
                                    $updateIdSession = $_POST["updateIdSession"];
                                    $updateNomSession = $_POST["updateNomSession"];
                                    $updateDateSession = $_POST["updateDateSession"];
                                    $updateIdCentreSession = $_POST["updateIdCentreSession"];
                                    $updateIdFormationSession = $_POST["updateIdFormationSession"];
                                    $updateIdPedagoSession = $_POST["updateIdPedagoSession"];

                                    $sqlUpdate = "UPDATE `session` 
                                SET 
                                `nom_session`='$updateNomSession',
                                `date_debut`='$updateDateSession',
                                `id_centre`='$updateIdCentreSession',
                                `id_formation`='$updateIdFormationSession',
                                `id_pedagogie`='$updateIdPedagoSession'
                                WHERE id_session = $updateIdSession";

                                    $bdd->query($sqlUpdate);
                                    echo "Données modifiées";
                                }
                            }
                            if (isset($_POST['submitSession'])) {
                                $nomSession = $_POST['nomSession'];
                                $debutSession = $_POST['debutSession'];
                                $centre = $_POST['centre'];
                                $formation = $_POST['formation'];
                                $formateur = $_POST['formateur'];

                                $sql = "INSERT INTO `session`(`nom_session`, `date_debut`, `id_centre`, `id_pedagogie`, `id_formation` ) VALUES ('$nomSession', '$debutSession', $centre, $formateur, $formation)";
                                $bdd->query($sql);

                                echo "data ajoutée dans la bdd";
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
                                <td>' . $value['nom_session'] . '</td>    
                                <td>' . $value['date_debut'] . '</td>    
                                <td>' . $value['ville_centre'] . '</td>    
                                <td>' . $value['nom_formation'] . '</td> 
                                <td>' . $value['formateur'] . '</td> 
                                <td><button type="button" onclick="window.location.href=\'?page=sessions&type=modifier&id=' . $value['id_session'] . '\'">Modifier</button></td>                                  
                                <td><input type="submit" name="deleteSession" value="Supprimer"></td>';
                                            }

                                            if (isset($_POST['deleteSession'])) {
                                                $idSessionDelete = $_POST['idSession' . $value['id_session']];
                                                $sql = "DELETE FROM `session` WHERE `session`.`id_session` = $idSessionDelete";
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

                        <?php
                        // Gestion Apprenants
                        if (isset($_GET["page"]) && $_GET["page"] == "apprenants") {
                        ?>
                            <main>
                                <h1>Gestion des Apprenants</h1>
                                <form method="POST">
                                    <fieldset>
                                        <legend>Ajouter des Apprenants</legend>

                                        <label for="nomApprenant">Nom</label>
                                        <input type="text" name="nomApprenant" id="nomApprenant">

                                        <label for="prenomApprenant">Prénom</label>
                                        <input type="text" name="prenomApprenant" id="prenomApprenant">

                                        <label for="emailApprenant">Email</label>
                                        <input type="email" name="emailApprenant" id="emailApprenant">

                                        <label for="adresseApprenant">Adresse</label>
                                        <input type="text" name="adresseApprenant" id="adresseApprenant">

                                        <label for="villeApprenant">Ville</label>
                                        <input type="text" name="villeApprenant" id="villeApprenant">

                                        <label for="codePostalApprenant">Code Postal</label>
                                        <input type="number" name="codePostalApprenant" id="codePostalApprenant">

                                        <label for="telephoneApprenant">Télephone</label>
                                        <input type="tel" name="telephoneApprenant" id="telephoneApprenant">

                                        <label for="dateDeNaissanceApprenant">Date de naissance</label>
                                        <input type="date" name="dateDeNaissanceApprenant" id="dateDeNaissanceApprenant">

                                        <label for="niveauApprenant">Niveau</label>
                                        <input type="text" name="niveauApprenant" id="niveauApprenant">

                                        <label for="numeroPoleEmploiApprenant">N° Pôle Emploi</label>
                                        <input type="text" name="numeroPoleEmploiApprenant" id="numeroPoleEmploiApprenant">

                                        <label for="numeroSecuriteSocialeApprenant">N° Sécurité sociale</label>
                                        <input type="number" name="numeroSecuriteSocialeApprenant" id="numeroSecuriteSocialeApprenant">

                                        <label for="ribApprenant">RIB</label>
                                        <input type="text" name="ribApprenant" id="ribApprenant">

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

                                        <label for="idRole">Sélectionnez une session</label>
                                        <select name="session" id="idSession">
                                            <option value="" hidden>Nom de session</option>


                                            <?php
                                            $sql = "SELECT `id_session`, `nom_session` FROM session";
                                            $requete = $bdd->query($sql);
                                            $results = $requete->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($results as $value) {
                                                echo '<option value="' . $value['id_session'] .  '">' . $value['nom_session'] . '</option>';
                                            }
                                            ?>
                                        </select>



                                        <input type="submit" name="submitApprenant" value="Ajouter">
                                    </fieldset>
                                </form>

                                <?php
                                if (isset($_GET['type']) && $_GET['type'] == "modifier") {

                                    $id = $_GET["id"];
                                    // trouver le innerjoin à faire pour récup les datas etrangeres
                                    $sqlId = "SELECT * FROM `apprenants` WHERE id_apprenant = $id";
                                    $requeteId = $bdd->query($sqlId);
                                    $resultsId = $requeteId->fetch(PDO::FETCH_ASSOC);
                                ?>
                                    <form method="POST">
                                        <input type="hidden" name="updateIdApprenant" value="<?php echo $resultsId['id_apprenant']; ?>">
                                        <input type="text" name="updateNomApprenant" value="<?php echo $resultsId['nom_apprenant']; ?>">
                                        <input type="text" name="updatePrenomApprenant" value="<?php echo $resultsId['prenom_apprenant']; ?>">
                                        <input type="mail" name="updateMailApprenant" value="<?php echo $resultsId['mail_apprenant']; ?>">
                                        <input type="text" name="updateAdresseApprenant" value="<?php echo $resultsId['adresse_apprenant']; ?>">
                                        <input type="text" name="updateVilleApprenant" value="<?php echo $resultsId['ville_apprenant']; ?>">
                                        <input type="text" name="updateCpApprenant" value="<?php echo $resultsId['code_postal_apprenant']; ?>">
                                        <input type="text" name="updateTelApprenant" value="<?php echo $resultsId['tel_apprenant']; ?>">
                                        <input type="date" name="updateDateApprenant" value="<?php echo $resultsId['date_naissance_apprenant']; ?>">
                                        <input type="text" name="updateNiveauApprenant" value="<?php echo $resultsId['niveau_apprenant']; ?>">
                                        <input type="text" name="updateNumPEApprenant" value="<?php echo $resultsId['num_PE_apprenant']; ?>">
                                        <input type="text" name="updateNumSecuApprenant" value="<?php echo $resultsId['num_secu_apprenant']; ?>">
                                        <input type="text" name="updateRibApprenant" value="<?php echo $resultsId['rib_apprenant']; ?>">
                                        <!-- add les deux select role et session -->
                                        <input type="submit" name="updateApprenant" value="Modifier">
                                    </form>
                                <?php
                                    if (isset($_POST["updateApprenant"])) {
                                        $updateIdApprenant = $_POST["updateIdApprenant"];
                                        $updateNomApprenant = $_POST["updateNomApprenant"];
                                        $updatePrenomApprenant = $_POST["updatePrenomApprenant"];
                                        $updateMailApprenant = $_POST["updateMailApprenant"];
                                        $updateAdresseApprenant = $_POST["updateAdresseApprenant"];
                                        $updateVilleApprenant = $_POST["updateVilleApprenant"];
                                        $updateCpApprenant = $_POST["updateCpApprenant"];
                                        $updateTelApprenant = $_POST["updateTelApprenant"];
                                        $updateDateApprenant = $_POST["updateDateApprenant"];
                                        $updateNiveauApprenant = $_POST["updateNiveauApprenant"];
                                        $updateNumPEApprenant = $_POST["updateNumPEApprenant"];
                                        $updateNumSecuApprenant = $_POST["updateNumSecuApprenant"];
                                        $updateRibApprenant = $_POST["updateRibApprenant"];
                                        // add les deux select role et session
                                        $sqlUpdate = "UPDATE `apprenants` 
    SET 
    `nom_apprenant`='$updateNomApprenant',
    `prenom_apprenant`='$updatePrenomApprenant',
    `mail_apprenant`='$updateMailApprenant',
    `adresse_apprenant`='$updateAdresseApprenant',
    `ville_apprenant`='$updateVilleApprenant',
    `code_postal_apprenant`='$updateCpApprenant',
    `tel_apprenant`='$updateTelApprenant',
    `date_naissance_apprenant`='$updateDateApprenant',
    `niveau_apprenant`='$updateNiveauApprenant',
    `num_PE_apprenant`='$updateNumPEApprenant',
    `num_secu_apprenant`='$updateNumSecuApprenant',
    `rib_apprenant`='$updateRibApprenant'
    -- add les deux select role et session
    WHERE `id_apprenant` = $updateIdApprenant";

                                        $bdd->query($sqlUpdate);
                                        echo "Données modifiées";
                                    }
                                }
                                if (isset($_POST['submitApprenant'])) {
                                    $nomApprenant = $_POST['nomApprenant'];
                                    $prenomApprenant = $_POST['prenomApprenant'];
                                    $emailApprenant = $_POST['emailApprenant'];
                                    $adresseApprenant = $_POST['adresseApprenant'];
                                    $villeApprenant = $_POST['villeApprenant'];
                                    $codePostalApprenant = $_POST['codePostalApprenant'];
                                    $telephoneApprenant = $_POST['telephoneApprenant'];
                                    $dateDeNaissanceApprenant = $_POST['dateDeNaissanceApprenant'];
                                    $niveauApprenant = $_POST['niveauApprenant'];
                                    $numeroPoleEmploiApprenant = $_POST['numeroPoleEmploiApprenant'];
                                    $numeroSecuriteSocialeApprenant = $_POST['numeroSecuriteSocialeApprenant'];
                                    // add les deux select role et session
                                    $ribApprenant = $_POST['ribApprenant'];

                                    $sql =
                                        "INSERT INTO `apprenants`(
                    `nom_apprenant`, 
                    `prenom_apprenant`, 
                    `mail_apprenant`, 
                    `adresse_apprenant`, 
                    `ville_apprenant`, 
                    `code_postal_apprenant`, 
                    `tel_apprenant`, 
                    `date_naissance_apprenant`, 
                    `niveau_apprenant`, 
                    `num_PE_apprenant`, 
                    `num_secu_apprenant`, 
                    -- add les deux select role et session
                    `rib_apprenant`
                ) 
                VALUES (
                    '$nomApprenant',
                    '$prenomApprenant',
                    '$emailApprenant',
                    '$adresseApprenant',
                    '$villeApprenant',
                    '$codePostalApprenant',
                    '$telephoneApprenant',
                    '$dateDeNaissanceApprenant',
                    '$niveauApprenant',
                    '$numeroPoleEmploiApprenant',
                    '$numeroSecuriteSocialeApprenant',
                    -- add les deux select role et session
                    '$ribApprenant'
                )";

                                    $bdd->query($sql);

                                    echo "data ajoutée dans la bdd";
                                }
                                ?>

                                <article>
                                    <h2>Apprenants</h2>
                                    <?php
                                    // Lire des données dans la BDD
                                    $sql = "SELECT apprenants.*, role.nom_role, session.nom_session
                                                FROM apprenants
                                                INNER JOIN role ON apprenants.id_role = role.id_role
                                                INNER JOIN session ON apprenants.id_session = session.id_session;";
                                    $requete = $bdd->query($sql);
                                    $results = $requete->fetchAll(PDO::FETCH_ASSOC);
                                    ?>
                                    <form method="POST">
                                        <fieldset>
                                            <legend>Nos sessions</legend>
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>Nom</th>
                                                        <th>Prénom</th>
                                                        <th>Email</th>
                                                        <th>Adresse</th>
                                                        <th>Ville</th>
                                                        <th>Code Postal</th>
                                                        <th>Téléphone</th>
                                                        <th>Date de naissance</th>
                                                        <th>Niveau</th>
                                                        <th>N° Pôle Emploi</th>
                                                        <th>N° Sécurité sociale</th>
                                                        <th>RIB</th>
                                                        <th>Rôle</th>
                                                        <th>Session</th>
                                                        <th>Modification</th>
                                                        <th>Suppression</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                foreach ($results as $value) {
                                                    echo '
                                <input type="hidden" name="' . 'idApprenant' . $value['id_apprenant'] . '"value="' . $value['id_apprenant'] . '">
                                <tr>
                                <td>' . $value['nom_apprenant'] . '</td>    
                                <td>' . $value['prenom_apprenant'] . '</td>    
                                <td>' . $value['mail_apprenant'] . '</td>    
                                <td>' . $value['adresse_apprenant'] . '</td>    
                                <td>' . $value['ville_apprenant'] . '</td>    
                                <td>' . $value['code_postal_apprenant'] . '</td>    
                                <td>' . $value['tel_apprenant'] . '</td>    
                                <td>' . $value['date_naissance_apprenant'] . '</td>    
                                <td>' . $value['niveau_apprenant'] . '</td>    
                                <td>' . $value['num_PE_apprenant'] . '</td>    
                                <td>' . $value['num_secu_apprenant'] . '</td>    
                                <td>' . $value['rib_apprenant'] . '</td>    
                                <td><button type="button" onclick="window.location.href=\'?page=apprenants&type=modifier&id=' . $value['id_apprenant'] . '\'">Modifier</button></td>                                  
                                <td><input type="submit" name="deleteApprenant" value="Supprimer"></td>';
                                                }
                                                // add les deux select role et session

                                                if (isset($_POST['deleteApprenant'])) {
                                                    $idApprenantDelete = $_POST['idApprenant'];
                                                    $sql = "DELETE FROM apprenants WHERE `apprenants`.`id_apprenant` = $idApprenantDelete";
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

</body>

</html>