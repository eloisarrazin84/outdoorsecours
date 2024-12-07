<?php
include '../config/db.php';

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
                    <input type="text" class="form-control" id="event_name" name="event_name" required>
                </div>
                <div class="mb-3">
                    <label for="event_date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="event_date" name="event_date" required>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Créer</button>
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
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Exemple d'événements -->
                        <tr>
                            <td>1</td>
                            <td>Événement 1</td>
                            <td>2024-12-20</td>
                            <td>
                                <button class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Modifier</button>
                                <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Supprimer</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

