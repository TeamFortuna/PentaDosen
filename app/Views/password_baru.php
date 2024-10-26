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
    <div class="container" id="container">
        <div class="form-container new-password">
            <form action="<?= base_url('/process_new_password') ?>" method="post">
                <h1>Password Baru</h1>
                <input type="text" name="kode_otp" placeholder="Masukkan OTP" required>
                <input type="password" name="new_password" placeholder="Password Baru" required>
                <input type="password" name="confirm_password" placeholder="Konfirmasi Password Baru" required>
                <button type="submit">Simpan Password</button>
            </form>
        </div>
    </div>
</body>

</html>