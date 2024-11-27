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
            
            <?php if (session()->getFlashdata('success') || session()->getFlashdata('errHAKI')): ?>
                    <div class="success-feedback">
                        <?php echo session()->getFlashdata('success') ?>
                    </div>
                    <div class="invalid-feedback">
                        <?php echo session()->getFlashdata('errHAKI') ?>
                    </div>
            <?php endif; ?>

            <!-- Modal untuk form HAKI -->
            <div id="hakiModal" class="modal">
                <div class="modal-content">
                    <span class="close-modal" onclick="closehakiModal()">&times;</span>
                    <form id="hakiForm" action="<?= base_url('uploadHAKI'); ?>" method="post" enctype="multipart/form-data">
                        <h2>Tambah HAKI</h2>
                        <?= csrf_field(); ?>
                        
                        <!-- Judul Ciptaan -->
                        <label for="judulCiptaan">Judul Ciptaan:</label>
                        <input type="text" id="judulCiptaan" name="judulCiptaan" placeholder="Masukkan judul ciptaan" required>
                        
                        <?php if (session()->getFlashdata('errJudul')): ?>
                            <div class="success-feedback">
                                <?php echo session()->getFlashdata('errJudul') ?>
                            </div>
                        <?php endif; ?>

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
                        
                        <?php if (session()->getFlashdata('errJenis')): ?>
                            <div class="success-feedback">
                                <?php echo session()->getFlashdata('errJenis') ?>
                            </div>
                        <?php endif; ?>

                        <!-- Nomor Permohonan -->
                        <label for="nomorPermohonan">Nomor Permohonan:</label>
                        <input type="text" id="nomorPermohonan" name="nomorPermohonan" placeholder="Masukkan nomor permohonan" required>

                        <?php if (session()->getFlashdata('errNomorP')): ?>
                            <div class="success-feedback">
                                <?php echo session()->getFlashdata('errNomorP') ?>
                            </div>
                        <?php endif; ?>

                        <!-- Tanggal Permohonan -->
                        <label for="tanggalPermohonan">Tanggal Permohonan:</label>
                        <input type="date" id="tanggalPermohonan" name="tanggalPermohonan" required>

                        <?php if (session()->getFlashdata('errTGLP')): ?>
                            <div class="success-feedback">
                                <?php echo session()->getFlashdata('errTGLP') ?>
                            </div>
                        <?php endif; ?>

                        <!-- Tanggal Diumumkan Pertama Kali -->
                        <label for="tanggalDiumumkan">Tanggal Diumumkan Pertama Kali:</label>
                        <input type="date" id="tanggalDiumumkan" name="tanggalDiumumkan">

                        <?php if (session()->getFlashdata('errTGLD')): ?>
                            <div class="success-feedback">
                                <?php echo session()->getFlashdata('errTGLD') ?>
                            </div>
                        <?php endif; ?>

                        <!-- Tempat Diumumkan Pertama Kali -->
                        <label for="tempatDiumumkan">Tempat Diumumkan Pertama Kali:</label>
                        <input type="text" id="tempatDiumumkan" name="tempatDiumumkan" placeholder="Masukkan tempat diumumkan">

                        <?php if (session()->getFlashdata('errTempat')): ?>
                            <div class="success-feedback">
                                <?php echo session()->getFlashdata('errTempat') ?>
                            </div>
                        <?php endif; ?>

                        <!-- Nomor Pencatatan -->
                        <label for="nomorPencatatan">Nomor Pencatatan:</label>
                        <input type="text" id="nomorPencatatan" name="nomorPencatatan" placeholder="Masukkan nomor pencatatan">

                        <?php if (session()->getFlashdata('errNomorPC')): ?>
                            <div class="success-feedback">
                                <?php echo session()->getFlashdata('errNomorPC') ?>
                            </div>
                        <?php endif; ?>

                        <!-- Status HAKI -->
                        <label for="statusHaki">Status HAKI:</label>
                        <select id="statusHaki" name="statusHaki" required>
                            <option value="berlaku">Berlaku</option>
                            <option value="kadaluarsa">Kadaluarsa</option>
                        </select>

                        <?php if (session()->getFlashdata('errStatusHAKI')): ?>
                            <div class="success-feedback">
                                <?php echo session()->getFlashdata('errStatusHAKI') ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Nama Pencipta -->
                        <label for="namaPencipta">Nama Pencipta:</label>
                        <div id="penciptaContainer">
                            <div class="input-group">
                                <input 
                                type="text"
                                list="dosenList" 
                                name="namaPencipta[]" 
                                placeholder="Masukkan nama pencipta" 
                                required>

                                <datalist id="dosenList">
                                        <?php foreach ($dataDosenPP as $dosenPencipta): ?>
                                            <option value="<?= $dosenPencipta['nama'] . ' - ' . $dosenPencipta['nidn'] ?>">
                                                <?= $dosenPencipta['nama'] ?> - <?= $dosenPencipta['nidn'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                </datalist>

                                <span class="hapusNamaPencipta material-icons-sharp" onclick="hapusPencipta(this)">remove</span>
                            </div>
                        </div>

                        <?php if (session()->getFlashdata('errNamaPencipta')): ?>
                            <div class="success-feedback">
                                <?php echo session()->getFlashdata('errNamaPencipta') ?>
                            </div>
                        <?php endif; ?>

                        <button type="button" onclick="addPencipta()">Tambah Pencipta</button>

                        <!-- Nama Pemegang Hak Cipta -->
                        <label for="namaPemegang">Nama Pemegang Hak Cipta:</label>
                        <div id="pemegangContainer">
                            <div class="input-group">
                                <input 
                                type="text"
                                list="dosenList" 
                                name="namaPemegang[]" 
                                placeholder="Masukkan nama pemegang hak cipta" 
                                required>

                                <datalist id="dosenList">
                                        <?php foreach ($dataDosenPP as $dosenPencipta): ?>
                                            <option value="<?= $dosenPencipta['nama'] . ' - ' . $dosenPencipta['nidn'] ?>">
                                                <?= $dosenPencipta['nama'] ?> - <?= $dosenPencipta['nidn'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                </datalist>

                                <span class="hapusNamaPemegang material-icons-sharp" onclick="hapusPemegang(this)">remove</span>
                            </div>
                        </div>

                        <?php if (session()->getFlashdata('errNamaPemegang')): ?>
                            <div class="success-feedback">
                                <?php echo session()->getFlashdata('errNamaPemegang') ?>
                            </div>
                        <?php endif; ?>

                        <button type="button" onclick="addPemegang()">Tambah Pemegang Hak Cipta</button>

                        <!-- Unggah File -->
                        <label for="unggahFile">Unggah File:</label>
                        <input type="file" id="unggahFile" name="berkasHAKI" accept=".pdf" required>
                        
                        <?php if (session()->getFlashdata('errBerkasHAKI')): ?>
                            <div class="success-feedback">
                                <?php echo session()->getFlashdata('errBerkasHAKI') ?>
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
                            <th>Tanggal Upload</th>
                            <th>File</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $no = 1; ?>
                        <?php foreach ($haki as $dataHaki): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= esc($dataHaki['judul_ciptaan'] ?? ''); ?></td>
                                <td><?= esc($dataHaki['nama_pencipta']); ?></td>
                                <td><?= esc($dataHaki['nama_pemegang']); ?></td>
                                <td><?= esc($dataHaki['jenis_ciptaan']); ?></td>
                                <td><?= esc($dataHaki['nomor_permohonan'] ?? ''); ?></td>
                                <td><?= date('d-m-Y', strtotime($dataHaki['tanggal_upload'])); ?></td>
                                <td>
                                    <div>
                                        <a href="javascript:void(0);" onclick="openPreviewModal('<?= base_url('uploads/HAKI/'. $dataHaki['file_haki']); ?>')">
                                            <span class="material-icons-sharp">picture_as_pdf</span>
                                        </a>
                                    </div>
                                </td>
                                <?php if (session()->get('user_type') == 'dosen'): ?>
                                    <td>
                                        <span class="material-icons-sharp" onclick="openEditProposalModal('<?= $dataHaki['id']; ?>')">edit</span>
                                        <span class="material-icons-sharp" onclick="openDeleteModal('<?= $dataHaki['id']; ?>')">delete</span>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>

</html>