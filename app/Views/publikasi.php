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

            <?php if (session()->get('user_type') == 'dosen'): ?>
                <button id="openModalBtn" class="button-primary">Tambah Publikasi</button>
            <?php endif; ?>
            <?php if (session()->getFlashdata('success') || session()->getFlashdata('errPublikasi')): ?>
                <div class="success-feedback">
                    <?php echo session()->getFlashdata('success') ?>
                </div>
                <div class="invalid-feedback">
                    <?php echo session()->getFlashdata('errPublikasi') ?>
                </div>
            <?php endif; ?>

            <!-- Modal untuk form Publikasi -->
            <div id="publicationModal" class="modal">
                <div class="modal-content">
                    <span class="close-modal" onclick="closepublicationModal()">&times;</span>
                    <form id="publicationForm" action="<?= base_url('uploadPublikasi'); ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <h4>Tambah Publikasi</h4>

                        <!-- Kategori Kegiatan -->
                        <label for="kategoriKegiatan" class="required">Kategori Kegiatan:</label>
                        <select id="kategoriKegiatan" name="kategoriKegiatan" required>
                            <option value="Publikasi Karya Ilmiah">Publikasi Karya Ilmiah</option>
                            <option value="Publikasi Buku Ilmiah">Publikasi Buku Ilmiah</option>
                        </select>

                        <!-- Jenis -->
                        <label for="jenis" class="required">Jenis:</label>
                        <select id="jenis" name="jenisPublikasi" required>
                            <option value="Artikel">Artikel</option>
                            <option value="Buku">Buku</option>
                            <option value="Majalah">Majalah</option>
                        </select>

                        <!-- Judul -->
                        <label for="judul" class="required">Judul:</label>
                        <input type="text" id="judul" name="judulPublikasi" placeholder="Masukkan judul publikasi" value="<?= old('judulPublikasi'); ?>" required>

                        <?php if (session()->getFlashdata('errJudul')): ?>
                            <div class="invalid-feedback">
                                <?php echo session()->getFlashdata('errJudul') ?>
                            </div>
                        <?php endif; ?>

                        <!-- Tanggal Terbit -->
                        <label for="tanggalTerbit" class="required">Tanggal Terbit:</label>
                        <input type="date" id="tanggalTerbit" name="tanggalTerbit" value="<?= old('tanggalTerbit'); ?>" required>

                        <?php if (session()->getFlashdata('errTGlTerbt')): ?>
                            <div class="invalid-feedback">
                                <?php echo session()->getFlashdata('errTGlTerbt') ?>
                            </div>
                        <?php endif; ?>

                        <!-- Jumlah Halaman -->
                        <label for="jumlahHalaman" class="required">Jumlah Halaman:</label>
                        <input type="text" id="jumlahHalaman" name="jumlahHalaman" placeholder="Masukkan jumlah halaman" value="<?= old('jumlahHalaman'); ?>" required>

                        <?php if (session()->getFlashdata('errJumlahHal')): ?>
                            <div class="invalid-feedback">
                                <?php echo session()->getFlashdata('errJumlahHal') ?>
                            </div>
                        <?php endif; ?>

                        <!-- Penerbit -->
                        <label for="penerbit" class="required">Penerbit:</label>
                        <input type="text" id="penerbit" name="penerbit" placeholder="Masukkan nama penerbit" value="<?= old('penerbit'); ?>" required>

                        <?php if (session()->getFlashdata('errPenerbit')): ?>
                            <div class="invalid-feedback">
                                <?php echo session()->getFlashdata('errPenerbit') ?>
                            </div>
                        <?php endif; ?>

                        <!-- ISBN -->
                        <label for="isbn" class="required">ISBN:</label>
                        <input type="text" id="isbn" name="isbn" placeholder="Masukkan ISBN" value="<?= old('isbn'); ?>" required>

                        <?php if (session()->getFlashdata('errISBN')): ?>
                            <div class="invalid-feedback">
                                <?php echo session()->getFlashdata('errISBN') ?>
                            </div>
                        <?php endif; ?>

                        <!-- Penulis Dosen -->
                        <h4>1.1 Penulis Dosen</h4>
                        <div id="penulisDosenContainer">
                            <label for="penulisDosen" class="required">Penulis Dosen:</label>
                            <div class="penulis-dosen">
                                <div class="input-wrapper">
                                    <input
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
                                    <span class="hapusPenulisDosenIcon material-icons-sharp">remove</span>

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
                        <button type="button" id="tambahPenulisDosenBtn" class="button-tambah-dosen">Tambah</button>

                        <!-- Upload File -->
                        <label for="berkasPublikasi" class="required">File Publikasi:</label>
                        <input type="file" name="berkasPublikasi" id="berkasPublikasi" accept=".pdf" required>

                        <?php if (session()->getFlashdata('errBerkasPublikasi')): ?>
                            <div class="invalid-feedback">
                                <?php echo session()->getFlashdata('errBerkasPublikasi') ?>
                            </div>
                        <?php endif; ?>

                        <button type="submit">Unggah</button>
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


            <div class="recent-orders">
                <h2>Daftar Publikasi</h2>
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
                            <?php if (session()->get('user_type') == 'dosen'): ?>
                                <th>Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
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
                                    <td>
                                        <span class="material-icons-sharp" onclick="openEditProposalModal('<?= $dataPublikasiFU['id']; ?>')">edit</span>
                                        <span class="material-icons-sharp" onclick="openDeleteModal('<?= $dataPublikasiFU['id']; ?>')">delete</span>
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
            </div>
        </main>
    </div>
</body>

</html>