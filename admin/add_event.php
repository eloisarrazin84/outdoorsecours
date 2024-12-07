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
        echo "Événement ajouté avec succès !";
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
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
    <title>Ajouter un événement</title>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Ajouter un événement</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Nom de l'événement</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Lieu</label>
                <input type="text" class="form-control" id="location" name="location">
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>
</body>
</html>
