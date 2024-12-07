<?php
include '../config/db.php';

// Vérifier si l'ID de l'événement est fourni
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];

    // Supprimer l'événement de la base de données
    $stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
    if ($stmt->execute([$event_id])) {
        header("Location: manage_events.php");
        exit();
    } else {
        echo "Erreur lors de la suppression de l'événement.";
    }
} else {
    echo "ID de l'événement non fourni.";
}
?>
