<?php
include '../config/db.php';

if (isset($_GET['id'])) {
    $event_id = $_GET['id'];

    // Supprimer l'événement
    $stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
    if ($stmt->execute([$event_id])) {
        header('Location: manage_events.php');
        exit;
    } else {
        echo "Erreur lors de la suppression de l'événement.";
    }
} else {
    die("ID de l'événement non fourni.");
}
?>
