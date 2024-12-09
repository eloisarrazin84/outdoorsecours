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
        .modal-header, .modal-footer {
            background-color: #007bff;
            color: white;
        }
        .event-card {
            margin-bottom: 15px;
        }
        .fc .fc-toolbar-title {
            font-weight: bold;
            color: #5b6e84;
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
        <!-- Ajouter un nouvel événement -->
        <button class="btn btn-success mt-4" data-bs-toggle="modal" data-bs-target="#eventModal">Ajouter un événement</button>
    </div>

    <!-- Modal pour ajouter/modifier un événement -->
    <div id="eventModal" class="modal fade" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Ajouter / Modifier un événement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="eventForm">
                        <div class="mb-3">
                            <label for="eventTitle" class="form-label">Titre</label>
                            <input type="text" class="form-control" id="eventTitle">
                        </div>
                        <div class="mb-3">
                            <label for="eventDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="eventDescription"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="eventLocation" class="form-label">Lieu</label>
                            <input type="text" class="form-control" id="eventLocation">
                        </div>
                        <div class="mb-3">
                            <label for="eventDate" class="form-label">Date</label>
                            <input type="date" class="form-control" id="eventDate">
                        </div>
                        <button type="button" id="saveEventBtn" class="btn btn-primary">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>
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
                    <div class="event-card">
                        <div class="event-title">${event.title}</div>
                        <div class="event-details">
                            <strong>Date:</strong> ${event.start} <br>
                            <strong>Description:</strong> ${event.description} <br>
                            <strong>Lieu:</strong> ${event.location}
                        </div>
                    </div>
                `);
            });
        }

        renderCardView();  // Initialisation de la vue des cartes

        // Sauvegarder l'événement depuis le modal
        $('#saveEventBtn').click(function() {
            const eventData = {
                title: $('#eventTitle').val(),
                description: $('#eventDescription').val(),
                location: $('#eventLocation').val(),
                start: $('#eventDate').val()
            };

            // Ajouter l'événement dans le tableau local pour l'exemple
            eventsData.push(eventData);

            // Réactualiser la vue des cartes
            renderCardView();
            $('#eventModal').modal('hide');  // Fermer le modal
        });
    });
</script>

</body>
</html>
