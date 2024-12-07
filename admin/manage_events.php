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
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            background-color: #343a40;
            color: #fff;
            padding: 20px;
        }
        .sidebar h4 {
            text-align: center;
            font-size: 20px;
            margin-bottom: 20px;
        }
        .sidebar .nav-link {
            color: #adb5bd;
            margin-bottom: 10px;
            font-size: 16px;
        }
        .sidebar .nav-link:hover {
            color: #fff;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .table thead {
            background-color: #007bff;
            color: white;
        }
        .btn-primary, .btn-primary:hover {
            background-color: #007bff;
            border: none;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .card-header {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }
        .search-bar {
            max-width: 400px;
        }
    </style>
    <title>Gestion des événements</title>
</head>
<body>
    <div class="sidebar">
        <h4><i class="fas fa-calendar-alt"></i> Gestion</h4>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="manage_events.php" class="nav-link">
                    <i class="fas fa-list"></i> Tous les événements
                </a>
            </li>
            <li class="nav-item">
                <a href="add_event.php" class="nav-link">
                    <i class="fas fa-plus-circle"></i> Ajouter un événement
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-users"></i> Participants
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-chart-bar"></i> Statistiques
                </a>
            </li>
        </ul>
    </div>

    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-primary">
                <i class="fas fa-calendar-alt"></i> Tous les événements
            </h1>
            <div class="input-group search-bar">
                <input type="text" class="form-control" placeholder="Rechercher...">
                <button class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header">
                Liste des événements
            </div>
            <div class="card-body">
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
                        <?php foreach ($events as $event): ?>
                            <tr>
                                <td><?= htmlspecialchars($event['id']) ?></td>
                                <td><?= htmlspecialchars($event['name']) ?></td>
                                <td><?= htmlspecialchars($event['description']) ?></td>
                                <td><?= htmlspecialchars($event['date']) ?></td>
                                <td><?= htmlspecialchars($event['location']) ?></td>
                                <td class="text-center">
                                    <a href="edit_event.php?id=<?= $event['id'] ?>" class="btn btn-warning btn-sm me-2">
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
