<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/sidebar.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('css/settings.css'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">

    <title>Setting</title>
</head>

<body>
    <div class="container">
        <!-- Sidebar Section -->
        <?= $this->include('partials/sidebar'); ?>
        <!-- End of Sidebar Section -->

        <!-- Main Content -->
        <main>
            <h1>Pengaturan Akun</h1>

            <!-- Form Pengaturan Akun -->
            <div class="settings-form">
                <form action="<?= base_url('Setting/update'); ?>" method="post" enctype="multipart/form-data">
                    <!-- Bagian Foto Profil -->
                    <div class="input-group" style="flex-direction: column; align-items: center;">
                        <img src="<?= base_url('uploads/'.session()->get('profilePicture')); ?>" alt="Profile Picture" class="profile-pic">
                        <input type="file" id="profilePicture" name="profilePicture" accept="image/*">
                    </div>

                    <!-- Pengaturan Lainnya -->
                    <div class="input-group">
                        <label for="nama">Nama</label>
                        <input type="text" id="nama" name="nama" value="<?= session()->get('nama'); ?>" required readonly>
                        <button type="button" class="edit-button" onclick="enableField('nama')">Rubah</button>
                    </div>

                    <div class="input-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?= session()->get('email'); ?>" required readonly>
                        <button type="button" class="edit-button" onclick="enableField('email')">Rubah</button>
                    </div>

                    <div class="input-group">
                        <label for="password">Password Baru</label>
                        <input type="password" id="password" name="password" placeholder="Masukkan password baru jika ingin mengganti" readonly>
                        <button type="button" class="edit-button" onclick="enableField('password')">Rubah</button>
                    </div>

                    <div class="input-group">
                        <label for="confirm_password">Konfirmasi Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Konfirmasi password baru" readonly>
                        <button type="button" class="edit-button" onclick="enableField('confirm_password')">Rubah</button>
                    </div>

                    <button type="submit">Simpan Pengaturan</button>
                </form>
            </div>
            <!-- End of Form Pengaturan Akun -->
        </main>
        <!-- End of Main Content -->
    </div>

    <script>
        function enableField(fieldId) {
            document.getElementById(fieldId).removeAttribute('readonly');
            document.getElementById(fieldId).focus();
        }
    </script>
</body>
</html>
