<?php
session_start();
include 'db/config.php';
include 'includes/header.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'accueil';

switch ($page) {
    case 'accueil':
        include 'pages/accueil.php';
        break;
    case 'inscription':
        include 'pages/inscription.php';
        break;
    case 'connexion':
        include 'pages/connexion.php';
        break;
    case 'dashboard':
        include 'pages/dashboard.php';
        break;
    default:
        include 'pages/accueil.php';
        break;
}

include 'includes/footer.php';

