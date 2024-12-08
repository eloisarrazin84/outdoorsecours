<?php
include '../config/db.php';

// Récupérer les événements depuis la base de données
$stmt = $pdo->prepare("SELECT id, name, date, location, description FROM events ORDER BY date ASC");
$stmt->execute();
$events = $stmt->fetchAll();

// Convertir les événements en format JSON pour Evo Calendar et Vue Cartes
$eventsJson = [];
foreach ($events as $event) {
    $eventsJson[] = [
        'id' => $event['id'],
        'name' => $event['name'],
        'date' => date('F/d/Y', strtotime($event['date'])), // Format pour Evo Calendar
        'description' => $event['description'],
        'location' => $event['location'],
        'color' => '#007bff', // Couleur personnalisée
        'category' => 'event',
    ];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendrier d'Événements</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/evo-calendar/css/evo-calendar.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/evo-calendar/css/evo-calendar.midnight-blue.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .calendar-header {
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
            color: #5f6368;
        }

        .calendar-controls {
            text-align: center;
            margin-top: 30px;
        }

        .calendar-controls button {
            background-color: #3c7ab6;
            color: white;
            padding: 12px 24px;
            border-radius: 6px;
            border: none;
            margin: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .calendar-controls button:hover {
            background-color: #285d8f;
        }

        #calendar {
            border-radius: 10px;
            background-color: white;
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.1);
        }

        /* Cartes des événements */
        .event-cards-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin-top: 40px;
        }

        .event-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.15);
            width: 300px;
            padding: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
        }

        .event-card .event-title {
            font-size: 18px;
            font-weight: 600;
            color: #5f6368;
            margin-bottom: 10px;
        }

        .event-card .event-date {
            font-size: 14px;
            color: #8a8a8a;
            margin-bottom: 15px;
        }

        .event-card .event-description {
            font-size: 16px;
            color: #636363;
            margin-bottom: 15px;
        }

        .event-card .event-location {
            font-size: 14px;
            color: #285d8f;
        }

    </style>
</head>
<body>

<div class="container">
    <!-- Entête -->
    <div class="calendar-header">
        <h1>Vue Calendrier</h1>
    </div>

    <!-- Vue Calendrier -->
    <div id="calendar"></div>

    <!-- Contrôles pour changer de vue -->
    <div class="calendar-controls">
        <button id="calendarViewBtn">Vue Calendrier</button>
        <button id="cardsViewBtn">Vue Cartes</button>
    </div>

    <!-- Événements sous forme de cartes -->
    <div class="event-cards-container" id="eventsCardsView" style="display: none;">
        <!-- Cartes des événements -->
        <!-- Dynamique avec PHP -->
        <?php foreach ($events as $event): ?>
        <div class="event-card">
            <div class="event-title"><?= htmlspecialchars($event['name']) ?></div>
            <div class="event-date"><?= htmlspecialchars($event['date']) ?></div>
            <div class="event-description"><?= htmlspecialchars($event['description']) ?></div>
            <div class="event-location"><?= htmlspecialchars($event['location']) ?></div>
        </div>
        <?php endforeach; ?>
    </div>

</div>

<!-- Jquery et Evo Calendar JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/evo-calendar/js/evo-calendar.min.js"></script>

<script>
    $(document).ready(function () {
        // Initialisation du calendrier
        $("#calendar").evoCalendar({
            language: 'en',
            theme: "", // Design moderne
            todayHighlight: true,
            sidebarDisplayDefault: true,
            sidebarToggler: true,
            eventDisplayDefault: true,
            eventListToggler: true,
            calendarEvents: <?= json_encode($eventsJson) ?>, // Charger les événements depuis la base de données
        });

        // Changer de vue (Calendrier ou Cartes)
        $('#calendarViewBtn').on('click', function () {
            $('#calendar').show();
            $('#eventsCardsView').hide();
            $('#calendarViewBtn').addClass('active');
            $('#cardsViewBtn').removeClass('active');
        });

        $('#cardsViewBtn').on('click', function () {
            $('#calendar').hide();
            $('#eventsCardsView').show();
            $('#cardsViewBtn').addClass('active');
            $('#calendarViewBtn').removeClass('active');
        });
    });
</script>

</body>
</html>
