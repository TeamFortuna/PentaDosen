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

    <!-- Link ke publikasi.css -->
    <link rel="stylesheet" href="<?= base_url('css/publikasi.css'); ?>">
    <!-- Link JS DataTables dan jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <!-- Link ke publikasi.js -->
    <script src="<?= base_url('js/publikasi.js'); ?>"></script>

    <title>Publikasi</title>
</head>

<body>
    <div class="container">
        <?= $this->include('partials/sidebar'); ?>

        <main>
            <h1>Publikasi</h1>
            <p>Ini adalah halaman untuk Publikasi.</p>

            <button id="openModalBtn" class="button-primary">Tambah Publikasi</button>
            <?php if (session()->getFlashdata('success') || session()->getFlashdata('errProposal')): ?>
                <div class="success-feedback">
                    <?php echo session()->getFlashdata('success') ?>
                </div>
                <div class="invalid-feedback">
                    <?php echo session()->getFlashdata('errProposal') ?>
                </div>
            <?php endif; ?>

            <!-- Modal untuk form Publikasi -->
            <div id="publicationModal" class="modal">
                <div class="modal-content">
                    <span class="close-modal" onclick="closepublicationModal()">&times;</span>
                    <form id="publicationForm" action="<?= base_url('Publikasi/upload'); ?>" method="post" enctype="multipart/form-data">
                        <h4>Tambah Publikasi</h4>

                        <!-- Kategori Kegiatan -->
                        <label for="kategoriKegiatan">Kategori Kegiatan:</label>
                        <select id="kategoriKegiatan" name="kategoriKegiatan" required>
                            <option value="publikasi_karya_ilmiah">Publikasi Karya Ilmiah</option>
                            <option value="publikasi_buku_ilmiah">Publikasi Buku Ilmiah</option>
                        </select>

                        <!-- Jenis -->
                        <label for="jenis">Jenis:</label>
                        <select id="jenis" name="jenis" required>
                            <option value="artikel">Artikel</option>
                            <option value="buku">Buku</option>
                            <option value="majalah">Majalah</option>
                        </select>

                        <!-- Judul -->
                        <label for="judul" class="required">Judul:</label>
                        <input type="text" id="judul" name="judul" placeholder="Masukkan judul publikasi" required>

                        <!-- Tanggal Terbit -->
                        <label for="tanggalTerbit">Tanggal Terbit:</label>
                        <input type="date" id="tanggalTerbit" name="tanggalTerbit" required>

                        <!-- Jumlah Halaman -->
                        <label for="jumlahHalaman">Jumlah Halaman:</label>
                        <input type="text" id="jumlahHalaman" name="jumlahHalaman" placeholder="Masukkan jumlah halaman" required>

                        <!-- Penerbit -->
                        <label for="penerbit">Penerbit:</label>
                        <input type="text" id="penerbit" name="penerbit" placeholder="Masukkan nama penerbit" required>

                        <!-- ISBN -->
                        <label for="isbn">ISBN:</label>
                        <input type="text" id="isbn" name="isbn" placeholder="Masukkan ISBN" required>

                        <!-- Penulis Dosen -->
                        <h4>1.1 Penulis Dosen</h4>
                        <div id="penulisDosenContainer">
                            <label for="penulisDosen">Penulis Dosen:</label>
                            <div class="penulis-dosen">
                                <div class="input-wrapper">
                                    <input type="text" id="penulisDosen" name="penulisDosen[]" placeholder="Masukkan nama penulis dosen" autocomplete="off" required>
                                    <div id="suggestions" class="suggestions"></div>
                                    <span class="hapusPenulisDosenIcon material-icons-sharp">remove</span>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol untuk menambah anggota internal -->
                        <button type="button" id="tambahPenulisDosenBtn" class="button-tambah-dosen">Tambah</button>

                        <!-- Upload File -->
                        <label for="berkasPublikasi">File Publikasi:</label>
                        <input type="file" name="berkasPublikasi" id="berkasPublikasi" required>

                        <button type="submit">Unggah</button>
                    </form>
                </div>
            </div>


            <div class="recent-orders">
                <h2>Daftar Publikasi</h2>
                <table id="publicationTable" class="display full-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Publikasi</th>
                            <th>Penulis Dosen</th>
                            <th>Tanggal Terbit</th>
                            <th>File</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Contoh Judul Publikasi </td>
                            <td>Fuad</td>
                            <td>01/01/2024</td>
                            <td><a href="<?= base_url('uploads/Publikasi1.pdf'); ?>" target="_blank">Unduh/Preview</a></td>
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