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
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
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
        .btn-info, .btn-info:hover {
            background-color: #17a2b8;
            border: none;
        }
        .table thead {
            background-color: #17a2b8;
            color: white;
        }
        .section-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
    <title>Gestion des événements</title>
</head>
<body>
    <div class="container mt-4">
        <!-- Retour au tableau de bord -->
        <a href="#" class="btn btn-info mb-3">
            <i class="fas fa-arrow-left"></i> Retour au Tableau de Bord
        </a>

        <!-- Section Création d'événements -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-plus-circle"></i> Créer un Nouvel Événement
            </div>
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label for="eventName" class="form-label">Nom de l'événement</label>
                        <input type="text" class="form-control" id="eventName" placeholder="Nom de l'événement">
                    </div>
                    <div class="mb-3">
                        <label for="eventDate" class="form-label">Date de l'événement</label>
                        <input type="date" class="form-control" id="eventDate">
                    </div>
                    <div class="mb-3">
                        <label for="eventLocation" class="form-label">Lieu</label>
                        <input type="text" class="form-control" id="eventLocation" placeholder="Lieu de l'événement">
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Créer
                    </button>
                </form>
            </div>
        </div>

        <!-- Section Filtrage des événements -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-filter"></i> Filtrer les Événements
            </div>
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label for="filterEvent" class="form-label">Filtrer par Nom</label>
                        <input type="text" class="form-control" id="filterEvent" placeholder="Nom de l'événement">
                    </div>
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-search"></i> Filtrer
                    </button>
                </form>
            </div>
        </div>

        <!-- Section Liste des événements -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-list"></i> Liste des Événements
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Date</th>
                            <th>Lieu</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($events as $event): ?>
                            <tr>
                                <td><?= htmlspecialchars($event['id']) ?></td>
                                <td><?= htmlspecialchars($event['name']) ?></td>
                                <td><?= htmlspecialchars($event['date']) ?></td>
                                <td><?= htmlspecialchars($event['location']) ?></td>
                                <td class="text-center">
                                    <a href="edit_event.php?id=<?= $event['id'] ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Modifier
                                    </a>
                                    <a href="delete_event.php?id=<?= $event['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer cet événement ?');">
                                        <i class="fas fa-trash-alt"></i> Supprimer
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
