<?php
include '../db/config.php';

$numeroCompte = $_POST['numeroCompte'];
$solde = $_POST['solde'];
$typeDeCompte = $_POST['typeDeCompte'];
$clientId = $_POST['clientId'];

// Insertion dans la table comptes
$sql = "INSERT INTO comptes (numero_compte, solde, type_de_compte, client_id) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sdsi", $numeroCompte, $solde, $typeDeCompte, $clientId);
$stmt->execute();

header("Location: ../index.php?page=dashboard");

