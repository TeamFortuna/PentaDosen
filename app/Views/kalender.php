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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        if (localStorage.getItem('darkMode') === 'enabled') {
            document.documentElement.classList.add('dark-mode-variables');
        }
    </script>

    <script>
        const updateJadwalUrl = "<?= base_url('/updateJadwal'); ?>";
        const deleteJadwalUrl = "<?= base_url('/deleteJadwal'); ?>";
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
                    <textarea id="eventDescription" name='deskripsi' placeholder="Masukkan deskripsi acara"></textarea>


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

        <!-- Modal Popup untuk Update dan Delete -->
        <div id="eventActionModal" class="event-action-modal">
            <div class="event-action-content">
                <span class="close-modal" onclick="closeEventActionModal()">&times;</span>
                <h2>Edit atau Hapus Acara</h2>
                <form id="updateForm" onsubmit="submitUpdate(event)">
                    <input type="hidden" id="updateEventId">

                    <!-- Salin elemen-elemen dari form tambah acara -->
                    <label for="updateEventTitle">Judul Acara:</label>
                    <input type="text" id="updateEventTitle" name="judul_kegiatan" value="<?= old('judul_kegiatan'); ?>">

                    <label for="updateEventDescription">Deskripsi:</label>
                    <textarea id="updateEventDescription" name="deskripsi" required></textarea>

                    <label for="updateEventStart">Tanggal Mulai:</label>
                    <input type="date" id="updateEventStart" name="batas_awal" required min="<?= date('Y-m-d'); ?>">

                    <label for="updateEventEnd">Tanggal Selesai:</label>
                    <input type="date" id="updateEventEnd" name="batas_akhir">

                    <button type="submit">Update Acara</button>
                    <button type="button" onclick="deleteEvent()">Delete Acara</button>
                    <button type="button" onclick="closeEventActionModal()">Batal</button>
                </form>
            </div>
        </div>

        <!-- Modal untuk Konfirmasi Delete -->
        <div id="confirmDeleteModal" class="confirm-delete-modal">
            <div class="confirm-delete-content">
                <h3>Apakah Anda yakin ingin menghapus acara ini?</h3>
                <button class="delete" onclick="confirmDelete()">Ya, Hapus</button>
                <button class="cancel" onclick="closeConfirmDeleteModal()">Batal</button>
            </div>
        </div>

        <!-- Modal untuk Pemberitahuan Penghapusan -->
        <div id="deleteNotificationModal" class="delete-notification-modal">
            <div class="delete-notification-content">
                <p>Acara berhasil dihapus!</p>
            </div>
        </div>

        <!-- Modal untuk Pemberitahuan Update -->
        <div id="updateNotificationModal" class="update-notification-modal">
            <div class="update-notification-content">
                <p>Acara berhasil diperbarui!</p>
            </div>
        </div>




        <!-- Right Section -->
        <div class="right-section">
            <div class="nav">
                <button id="menu-btn">
                    <span class="material-icons-sharp">
                        menu
                    </span>
                </button>
                <div class="dark-mode">
                    <span class="material-icons-sharp active">
                        light_mode
                    </span>
                    <span class="material-icons-sharp">
                        dark_mode
                    </span>
                </div>

                <div class="profile">
                    <div class="info">
                        <p>Hello, <b><?= session()->get('nama') ? session()->get('nama') : 'Guest'; ?></b></p>
                        <small class="text-muted"><?= session()->get('user_type'); ?></small>
                    </div>
                    <div class="profile-photo">
                        <a href="<?= base_url('profile'); ?>"> <!-- Tambahkan link ke halaman profil -->
                            <img src="<?= base_url('images/Logo Web Fortuna.png'); ?>" alt="Logo Web Fortuna">
                        </a>
                    </div>
                </div>
            </div>
            <!-- End of Nav -->

            <div class="user-profile">
                <div class="logo">
                    <img src="<?= base_url('images/Logo Web Fortuna.png'); ?>" alt="Logo Web Fortuna">
                    <h2>Penta Dosen</h2>
                    <p>Teams Fortuna</p>
                </div>
            </div>

            <div class="reminders">
                <div class="header">
                    <h2>Reminders</h2>
                    <span class="material-icons-sharp">notifications_none</span>
                </div>
                <?php foreach ($jadwal as $event): ?>
                    <div class="notification" onclick="showEventDetailFromReminder('<?= $event['judul_kegiatan']; ?>', '<?= $event['deskripsi']; ?>', '<?= $event['batas_awal']; ?>', '<?= $event['batas_akhir']; ?>')">
                        <div class="icon">
                            <span class="material-icons-sharp">event</span>
                        </div>
                        <div class="content">
                            <div class="info">
                                <h3><?= $event['judul_kegiatan']; ?></h3>
                                <small class="text-muted"><?= date("d M Y", strtotime($event['batas_awal'])); ?> - <?= date("d M Y", strtotime($event['batas_akhir'])); ?></small>
                            </div>
                            <?php if (session()->get('user_type') !== 'dosen'): ?>
                                <span class="material-icons-sharp" onclick="openEventActionModal(
                            '<?= $event['id']; ?>', 
                            '<?= $event['judul_kegiatan']; ?>', 
                            '<?= $event['deskripsi']; ?>', 
                            '<?= $event['batas_awal']; ?>', 
                            '<?= $event['batas_akhir']; ?>')">more_vert</span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>

        </div>

        <script src="<?= base_url('js/kalender.js'); ?>"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var calendarEl = document.getElementById("calendar");
                var calendarConfig = {
                    initialView: "dayGridMonth",
                    events: [{

                        }
                        <?php foreach ($jadwal as $event): ?>, {
                                title: '<?= $event['judul_kegiatan']; ?>',
                                description: '<?= $event['deskripsi']; ?>',
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
                <?php if (session()->get('user_type') !== 'dosen'): ?>
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