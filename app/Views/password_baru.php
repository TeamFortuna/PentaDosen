<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <title>Password Baru</title>
</head>

<body data-baseurl="<?= base_url(); ?>">
    <?php if ($currentDateTime > $otpExpirationDateTime): ?>
        <?=
        $userModel->update($user['id'], [
            'otp' => NULL,
            'otp_expiration' => NULL,
        ]);; ?>
        <?= session()->remove('email_access'); ?>
        <?= session()->remove('token'); ?>
        <script>
            // Jika OTP sudah kadaluarsa, alihkan ke forgot_password
            window.location.href = "<?= base_url('forgot_password'); ?>";
        </script>
    <?php else: ?>
        <div class="container" id="container">
            <div class="form-container new-password">
                <form action="<?= base_url('/processNewPassword') ?>" method="post">
                    <?php
                    if (session()->getFlashdata('berhasil')) {
                        echo '<div id="validationServer03Feedback" class="invalid-feedback">
                            ' . session()->getFlashdata('berhasil') . '
                        </div>';
                    }
                    ?>
                    <h1>Password Baru</h1>
                    <input type="text" name="kode_otp" placeholder="Masukkan OTP" required>
                    <?php
                    if (session()->getFlashdata('errToken')) {
                        echo '<div id="validationServer03Feedback" class="invalid-feedback">
                            ' . session()->getFlashdata('errToken') . '
                        </div>';
                    }
                    if (session()->getFlashdata('errTokenInvalid')) {
                        echo '<div id="validationServer03Feedback" class="invalid-feedback">
                            ' . session()->getFlashdata('errTokenInvalid') . '
                        </div>';
                    }
                    ?>
                    <input type="password" name="new_password" placeholder="Password Baru" required>
                    <input type="password" name="confirm_password" placeholder="Konfirmasi Password Baru" required>
                    <?php
                    if (session()->getFlashdata('errRepassword')) {
                        echo '<div id="validationServer03Feedback" class="invalid-feedback">
                            ' . session()->getFlashdata('errRepassword') . '
                        </div>';
                    }
                    ?>
                    <button type="submit">Simpan Password</button>
                </form>
            </div>
            <div class="toggle-container">
                <div class="toggle">
                    <div class="toggle-panel toggle-right">
                        <h1>Pemberitahuan</h1>
                        <ol>
                            <li>Gunakan kata sandi dengan minimal 6 karakter.</li>
                            <li>Jangan beritahu password anda kepada siapapun termasuk kami.</li>
                            <li>Pastikan Anda mencatat kata sandi baru Anda supaya tidak terlupakan.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</body>

</html>