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
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
    <title>Modifier un événement</title>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title text-center">Modifier l'événement</h3>
                        <p class="text-center text-muted">Mettez à jour les détails de l'événement ci-dessous</p>
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
                            <button type="submit" class="btn btn-success w-100">Mettre à jour</button>
                            <a href="manage_events.php" class="btn btn-secondary w-100 mt-2">Annuler</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
