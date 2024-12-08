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
    <title>Événements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/evo-calendar/css/evo-calendar.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/evo-calendar/css/evo-calendar.midnight-blue.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
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
            font-size: 32px;
            font-weight: bold;
            color: #5b6e84;
        }
        .calendar-controls {
            text-align: center;
            margin-top: 20px;
        }
        .calendar-controls button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            margin: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 16px;
        }
        .calendar-controls button:hover {
            background-color: #0056b3;
        }
        .calendar-controls button.active {
            background-color: #0056b3;
        }
        #calendar {
            border-radius: 12px;
            background-color: #fff;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            animation: fadeIn 0.5s ease-in-out;
        }
        .event-card {
            border: 1px solid #ddd;
            background-color: #ffffff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
            transition: transform 0.3s ease;
        }
        .event-card:hover {
            transform: scale(1.05);
        }
        .event-title {
            font-size: 20px;
            font-weight: bold;
            color: #007bff;
        }
        .event-details {
            font-size: 14px;
            color: #555;
            margin-top: 8px;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="calendar-header">
        <h1><i class="fas fa-calendar-alt"></i> Vue Calendrier</h1>
    </div>
    
    <div class="calendar-controls">
        <button id="calendarViewBtn" class="btn btn-secondary active">Vue Calendrier</button>
        <button id="cardViewBtn" class="btn btn-secondary">Vue Cartes</button>
    </div>
    
    <!-- Vue Calendrier -->
    <div id="calendarView" style="display: block;">
        <div id="calendar"></div>
    </div>

    <!-- Vue Cartes -->
    <div id="cardView" style="display: none;">
        <h2 class="text-center mb-4">Événements sous forme de cartes</h2>
        <div class="event-card">
            <div class="event-title">Ultra</div>
            <div class="event-details">
                <strong>Date:</strong> December 29, 2024 <br>
                <strong>Description:</strong> test nnfc sd^lfsqfsddsgvfsdggsd <br>
                <strong>Lieu:</strong> Biviers
            </div>
        </div>
    </div>
</div>

<!-- Jquery et Evo Calendar JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/evo-calendar/js/evo-calendar.min.js"></script>
<script>
    $(document).ready(function () {
        // Initialiser le calendrier
        $("#calendar").evoCalendar({
            language: 'en',
            theme: "midnight-blue",
            todayHighlight: true,
            sidebarDisplayDefault: true,
            sidebarToggler: true,
            eventDisplayDefault: true,
            eventListToggler: true,
            calendarEvents: <?= json_encode($eventsJson) ?>, // Événements dynamiques
        });

        // Basculer entre les vues
        $('#calendarViewBtn').on('click', function () {
            $('#calendarView').show();
            $('#cardView').hide();
            $(this).addClass('active');
            $('#cardViewBtn').removeClass('active');
        });

        $('#cardViewBtn').on('click', function () {
            $('#cardView').show();
            $('#calendarView').hide();
            $(this).addClass('active');
            $('#calendarViewBtn').removeClass('active');
        });
    });
</script>

</body>
</html>
