<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/sidebar.css'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Link CSS DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <script src="<?= base_url('js/animasi.js'); ?>"></script>
    <!-- Link JS DataTables dan jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <title>Laporan Akhir</title>
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 220px;
            top: 0;
            width: calc(100% - 250px);
            height: 100%;
            overflow-y: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #f9f9f9;
            margin: 0;
            padding: 40px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            position: absolute;
            top: 20px;
            right: 30px;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
        }

        #laporanAkhirForm {
            width: 100%;
            max-width: 100%;
        }

        #laporanAkhirForm h2 {
            text-align: left;
            margin-top: 0;
        }

        #laporanAkhirForm label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
            text-align: left;
        }

        #laporanAkhirForm input[type="text"],
        #laporanAkhirForm input[type="date"],
        #laporanAkhirForm input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 13px;
            box-sizing: border-box;
        }

        #laporanAkhirForm button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 13px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }

        #laporanAkhirForm button:hover {
            background-color: #0056b3;
        }
    </style>

    <!-- Script untuk langsung menerapkan dark mode jika statusnya disimpan di localStorage -->
    <script>
        if (localStorage.getItem('darkMode') === 'enabled') {
            document.documentElement.classList.add('dark-mode-variables');
        }
    </script>
</head>

<body>
    <div class="container">
        <?= $this->include('partials/sidebar'); ?>

        <main>
            <h1>Laporan Akhir</h1>
            <p>Ini adalah halaman untuk Laporan Akhir.</p>

            <button id="openModalBtn" style="margin-bottom: 20px; margin-top: 15px; padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 13px; cursor: pointer; font-family: 'Montserrat';">Tambah Laporan Akhir</button>

            <!-- Modal untuk form Laporan Akhir -->
            <div id="laporanAkhirModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <form id="laporanAkhirForm" action="<?= base_url('Laporan Akhir/upload'); ?>" method="post" enctype="multipart/form-data">
                        <h2>Tambah Laporan Akhir</h2>

                        <label for="laporanAkhirName">Judul Penelitian:</label>
                        <input type="text" id="laporanAkhirName" name="laporanAkhirName" placeholder="Masukkan nama Laporan Akhir" required>

                        <label for="laporanAkhirDate">Kesimpulan Penelitian:</label>
                        <input type="date" id="laporanAkhirDate" name="laporanAkhirDate" required>

                        <label for="judulPenelitian">Pembahasan Temuan:</label>
                        <input type="text" id="judulPenelitian" name="judulPenelitian" placeholder="Masukkan judul penelitian" required>

                        <label for="deskripsiSingkat">Dampak Penelitian:</label>
                        <textarea id="deskripsiSingkat" name="deskripsiSingkat" required></textarea>

                        <label for="latarBelakang">Rekomendasi:</label>
                        <textarea id="latarBelakang" name="latarBelakang" required></textarea>

                        <label for="jadwalPenelitian">Tanggal Selesai:</label>
                        <input type="date" id="jadwalPenelitian" name="jadwalPenelitian" required>

                        <label for="berkas_proposal">File Laporan Akhir:</label>
                        <input type="file" name="berkas_proposal" id="berkas_proposal" required>

                        <button type="submit">Unggah</button>
                    </form>

                    <style>
                        textarea {
                            width: 100%;
                            height: 150px;
                            padding: 10px;
                            margin-top: 5px;
                            margin-bottom: 10px;
                            border: 1px solid #ccc;
                            border-radius: 13px;
                            box-sizing: border-box;
                            resize: none;
                        }
                    </style>


                </div>
            </div>

            <div class="recent-orders" style="width: 100%; height: auto; overflow-x: auto;">
                <h2>Daftar Laporan Akhir</h2>
                <table id="laporanAkhirTable" class="display full-table">
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
                        <tr>
                            <td>1</td>
                            <td>Contoh Judul Laporan Akhir 1</td>
                            <td>01/01/2024</td>
                            <td><a href="<?= base_url('uploads/Laporan Akhir1.pdf'); ?>" target="_blank">Unduh/Preview</a></td>
                            <td>
                                <button>Edit</button>
                                <button>Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Contoh Judul Laporan Akhir 2</td>
                            <td>06/01/2024</td>
                            <td><a href="<?= base_url('uploads/Laporan Akhir2.pdf'); ?>" target="_blank">Unduh/Preview</a></td>
                            <td>
                                <button>Edit</button>
                                <button>Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script>
        $(document).ready(function() {
            $('#laporanAkhirTable').DataTable();

            var modal = document.getElementById("laporanAkhirModal");
            var btn = document.getElementById("openModalBtn");
            var span = document.getElementsByClassName("close")[0];

            btn.onclick = function() {
                modal.style.display = "block";
            }

            span.onclick = function() {
                modal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
            // Menutup modal saat tombol 'X' diklik
            document.querySelector('.close').onclick = function() {
                document.getElementById('laporanAkhirModal').style.display = 'none';
            };

            // Menutup modal jika pengguna mengklik di luar konten modal
            window.onclick = function(event) {
                const modal = document.getElementById('laporanAkhirModal');
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            };
        });
    </script>
</body>

</html>