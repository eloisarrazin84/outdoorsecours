<?php
// Inclusion du fichier de configuration
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $location = $_POST['location'];

    // Insertion dans la base de données
    $stmt = $pdo->prepare("INSERT INTO events (name, description, date, location) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$name, $description, $date, $location])) {
        header("Location: manage_events.php");
        exit();
    } else {
        echo "Erreur lors de l'ajout de l'événement.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un événement</title>
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
    </style>
</head>
<body>
    <div class="container mt-5">
        <!-- Retour au tableau de bord -->
        <a href="manage_events.php" class="btn btn-info mb-3">
            <i class="fas fa-arrow-left"></i> Retour à la Gestion des Événements
        </a>

        <!-- Formulaire d'ajout -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-plus-circle"></i> Ajouter un Nouvel Événement
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom de l'événement</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nom de l'événement" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" placeholder="Description de l'événement"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Lieu</label>
                        <input type="text" class="form-control" id="location" name="location" placeholder="Lieu de l'événement">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save"></i> Ajouter
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
