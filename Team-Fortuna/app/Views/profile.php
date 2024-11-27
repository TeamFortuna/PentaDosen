<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="<?= base_url('css/profilestyle.css'); ?>">
</head>

<body>
    <div class="profile-container">
        <div class="back-button-container">
            <a href="<?= base_url('dashboard'); ?>" class="back-button">← Back to Dashboard</a>
        </div>
        <!-- Tombol Kembali ke Dashboard -->
        <h1>Profil Pengguna</h1>
        <div class="profile-card">
            <!-- Foto Profil -->
            <div class="profile-photo">
                <img src="<?= base_url('images/Logo Web Fortuna.png'); ?>" alt="User Profile Photo">
            </div>
            <!-- Informasi Profil -->
            <div class="profile-info">
                <label>Nama:</label>
                <p>Nama Lengkap</p>
            </div>
            <div class="profile-info">
                <label>Inisial Nama:</label>
                <p>AB</p>
            </div>
            <div class="profile-info">
                <label>Nama Prodi:</label>
                <p>Informatika</p>
            </div>
            <div class="profile-info">
                <label>Email:</label>
                <p>example@example.com</p>
            </div>
            <div class="profile-info">
                <label>Username:</label>    
                <p>username123</p>
            </div>
            <div class="profile-info">
                <label>Password:</label>
                <p>********</p>
            </div>
        </div>
    </div>
</body>

</html>
