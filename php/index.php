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
                <li><a href="?page=accueil">Accueil</a></li>
                <li><a href="?page=roles">Rôles</a></li>
                <li><a href="?page=centres">Centres</a></li>
                <li><a href="?page=formations">Formations</a></li>
                <li><a href="?page=equipe-pedagogique">Equipe Pedagogique</a></li>
                <li><a href="?page=sessions">Sessions</a></li>
                <li><a href="?page=apprenants">Apprenants</a></li>
                <li><a href="?page=affectations">Affectations</a></li>
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

    function affichage($table){
        return "SELECT * FROM $table";
        }


    include 'accueil.php';
    include 'roles.php';
    include 'centres.php';
    include 'formations.php';
    include 'equipe_pedagogique.php';
    include 'sessions.php';
    include 'apprenants.php';
    include 'affectations.php';
    
    ?>
</body>

</html>