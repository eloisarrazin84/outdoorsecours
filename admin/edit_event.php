<?php
include '../config/db.php';

// Récupérer l'événement à modifier
if (isset($_GET['id'])) {
    $event_id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
    $stmt->execute([$event_id]);
    $event = $stmt->fetch();

    if (!$event) {
        die("Événement non trouvé !");
    }
}

// Mettre à jour les données
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $location = $_POST['location'];

    $stmt = $pdo->prepare("UPDATE events SET name = ?, description = ?, date = ?, location = ? WHERE id = ?");
    if ($stmt->execute([$name, $description, $date, $location, $event_id])) {
        header('Location: manage_events.php');
        exit;
    } else {
        echo "Erreur lors de la mise à jour de l'événement.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un événement</title>
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
        .btn-success, .btn-success:hover {
            background-color: #28a745;
            border: none;
        }
        .btn-secondary, .btn-secondary:hover {
            background-color: #6c757d;
            border: none;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <!-- Retour au tableau de bord -->
        <a href="manage_events.php" class="btn btn-info mb-3">
            <i class="fas fa-arrow-left"></i> Retour à la Gestion des Événements
        </a>

        <!-- Formulaire de modification -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-edit"></i> Modifier l'Événement
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom de l'événement</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nom de l'événement" value="<?= htmlspecialchars($event['name']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" placeholder="Description de l'événement"><?= htmlspecialchars($event['description']) ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" value="<?= htmlspecialchars($event['date']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Lieu</label>
                        <input type="text" class="form-control" id="location" name="location" placeholder="Lieu de l'événement" value="<?= htmlspecialchars($event['location']) ?>">
                    </div>
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-save"></i> Mettre à jour
                    </button>
                    <a href="manage_events.php" class="btn btn-secondary w-100 mt-2">
                        <i class="fas fa-times"></i> Annuler
                    </a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
