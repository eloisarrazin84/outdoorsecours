<?php
include '../config/db.php';

// Activer le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Récupérer les événements
$stmt = $pdo->prepare("SELECT id, name, date, location FROM events ORDER BY date ASC");
$stmt->execute();
$events = $stmt->fetchAll();

// Convertir les événements en format JSON pour Evo Calendar
$eventsJson = [];
foreach ($events as $event) {
    $eventsJson[] = [
        'id' => $event['id'],
        'name' => $event['name'],
        'date' => date('F/d/Y', strtotime($event['date'])), // Format requis pour Evo Calendar
        'description' => $event['location'],
        'type' => 'event',
        'color' => '#007bff'  // Couleur personnalisée pour l'événement
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Calendar</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/evo-calendar/css/evo-calendar.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/evo-calendar/css/evo-calendar.midnight-blue.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4"><i class="fas fa-calendar-alt"></i> Calendar View</h1>
    <div id="calendar"></div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/evo-calendar/js/evo-calendar.min.js"></script>
<script>
    $(document).ready(function () {
        $("#calendar").evoCalendar({
            language: 'fr', // Calendar in English
            theme: "Midnight Blue", // Optional theme
            todayHighlight: true,
            sidebarDisplayDefault: true,
            sidebarToggler: true,
            eventDisplayDefault: true,
            eventListToggler: true,
            calendarEvents: <?= json_encode($eventsJson) ?>, // Passing PHP events data
        });

        $("#calendar").on('selectEvent', function (event, activeEvent) {
            alert("Event: " + activeEvent.name + "\nLocation: " + activeEvent.description);
        });
    });
</script>
</body>
</html>
