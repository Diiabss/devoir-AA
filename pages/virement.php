<?php
session_start();
include '../db/config.php';

if (!isset($_SESSION['client_id'])) {
    header("Location: ../index.php?page=connexion");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $compte_id_source = $_POST['compte_id_source'];
    $compte_id_dest = $_POST['compte_id_dest'];
    $montant = $_POST['montant'];

    // Vérifier si le solde du compte source est suffisant
    $sql = "SELECT solde FROM comptes WHERE id = ? AND client_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $compte_id_source, $_SESSION['client_id']);
    $stmt->execute();
    $stmt->bind_result($solde_source);
    $stmt->fetch();

    if ($solde_source >= $montant) {
        // Débiter le compte source
        $sql_update_source = "UPDATE comptes SET solde = solde - ? WHERE id = ? AND client_id = ?";
        $stmt_update_source = $conn->prepare($sql_update_source);
        $stmt_update_source->bind_param("dii", $montant, $compte_id_source, $_SESSION['client_id']);
        $stmt_update_source->execute();

        // Créditer le compte destination
        $sql_update_dest = "UPDATE comptes SET solde = solde + ? WHERE id = ?";
        $stmt_update_dest = $conn->prepare($sql_update_dest);
        $stmt_update_dest->bind_param("di", $montant, $compte_id_dest);
        $stmt_update_dest->execute();

        header("Location: dashboard.php");
    } else {
        echo "<p>Solde insuffisant pour effectuer ce virement.</p>";
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
    <h2>Effectuer un virement</h2>
    <form method="POST" action="virement.php">
        <div class="form-group">
            <label for="compte_id_source">Compte source</label>
            <select class="form-control" id="compte_id_source" name="compte_id_source" required>
                <?php while ($compte = $result_comptes->fetch_assoc()): ?>
                    <option value="<?php echo $compte['id']; ?>">
                        <?php echo $compte['numero_compte']; ?> - Solde : <?php echo $compte['solde']; ?> €
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="compte_id_dest">Compte destinataire</label>
            <input type="number" class="form-control" id="compte_id_dest" name="compte_id_dest" placeholder="ID du compte destinataire" required>
        </div>
        <div class="form-group">
            <label for="montant">Montant</label>
            <input type="number" class="form-control" id="montant" name="montant" min="1" required>
        </div>
        <button type="submit" class="btn btn-primary">Virer</button>
    </form>
</div>
