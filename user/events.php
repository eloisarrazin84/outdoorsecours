<?php
include '../config/db.php';

// Récupérer tous les événements
$stmt = $pdo->prepare("SELECT * FROM events ORDER BY date ASC");
$stmt->execute();
$events = $stmt->fetchAll();

// Gestion de l'inscription
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = $_POST['event_id'];
    $user_id = 1; // Remplacez par l'ID de l'utilisateur connecté (via session)
    $availability = $_POST['availability'];

    $stmt = $pdo->prepare("INSERT INTO user_events (user_id, event_id, availability) VALUES (?, ?, ?)");
    if ($stmt->execute([$user_id, $event_id, $availability])) {
        echo "Inscription réussie !";
    } else {
        echo "Erreur lors de l'inscription.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
    <title>Événements</title>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Événements disponibles</h1>
        <div class="row">
            <?php foreach ($events as $event): ?>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($event['name']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($event['description']) ?></p>
                            <p><strong>Date :</strong> <?= htmlspecialchars($event['date']) ?></p>
                            <p><strong>Lieu :</strong> <?= htmlspecialchars($event['location']) ?></p>
                            <form method="POST">
                                <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
                                <div class="mb-3">
                                    <label for="availability" class="form-label">Disponibilité</label>
                                    <textarea class="form-control" id="availability" name="availability" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">S'inscrire</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
