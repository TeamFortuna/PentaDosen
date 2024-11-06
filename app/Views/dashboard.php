<?php
if (session()->get('logged_in')):
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
        <!-- <link rel="stylesheet" href="dashboard.css"> -->
        <link rel="stylesheet" href="<?= base_url('css/dashboard.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('css/sidebar.css'); ?>">
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
            <?= $this->include('partials/sidebar'); ?> <!-- Include file sidebar.php -->
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
                                <h3>Jumlah paper</h3>
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

                <!-- Recent Orders Table -->
                <div class="recent-orders">
                    <h2>Rekap</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Nama Dosen</th>
                                <th>Judul Laporan</th>
                                <th>Tanggal Laporan</th>
                                <th>File</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data Jadwal akan dimasukkan di sini -->
                        </tbody>
                    </table>
                    <!-- <a href="#">Show All</a> -->
                </div>
                <!-- End of Recent Orders -->

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
            </div>
        </div>

        <script src="<?= base_url('js/index.js') ?>"></script>
    </body>

    </html>
<?php else: ?>
    <script>
        window.location.href = "<?= base_url('\register_login'); ?>";
    </script>
<?php endif; ?>