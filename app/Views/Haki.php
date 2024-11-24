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
    <link rel="stylesheet" href="<?= base_url('css/haki.css'); ?>">

    <!-- Link JS DataTables dan jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('js/haki.js'); ?>"></script>

    <title>HAKI</title>
</head>

<body>
    <div class="container">
        <?= $this->include('partials/sidebar'); ?>

        <main>
            <h1>HAKI</h1>
            <p>Ini adalah halaman untuk HAKI.</p>

            <button id="openModalBtn" class="button-primary">Tambah Haki</button>
            <?php if (session()->getFlashdata('success') || session()->getFlashdata('errProposal')): ?>
                <div class="success-feedback">
                    <?php echo session()->getFlashdata('success') ?>
                </div>
                <div class="invalid-feedback">
                    <?php echo session()->getFlashdata('errProposal') ?>
                </div>
            <?php endif; ?>

            <!-- Modal untuk form HAKI -->
            <div id="hakiModal" class="modal">
                <div class="modal-content">
                    <span class="close-modal" onclick="closehakiModal()">&times;</span>
                    <form id="hakiForm" action="<?= base_url('HAKI/upload'); ?>" method="post" enctype="multipart/form-data">
                        <h2>Tambah HAKI</h2>

                        <!-- Judul Ciptaan -->
                        <label for="judulCiptaan">Judul Ciptaan:</label>
                        <input type="text" id="judulCiptaan" name="judulCiptaan" placeholder="Masukkan judul ciptaan" required>

                        <!-- Jenis Ciptaan -->
                        <label for="jenisCiptaan">Jenis Ciptaan:</label>
                        <select id="jenisCiptaan" name="jenisCiptaan" required>
                            <option value="hak_cipta">Hak Cipta</option>
                            <option value="paten">Paten</option>
                            <option value="merek">Merek</option>
                            <option value="desain_industri">Desain Industri</option>
                            <option value="rahasia_dagang">Rahasia Dagang</option>
                            <option value="dtlst">DTLST</option>
                        </select>

                        <!-- Nomor Permohonan -->
                        <label for="nomorPermohonan">Nomor Permohonan:</label>
                        <input type="text" id="nomorPermohonan" name="nomorPermohonan" placeholder="Masukkan nomor permohonan" required>

                        <!-- Tanggal Permohonan -->
                        <label for="tanggalPermohonan">Tanggal Permohonan:</label>
                        <input type="date" id="tanggalPermohonan" name="tanggalPermohonan" required>

                        <!-- Tanggal Diumumkan Pertama Kali -->
                        <label for="tanggalDiumumkan">Tanggal Diumumkan Pertama Kali:</label>
                        <input type="date" id="tanggalDiumumkan" name="tanggalDiumumkan">

                        <!-- Tempat Diumumkan Pertama Kali -->
                        <label for="tempatDiumumkan">Tempat Diumumkan Pertama Kali:</label>
                        <input type="text" id="tempatDiumumkan" name="tempatDiumumkan" placeholder="Masukkan tempat diumumkan">

                        <!-- Nomor Pencatatan -->
                        <label for="nomorPencatatan">Nomor Pencatatan:</label>
                        <input type="text" id="nomorPencatatan" name="nomorPencatatan" placeholder="Masukkan nomor pencatatan">

                        <!-- Status HAKI -->
                        <label for="statusHaki">Status HAKI:</label>
                        <select id="statusHaki" name="statusHaki" required>
                            <option value="berlaku">Berlaku</option>
                            <option value="kadaluarsa">Kadaluarsa</option>
                        </select>

                        <!-- Nama Pencipta -->
                        <label for="namaPencipta">Nama Pencipta:</label>
                        <div id="penciptaContainer">
                            <div class="input-group">
                                <input type="text" name="namaPencipta[]" placeholder="Masukkan nama pencipta" required>
                                <span class="hapusNamaPencipta material-icons-sharp" onclick="hapusPencipta(this)">remove</span>
                            </div>
                        </div>
                        <button type="button" onclick="addPencipta()">Tambah Pencipta</button>

                        <!-- Nama Pemegang Hak Cipta -->
                        <label for="namaPemegang">Nama Pemegang Hak Cipta:</label>
                        <div id="pemegangContainer">
                            <div class="input-group">
                                <input type="text" name="namaPemegang[]" placeholder="Masukkan nama pemegang hak cipta" required>
                                <span class="hapusNamaPemegang material-icons-sharp" onclick="hapusPemegang(this)">remove</span>
                            </div>
                        </div>
                        <button type="button" onclick="addPemegang()">Tambah Pemegang Hak Cipta</button>


                        <!-- Unggah File -->
                        <label for="unggahFile">Unggah File:</label>
                        <input type="file" id="unggahFile" name="unggahFile" required>

                        <button type="submit">Unggah</button>
                    </form>
                </div>
            </div>


            <div class="recent-orders">
                <h2>Daftar HAKI</h2>
                <table id="hakiTable" class="display full-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Ciptaan</th>
                            <th>Nama Pencipta</th>
                            <th>Nama Pemegang Hak Cipta</th>
                            <th>Jenis Ciptaan</th>
                            <th>Nomor Permohonan</th>
                            <th>Tanggal HAKI</th>
                            <th>File</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Fuad anak mamah</td>
                            <td>Fuad</td>
                            <td>Fuad, Rusdi, Amba</td>
                            <td>Hak Ciptaan</td>
                            <td>10023494</td>
                            <td>01/01/2024</td>
                            <td><a href="<?= base_url('uploads/HAKI1.pdf'); ?>" target="_blank">Unduh/Preview</a></td>
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
</body>

</html>