<!DOCTYPE html>
<html>

<head>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: #6366f1;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }

        .content {
            padding: 20px;
            background-color: #f9fafb;
            border-radius: 0 0 8px 8px;
        }

        .otp-box {
            background-color: #e0e7ff;
            color: #4338ca;
            padding: 15px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 2px;
            margin: 20px 0;
            border-radius: 6px;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #6b7280;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Reset Password</h1>
        </div>
        <div class="content">
            <p>Halo <?= $name ?>,</p>
            <p>Anda telah meminta untuk mereset password Anda. Gunakan kode OTP berikut untuk melanjutkan proses reset password:</p>

            <div class="otp-box">
                <?= $otp ?>
            </div>

            <p>Kode ini akan kadaluarsa dalam 15 menit. Jika Anda tidak meminta reset password, abaikan email ini.</p>
            <p>Terima kasih,</p>
            <p>Tim PentaDosen</p>
        </div>
        <div class="footer">
            <p>&copy; <?= date('Y') ?> PentaDosen. All rights reserved.</p>
        </div>
    </div>
</body>

</html>