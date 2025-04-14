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

    <link rel="stylesheet" href="<?= base_url('css/topprofile.css'); ?>">

    <!-- Link ke publikasi.js -->
    <script src="<?= base_url('js/publikasi.js'); ?>"></script>

    <script>
        if (localStorage.getItem('darkMode') === 'enabled') {
            document.documentElement.classList.add('dark-mode-variables');
        }
    </script>

    <title>Publikasi</title>
</head>

<body>
    <div class="container">
        <?= $this->include('partials/sidebar'); ?>

        <main>
            <h1>Publikasi</h1>
            <p>Ini adalah halaman untuk Publikasi.</p>
            <div class="container-table">
                <div class="card">
                    <div class="card-header">
                        <h4>Publikasi</h4>
                    </div>
                    <div class="card-body">
                        <!-- ubah jadi dosen ya nanti -->
                        <?php if (session()->get('user_type') == 'dosen'): ?>
                            <button id="openModalBtn" class="button-primary">Tambah Publikasi</button>
                        <?php endif; ?>
                    </div>
                    <div class="table-controls">
                        <?php if (session()->get('user_type') == 'admin' || session()->get('user_type') == 'dosen' || session()->get('user_type') == 'fakultas'): ?>
                            <button id="exportToExcelBtn" class="button excel">Export to Excel</button>
                        <?php endif; ?>
                        <?php if (session()->getFlashdata('success') || session()->getFlashdata('errPublikasi')): ?>
                            <div class="success-feedback">
                                <?php echo session()->getFlashdata('success') ?>
                            </div>
                            <div class="invalid-feedback">
                                <?php echo session()->getFlashdata('errPublikasi') ?>
                            </div>
                        <?php endif; ?>
                        <div class="showEntries">
                            <label for="entriesSelect">Show entries:</label>
                            <select id="entriesSelect">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div class="filter">
                            <input type="text" id="customSearchInput" placeholder="Search..." class="search-input">
                        </div>
                    </div>
                    <table id="publicationTable" class="display full-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Publikasi</th>
                                <th>Dosen Penulis</th>
                                <th>Tanggal Terbit</th>
                                <th>Kategoi Kegiatan</th>
                                <th>Jenis Publikasi</th>
                                <th>Jumlah Halaman</th>
                                <th>Penerbit</th>
                                <th>Tanggal Unggah</th>
                                <th>File</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- <tr>
                                <td colspan="9" class="no-data">No data available in table</td>
                            </tr> -->
                            <?php $no = 1; ?>
                            <!-- Jika user_type dosen -->
                            <?php if (session()->get('user_type') == 'dosen'): ?>
                                <?php foreach ($publikasiFU as $dataPublikasiFU): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= esc($dataPublikasiFU['judul_publikasi'] ?? ''); ?></td>
                                        <td><?= esc($dataPublikasiFU['nama_penulis']); ?></td>
                                        <td><?= esc($dataPublikasiFU['tanggal_terbit']); ?></td>
                                        <td><?= esc($dataPublikasiFU['kategori_kegiatan']); ?></td>
                                        <td><?= esc($dataPublikasiFU['jenis_publikasi'] ?? ''); ?></td>
                                        <td><?= esc($dataPublikasiFU['jumlah_halaman']); ?></td>
                                        <td><?= esc($dataPublikasiFU['penerbit']); ?></td>
                                        <td><?= date('d-m-Y', strtotime($dataPublikasiFU['tanggal_upload'])); ?></td>
                                        <td>
                                            <div>
                                                <a href="javascript:void(0);" onclick="openPreviewModal('<?= base_url('uploads/publikasi/' . $dataPublikasiFU['file_publikasi']); ?>')">
                                                    <span class="material-icons-sharp">picture_as_pdf</span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <!-- Jika user_type admin -->
                                <?php foreach ($publikasiFA as $dataPublikasiFA): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= esc($dataPublikasiFA['judul_publikasi'] ?? ''); ?></td>
                                        <td><?= esc($dataPublikasiFA['nama_penulis']); ?></td>
                                        <td><?= esc($dataPublikasiFA['tanggal_terbit']); ?></td>
                                        <td><?= esc($dataPublikasiFA['kategori_kegiatan']); ?></td>
                                        <td><?= esc($dataPublikasiFA['jenis_publikasi'] ?? ''); ?></td>
                                        <td><?= esc($dataPublikasiFA['jumlah_halaman']); ?></td>
                                        <td><?= esc($dataPublikasiFA['penerbit']); ?></td>
                                        <td><?= date('d-m-Y', strtotime($dataPublikasiFA['tanggal_upload'])); ?></td>
                                        <td>
                                            <div>
                                                <a href="javascript:void(0);" onclick="openPreviewModal('<?= base_url('uploads/publikasi/' . $dataPublikasiFA['file_publikasi']); ?>')">
                                                    <span class="material-icons-sharp">picture_as_pdf</span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <div class="page-controls">
                        <span id="entriesShowing" class="entries-info"></span>
                        <button id="prevPageBtn" class="paginate_button">Previous</button>
                        <button id="nextPageBtn" class="paginate_button">Next</button>
                    </div>
                </div>
            </div>

            <!-- Modal untuk form Publikasi -->
            <div id="publicationModal" class="modal">
                <div class="modal-content">
                    <button class="close-modal" onclick="closepublicationModal()" aria-label="Close modal">&times;</button>
                    <form id="publicationForm" action="<?= base_url('uploadPublikasi'); ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <h4>Tambah Publikasi</h4>
                        <div class="publikasi-card">
                            <div class="publikasi-container">
                                <!-- Kategori Kegiatan -->
                                <div class="form-group">
                                    <label for="kategoriKegiatan" class="required">Kategori Kegiatan:</label>
                                    <select id="kategoriKegiatan" name="kategoriKegiatan" required>
                                        <option value="Publikasi Karya Ilmiah">Publikasi Karya Ilmiah</option>
                                        <option value="Publikasi Buku Ilmiah">Publikasi Buku Ilmiah</option>
                                    </select>
                                </div>

                                <!-- Jenis -->
                                <div class="form-group">
                                    <label for="jenis" class="required">Jenis:</label>
                                    <select id="jenis" name="jenisPublikasi" required>
                                        <option value="Artikel">Artikel</option>
                                        <option value="Buku">Buku</option>
                                        <option value="Majalah">Majalah</option>
                                    </select>
                                </div>

                                <!-- Judul -->
                                <div class="form-group">
                                    <label for="judul" class="required">Judul:</label>
                                    <input type="text" id="judul" name="judulPublikasi" placeholder="Masukkan judul publikasi" value="<?= old('judulPublikasi'); ?>" required maxlength="255">
                                    <?php if (session()->getFlashdata('errJudul')): ?>
                                        <div class="invalid-feedback">
                                            <?= session()->getFlashdata('errJudul'); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Tanggal Terbit -->
                                <div class="form-group">
                                    <label for="tanggalTerbit" class="required">Tanggal Terbit:</label>
                                    <input type="date" id="tanggalTerbit" name="tanggalTerbit" value="<?= old('tanggalTerbit'); ?>" required>
                                    <?php if (session()->getFlashdata('errTGlTerbt')): ?>
                                        <div class="invalid-feedback">
                                            <?= session()->getFlashdata('errTGlTerbt'); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Jumlah Halaman -->
                                <div class="form-group">
                                    <label for="jumlahHalaman" class="required">Jumlah Halaman:</label>
                                    <input type="text" id="jumlahHalaman" name="jumlahHalaman" placeholder="Masukkan jumlah halaman" value="<?= old('jumlahHalaman'); ?>" required>

                                    <?php if (session()->getFlashdata('errJumlahHal')): ?>
                                        <div class="invalid-feedback">
                                            <?php echo session()->getFlashdata('errJumlahHal') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Penerbit -->
                                <div class="form-group">
                                    <label for="penerbit" class="required">Penerbit:</label>
                                    <input type="text" id="penerbit" name="penerbit" placeholder="Masukkan nama penerbit" value="<?= old('penerbit'); ?>" required>

                                    <?php if (session()->getFlashdata('errPenerbit')): ?>
                                        <div class="invalid-feedback">
                                            <?php echo session()->getFlashdata('errPenerbit') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- ISBN -->
                                <div class="form-group">
                                    <label for="isbn" class="required">ISBN:</label>
                                    <input type="text" id="isbn" name="isbn" placeholder="Masukkan ISBN" value="<?= old('isbn'); ?>" required>

                                    <?php if (session()->getFlashdata('errISBN')): ?>
                                        <div class="invalid-feedback">
                                            <?php echo session()->getFlashdata('errISBN') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Penulis Dosen -->
                        <div class="anggota-card">
                            <h4>1.1 Penulis Dosen</h4>
                            <div class="penulis-container" id="penulisDosenContainer">
                                <label for="penulisDosen" class="required">Penulis Dosen:</label>
                                <div class="anggota-penulis input-group">
                                    <div class="input-wrapper">
                                        <input
                                            type="text"
                                            list="dosenList"
                                            id="penulisDosen"
                                            name="penulisDosen[]"
                                            placeholder="Cari nama atau NIDN penulis dosen"
                                            autocomplete="off"
                                            required>
                                        <datalist id="dosenList">
                                            <?php foreach ($dataDosen as $dosen): ?>
                                                <option value="<?= $dosen['nama'] . ' - ' . $dosen['nidn'] ?>">
                                                    <?= $dosen['nama'] ?> - <?= $dosen['nidn'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </datalist>
                                        <?php if (session()->getFlashdata('errDosenPenulis')): ?>
                                            <div class="invalid-feedback">
                                                <?php echo session()->getFlashdata('errDosenPenulis') ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (session()->getFlashdata('errEmptyDosenPenulis')): ?>
                                            <div class="invalid-feedback">
                                                <?php echo session()->getFlashdata('errEmptyDosenPenulis') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <!-- Tombol untuk menambah anggota internal -->
                            <button type="button" id="tambahPenulisDosenBtn">Tambah</button>
                        </div>


                        <!-- Upload File -->
                        <div class="unggah-file-card">
                            <label for="berkasPublikasi" class="required">File Publikasi:</label>
                            <input type="file" name="berkasPublikasi" id="berkasPublikasi" accept=".pdf" required>
                            <p class="file-size-info">Maksimal ukuran file: 10 MB</p>

                            <?php if (session()->getFlashdata('errBerkasPublikasi')): ?>
                                <div class="invalid-feedback">
                                    <?php echo session()->getFlashdata('errBerkasPublikasi') ?>
                                </div>
                            <?php endif; ?>
                        </div>


                        <!-- Tombol untuk unggah form -->
                        <div class="form-action">
                            <button type="submit" class="unggah-button">Unggah</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal untuk Preview PDF -->
            <div id="pdfPreviewModal" class="modal">
                <span class="close-modal" onclick="closePreviewModal()">&times;</span>
                <div class="pdf-modal-content">
                    <iframe id="pdfViewer" src="" frameborder="0"></iframe>
                    <div class="modal-actions">
                        <a id="downloadButton" href="#" download>Download</a>
                    </div>
                </div>
            </div>
            <?= $this->include('partials/topprofile'); ?>
        </main>
    </div>

</body>

</html>