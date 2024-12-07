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
    <title>Gestion des événements</title>
</head>
<body>
    <div class="d-flex">
        <!-- Barre latérale -->
        <nav class="bg-dark text-light p-3 vh-100" style="width: 250px;">
            <h4 class="text-center"><i class="fas fa-calendar-alt"></i> Gestion</h4>
            <ul class="nav flex-column mt-4">
                <li class="nav-item">
                    <a href="manage_events.php" class="nav-link text-light">
                        <i class="fas fa-list"></i> Tous les événements
                    </a>
                </li>
                <li class="nav-item">
                    <a href="add_event.php" class="nav-link text-light">
                        <i class="fas fa-plus-circle"></i> Ajouter un événement
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-light">
                        <i class="fas fa-users"></i> Participants
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-light">
                        <i class="fas fa-chart-bar"></i> Statistiques
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Contenu principal -->
        <div class="container-fluid p-4" style="margin-left: 250px;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="text-primary">
                    <i class="fas fa-calendar-alt"></i> Tous les événements
                </h1>
                <div class="input-group w-25">
                    <input type="text" class="form-control" placeholder="Rechercher...">
                    <button class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

            <!-- Tableau des événements -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Liste des événements</h5>
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
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
