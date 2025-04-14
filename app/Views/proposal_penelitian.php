<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/sidebar.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('css/proposal.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('css/topprofile.css'); ?>">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <!-- jQuery (jika belum terinstal) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Tambahkan library SheetJS untuk export Excel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>


    <title>Penelitian</title>

    <!-- Dark Mode Script -->
    <script>
        if (localStorage.getItem('darkMode') === 'enabled') {
            document.documentElement.classList.add('dark-mode-variables');
        }
    </script>

    <script>
        function formatCurrency(input) {
            // Menghilangkan semua karakter selain angka
            let value = input.value.replace(/\D/g, '');

            // Mengformat angka menjadi format mata uang
            if (value) {
                value = parseInt(value).toLocaleString('id-ID', {
                    style: 'decimal'
                });
                input.value = 'Rp.' + value;
            } else {
                input.value = '';
            }
        }
    </script>

    <script>
        const flashSuccess = "<?= session('success') ?>";
        const flashError = "<?= session('error') ?>";
    </script>

</head>

<body>

    <div class="container">
        <?= $this->include('partials/sidebar'); ?>
        <main>
            <h1>Penelitian</h1>
            <p>Ini adalah halaman untuk Penelitian.</p>
            <div class="container-table">
                <div class="card">
                    <div class="card-header">
                        <h4>Penelitian</h4>
                    </div>
                    <div class="card-body">
                        <!-- ubah jadi dosen ya nanti -->
                        <?php if (session()->get('user_type') == 'dosen'): ?>
                            <button id="openModalBtn" class="button-primary">Tambah Penelitian</button>
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
                    <table id="proposalPenelitianTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Penelitian</th>
                                <th>Ketua Pengusul</th>
                                <th>Anggota Pengusul</th>
                                <th>Dana yang Disetujui</th>
                                <th>Tanggal Pengisian</th>
                                <th>Proposal</th>
                                <th>Laporan Kemajuan</th>
                                <th>Laporan Akhir</th>
                                <?php if (session()->get('user_type') == 'dosen'): ?>
                                    <th>Aksi</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- <tr>
                                <td colspan="9" class="no-data">No data available in table</td>
                            </tr> -->
                            <?php $no = 1; ?>
                            <!-- Jika user_type dosen -->
                            <?php if (session()->get('user_type') == 'dosen'): ?>
                                <?php foreach ($proposalsFU as $proposalFU): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= esc($proposalFU['judul_penelitian']); ?></td>
                                        <td><?= esc($proposalFU['nama'] ?? ''); ?></td>
                                        <td><?= esc($proposalFU['anggota_nama'] ?? ''); ?></td>
                                        <td>Rp. <?= number_format($proposalFU['biaya_didanai'] ?? 0, 0, ',', '.'); ?></td>
                                        <td><?= date('d-m-Y', strtotime($proposalFU['tanggal_upload'])); ?></td>
                                        <td>
                                            <div>
                                                <a href="javascript:void(0);" onclick="openPreviewModal('<?= base_url('uploads/' . $proposalFU['file_penelitian']); ?>')">
                                                    <span class="material-icons-sharp">picture_as_pdf</span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <!-- laporan kemajuan -->
                                            <?php if ($proposalFU['file_penelitian'] != null): ?>
                                                <?php if ($proposalFU['file_laporan_kemajuan'] != null): ?>
                                                    <div>
                                                        <a href="javascript:void(0);" onclick="openPreviewModal('<?= base_url('uploads/' . $proposalFU['file_laporan_kemajuan']); ?>')">
                                                            <span class="material-icons-sharp">picture_as_pdf</span>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                                <form action="<?= base_url('ProposalPenelitianController/uploadLaporanKemajuan/' . $proposalFU['id']); ?>" method="post" enctype="multipart/form-data">
                                                    <input type="file" name="laporan_kemajuan" style="display: none;" id="laporanKemajuan_<?= $proposalFU['id']; ?>" onchange="this.form.submit();">
                                                    <label for="laporanKemajuan_<?= $proposalFU['id']; ?>" class="btn btn-upload">
                                                        <span class="material-icons-sharp">file_upload</span> Unggah
                                                    </label>
                                                </form>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <!-- laporan akhir Preview -->
                                            <?php if ($proposalFU['file_penelitian'] != null): ?>
                                                <?php if ($proposalFU['file_laporan_akhir'] != null): ?>
                                                    <div>
                                                        <a href="javascript:void(0);" onclick="openPreviewModal('<?= base_url('uploads/' . $proposalFU['file_laporan_akhir']); ?>')">
                                                            <span class="material-icons-sharp">picture_as_pdf</span>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                                <!-- laporan akhir Unggah -->
                                                <form action="<?= base_url('ProposalPenelitianController/uploadLaporanAkhir/' . $proposalFU['id']); ?>" method="post" enctype="multipart/form-data">
                                                    <input type="file" name="laporan_akhir" style="display: none;" id="laporanAkhir_<?= $proposalFU['id']; ?>" onchange="this.form.submit();">
                                                    <label for="laporanAkhir_<?= $proposalFU['id']; ?>" class="btn btn-upload">
                                                        <span class="material-icons-sharp">file_upload</span> Unggah
                                                    </label>
                                                </form>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="material-icons-sharp" onclick="openEditModal('<?= $proposalFU['id']; ?>')">edit</span>
                                            <span class="material-icons-sharp" onclick="openDeleteModal('<?= $proposalFU['id']; ?>')">delete</span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <!-- Jika user_type admin -->
                            <?php else: ?>
                                <?php foreach ($proposalsFA as $proposalFA): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= esc($proposalFA['judul_penelitian']); ?></td>
                                        <td><?= esc($proposalFA['nama'] ?? ''); ?></td>
                                        <td><?= esc($proposalFA['anggota_nama'] ?? ''); ?></td>
                                        <td>Rp. <?= number_format($proposalFA['biaya_didanai'] ?? 0, 0, ',', '.'); ?></td>
                                        <td><?= date('d-m-Y', strtotime($proposalFA['tanggal_upload'])); ?></td>
                                        <td>
                                            <div>
                                                <a href="javascript:void(0);" onclick="openPreviewModal('<?= base_url('uploads/' . $proposalFA['file_penelitian']); ?>')">
                                                    <span class="material-icons-sharp">picture_as_pdf</span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <!-- laporan kemajuan -->
                                            <div>
                                                <a href="javascript:void(0);" onclick="openPreviewModal('<?= base_url('uploads/' . $proposalFA['file_laporan_kemajuan']); ?>')">
                                                    <span class="material-icons-sharp">picture_as_pdf</span>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <!-- laporan akhir -->
                                            <div>
                                                <a href="javascript:void(0);" onclick="openPreviewModal('<?= base_url('uploads/' . $proposalFA['file_laporan_akhir']); ?>')">
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

            <!-- Modal untuk form Proposal Penelitian -->
            <div id="proposalPenelitianModal" class="modal">
                <div class="modal-content">
                    <span class="close-modal" onclick="closeproposalPenelitianModal()">&times;</span>
                    <form id="proposalPenelitianForm" action="<?= base_url('uploadProposal'); ?>" method="post" enctype="multipart/form-data">
                        <h2>Tambah Proposal Penelitian</h2>
                        <!-- 1.1 Identitas -->
                        <div class="identitas-card">
                            <h4>1.1 Identitas Ketua</h4>
                            <div class="identitas-container">
                                <div class="form-group">
                                    <label for="nama">Nama:</label>
                                    <input type="text" id="nama" name="nama" value="<?= esc($userData['nama']) ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="nidn">NIDN:</label>
                                    <input type="text" id="nidn" name="nidn" value="<?= esc($userData['nidn']) ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="nip">NIP:</label>
                                    <input type="text" id="nip" name="nip" value="<?= esc($userData['nip']) ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="jabatanAkademik">Jabatan Akademik:</label>
                                    <input type="text" id="jabatanAkademik" name="jabatanAkademik" value="<?= esc($userData['jabatan_akademik']) ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="perguruanTinggi">Perguruan Tinggi:</label>
                                    <input type="text" id="perguruanTinggi" name="perguruanTinggi" value="<?= esc($userData['perguruan_tinggi']) ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="fakultas">Fakultas:</label>
                                    <input type="text" id="fakultas" name="fakultas" value="<?= esc($userData['fakultas']) ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="programStudi">Program Studi:</label>
                                    <input type="text" id="programStudi" name="programStudi" value="<?= esc($userData['program_studi']) ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" id="email" name="email" value="<?= esc($userData['email']) ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- 1.2 Proposal Penelitian -->
                        <div class="penelitian-card">
                            <h4>1.2 Proposal Penelitian</h4>
                            <div class="penelitian-container">
                                <div class="form-group">
                                    <label for="judulPenelitian">Judul Penelitian:</label>
                                    <input type="text" id="judulPenelitian" name="judulPenelitian" value="<?= old('judulPenelitian'); ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="skema">Skema:</label>
                                    <select id="skema" name="skema" onchange="updateSumberDana()">
                                        <option value="" disabled selected>Silahkan Pilih</option>
                                        <option value="Hibah Internal">Hibah Internal</option>
                                        <option value="Hibah Eksternal">Hibah Eksternal</option>
                                        <option value="Mandiri">Mandiri</option>
                                    </select>
                                </div>

                                <input type="text" id="skema_lainnya" name="skema_lainnya" placeholder="Isi skema lainnya jika dipilih" style="display:none;">

                                <div class="form-group">
                                    <label for="biayaDiusulkan">Biaya yang diusulkan:</label>
                                    <input type="text" id="biayaDiusulkan" name="biayaDiusulkan" value="<?= old('biayaDiusulkan'); ?>" required oninput="formatCurrency(this)">
                                </div>

                                <div class="form-group">
                                    <label for="biayaDidanai">Biaya yang didanai:</label>
                                    <input type="text" id="biayaDidanai" name="biayaDidanai" value="<?= old('biayaDidanai'); ?>" required oninput="formatCurrency(this)">
                                </div>

                                <div class="form-group">
                                    <label for="sumberDana">Sumber Dana:</label>
                                    <select id="sumberDana" name="sumberDana">
                                        <option value="" disabled selected>Silahkan Pilih</option>
                                        <option value="DIKTI">DIKTI</option>
                                        <option value="BRIN">BRIN</option>
                                        <option value="Yayasan YARSI">Yayasan YARSI</option>
                                        <option value="Pribadi">Pribadi</option>
                                        <option value="lainnya">Lainnya (isi sendiri)</option>
                                    </select>
                                </div>

                                <input type="text" id="dana_lainnya" name="dana_lainnya" placeholder="Isi sumber dana lain " style="display:none;">
                            </div>
                        </div>



                        <!-- Anggota Internal Card -->
                        <div class="anggota-card">
                            <h4>Anggota Kegiatan (Dosen Internal)</h4>
                            <div class="anggota-container" id="anggotaInternalContainer">
                                <div class="anggota-internal">
                                    <label for="anggotaInternal">Nama Dosen:</label>
                                    <div class="input-wrapper">
                                        <input
                                            type="text"
                                            list="dosenList"
                                            id="anggotaInternal"
                                            name="nama_anggota[]"
                                            placeholder="Masukkan nama dosen"
                                            autocomplete="off"
                                            required>
                                        <datalist id="dosenList">
                                            <?php foreach ($dataDosenPP as $dosen): ?>
                                                <option value="<?= $dosen['nama'] . ' - ' . $dosen['nidn'] ?>">
                                                    <?= $dosen['nama'] ?> - <?= $dosen['nidn'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </datalist>
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol untuk Menambah Anggota Internal -->
                            <button type="button" id="tambahAnggotaInternalBtn" onclick="tambahAnggotaInternal()">Tambah Anggota</button>
                        </div>


                        <!-- Kontainer untuk biodata anggota eksternal -->
                        <div id="anggotaEksternal">
                            <div class="anggota card">
                                <h4>Anggota Kegiatan (Dosen Eksternal)</h4>
                                <div class="card-eskternal">
                                </div>
                            </div>
                        </div>
                        <!-- Tombol untuk menambah anggota -->
                        <button type="button" id="tambahAnggotaBtn" class="btn btn-primary">Tambah Anggota</button>

                        <div class="form-group mt-4">
                            <label for="berkas_proposal">Unggah File Proposal (PDF):</label>
                            <input type="file" id="berkas_proposal" name="berkas_proposal" accept=".pdf" class="form-control">
                            <small class="form-text text-muted">Maksimal ukuran file: 10 MB</small>
                            <?php if (session()->getFlashdata('errFile')): ?>
                                <div class="invalid-feedback d-block">
                                    <?php echo session()->getFlashdata('errFile') ?>
                                </div>
                            <?php endif; ?>
                            <div id="uploadAlert" class="alert alert-danger d-none" role="alert"></div>
                        </div>
                        <button type="submit" class="button-primary">Unggah</button>

                    </form>
                </div>
            </div>

            <!-- Delete -->
            <div id="deleteModal" class="modal">
                <div class="modal-content">
                    <input type="hidden" id="deleteProposalId">
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



            <!-- Edit Proposal Modal -->
            <div id="editProposalModal" class="modal">
                <div class="modal-content">
                    <span class="close-modal" onclick="closeEditProposalModal()">&times;</span>
                    <form id="editProposalForm" action="<?= base_url('updateProposal'); ?>" method="post" enctype="multipart/form-data">
                        <h2>Edit Proposal Penelitian</h2>
                        <div class="edit-card">
                            <div class="edit-container">
                                <div class="form-group">
                                    <input type="hidden" id="editProposalId" name="id">
                                    <label for="editJudulPenelitian">Judul Penelitian:</label>
                                    <input type="text" id="editJudulPenelitian" name="judulPenelitian" required>
                                </div>

                                <div class="form-group">
                                    <label for="editSkema">Skema:</label>
                                    <select id="editSkema" name="skema" onchange="updateSumberDana()">
                                        <option value="" disabled>Pilih Skema</option>
                                        <option value="Hibah Internal">Hibah Internal</option>
                                        <option value="Hibah Eksternal">Hibah Eksternal</option>
                                        <option value="Mandiri">Mandiri</option>
                                    </select>
                                    <!-- Field untuk skema lainnya -->
                                    <input type="text" id="editSkemaLainnya" name="skema_lainnya" placeholder="Isi skema lainnya jika dipilih" style="display:none;">
                                </div>

                                <div class="form-group">
                                    <label for="editBiayaDiusulkan">Biaya yang Diusulkan:</label>
                                    <input type="text" id="editBiayaDiusulkan" name="biayaDiusulkan" required>
                                </div>

                                <div class="form-group">
                                    <label for="editBiayaDidanai">Biaya yang Didanai:</label>
                                    <input type="text" id="editBiayaDidanai" name="biayaDidanai" required>
                                </div>

                                <div class="form-group">
                                    <label for="editSumberDana">Sumber Dana:</label>
                                    <select id="editSumberDana" name="sumberDana">
                                        <option value="" disabled>Pilih Sumber Dana</option>
                                        <option value="DIKTI">DIKTI</option>
                                        <option value="BRIN">BRIN</option>
                                        <option value="Yayasan YARSI">Yayasan YARSI</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                    <!-- Field untuk sumber dana lainnya -->
                                    <input type="text" id="editDanaLainnya" name="dana_lainnya" placeholder="Isi dana lainnya jika dipilih" style="display:none;">
                                </div>
                            </div>
                        </div>

                        <!-- Edit Anggota -->
                        <div class="editAnggota-card">
                            <h2>Edit Anggota Penelitian</h2>
                            <label>Nama Anggota:</label>
                            <div id="editAnggotaKegiatanContainer">
                                <!-- Anggota akan ditampilkan melalui JS -->
                            </div>
                            <button type="button" id="editTambahAnggotaKegiatanBtn">Tambah Anggota</button>
                        </div>



                        <!-- File Proposal -->
                        <div id="fileProposalSection">
                            <label>File Proposal Saat Ini:</label>
                            <div class="file-display">
                                <a id="editCurrentBerkasProposal" href="#" target="_blank">Lihat File Proposal</a>
                            </div>
                            <small>Jika ingin mengganti, unggah file baru:</small>
                            <div class="file-upload-wrapper">
                                <input type="file" id="editBerkasProposal" name="berkas_proposal" accept=".pdf">
                                <small class="form-text text-muted">Maksimal ukuran file: 10 MB</small>
                            </div>
                        </div>
                        <button type="submit" class="button-primary">Update</button>

                    </form>
                </div>
            </div>


            <?= $this->include('partials/topprofile'); ?>

        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('js/proposal.js'); ?>"></script>
    <script src="<?= base_url('js/darkmode.js'); ?>"></script>
</body>

</html>