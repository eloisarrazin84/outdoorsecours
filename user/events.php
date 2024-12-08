<?php
include '../config/db.php';

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
        'date' => date('F/d/Y', strtotime($event['date'])),
        'description' => $event['location'],
        'color' => '#007bff', // Utilisation de couleurs personnalisées
        'category' => 'event',
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Calendar</title>
    <!-- Style du calendrier avec un design plus moderne -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/evo-calendar/css/evo-calendar.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/evo-calendar/css/evo-calendar.midnight-blue.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 30px 15px;
        }
        .calendar-header {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #5b6e84;
        }
        #calendar {
            border-radius: 12px;
            background-color: #fff;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            animation: fadeIn 0.5s ease-in-out;
        }
        .evo-calendar {
            border: none;
        }
        /* Animation pour faire apparaître le calendrier */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .calendar-controls {
            text-align: center;
            margin-top: 20px;
        }
        .calendar-controls button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            margin: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .calendar-controls button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="calendar-header">
        <h1><i class="fas fa-calendar-alt"></i> Calendar View</h1>
    </div>
    <div id="calendar"></div>

    <div class="calendar-controls">
        <button id="prevMonth" class="btn btn-secondary">Previous</button>
        <button id="nextMonth" class="btn btn-secondary">Next</button>
    </div>
</div>

<!-- Jquery et Evo Calendar JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/evo-calendar/js/evo-calendar.min.js"></script>
<script>
    $(document).ready(function () {
        $("#calendar").evoCalendar({
            language: 'en',
            theme: "", // Design personnalisé
            todayHighlight: true,
            sidebarDisplayDefault: true,
            sidebarToggler: true,
            eventDisplayDefault: true,
            eventListToggler: true,
            calendarEvents: <?= json_encode($eventsJson) ?>, // Ajouter les événements
        });
</script>
</body>
</html>
