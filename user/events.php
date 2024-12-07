<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../config/db.php';

// Récupérer tous les événements
$stmt = $pdo->prepare("SELECT * FROM events ORDER BY date ASC");
$stmt->execute();
$events = $stmt->fetchAll();

// Gestion de l'inscription
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = $_POST['event_id'];
    $user_id = 1; // Remplacez par l'ID de l'utilisateur connecté (via session).
    $availability = $_POST['availability'];

    // Vérifiez que l'événement et l'utilisateur existent
    $check_event = $pdo->prepare("SELECT id FROM events WHERE id = ?");
    $check_event->execute([$event_id]);
    $check_user = $pdo->prepare("SELECT id FROM users WHERE id = ?");
    $check_user->execute([$user_id]);

    if ($check_event->rowCount() === 0) {
        echo '<div class="alert alert-danger text-center">L\'événement sélectionné n\'existe pas.</div>';
    } elseif ($check_user->rowCount() === 0) {
        echo '<div class="alert alert-danger text-center">L\'utilisateur n\'existe pas.</div>';
    } else {
        // Inscription de l'utilisateur
        $stmt = $pdo->prepare("INSERT INTO user_events (user_id, event_id, availability) VALUES (?, ?, ?)");
        if ($stmt->execute([$user_id, $event_id, $availability])) {
            echo '<div class="alert alert-success text-center">Inscription réussie !</div>';
        } else {
            echo '<div class="alert alert-danger text-center">Erreur lors de l\'inscription.</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Événements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <!-- Titre principal -->
        <h1 class="text-center mb-4"><i class="fas fa-calendar-alt"></i> Événements disponibles</h1>

        <!-- Liste des événements -->
        <div class="row">
            <?php if (!empty($events)): ?>
                <?php foreach ($events as $event): ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title text-primary"><?= htmlspecialchars($event['name']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($event['description']) ?></p>
                                <p><strong>Date :</strong> <?= htmlspecialchars($event['date']) ?></p>
                                <p><strong>Lieu :</strong> <?= htmlspecialchars($event['location']) ?></p>
                                <form method="POST">
                                    <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
                                    <div class="mb-3">
                                        <label for="availability" class="form-label">Disponibilité</label>
                                        <textarea class="form-control" id="availability" name="availability" rows="3" placeholder="Exemple : Disponible à partir de 14h" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-check-circle"></i> S'inscrire
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">Aucun événement disponible pour le moment.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
