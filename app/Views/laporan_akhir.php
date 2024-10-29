<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/sidebar.css'); ?>">
    <title>Laporan Akhir</title>
    <style>
        /* Styling form */
        #finalReportForm,
        #additionalReportForm {
            background: #f9f9f9;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            max-width: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        #finalReportForm label,
        #additionalReportForm label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }

        #finalReportForm input[type="file"],
        #additionalReportForm input[type="text"],
        #additionalReportForm input[type="date"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        #finalReportForm button,
        #additionalReportForm button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        #finalReportForm button:hover,
        #additionalReportForm button:hover {
            background-color: #0056b3;
        }

        /* Styling tabel laporan akhir */
        .full-table {
            width: 100%;
            border-collapse: collapse;
        }

        .full-table th,
        .full-table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .full-table th {
            background-color: #f2f2f2;
        }

        /* Layout utama */
        .container {
            display: flex;
        }

        main {
            flex: 1;
            padding: 20px;
        }

        .right-section {
            width: 400px;
            position: relative;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Sidebar Section -->
        <?= $this->include('partials/sidebar'); ?>
        <!-- End of Sidebar Section -->

        <!-- Main Content -->
        <main>
            <h1>Laporan Akhir</h1>
            <p>Ini adalah halaman untuk laporan akhir.</p>

            <!-- Tabel laporan akhir -->
            <div class="recent-orders" style="width: 100%; height: auto; overflow-x: auto;">
                <h2>Daftar Laporan Akhir</h2>
                <table class="full-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Laporan Akhir</th>
                            <th>Tanggal Laporan Akhir</th>
                            <th>File</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Contoh Data Laporan Akhir -->
                        <tr>
                            <td>1</td>
                            <td>Contoh Judul Laporan Akhir 1</td>
                            <td>01/01/2024</td>
                            <td><a href="<?= base_url('uploads/laporan_Akhir1.pdf'); ?>" target="_blank">Unduh/Preview</a></td>
                            <td>
                                <button>Edit</button>
                                <button>Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Contoh Judul Laporan Akhir 2</td>
                            <td>06/01/2024</td>
                            <td><a href="<?= base_url('uploads/laporan_Akhir2.pdf'); ?>" target="_blank">Unduh/Preview</a></td>
                            <td>
                                <button>Edit</button>
                                <button>Delete</button>
                            </td>
                        </tr>
                        <!-- Tambahkan baris sesuai kebutuhan -->
                    </tbody>
                </table>
            </div>
            <!-- End of Laporan Akhir Table -->
        </main>
        <!-- End of Main Content -->

        <!-- Form tambahan untuk laporan akhir -->
        <form id="additionalReportForm" action="<?= base_url('laporan_Akhir/upload'); ?>" method="post" enctype="multipart/form-data">
            <label for="reportTitle">Judul Laporan:</label>
            <input type="text" id="reportTitle" name="reportTitle" placeholder="Masukkan judul laporan" required>

            <label for="reportDate">Tanggal Laporan:</label>
            <input type="date" id="reportDate" name="reportDate" required>

            <label for="finalReportFile">Unggah File Laporan Akhir:</label>
            <input type="file" name="finalReportFile" id="finalReportFile" required>

            <button type="submit">Unggah</button>
        </form>

        <script src="<?= base_url('js/index.js') ?>"></script>
    </div>
</body>

</html>
