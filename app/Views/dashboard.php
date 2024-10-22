<?php

use App\Controllers\DashboardController;

?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url('css/dashboard.css') ?>">
    <title>Document</title>
</head>

<body>

    <div class="container">
        <!-- Sidebar action-->
        <aside>
            <div class="toogle">
                <div class="logo">
                    <img src="images/logo.png">
                    <h2>PentaDosen <span class="danger"></span>
                    </h2>
                </div>
                <div class="close" id="close-btn">

                </div>
            </div>
        </aside>
    </div>

    <script src="orders.js"></script>
    <script src="index.js"></script>
</body>

</html>