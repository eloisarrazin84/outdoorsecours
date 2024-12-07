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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Ajouter le CSS d'Evo Calendar -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/evo-calendar/css/evo-calendar.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        #calendar {
            margin: 50px auto;
            max-width: 900px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4"><i class="fas fa-calendar-alt"></i> Vue Calendrier</h1>
    <!-- Div pour Evo Calendar -->
    <div id="calendar"></div>
</div>

<!-- Ajouter jQuery -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>
<!-- Ajouter le JS d'Evo Calendar -->
<script src="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/evo-calendar/js/evo-calendar.min.js"></script>
<script>
    $(document).ready(function () {
        // Initialisation d'Evo Calendar
        $("#calendar").evoCalendar({
            theme: "Royal Navy", // Choisir un thème
            language: "fr", // Définir la langue en français
            todayHighlight: true, // Surligner la date d'aujourd'hui
            calendarEvents: <?= json_encode($eventsJson) ?> // Charger les événements depuis PHP
        });

        // Ajouter un événement lorsque l'utilisateur clique dessus
        $("#calendar").on("selectEvent", function(event, activeEvent) {
            alert("Événement : " + activeEvent.name + "\nLieu : " + activeEvent.description);
        });
    });
</script>
</body>
</html>
