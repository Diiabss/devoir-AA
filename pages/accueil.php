<?php

// Vérifier si le client est déjà connecté
if (isset($_SESSION['client_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container text-center mt-5">
    <h1>Bienvenue sur votre service de banque en ligne</h1>
    <p>Gérez facilement votre compte bancaire en ligne !</p>
    <a href="index.php?page=inscription" class="btn btn-primary">Créer un compte</a>
    <a href="index.php?page=connexion" class="btn btn-secondary">Se connecter</a>
</div>
</body>
</html>
