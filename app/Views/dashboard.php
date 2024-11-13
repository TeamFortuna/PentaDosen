<?php if (session()->get('logged_in')): ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
        <link rel="stylesheet" href="<?= base_url('css/dashboard.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('css/sidebar.css'); ?>">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
        <title>Penta Dosen</title>

        <!-- Script untuk langsung menerapkan dark mode jika statusnya disimpan di localStorage -->
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
            <!-- End of Sidebar Section -->

            <!-- Main Content -->
            <main>
                <h1>Selamat Datang</h1>

                <!-- Analyses -->
                <div class="analyse">
                    <div class="sales">
                        <div class="status">
                            <div class="info">
                                <h3>Jumlah Proposal</h3>
                                <h1>8</h1>
                            </div>
                            <div class="progresss">
                                <svg>
                                    <circle cx="38" cy="38" r="36"></circle>
                                </svg>
                                <div class="percentage">
                                    <p>+81%</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="visits">
                        <div class="status">
                            <div class="info">
                                <h3>Jumlah Paper</h3>
                                <h1>5</h1>
                            </div>
                            <div class="progresss">
                                <svg>
                                    <circle cx="38" cy="38" r="36"></circle>
                                </svg>
                                <div class="percentage">
                                    <p>-48%</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="searches">
                        <div class="status">
                            <div class="info">
                                <h3>Jumlah HAKI</h3>
                                <h1>6</h1>
                            </div>
                            <div class="progresss">
                                <svg>
                                    <circle cx="38" cy="38" r="36"></circle>
                                </svg>
                                <div class="percentage">
                                    <p>+21%</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Analyses -->

                <!-- Table -->

                <h2>Rekap Proposal Penelitian</h2>
                <table id="dashboardTable" class="display">
                    <thead>
                        <tr>
                            <th>Nama Dosen</th>
                            <th>Judul Proposal</th>
                            <th>Tanggal Proposal</th>
                            <th>Skema</th>
                            <th>Sumber Dana</th>
                            <th>Dana yang Didanai</th>
                            <th>File</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <!-- End of Table -->

            </main>
            <!-- End of Main Content -->

            <!-- Right Section -->
            <div class="right-section">
                <div class="nav">
                    <button id="menu-btn"><span class="material-icons-sharp">menu</span></button>
                    <div class="dark-mode">
                        <span class="material-icons-sharp active">light_mode</span>
                        <span class="material-icons-sharp">dark_mode</span>
                    </div>
                    <div class="profile">
                        <div class="info">
                            <p>Hello, <b><?= session()->get('nama') ? session()->get('nama') : 'Guest'; ?></b></p>
                            <small class="text-muted"><?= session()->get('user_type'); ?></small>
                        </div>
                        <div class="profile-photo">
                            <a href="<?= base_url('profile'); ?>">
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
            </div>
        </div>

        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
        <script src="<?= base_url('js/dashboard.js') ?>"></script>
    </body>

    </html>

<?php else: ?>
    <script>
        window.location.href = "<?= base_url('register_login'); ?>";
    </script>
<?php endif; ?>