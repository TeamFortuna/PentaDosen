<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/sidebar.css'); ?>">
    <title>Publikasi</title>
    <style>
        /* Styling form */
        #publicationForm {
            background: #f9f9f9;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            max-width: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        #publicationForm label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }

        #publicationForm input[type="text"],
        #publicationForm input[type="date"],
        #publicationForm input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        #publicationForm button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        #publicationForm button:hover {
            background-color: #0056b3;
        }

        /* Styling tabel publikasi */
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
            <h1>Publikasi</h1>
            <p>Ini adalah halaman untuk publikasi.</p>

            <!-- Tabel Publikasi -->
            <div class="recent-orders" style="width: 100%; height: auto; overflow-x: auto;">
                <h2>Daftar Publikasi</h2>
                <table class="full-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Publikasi</th>
                            <th>Tanggal Publikasi</th>
                            <th>File</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Contoh Data Publikasi -->
                        <tr>
                            <td>1</td>
                            <td>Contoh Judul Publikasi 1</td>
                            <td>01/01/2024</td>
                            <td><a href="<?= base_url('uploads/publikasi1.pdf'); ?>" target="_blank">Unduh/Preview</a></td>
                            <td>
                                <button>Edit</button>
                                <button>Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Contoh Judul Publikasi 2</td>
                            <td>06/01/2024</td>
                            <td><a href="<?= base_url('uploads/publikasi2.pdf'); ?>" target="_blank">Unduh/Preview</a></td>
                            <td>
                                <button>Edit</button>
                                <button>Delete</button>
                            </td>
                        </tr>
                        <!-- Tambahkan baris sesuai kebutuhan -->
                    </tbody>
                </table>
            </div>
            <!-- End of Publikasi Table -->
        </main>
        <!-- End of Main Content -->

        <!-- Right Section -->
            <!-- Form untuk menambah publikasi -->
            <form id="publicationForm" action="<?= base_url('publikasi/upload'); ?>" method="post" enctype="multipart/form-data">
                <label for="publicationName">Nama Publikasi:</label>
                <input type="text" id="publicationName" name="publicationName" placeholder="Masukkan nama publikasi" required>

                <label for="publicationDate">Tanggal Publikasi:</label>
                <input type="date" id="publicationDate" name="publicationDate" required>

                <label for="berkas_publikasi">Unggah File:</label>
                <input type="file" name="berkas_publikasi" id="berkas_publikasi" required>

                <button type="submit">Unggah</button>
            </form>
    </div>

    <script src="<?= base_url('js/index.js') ?>"></script>
</body>

</html>
