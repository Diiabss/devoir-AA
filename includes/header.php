<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banque en ligne</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e7c697;">
        <a class="navbar-brand" href="index.php?page=accueil">Banque en ligne</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <?php if (isset($_SESSION['client_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=dashboard">Mon Compte</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/deconnexion.php">Se déconnecter</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=connexion">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=inscription">Inscription</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
