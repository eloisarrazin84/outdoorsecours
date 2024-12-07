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

// Convertir les événements en format JSON pour FullCalendar
$eventsJson = [];
foreach ($events as $event) {
    $eventsJson[] = [
        'id' => $event['id'],
        'title' => $event['name'],
        'start' => $event['date'],
        'description' => $event['location']
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        #calendar {
            max-width: 900px;
            margin: 50px auto;
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

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');

        // Initialiser FullCalendar
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth', // Vue par défaut
            headerToolbar: {
                left: 'prev,next today', // Boutons
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay' // Vues disponibles
            },
            events: <?= json_encode($eventsJson) ?>, // Charger les événements depuis PHP
            eventClick: function (info) { // Action lors du clic sur un événement
                alert('Événement : ' + info.event.title + '\nLieu : ' + info.event.extendedProps.description);
            }
        });

        calendar.render();
    });
</script>
</body>
</html>
