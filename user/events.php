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

// Préparer les événements pour Evo Calendar
$eventsJson = [];
foreach ($events as $event) {
    $eventsJson[] = [
        'id' => $event['id'],
        'name' => $event['name'],
        'date' => $event['date'],
        'description' => $event['location'],
        'type' => 'event' // Type peut être 'event', 'holiday', etc.
    ];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Événements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Evo Calendar CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/css/evo-calendar.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/css/evo-calendar.royal-navy.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        #calendar {
            margin: 50px auto;
            max-width: 900px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4"><i class="fas fa-calendar-alt"></i> Vue Calendrier</h1>
    <div id="calendar"></div>
</div>

<!-- Evo Calendar JS -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/js/evo-calendar.min.js"></script>
<script>
    $(document).ready(function () {
        // Initialiser Evo Calendar
        $('#calendar').evoCalendar({
            theme: 'Royal Navy', // Thème
            language: 'fr', // Langue française
            todayHighlight: true, // Surligner la date d'aujourd'hui
            calendarEvents: <?= json_encode($eventsJson) ?> // Charger les événements dynamiques depuis PHP
        });

        // Gestion des clics sur un événement
        $('#calendar').on('selectEvent', function(event, activeEvent) {
            alert(`Événement : ${activeEvent.name}\nLieu : ${activeEvent.description}`);
        });
    });
</script>
</body>
</html>
