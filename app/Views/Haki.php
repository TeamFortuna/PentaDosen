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

    <link rel="stylesheet" href="<?= base_url('css/topprofile.css'); ?>">

    <!-- Link JS DataTables dan jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('js/haki.js'); ?>"></script>

    <script>
        if (localStorage.getItem('darkMode') === 'enabled') {
            document.documentElement.classList.add('dark-mode-variables');
        }
    </script>

    <title>HKI</title>
</head>

<body>
    <div class="container">
        <?= $this->include('partials/sidebar'); ?>
        <main>
            <h1>HKI</h1>
            <p>Ini adalah halaman untuk HKI.</p>
            <div class="container-table">
                <div class="card">
                    <div class="card-header">
                        <h4>HKI</h4>
                    </div>
                    <div class="card-body">
                        <!-- ubah jadi dosen ya nanti -->
                        <?php if (session()->get('user_type') == 'dosen'): ?>
                            <button id="openModalBtn" class="button-primary">Tambah HKI</button>
                        <?php endif; ?>
                    </div>
                    <div class="table-controls">
                        <?php if (session()->get('user_type') == 'admin' || session()->get('user_type') == 'dosen' || session()->get('user_type') == 'fakultas'): ?>
                            <button id="exportToExcelBtn" class="button excel">Export to Excel</button>
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
                    <div class="table-wrapper">
                        <table id="hakiTable" class="display full-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul Ciptaan</th>
                                    <th>Nama Pencipta</th>
                                    <th>Nama Pemegang Hak Cipta</th>
                                    <th>Jenis Ciptaan</th>
                                    <th>Nomor Permohonan</th>
                                    <th>Tanggal Upload</th>
                                    <th>File</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <!-- Jika user_type dosen -->
                                <?php if (session()->get('user_type') == 'dosen'): ?>
                                    <?php foreach ($hakiFU as $dataHakiFU): ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= esc($dataHakiFU['judul_ciptaan'] ?? ''); ?></td>
                                            <td><?= esc($dataHakiFU['nama_pencipta']); ?></td>
                                            <td><?= esc($dataHakiFU['nama_pemegang']); ?></td>
                                            <td><?= esc($dataHakiFU['jenis_ciptaan']); ?></td>
                                            <td><?= esc($dataHakiFU['nomor_permohonan'] ?? ''); ?></td>
                                            <td><?= date('d-m-Y', strtotime($dataHakiFU['tanggal_upload'])); ?></td>
                                            <td>
                                                <div>
                                                    <a href="javascript:void(0);" onclick="openPreviewModal('<?= base_url('uploads/HAKI/' . $dataHakiFU['file_haki']); ?>')">
                                                        <span class="material-icons-sharp">picture_as_pdf</span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <!-- Jika user_type admin     -->
                                    <?php foreach ($hakiFA as $dataHakiFA): ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= esc($dataHakiFA['judul_ciptaan'] ?? ''); ?></td>
                                            <td><?= esc($dataHakiFA['nama_pencipta']); ?></td>
                                            <td><?= esc($dataHakiFA['nama_pemegang']); ?></td>
                                            <td><?= esc($dataHakiFA['jenis_ciptaan']); ?></td>
                                            <td><?= esc($dataHakiFA['nomor_permohonan'] ?? ''); ?></td>
                                            <td><?= date('d-m-Y', strtotime($dataHakiFA['tanggal_upload'])); ?></td>
                                            <td>
                                                <div>
                                                    <a href="javascript:void(0);" onclick="openPreviewModal('<?= base_url('uploads/HAKI/' . $dataHakiFA['file_haki']); ?>')">
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
                    <div class="page-controls">
                        <span id="entriesShowing" class="entries-info"></span>
                        <button id="prevPageBtn" class="paginate_button">Previous</button>
                        <button id="nextPageBtn" class="paginate_button">Next</button>
                    </div>
                </div>
            </div>

            <!-- Modal untuk form HAKI -->
            <div id="hakiModal" class="modal">
                <div class="modal-content">
                    <span class="close-modal" onclick="closehakiModal()">&times;</span>
                    <form id="hakiForm" action="<?= base_url('uploadHAKI'); ?>" method="post" enctype="multipart/form-data">
                        <h2>Tambah HKI</h2>
                        <?= csrf_field(); ?>
                        <div class="haki-card">
                            <div class="haki-container">
                                <!-- Judul Ciptaan -->
                                <div class="form-group">
                                    <label for="judulCiptaan">Judul Ciptaan:</label>
                                    <input type="text" id="judulCiptaan" name="judulCiptaan" placeholder="Masukkan judul ciptaan" required>
                                </div>
                                <?php if (session()->getFlashdata('errJudul')): ?>
                                    <div class="success-feedback">
                                        <?php echo session()->getFlashdata('errJudul') ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Jenis Ciptaan -->
                                <div class="form-group">
                                    <label for="jenisCiptaan">Jenis Ciptaan:</label>
                                    <select id="jenisCiptaan" name="jenisCiptaan" required>
                                        <option value="Hak Cipta">Hak Cipta</option>
                                        <option value="Paten">Paten</option>
                                        <option value="Merek">Merek</option>
                                        <option value="Desain Industri">Desain Industri</option>
                                        <option value="Rahasia Dagang">Rahasia Dagang</option>
                                        <option value="DTLST">DTLST</option>
                                    </select>
                                </div>

                                <?php if (session()->getFlashdata('errJenis')): ?>
                                    <div class="success-feedback">
                                        <?php echo session()->getFlashdata('errJenis') ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Nomor Permohonan -->
                                <div class="form-group">
                                    <label for="nomorPermohonan">Nomor Permohonan:</label>
                                    <input type="text" id="nomorPermohonan" name="nomorPermohonan" placeholder="Masukkan nomor permohonan" required>
                                </div>
                                <?php if (session()->getFlashdata('errNomorP')): ?>
                                    <div class="success-feedback">
                                        <?php echo session()->getFlashdata('errNomorP') ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Tanggal Permohonan -->
                                <div class="form-group">
                                    <label for="tanggalPermohonan">Tanggal Permohonan:</label>
                                    <input type="date" id="tanggalPermohonan" name="tanggalPermohonan" required>
                                </div>
                                <?php if (session()->getFlashdata('errTGLP')): ?>
                                    <div class="success-feedback">
                                        <?php echo session()->getFlashdata('errTGLP') ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Tempat Diumumkan Pertama Kali -->
                                <div class="form-group">
                                    <label for="tempatDiumumkan">Tempat Diumumkan Pertama Kali:</label>
                                    <input type="text" id="tempatDiumumkan" name="tempatDiumumkan" placeholder="Masukkan tempat diumumkan">
                                </div>
                                <?php if (session()->getFlashdata('errTempat')): ?>
                                    <div class="success-feedback">
                                        <?php echo session()->getFlashdata('errTempat') ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Tanggal Diumumkan Pertama Kali -->
                                <div class="form-group">
                                    <label for="tanggalDiumumkan">Tanggal Diumumkan Pertama Kali:</label>
                                    <input type="date" id="tanggalDiumumkan" name="tanggalDiumumkan">
                                </div>

                                <?php if (session()->getFlashdata('errTGLD')): ?>
                                    <div class="success-feedback">
                                        <?php echo session()->getFlashdata('errTGLD') ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Nomor Pencatatan -->
                                <div class="form-group">
                                    <label for="nomorPencatatan">Nomor Pencatatan:</label>
                                    <input type="text" id="nomorPencatatan" name="nomorPencatatan" placeholder="Masukkan nomor pencatatan">
                                </div>
                                <?php if (session()->getFlashdata('errNomorPC')): ?>
                                    <div class="success-feedback">
                                        <?php echo session()->getFlashdata('errNomorPC') ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Status HAKI -->
                                <div class="form-group">
                                    <label for="statusHaki">Status HKI:</label>
                                    <select id="statusHaki" name="statusHaki" required>
                                        <option value="berlaku">Berlaku</option>
                                        <option value="kadaluarsa">Kadaluarsa</option>
                                    </select>
                                </div>

                                <?php if (session()->getFlashdata('errStatusHAKI')): ?>
                                    <div class="success-feedback">
                                        <?php echo session()->getFlashdata('errStatusHAKI') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Nama Pencipta -->
                        <div class="anggota-card">
                            <label for="namaPencipta">Nama Pencipta:</label>
                            <div class="pencipta-container" id="penciptaContainer">
                                <div class="anggota-pencipta input-group">
                                    <div class="input-wrapper">
                                        <input
                                            type="text"
                                            list="dosenList"
                                            name="namaPencipta[]"
                                            placeholder="Masukkan nama pencipta"
                                            autocomplete="off"
                                            required>
                                        <datalist id="dosenList">
                                            <?php foreach ($dataDosenPP as $dosenPencipta): ?>
                                                <option value="<?= $dosenPencipta['nama'] . ' - ' . $dosenPencipta['nidn'] ?>">
                                                    <?= $dosenPencipta['nama'] ?> - <?= $dosenPencipta['nidn'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </datalist>
                                    </div>
                                </div>
                            </div>
                            <?php if (session()->getFlashdata('errNamaPencipta')): ?>
                                <div class="success-feedback">
                                    <?php echo session()->getFlashdata('errNamaPencipta') ?>
                                </div>
                            <?php endif; ?>
                            <button type="button" id="tambahAnggotaPencipta" onclick="addPencipta()">Tambah Pencipta</button>
                        </div>

                        <!-- Nama Pemegang Hak Cipta -->
                        <div class="anggota-card" style="margin-top: 20px;">
                            <label for="namaPemegang">Nama Pemegang Hak Cipta:</label>
                            <div class="pemegang-container" id="pemegangContainer">
                                <div class="anggota-pemegang input-group">
                                    <div class="input-wrapper">
                                        <input
                                            type="text"
                                            list="dosenList"
                                            name="namaPemegang[]"
                                            placeholder="Masukkan nama pemegang hak cipta"
                                            autocomplete="off"
                                            required>
                                        <datalist id="dosenList">
                                            <?php foreach ($dataDosenPP as $dosenPencipta): ?>
                                                <option value="<?= $dosenPencipta['nama'] . ' - ' . $dosenPencipta['nidn'] ?>">
                                                    <?= $dosenPencipta['nama'] ?> - <?= $dosenPencipta['nidn'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </datalist>
                                    </div>
                                </div>
                            </div>
                            <?php if (session()->getFlashdata('errNamaPemegang')): ?>
                                <div class="success-feedback">
                                    <?php echo session()->getFlashdata('errNamaPemegang') ?>
                                </div>
                            <?php endif; ?>
                            <button type="button" id="tambahAnggotaPemegang" onclick="addPemegang()">Tambah Pemegang</button>
                        </div>

                        <!-- Unggah File -->
                        <div class="unggah-file-card">
                            <label for="unggahFile">Unggah File:</label>
                            <input type="file" id="unggahFile" name="berkasHAKI" accept=".pdf" required>
                            <p class="file-size-info">Maksimal ukuran file: 10 MB</p>

                            <?php if (session()->getFlashdata('errBerkasHAKI')): ?>
                                <div class="error-feedback">
                                    <?php echo session()->getFlashdata('errBerkasHAKI') ?>
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
    <script src="<?= base_url('js/darkmode.js'); ?>"></script>
</body>

</html>