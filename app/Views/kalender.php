<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/sidebar.css'); ?>">
    <title>Kalender</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
    <style>
        /* Styling form */
        #eventForm {
            background: #f9f9f9;
            border-radius: 13px;
            padding: 20px;
            margin-bottom: 20px;
            max-width: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        #eventForm label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }
        
        #eventForm input[type="text"],
        #eventForm input[type="date"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 13px;
        }
        
        #eventForm button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 13px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        
        #eventForm button:hover {
            background-color: #0056b3;
        }
        
        /* Styling kalender */
        #calendar {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 13px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Sidebar Section -->
        <?= $this->include('partials/sidebar'); ?>
        <!-- End of Sidebar Section -->

        <!-- Main Content -->
        <main>
            <h1>Kalender</h1>
            <p>Ini adalah halaman untuk Kalender.</p>
            
            <!-- Kalender -->
            <div id="calendar"></div>
            
        </main>
        <!-- End of Main Content -->
        
        <!-- Form untuk menambah acara -->
        <form id="eventForm">
            <label for="eventTitle">Judul Acara:</label>
            <input type="text" id="eventTitle" placeholder="Masukkan judul acara" required>

            <label for="eventStart">Tanggal Mulai:</label>
            <input type="date" id="eventStart" required>

            <label for="eventEnd">Tanggal Selesai:</label>
            <input type="date" id="eventEnd">

            <button type="button" onclick="addEvent()">Tambahkan Acara</button>
        </form>
        
        <!-- Right Section -->
        <div class="right-section">
            <div class="nav">
                <button id="menu-btn">
                    <span class="material-icons-sharp">menu</span>
                </button>
                <div class="dark-mode">
                    <span class="material-icons-sharp active">light_mode</span>
                    <span class="material-icons-sharp">dark_mode</span>
                </div>

                <div class="profile">
                    <div class="info">
                        <p>Hey, <b>Fortuna</b></p>
                        <small class="text-muted">Admin</small>
                    </div>
                    <div class="profile-photo">
                        <img src="<?= base_url('images/Logo Web Fortuna.png'); ?>" alt="Logo Web Fortuna">
                    </div>
                </div>
            </div>
            <!-- End of Nav -->
        </div>

        <script src="<?= base_url('js/index.js') ?>"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth', // Tipe tampilan kalender (bulanan, mingguan, dll.)
                    events: [
                        {
                            title: 'Event 1',
                            start: '2024-11-01'
                        },
                        {
                            title: 'Event 2',
                            start: '2024-11-15',
                            end: '2024-11-17'
                        }
                    ]
                });
                calendar.render();

                // Fungsi untuk menambah acara
                window.addEvent = function() {
                    var title = document.getElementById('eventTitle').value;
                    var start = document.getElementById('eventStart').value;
                    var end = document.getElementById('eventEnd').value;

                    if (title && start) {
                        calendar.addEvent({
                            title: title,
                            start: start,
                            end: end ? end : start // Jika tidak ada tanggal akhir, pakai tanggal mulai
                        });

                        // Bersihkan form setelah menambahkan acara
                        document.getElementById('eventForm').reset();
                    } else {
                        alert('Judul dan tanggal mulai wajib diisi');
                    }
                };
            });
        </script>
    </div>
</body>

</html>
