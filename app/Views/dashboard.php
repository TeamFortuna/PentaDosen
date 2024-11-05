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
        <title>Penta Dosen</title>
    </head>

    <body>
        <a>SELAMAT DATANG <?= session()->get('username'); ?></a>
        <a><?= session()->get('logged_in'); ?></a>
        <a> Anda adalah <?= session()->get('user_type'); ?></a>
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
                                <h3>Total Sales</h3>
                                <h1>$65,024</h1>
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
                                <h3>Site Visit</h3>
                                <h1>24,981</h1>
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
                                <h3>Searches</h3>
                                <h1>14,147</h1>
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
                    <h2>Jadwal</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Course Name</th>
                                <th>Course Number</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data Jadwal akan dimasukkan di sini -->
                        </tbody>
                    </table>
                    <a href="#">Show All</a>
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
                            <p>Hey, <b><?= session()->get('nama') ? session()->get('nama') : 'Guest'; ?></b></p>
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
                        <p>Fullstack Web Developer</p>
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