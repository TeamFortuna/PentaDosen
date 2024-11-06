<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/sidebar.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('css/kalender.css'); ?>">
    <title>Kalender</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>

    <script>
        if (localStorage.getItem('darkMode') === 'enabled') {
            document.documentElement.classList.add('dark-mode-variables');
        }
    </script>
</head>

<body>
    <div class="container">
        <!-- Sidebar Section -->
        <?= $this->include('partials/sidebar'); ?>

        <!-- Main Content -->
        <main>
            <h1>Kalender</h1>
            <p>Ini adalah halaman untuk Kalender.</p>

            <!-- Kalender -->
            <div id="calendar"></div>

            <!-- Pop-Up Form untuk menambah acara -->
            <div id="eventForm">
                <label for="eventTitle">Judul Acara:</label>
                <input type="text" id="eventTitle" placeholder="Masukkan judul acara" required>

                <label for="eventDescription">Deskripsi:</label>
                <textarea id="eventDescription" placeholder="Masukkan deskripsi acara"></textarea>

                <label for="eventStart">Tanggal Mulai:</label>
                <input type="date" id="eventStart" required min="<?= date('Y-m-d'); ?>">

                <label for="eventEnd">Tanggal Selesai:</label>
                <input type="date" id="eventEnd">

                <button type="button" onclick="addEvent()">Tambahkan Acara</button>
                <button type="button" onclick="closeEventForm()">Batal</button>
            </div>

            <!-- Modal Overlay -->
            <div class="modal-overlay" onclick="closeEventForm()"></div>

            <!-- Modal untuk Detail Acara -->
            <div id="eventDetailModal" class="event-detail-modal">
                <div class="event-detail-content">
                    <span class="close-modal" onclick="closeEventDetailModal()">&times;</span>
                    <h2 id="modalEventTitle">Judul Acara</h2>
                    <p id="modalEventDescription">Deskripsi acara</p>
                    <p><strong>Tanggal Mulai:</strong> <span id="modalEventStart"></span></p>
                    <p><strong>Tanggal Selesai:</strong> <span id="modalEventEnd"></span></p>
                </div>
            </div>
        </main>


        <!-- Right Section -->
        <?= $this->include('partials/topprofile'); ?> <!-- Include file profile.php -->
        <!-- End of Nav -->

        <script src="<?= base_url('js/kalender.js'); ?>"></script>
        <script src="<?= base_url('js/index.js'); ?>"></script>
    </div>
</body>

</html>