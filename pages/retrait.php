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

    // Vérifier si le solde est suffisant
    $sql = "SELECT solde FROM comptes WHERE id = ? AND client_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $compte_id, $_SESSION['client_id']);
    $stmt->execute();
    $stmt->bind_result($solde);
    $stmt->fetch();

    if ($solde >= $montant) {
        // Mise à jour du solde
        $sql_update = "UPDATE comptes SET solde = solde - ? WHERE id = ? AND client_id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("dii", $montant, $compte_id, $_SESSION['client_id']);
        $stmt_update->execute();

        header("Location: dashboard.php");
    } else {
        echo "<p>Solde insuffisant pour effectuer ce retrait.</p>";
    }
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
    <h2>Effectuer un retrait</h2>
    <form method="POST" action="retrait.php">
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
        <button type="submit" class="btn btn-warning">Retirer</button>
    </form>
</div>
