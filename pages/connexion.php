<?php

include '../db/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];

    // Vérifier les identifiants
    $sql = "SELECT * FROM client WHERE email = ? AND mdp = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $mdp);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $client = $result->fetch_assoc();
        $_SESSION['client_id'] = $client['clientId'];  // Stocker l'ID du client dans la session
        header("Location: dashboard.php");  // Assurez-vous que le chemin est correct
        exit();
    } else {
        $error = "Identifiants incorrects";  // Message d'erreur si la connexion échoue
    }
}
?>

<!-- Formulaire de connexion -->
<div class="container form-container">
    <h2>Connexion</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST" action="pages/connexion.php">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
        </div>
        <div class="form-group">
            <label for="mdp">Mot de passe</label>
            <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Mot de passe" required>
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
</div>
