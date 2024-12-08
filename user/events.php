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
    <title>Calendrier et Détails des Événements</title>
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
        .event-detail {
            margin-top: 30px;
        }
        .event-detail h4 {
            color: #5b6e84;
        }
        .event-detail p {
            font-size: 14px;
        }
        /* Animation pour faire apparaître le calendrier */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        /* Masquer les sections par défaut */
        #calendarView, #cardView {
            display: none;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Titre de la section -->
    <div class="calendar-header">
        <h1><i class="fas fa-calendar-alt"></i> Vue Calendrier</h1>
    </div>

    <!-- Boutons pour changer de vue -->
    <div class="text-center">
        <button onclick="showCalendarView()" class="btn btn-primary">Vue Calendrier</button>
        <button onclick="showCardView()" class="btn btn-secondary">Vue Cartes</button>
    </div>

    <!-- Vue Calendrier -->
    <div id="calendarView">
        <div id="calendar"></div>
    </div>

    <!-- Vue Cartes -->
    <div id="cardView">
        <div class="card-header">
            <h1><i class="fas fa-list"></i> Événements sous forme de cartes</h1>
        </div>
        <!-- Conteneur pour les cartes des événements -->
        <div class="card-container" id="cardContainer">
            <?php foreach ($events as $event): ?>
                <div class="event-card" onclick="showEventDetails(<?= $event['id'] ?>)">
                    <h5><?= htmlspecialchars($event['name']) ?></h5>
                    <p class="event-date"><?= date('F d, Y', strtotime($event['date'])) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Détails de l'événement -->
    <div class="event-detail" id="eventDetail" style="display:none;">
        <h4>Événement Détails</h4>
        <div id="eventInfo">
            <!-- Détails seront ajoutés ici via JS -->
        </div>
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

    // Affichage des détails d'un événement
    function showEventDetails(eventId) {
        // Recherche de l'événement dans les données PHP
        var events = <?= json_encode($events) ?>;
        var event = events.find(event => event.id == eventId);

        if (event) {
            // Afficher les détails
            var detailsHTML = `
                <h5>${event.name}</h5>
                <p><strong>Date:</strong> ${event.date}</p>
                <p><strong>Lieu:</strong> ${event.location}</p>
                <p><strong>Description:</strong> ${event.description}</p>
            `;
            document.getElementById('eventInfo').innerHTML = detailsHTML;
            document.getElementById('eventDetail').style.display = 'block';
        }
    }

    // Fonction pour afficher la vue Calendrier
    function showCalendarView() {
        document.getElementById('calendarView').style.display = 'block';
        document.getElementById('cardView').style.display = 'none';
    }

    // Fonction pour afficher la vue Cartes
    function showCardView() {
        document.getElementById('calendarView').style.display = 'none';
        document.getElementById('cardView').style.display = 'block';
    }
</script>

</body>
</html>
