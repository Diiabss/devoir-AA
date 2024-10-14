<?php
session_start();
include '../db/config.php';

if (!isset($_SESSION['client_id'])) {
    header("Location: ../index.php?page=connexion");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $compte_id = $_POST['compte_id'];
    $montant = $_POST['montant'];

    // Mise à jour du solde
    $sql = "UPDATE comptes SET solde = solde + ? WHERE id = ? AND client_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("dii", $montant, $compte_id, $_SESSION['client_id']);
    $stmt->execute();

    header("Location: dashboard.php");
}

$client_id = $_SESSION['client_id'];

// Récupérer les comptes du client
$sql_comptes = "SELECT * FROM comptes WHERE client_id = ?";
$stmt_comptes = $conn->prepare($sql_comptes);
$stmt_comptes->bind_param("i", $client_id);
$stmt_comptes->execute();
$result_comptes = $stmt_comptes->get_result();
?>

<div class="container mt-5">
    <h2>Effectuer un dépôt</h2>
    <form method="POST" action="depot.php">
        <div class="form-group">
            <label for="compte_id">Choisissez un compte</label>
            <select class="form-control" id="compte_id" name="compte_id" required>
                <?php while ($compte = $result_comptes->fetch_assoc()): ?>
                    <option value="<?php echo $compte['id']; ?>">
                        <?php echo $compte['numero_compte']; ?> - Solde : <?php echo $compte['solde']; ?> €
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="montant">Montant</label>
            <input type="number" class="form-control" id="montant" name="montant" min="1" required>
        </div>
        <button type="submit" class="btn btn-success">Déposer</button>
    </form>
</div>
