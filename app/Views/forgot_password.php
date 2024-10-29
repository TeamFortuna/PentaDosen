<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Memuat style.css dari folder public -->
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <style>
        body.fade-in {
            opacity: 1;
            transition: opacity 0.5s ease-in;
        }

        body.fade-out {
            opacity: 0;
            transition: opacity 0.5s ease-out;
        }
    </style>
    <title>Forgot Password</title>
</head>

<body class="fade-in" data-baseurl="<?= base_url(); ?>">
    <div class="container" id="container">
        <div class="form-container forgot-password">
            <form action="<?= base_url('/processForgotPassword') ?>" method="post">
                <?php 
                    if (session()->getFlashdata('errToken')) {
                        echo '<div id="validationServer03Feedback" class="invalid-feedback">
                            '.session()->getFlashdata('errToken').'
                        </div>';
                    } 
                ?>
                <?php  
                    if (session()->getFlashdata('errOTP')) {
                        echo '<div id="validationServer03Feedback" class="invalid-feedback">
                            '.session()->getFlashdata('errOTP').'
                        </div>';
                    }
                ?>
                <h1>Forgot Password</h1>
                <input type="email" name="email" placeholder="Email" required>
                <?php 
                    if (session()->getFlashdata('errEmail')) {
                        echo '<div id="validationServer03Feedback" class="invalid-feedback">
                            '.session()->getFlashdata('errEmail').'
                        </div>';
                    } 
                ?>
                <button type="submit">Reset Password</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-right">
                    <h1>Pemberitahuan</h1>
                    <ol>
                        <li>Gunakan kata sandi yang terdiri dari huruf, angka, dan simbol.</li>
                        <li>Jangan beritahu password anda kepada siapapun termasuk kami.</li>
                        <li>Pastikan Anda mencatat kata sandi baru Anda supaya tidak terlupakan.</li>
                    </ol>
                    <a href="#" class="button hidden" id="register">Ingat password Anda?</a>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= base_url('js/animasi.js') ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const baseUrl = document.body.getAttribute('data-baseurl');
            const registerLink = document.getElementById('register');

            registerLink.addEventListener('click', function(event) {
                event.preventDefault();
                document.body.classList.add('fade-out');

                setTimeout(() => {
                    window.location.href = baseUrl + '/';
                }, 500);
            });
        });
    </script>
</body>

</html>