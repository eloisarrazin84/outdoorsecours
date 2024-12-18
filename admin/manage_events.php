<?php
include '../config/db.php';

// Gestion du formulaire de création d'un événement
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_event'])) {
    $name = $_POST['event_name'];
    $description = $_POST['event_description'];
    $date = $_POST['event_date'];
    $location = $_POST['event_location'];

    // Insertion dans la base de données
    $stmt = $pdo->prepare("INSERT INTO events (name, description, date, location) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$name, $description, $date, $location])) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Erreur lors de la création de l'événement.";
    }
}

// Récupérer tous les événements
$stmt = $pdo->prepare("SELECT * FROM events ORDER BY date ASC");
$stmt->execute();
$events = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Événements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card-header {
            background-color: #17a2b8;
            color: white;
            font-weight: bold;
        }
        .btn-primary, .btn-primary:hover {
            background-color: #007bff;
            border: none;
        }
        .btn-warning, .btn-warning:hover {
            background-color: #ffc107;
            border: none;
        }
        .btn-danger, .btn-danger:hover {
            background-color: #dc3545;
            border: none;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Gestion des Événements</h1>

    <!-- Formulaire pour créer un événement -->
    <div class="card mb-4">
        <div class="card-body">
            <h2>Créer un Nouvel Événement</h2>
            <form method="POST">
                <div class="mb-3">
                    <label for="event_name" class="form-label">Nom de l'événement</label>
                    <input type="text" class="form-control" id="event_name" name="event_name" placeholder="Nom de l'événement" required>
                </div>
                <div class="mb-3">
                    <label for="event_description" class="form-label">Description</label>
                    <textarea class="form-control" id="event_description" name="event_description" placeholder="Description de l'événement" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="event_date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="event_date" name="event_date" required>
                </div>
                <div class="mb-3">
                    <label for="event_location" class="form-label">Lieu</label>
                    <input type="text" class="form-control" id="event_location" name="event_location" placeholder="Lieu de l'événement" required>
                </div>
                <button type="submit" name="create_event" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i> Créer
                </button>
            </form>
        </div>
    </div>

    <!-- Liste des événements -->
    <div class="card">
        <div class="card-header">
            <i class="fas fa-list"></i> Liste des Événements
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Lieu</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($events)): ?>
                            <?php foreach ($events as $event): ?>
                                <tr>
                                    <td><?= htmlspecialchars($event['id']) ?></td>
                                    <td><?= htmlspecialchars($event['name']) ?></td>
                                    <td><?= htmlspecialchars($event['description']) ?></td>
                                    <td><?= htmlspecialchars($event['date']) ?></td>
                                    <td><?= htmlspecialchars($event['location']) ?></td>
                                    <td class="text-center">
                                        <a href="edit_event.php?id=<?= $event['id'] ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Modifier
                                        </a>
                                        <form method="POST" action="delete_event.php" class="d-inline">
                                            <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer cet événement ?');">
                                                <i class="fas fa-trash"></i> Supprimer
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Aucun événement trouvé.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
