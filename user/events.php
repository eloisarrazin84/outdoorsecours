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
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vue Calendrier et Cartes</title>
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
        .calendar-header, .card-header {
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
        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin-top: 30px;
        }
        .event-card {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 250px;
            margin: 15px;
            padding: 20px;
            transition: transform 0.3s;
        }
        .event-card:hover {
            transform: translateY(-10px);
        }
        .event-card h5 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }
        .event-card p {
            font-size: 14px;
            color: #666;
        }
        .event-card .event-date {
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Titre de la section Calendrier -->
    <div class="calendar-header">
        <h1><i class="fas fa-calendar-alt"></i> Vue Calendrier</h1>
    </div>

    <!-- Calendrier -->
    <div id="calendar"></div>

    <!-- Titre de la section Cartes -->
    <div class="card-header">
        <h1><i class="fas fa-list"></i> Événements sous forme de cartes</h1>
    </div>

    <!-- Conteneur pour les cartes des événements -->
    <div class="card-container">
        <?php foreach ($events as $event): ?>
            <div class="event-card">
                <h5><?= htmlspecialchars($event['name']) ?></h5>
                <p><?= htmlspecialchars($event['description']) ?></p>
                <p class="event-date"><?= date('F d, Y', strtotime($event['date'])) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Jquery et Evo Calendar JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/evo-calendar/js/evo-calendar.min.js"></script>
<script>
    $(document).ready(function () {
        // Initialiser le calendrier Evo
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
    });
</script>

</body>
</html>
