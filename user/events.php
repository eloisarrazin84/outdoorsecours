<?php
include '../config/db.php';

// Activer le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Gestion de l'inscription
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = $_POST['event_id'] ?? null;
    $user_id = 1; // Remplacez par l'utilisateur connecté via $_SESSION['user_id']
    $availability = $_POST['availability'] ?? '';

    if (!$event_id || !$availability) {
        echo '<div class="alert alert-danger">Tous les champs sont requis.</div>';
    } else {
        // Vérifier si l'utilisateur et l'événement existent
        $check_event = $pdo->prepare("SELECT id FROM events WHERE id = ?");
        $check_event->execute([$event_id]);

        $check_user = $pdo->prepare("SELECT id FROM users WHERE id = ?");
        $check_user->execute([$user_id]);

        if ($check_event->rowCount() === 0) {
            echo '<div class="alert alert-danger">L\'événement n\'existe pas.</div>';
        } elseif ($check_user->rowCount() === 0) {
            echo '<div class="alert alert-danger">L\'utilisateur n\'existe pas.</div>';
        } else {
            // Inscription
            $stmt = $pdo->prepare("INSERT INTO user_events (user_id, event_id, availability) VALUES (?, ?, ?)");
            if ($stmt->execute([$user_id, $event_id, $availability])) {
                echo '<div class="alert alert-success">Inscription réussie !</div>';
            } else {
                echo '<div class="alert alert-danger">Erreur lors de l\'inscription.</div>';
            }
        }
    }
}

// Récupérer les événements
$stmt = $pdo->prepare("SELECT * FROM events ORDER BY date ASC");
$stmt->execute();
$events = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Événements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.css">
    <script src="https://uicdn.toast.com/calendar/latest/toastui-calendar.ie11.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        #listView, #calendarView {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <!-- Boutons pour basculer entre les vues -->
    <div class="text-center mb-4">
        <button id="listViewBtn" class="btn btn-secondary">Vue Liste</button>
        <button id="calendarViewBtn" class="btn btn-primary">Vue Calendrier</button>
    </div>

    <!-- Vue Liste -->
    <div id="listView">
        <h1 class="text-center mb-4"><i class="fas fa-calendar-alt"></i> Événements disponibles</h1>
        <div class="row">
            <?php if (!empty($events)): ?>
                <?php foreach ($events as $event): ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title text-primary"><?= htmlspecialchars($event['name']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($event['description']) ?></p>
                                <p><strong>Date :</strong> <?= htmlspecialchars($event['date']) ?></p>
                                <p><strong>Lieu :</strong> <?= htmlspecialchars($event['location']) ?></p>
                                <form method="POST">
                                    <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
                                    <div class="mb-3">
                                        <label for="availability" class="form-label">Disponibilité</label>
                                        <textarea class="form-control" name="availability" rows="3" placeholder="Exemple : Disponible à partir de 14h" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-check-circle"></i> S'inscrire
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">Aucun événement disponible pour le moment.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Vue Calendrier -->
    <div id="calendarView" style="display: none;">
        <h1 class="text-center mb-4"><i class="fas fa-calendar-alt"></i> Vue Calendrier</h1>
        <div id="calendar" style="height: 600px;"></div>
    </div>
</div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');

        // Fonction pour formater l'heure
        function formatTime(time) {
            const hours = `${time.getHours()}`.padStart(2, '0');
            const minutes = `${time.getMinutes()}`.padStart(2, '0');
            return `${hours}:${minutes}`;
        }

        // Créer une instance de TUI Calendar
        const calendar = new tui.Calendar(calendarEl, {
            defaultView: 'month',
            taskView: true,
            scheduleView: ['time'],
            useCreationPopup: true,
            useDetailPopup: true,
            month: {
                startDayOfWeek: 1, // Début de la semaine (1 = Lundi)
            },
            template: {
                // Template pour les événements avec horaire
                time(event) {
                    const { start, end, title } = event;
                    return `<span style="color: white;">${formatTime(start)}~${formatTime(end)} ${title}</span>`;
                },
                // Template pour les événements toute la journée
                allday(event) {
                    return `<span style="color: gray;">${event.title}</span>`;
                },
            },
            theme: {
                'common.border': '1px solid #dddddd',
                'month.dayname.height': '42px',
                'month.dayname.borderLeft': 'none',
                'month.dayname.borderBottom': '1px solid #e5e5e5',
                'month.dayname.paddingLeft': '10px',
                'month.dayname.fontSize': '14px',
                'month.dayname.backgroundColor': 'inherit',
                'month.schedule.height': '18px',
                'month.schedule.borderRadius': '2px',
                'month.schedule.marginTop': '2px',
                'month.schedule.marginLeft': '10px',
                'month.schedule.marginRight': '10px',
            },
        });

        // Ajouter des événements au calendrier
        const events = [
            <?php foreach ($events as $event): ?>
            {
                id: '<?= $event['id'] ?>',
                title: '<?= addslashes($event['name']) ?>',
                start: '<?= $event['date'] ?>T09:00:00', // Exemple d'heure
                end: '<?= $event['date'] ?>T12:00:00', // Exemple d'heure
                category: 'time',
                location: '<?= addslashes($event['location']) ?>',
            },
            <?php endforeach; ?>
        ];
        calendar.createEvents(events);

        // Gérer les événements de clic sur les événements du calendrier
        calendar.on('clickEvent', function ({ event }) {
            alert(`Titre : ${event.title}\nLieu : ${event.location}`);
        });

        // Ajouter des boutons de navigation
        const prevButton = document.createElement('button');
        prevButton.innerHTML = 'Précédent';
        prevButton.className = 'btn btn-secondary mx-2';
        prevButton.addEventListener('click', function () {
            calendar.prev();
        });

        const nextButton = document.createElement('button');
        nextButton.innerHTML = 'Suivant';
        nextButton.className = 'btn btn-secondary mx-2';
        nextButton.addEventListener('click', function () {
            calendar.next();
        });

        const todayButton = document.createElement('button');
        todayButton.innerHTML = "Aujourd'hui";
        todayButton.className = 'btn btn-primary mx-2';
        todayButton.addEventListener('click', function () {
            calendar.today();
        });

        // Ajouter les boutons dans la page
        const calendarControls = document.createElement('div');
        calendarControls.className = 'text-center mb-3';
        calendarControls.appendChild(prevButton);
        calendarControls.appendChild(todayButton);
        calendarControls.appendChild(nextButton);

        // Insérer les contrôles avant le calendrier
        calendarEl.parentNode.insertBefore(calendarControls, calendarEl);
    });
</script>

</script>
</body>
</html>
