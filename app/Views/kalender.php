<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/sidebar.css'); ?>">
    <title>Laporan Kemajuan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>

</head>

<body>
    <div class="container">
        <!-- Sidebar Section -->
        <!-- Bisa meng-include file sidebar yang sama -->
        <?= $this->include('partials/sidebar'); ?>
        <!-- End of Sidebar Section -->

        <!-- Main Content -->
        <main>
            <h1>Kalender</h1>
            <p>Ini adalah halaman untuk Kalender.</p>
            <div id="calendar"></div> <!-- Elemen kalender -->
        </main>
        <!-- End of Main Content -->

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
                // Anda bisa menambahkan daftar event di sini
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
    });
</script>

</body>

</html>