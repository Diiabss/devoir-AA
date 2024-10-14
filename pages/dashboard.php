<?php
include '../db/config.php';

// Si l'utilisateur n'est pas connecté, redirection vers la page de connexion
if (!isset($_SESSION['client_id'])) {
    header("Location: index.php?page=connexion");
    exit();
}

$client_id = $_SESSION['client_id'];

// Récupérer les informations du client connecté
$sql = "SELECT * FROM client WHERE clientId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $client_id);
$stmt->execute();
$result = $stmt->get_result();
$client = $result->fetch_assoc();

// Récupérer les comptes bancaires du client
$sql_comptes = "SELECT * FROM comptes WHERE client_id = ?";
$stmt_comptes = $conn->prepare($sql_comptes);
$stmt_comptes->bind_param("i", $client_id);
$stmt_comptes->execute();
$result_comptes = $stmt_comptes->get_result();
?>

<div class="container mt-5">
    <h2>Bonjour, <?php echo $client['prenom']; ?> <?php echo $client['nom']; ?></h2>
    <p>Email : <?php echo $client['email']; ?></p>
    <p>Téléphone : <?php echo $client['telephone']; ?></p>

    <h3>Vos comptes bancaires :</h3>
    <?php if ($result_comptes->num_rows > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Numéro de compte</th>
                    <th>Solde</th>
                    <th>Type de compte</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($compte = $result_comptes->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $compte['numero_compte']; ?></td>
                    <td><?php echo $compte['solde']; ?> €</td>
                    <td><?php echo ucfirst($compte['type_de_compte']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Vous n'avez aucun compte bancaire pour le moment.</p>
    <?php endif; ?>

    <a href="depot.php" class="btn btn-success">Effectuer un dépôt</a>
    <a href="retrait.php" class="btn btn-warning">Effectuer un retrait</a>
    <a href="virement.php" class="btn btn-primary">Effectuer un virement</a>
</div>
