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
            <form action="<?= base_url('/addJadwal'); ?>" method="post">

                <label for="eventTitle">Judul Acara:</label>
                <input type="text" id="eventTitle" placeholder="Masukkan judul acara" name="judul_kegiatan" required>

                <label for="eventDescription">Deskripsi:</label>
                <textarea id="eventDescription" placeholder="Masukkan deskripsi acara"></textarea>

                <label for="eventStart">Tanggal Mulai:</label>
                <input type="date" id="eventStart" name="batas_awal" required min="<?= date('Y-m-d'); ?>">

                <label for="eventEnd">Tanggal Selesai:</label>
                <input type="date" id="eventEnd" name="batas_akhir">

                <button type="submit">Tambahkan Acara</button>
                <button type="button" onclick="closeEventForm()">Batal</button>
                </form>            

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
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var calendarEl = document.getElementById("calendar");
            var calendarConfig = {
                initialView: "dayGridMonth",
                events: [
                    {

                    }
                    <?php foreach($jadwal as $event): ?>
                    ,{
                        title: '<?= $event['judul_kegiatan']; ?>',
                        start: '<?= $event['batas_awal']; ?>',
                        end: '<?= date('Y-m-d', strtotime($event['batas_akhir'] . ' +1 day')); ?>'
                    }
                    <?php endforeach; ?>
                ],
                eventClick: function(info) {
                    // Tampilkan detail acara dalam modal
                    showEventDetails(info.event);
                }
            };
            // Menambahkan customButtons dan headerToolbar jika user_type bukan 'dosen'
            <?php if(session()->get('user_type') !== 'dosen'): ?>
                calendarConfig.customButtons = {
                    addEventButton: {
                        text: "Tambah Acara",
                        click: openEventForm
                    }
                };
                calendarConfig.headerToolbar = {
                    left: "addEventButton",
                    center: "title",
                    right: "today prev,next"
                };
            <?php endif; ?>
            // Membuat dan merender kalender
            var calendar = new FullCalendar.Calendar(calendarEl, calendarConfig);
            calendar.render();
        });
    </script>

        <script src="<?= base_url('js/index.js'); ?>"></script>
    </div>
</body>

</html>