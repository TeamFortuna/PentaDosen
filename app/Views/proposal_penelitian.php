<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/sidebar.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('css/proposal.css'); ?>">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <!-- jQuery (jika belum terinstal) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Proposal Penelitian</title>

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
            <h1>Proposal Penelitian</h1>
            <p>Ini adalah halaman untuk Proposal Penelitian.</p>

            <button id="openModalBtn" class="button-primary">Tambah Proposal Penelitian</button>
            <?php if (session()->getFlashdata('success') || session()->getFlashdata('errProposal')): ?>
                <div class="success-feedback">
                    <?php echo session()->getFlashdata('success') ?>
                </div>
                <div class="invalid-feedback">
                    <?php echo session()->getFlashdata('errProposal') ?>
                </div>
            <?php endif; ?>


            <!-- Modal untuk form Proposal Penelitian -->
            <div id="proposalPenelitianModal" class="modal">
                <div class="modal-content">
                    <span class="close-modal" onclick="closeproposalPenelitianModal()">&times;</span>
                    <form id="proposalPenelitianForm" action="<?= base_url('uploadProposal'); ?>" method="post" enctype="multipart/form-data">
                        <h2>Tambah Proposal Penelitian</h2>
                        <!-- 1.1 Identitas -->
                        <h4>1.1 Identitas Ketua</h4>

                        <label for="nama">Nama:</label>
                        <input type="text" id="nama" name="nama" value="<?= esc($userData['nama']) ?>" readonly>

                        <label for="nidn">NIDN:</label>
                        <input type="text" id="nidn" name="nidn" value="<?= esc($userData['nidn']) ?>" readonly>

                        <label for="nip">NIP:</label>
                        <input type="text" id="nip" name="nip" value="<?= esc($userData['nip']) ?>" readonly>

                        <label for="jabatanAkademik">Jabatan Akademik:</label>
                        <input type="text" id="jabatanAkademik" name="jabatanAkademik" value="<?= esc($userData['jabatan_akademik']) ?>" readonly>

                        <label for="perguruanTinggi">Perguruan Tinggi:</label>
                        <input type="text" id="perguruanTinggi" name="perguruanTinggi" value="<?= esc($userData['perguruan_tinggi']) ?>" readonly>

                        <label for="fakultas">Fakultas:</label>
                        <input type="text" id="fakultas" name="fakultas" value="<?= esc($userData['fakultas']) ?>" readonly>

                        <label for="programStudi">Program Studi:</label>
                        <input type="text" id="programStudi" name="programStudi" value="<?= esc($userData['program_studi']) ?>" readonly>

                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?= esc($userData['email']) ?>" readonly>


                        <!-- 1.2 Proposal Penelitian -->
                        <h4>1.2 Proposal Penelitian</h4>
                        <label for="judulPenelitian">Judul Penelitian:</label>
                        <input type="text" id="judulPenelitian" name="judulPenelitian" value="<?= old('judulPenelitian'); ?>" required>

                        <label for="skema">Skema:</label>
                        <select id="skema" name="skema" onchange="updateSumberDana()">
                            <option value="" disabled selected>Silahkan Pilih</option>
                            <option value="Hibah Internal">Hibah Internal</option>
                            <option value="Hibah Eksternal">Hibah Eksternal</option>
                            <option value="Mandiri">Mandiri</option>
                        </select>


                        <!-- Field untuk skema lainnya, tampil jika "lainnya" dipilih -->
                        <input type="text" id="skema_lainnya" name="skema_lainnya" placeholder="Isi skema lainnya jika dipilih" style="display:none;">

                        <label for="biayaYangDiusulkan">Biaya yang diusulkan:</label>
                        <input type="text" id="biayaDiusulkan" name="biayaDiusulkan" value="<?= old('biayaDiusulkan'); ?>" required oninput="formatCurrency(this)">

                        <label for="biayaYangDidanai">Biaya yang didanai:</label>
                        <input type="text" id="biayaDidanai" name="biayaDidanai" value="<?= old('biayaDidanai'); ?>" required oninput="formatCurrency(this)">


                        <label for="sumberDana">Sumber Dana:</label>
                        <select id="sumberDana" name="sumberDana">
                            <option value="" disabled selected>Silahkan Pilih</option>
                            <option value="DIKTI">DIKTI</option>
                            <option value="BRIN">BRIN</option>
                            <option value="Yayasan YARSI">Yayasan YARSI</option>
                            <option value="lainnya">Lainnya (isi sendiri)</option>
                        </select>
                        <!-- Field untuk skema lainnya, tampil jika "lainnya" dipilih -->
                        <input type="text" id="dana_lainnya" name="dana_lainnya" placeholder="Isi dana lainnya jika dipilih" style="display:none;">


                        <!-- Anggota Kegiatan -->
                        <div id="anggotaKegiatanContainer">
                            <h4>Anggota Kegiatan</h4>
                            <label for="namaDosen">Nama Dosen:</label>
                            <div class="anggota-kegiatan">
                                <div class="input-wrapper">
                                    <input type="text" id="anggotaKegiatan" name="nama_dosen_kegiatan[]" placeholder="Masukkan nama dosen" autocomplete="off">
                                </div>
                                <span class="hapusAnggotaKegiatanIcon material-icons-sharp">remove</span>
                            </div>
                        </div>
                        <!-- Tombol untuk menambah anggota kegiatan -->
                        <button type="button" id="tambahAnggotaKegiatanBtn">Tambah Anggota</button>


                        <div class="form-group">
                            <label for="berkas_proposal">Unggah File Proposal (PDF):</label>
                            <input type="file" id="berkas_proposal" name="berkas_proposal" accept=".pdf">
                            <small class="form-text text-muted">Maksimal ukuran file: 10 MB</small>
                            <div id="uploadAlert" class="alert alert-danger d-none" role="alert"></div>
                        </div>
                        <button type="submit" class="btn btn-primary">Unggah</button>

                    </form>
                </div>
            </div>

            <!-- Edit Proposal Modal -->
            <<div id="editProposalModal" class="modal">
                <div class="modal-content">
                    <span class="close-modal" onclick="closeEditProposalModal()">&times;</span>
                    <form id="editProposalForm" action="<?= base_url('updateProposal'); ?>" method="post" enctype="multipart/form-data">
                        <h2>Edit Proposal Penelitian</h2>
                        <input type="hidden" id="editProposalId" name="id">

                        <label for="editJudulPenelitian">Judul Penelitian:</label>
                        <input type="text" id="editJudulPenelitian" name="judulPenelitian" required>

                        <label for="editSkema">Skema:</label>
                        <select id="editSkema" name="skema" onchange="updateSumberDana()">
                            <option value="" disabled>Pilih Skema</option>
                            <option value="Hibah Internal">Hibah Internal</option>
                            <option value="Hibah Eksternal">Hibah Eksternal</option>
                            <option value="Mandiri">Mandiri</option>
                        </select>
                        <!-- Field untuk skema lainnya -->
                        <input type="text" id="editSkemaLainnya" name="skema_lainnya" placeholder="Isi skema lainnya jika dipilih" style="display:none;">

                        <label for="editBiayaDiusulkan">Biaya yang Diusulkan:</label>
                        <input type="text" id="editBiayaDiusulkan" name="biayaDiusulkan" required>

                        <label for="editBiayaDidanai">Biaya yang Didanai:</label>
                        <input type="text" id="editBiayaDidanai" name="biayaDidanai" required>

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

                        <!-- Anggota Kegiatan -->
                        <div id="editAnggotaKegiatanContainer">
                            <h4>Anggota Kegiatan</h4>
                            <div class="anggota-kegiatan">
                                <div class="input-wrapper">
                                    <input type="text" id="editAnggotaKegiatan" name="nama_dosen_kegiatan[]" placeholder="Masukkan nama dosen" autocomplete="off">
                                </div>
                                <span class="hapusAnggotaKegiatanIcon material-icons-sharp">remove</span>
                            </div>
                        </div>
                        <button type="button" id="editTambahAnggotaKegiatanBtn">Tambah Anggota</button>


                        <!-- File Proposal -->
                        <div id="fileProposalSection">
                            <label for="editCurrentBerkasProposal">File Proposal Saat Ini:</label>
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



    <!-- Delete -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h3>Konfirmasi Penghapusan</h3>
            <p>Apakah Anda yakin ingin menghapus proposal ini?</p>
            <input type="hidden" id="deleteProposalId">
            <button onclick="confirmDelete()">Ya, Hapus</button>
            <button onclick="closeDeleteModal()">Batal</button>
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
        <h2>Daftar Penelitian</h2>
        <table id="proposalPenelitianTable" class="display full-table">
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
                <?php $no = 1; ?>
                <?php foreach ($proposals as $proposal): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= esc($proposal['judul_penelitian']); ?></td>
                        <td><?= esc($proposal['nama'] ?? ''); ?></td>
                        <td><?= esc($proposal['anggota_nama'] ?? ''); ?></td>
                        <td>Rp. <?= number_format($proposal['biaya_didanai'] ?? 0, 0, ',', '.'); ?></td>
                        <td><?= date('d-m-Y', strtotime($proposal['tanggal_upload'])); ?></td>
                        <td>
                            <div>
                                <a href="javascript:void(0);" onclick="openPreviewModal('<?= base_url('uploads/' . $proposal['file_proposal']); ?>')">
                                    <span class="material-icons-sharp">picture_as_pdf</span>
                                </a>
                            </div>
                        </td>
                        <td>
                            <!-- laporan kemajuan -->

                        </td>
                        <td>
                            <!-- laporan akhir -->

                        </td>
                        <?php if (session()->get('user_type') == 'dosen'): ?>
                            <td>
                                <span class="material-icons-sharp" onclick="openEditModal('<?= $proposal['id']; ?>')">edit</span>
                                <span class="material-icons-sharp" onclick="openDeleteModal('<?= $proposal['id']; ?>')">delete</span>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </div>
    </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('js/proposal.js'); ?>"></script>
</body>

</html>