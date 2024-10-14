<?php
include '../db/config.php';

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$telephone = $_POST['telephone'];
$email = $_POST['email'];
$mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

// Insertion dans la table client
$sql = "INSERT INTO client (nom, prenom, telephone, email, mdp, dateCreation) VALUES (?, ?, ?, ?, ?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $nom, $prenom, $telephone, $email, $mdp);
$stmt->execute();

header("Location: ../index.php?page=connexion");

