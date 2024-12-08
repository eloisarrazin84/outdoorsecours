<?php
include '../config/db.php';

// Récupérer les événements
$stmt = $pdo->prepare("SELECT id, name, date, location, description FROM events ORDER BY date ASC");
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
    <title>Calendrier d'Événements</title>
    <!-- Style de base -->
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

        /* Vue Calendrier */
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
        <div class="event-card">
            <div class="event-title">Ultra</div>
            <div class="event-date">December 29, 2024</div>
            <div class="event-description">Test description for event</div>
            <div class="event-location">Location: Biviers</div>
        </div>
        <div class="event-card">
            <div class="event-title">Marathon</div>
            <div class="event-date">January 15, 2025</div>
            <div class="event-description">Another event description</div>
            <div class="event-location">Location: Paris</div>
        </div>
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
            theme: "midnight-blue", // Design moderne
            todayHighlight: true,
            sidebarDisplayDefault: true,
            sidebarToggler: true,
            eventDisplayDefault: true,
            eventListToggler: true,
            calendarEvents: [
                {
                    id: 'event1',
                    name: 'Ultra',
                    date: 'December/29/2024',
                    type: 'event',
                    description: 'Test description for event',
                    location: 'Biviers',
                    color: '#007bff'
                },
                {
                    id: 'event2',
                    name: 'Marathon',
                    date: 'January/15/2025',
                    type: 'event',
                    description: 'Another event description',
                    location: 'Paris',
                    color: '#ff5733'
                }
            ],
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
