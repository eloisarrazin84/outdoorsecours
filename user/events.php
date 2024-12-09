<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prochains Événements</title>

    <!-- CDN FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/main.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Style supplémentaire -->
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
        .calendar-controls {
            text-align: center;
            margin-top: 20px;
        }
        #calendar {
            margin-top: 20px;
        }
        .event-card {
            margin-bottom: 15px;
        }
        .fc .fc-toolbar-title {
            font-weight: bold;
            color: #5b6e84;
        }
        .modal-header, .modal-footer {
            background-color: #007bff;
            color: white;
        }
        .event-header {
            font-size: 22px;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Logo et titre -->
    <div class="text-center mb-4">
        <img src="https://outdoorsecours.fr/wp-content/uploads/2023/07/thumbnail_image001-1.png" alt="Logo" width="100">
        <h1 class="mt-3">Prochains Événements</h1>
    </div>

    <!-- Vue Cartes -->
    <div id="cardView">
        <div id="eventCardContainer"></div>
    </div>

</div>

<!-- jQuery, FullCalendar JS, et Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function () {
        // Événements récupérés depuis la base de données (exemple)
        const eventsData = [
            {
                title: 'Ultra',
                start: '2024-12-29',
                description: 'test nnfc^lfsqfsddsgvfsdggsd',
                location: 'Biviers',
                color: '#007bff'
            }
        ];

        // Afficher les événements sous forme de carte
        function renderCardView() {
            $('#eventCardContainer').empty(); // Vide l'ancienne vue
            eventsData.forEach(event => {
                $('#eventCardContainer').append(`
                    <div class="card mb-3">
                        <div class="card-header" style="background-color: #007bff; color: white;">
                            <h5 class="card-title">${event.title}</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Date:</strong> ${event.start}</p>
                            <p><strong>Description:</strong> ${event.description}</p>
                            <p><strong>Lieu:</strong> ${event.location}</p>
                        </div>
                    </div>
                `);
            });
        }

        renderCardView();  // Initialisation de la vue des cartes
    });
</script>

</body>
</html>
