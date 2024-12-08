<?php
include '../config/db.php';

// Récupérer les événements depuis la base de données
$stmt = $pdo->prepare("SELECT id, name, date, location, description FROM events ORDER BY date ASC");
$stmt->execute();
$events = $stmt->fetchAll();

// Convertir les événements en format JSON pour FullCalendar
$eventsJson = [];
foreach ($events as $event) {
    $eventsJson[] = [
        'id' => $event['id'],
        'title' => $event['name'],
        'start' => date('Y-m-d', strtotime($event['date'])), // Format pour FullCalendar
        'description' => $event['description'],
        'location' => $event['location'],
        'color' => '#007bff', // Couleur personnalisée
    ];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prochains Événements</title>

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">

    <!-- Bootstrap CSS pour la mise en page -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

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
            text-align: center;
        }
        .header {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 30px;
        }
        .header img {
            height: 50px;
            margin-right: 10px;
        }
        .calendar-header {
            font-size: 30px;
            font-weight: bold;
            color: #5b6e84;
            margin-top: 10px;
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
            width: 100%;
            max-width: 400px;
            margin: auto;
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
        .view-title {
            font-size: 26px;
            font-weight: bold;
            color: #5b6e84;
            margin-top: 30px;
            text-align: center;
        }
        .fc-toolbar {
            text-align: center;
            margin-bottom: 20px;
        }
        @media (max-width: 768px) {
            .calendar-header {
                font-size: 24px;
            }
            .calendar-controls button {
                padding: 10px 15px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <!-- Header with Logo and Title -->
    <div class="header">
        <img src="https://outdoorsecours.fr/wp-content/uploads/2023/07/thumbnail_image001-1.png" alt="Outdoor Secours Logo">
        <div class="calendar-header">Prochains Événements</div>
    </div>

    <!-- Controls for toggling calendar view and card view -->
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
        <div class="event-card">
            <div class="event-title">Ultra</div>
            <div class="event-details">
                <strong>Date:</strong> December 29, 2024 <br>
                <strong>Description:</strong> test nnfc sd^lfsqfsddsgvfsdggsd <br>
                <strong>Lieu:</strong> Biviers
            </div>
        </div>
    </div>

    <!-- jQuery and FullCalendar JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

    <script>
        $(document).ready(function () {
            // Initialize FullCalendar
            const calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                initialView: 'dayGridMonth', // Default view for the calendar
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: <?= json_encode($eventsJson) ?>, // Load dynamic events
                eventClick: function(info) {
                    // Show event details on click
                    $('#cardView').show();
                    $('#calendarView').hide();
                    var eventData = info.event.extendedProps;
                    var cardContent = `
                        <div class="event-card">
                            <div class="event-title">${info.event.title}</div>
                            <div class="event-details">
                                <strong>Date:</strong> ${info.event.start.toLocaleDateString()} <br>
                                <strong>Description:</strong> ${eventData.description} <br>
                                <strong>Lieu:</strong> ${eventData.location}
                            </div>
                        </div>
                    `;
                    $('#cardView').html(cardContent);
                }
            });
            calendar.render();

            // Toggle between calendar view and card view
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
