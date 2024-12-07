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
    <title>Events - Evo Calendar</title>
    <!-- Evo Calendar CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/evo-calendar/css/evo-calendar.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/evo-calendar/css/evo-calendar.midnight-blue.css"> <!-- Optional theme -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        #calendar {
            max-width: 900px;
            margin: 50px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4"><i class="fas fa-calendar-alt"></i> Calendar View</h1>
    <!-- Evo Calendar -->
    <div id="calendar"></div>
</div>

<!-- Add jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Add Evo Calendar JS -->
<script src="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/evo-calendar/js/evo-calendar.min.js"></script>
<script>
    $(document).ready(function () {
        // Initialize Evo Calendar with English language and events
        $("#calendar").evoCalendar({
            language: 'en', // Set language to English
            theme: "Midnight Blue", // Optional theme
            todayHighlight: true, // Highlight today's date
            calendarEvents: <?= json_encode($eventsJson) ?>, // Load events from PHP
            sidebarDisplayDefault: true, // Show the sidebar by default
            sidebarToggler: true, // Enable sidebar toggle button
            eventDisplayDefault: true, // Display events by default
            eventListToggler: true, // Enable event list toggle button
        });

        // Handle event selection
        $("#calendar").on('selectEvent', function (event, activeEvent) {
            alert("Event: " + activeEvent.name + "\nLocation: " + activeEvent.description);
        });
    });
</script>
</body>
</html>
