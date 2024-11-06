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

    <title>HAKI</title>
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

        #hakiForm {
            width: 100%;
            max-width: 100%;
        }

        #hakiForm h2 {
            text-align: left;
            margin-top: 0;
        }

        #hakiForm label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
            text-align: left;
        }

        #hakiForm input[type="text"],
        #hakiForm input[type="date"],
        #hakiForm input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 13px;
            box-sizing: border-box;
        }

        #hakiForm button {
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

        #hakiForm button:hover {
            background-color: #0056b3;
        }

        #statusPencapaian {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 13px;
            box-sizing: border-box;
            font-size: 14px;
            font-family: 'Montserrat';
        }
    </style>

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
            <h1>HAKI</h1>
            <p>Ini adalah halaman untuk HAKI.</p>

            <button id="openModalBtn" style="margin-bottom: 20px; margin-top: 15px; padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 13px; cursor: pointer; font-family: 'Montserrat';">Tambah HAKI</button>

            <!-- Modal untuk form HAKI -->
            <div id="hakiModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <form id="hakiForm" action="<?= base_url('HAKI/upload'); ?>" method="post" enctype="multipart/form-data">
                        <h2>Tambah HAKI</h2>

                        <label for="hakiName">Judul Penelitian:</label>
                        <input type="text" id="hakiName" name="hakiName" placeholder="Masukkan nama HAKI" required>

                        <label for="statusPencapaian">Jenis HAKI:</label>
                        <select id="statusPencapaian" name="statusPencapaian" required>
                            <option value="pending">Hak Cipta</option>
                            <option value="sedang_dikerjakan">Paten</option>
                            <option value="selesai">Merek</option>
                            <option value="selesai">Desain Industri</option>
                            <option value="selesai">Rahasia Dagang</option>
                            <option value="selesai">DTLST</option>
                        </select>

                        <label for="judulPenelitian">Nomor Pendaftaran:</label>
                        <input type="text" id="judulPenelitian" name="judulPenelitian" placeholder="Masukkan judul penelitian" required>

                        <label for="hakiDate">Tanggal Pengajuan:</label>
                        <input type="date" id="hakiDate" name="hakiDate" required>

                        <label for="statusPencapaian">Status HAKI:</label>
                        <select id="statusPencapaian" name="statusPencapaian" required>
                            <option value="pending">Pelayanan teknis</option>
                            <option value="sedang_dikerjakan">TM untuk dipublikasi</option>
                            <option value="selesai">Kadaluarsa</option>
                        </select>

                        <label for="berkas_proposal">Unggah File Proposal:</label>
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
                <h2>Daftar HAKI</h2>
                <table id="hakiTable" class="display full-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul HAKI</th>
                            <th>Tanggal HAKI</th>
                            <th>File</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Contoh Judul HAKI 1</td>
                            <td>01/01/2024</td>
                            <td><a href="<?= base_url('uploads/HAKI1.pdf'); ?>" target="_blank">Unduh/Preview</a></td>
                            <td>
                                <button>Edit</button>
                                <button>Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Contoh Judul HAKI 2</td>
                            <td>06/01/2024</td>
                            <td><a href="<?= base_url('uploads/HAKI2.pdf'); ?>" target="_blank">Unduh/Preview</a></td>
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
            $('#hakiTable').DataTable();

            var modal = document.getElementById("hakiModal");
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
                document.getElementById('hakiModal').style.display = 'none';
            };

            // Menutup modal jika pengguna mengklik di luar konten modal
            window.onclick = function(event) {
                const modal = document.getElementById('hakiModal');
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            };
        });
    </script>
</body>

</html>