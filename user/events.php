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
        'date' => date('F/d/Y', strtotime($event['date'])), // Evo Calendar attend le format 'Month/day/Year'
        'description' => $event['location'],
        'type' => 'event',
        'color' => '#007bff'
    ];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Événements - Evo Calendar</title>
    <!-- Evo Calendar CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/evo-calendar/css/evo-calendar.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/evo-calendar/css/evo-calendar.midnight-blue.css"> <!-- Thème optionnel -->
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
    <h1 class="text-center mb-4"><i class="fas fa-calendar-alt"></i> Vue Calendrier</h1>
    <!-- Evo Calendar -->
    <div id="calendar"></div>
</div>

<!-- Ajouter jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Evo Calendar JS -->
<script src="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/evo-calendar/js/evo-calendar.min.js"></script>
<script>
    $(document).ready(function () {
        // Initialisation d'Evo Calendar
        $("#calendar").evoCalendar({
            theme: "Midnight Blue", // Thème du calendrier
            language: "fr", // Langue française
            todayHighlight: true, // Surligner la date d'aujourd'hui
            calendarEvents: <?= json_encode($eventsJson) ?> // Charger les événements depuis PHP
        });

        // Gestion des clics sur les événements
        $("#calendar").on('selectEvent', function (event, activeEvent) {
            alert("Événement : " + activeEvent.name + "\nLieu : " + activeEvent.description);
        });
    });
</script>
</body>
</html>
