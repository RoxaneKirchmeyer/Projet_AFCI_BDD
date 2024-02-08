<?php
// Gestion Affectations
if (isset($_GET["page"]) && $_GET["page"] == "accueil") {
?>
<main>
    <h1>Connexion</h1>
<form method="POST">
        <fieldset>
            <legend>Création d'un utilisateur</legend>

            <label for="identifiant">Identifiant :</label>
            <input type="text" name="identifiant" id="identifiant">

            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password">

            <input type="submit" name="createUser" value="Créer un utilisateur">
        </fieldset>
    </form>

    <form method="POST">
        <fieldset>
            <legend>Connexion</legend>

            <label for="identifiantLogin">Identifiant :</label>
            <input type="text" name="identifiantLogin" id="identifiantLogin">

            <label for="passwordLogin">Mot de passe :</label>
            <input type="password" name="passwordLogin" id="passwordLogin">

            <input type="submit" name="submitLogin" value="Se connecter">
        </fieldset>
    </form>

    <?php
    if (isset($_POST['createUser'])) {
        $identifiant = $_POST['identifiant'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);


        $sqlCreateUser = "INSERT INTO users (`identifiant`, `password`) VALUES ('$identifiant', '$password')";
        $requestCreateUser = $bdd->prepare($sqlCreateUser);
        $requestCreateUser->execute([$identifiant, $password]);

        echo "User créé : " . htmlspecialchars($identifiant);
    }

    if (isset($_POST['submitLogin'])) {
        $identifiantLogin = $_POST['identifiantLogin'];
        $passwordLogin = $_POST['passwordLogin'];

        $sqlSelectUser = "SELECT * FROM `users` WHERE identifiant = '$identifiantLogin'";
        $requestLogin = $bdd->prepare($sqlSelectUser);
        $requestLogin->execute([$identifiantLogin]);
        $data = $requestLogin->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            // Vérification du mot de passe en utilisant password_verify
            if (password_verify($passwordLogin, $data['password'])) {
                echo "Utilisateur connecté";
                $_SESSION['user_id'] = $data['user_id']; // Stocke des informations de session sécurisées
            } else {
                echo "Mot de passe incorrect";
            }
        } else {
            echo "Identifiant incorrect";
        }
    }
}
?>
</main>