<?php
include '../config/db.php';

// Récupérer les événements
$stmt = $pdo->prepare("SELECT id, name, date, location FROM events ORDER BY date ASC");
$stmt->execute();
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Convertir les événements pour FullCalendar
$calendar_events = [];
foreach ($events as $event) {
    $calendar_events[] = [
        'id' => $event['id'],
        'title' => $event['name'],
        'start' => $event['date'],
        'description' => $event['location']
    ];
}

header('Content-Type: application/json');
echo json_encode($calendar_events);
?>
