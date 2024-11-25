<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/sidebar.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('css/proposal.css'); ?>">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
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
                        <select id="skema" name="skema">
                            <option value="" disabled selected>Silahkan Pilih</option>
                            <option value="Hibah Eksternal">Hibah Eksternal</option>
                            <option value="Hibah Internal">Hibah Internal</option>
                            <option value="Mandiri">Mandiri</option>
                            <option value="lainnya">Lainnya (isi sendiri)</option>
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

                        <!-- Kontainer untuk biodata anggota -->
                        <div id="anggotaContainer">
                            <div class="anggota">
                                <label>Nama Anggota:</label>
                                <?php if (old('nama_anggota')): ?>
                                    <?php foreach (old('nama_anggota') as $nama): ?>
                                        <input type="text" name="nama_anggota[]" placeholder="Nama anggota" value="<?= esc($nama); ?>" required>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <input type="text" name="nama_anggota[]" placeholder="Nama anggota" required>
                                <?php endif; ?>


                                <label>NIDN Anggota:</label>
                                <input type="text" name="nidn_anggota[]" placeholder="NIDN" value="<?= old('nidn_anggota[]'); ?>" required>
                                <?php if (session()->getFlashdata('errNIDN')): ?>
                                <div class="success-feedback">
                                    <?php echo session()->getFlashdata('errNIDN') ?>
                                </div>
                                <?php endif; ?>
                                <label>Jabatan Akademik:</label>
                                <input type="text" name="jabatan_anggota[]" placeholder="Jabatan" value="<?= old('jabatan_anggota[]'); ?>" required>

                                <label for="perguruan_anggota">Perguruan Tinggi:</label>
                                <select id="perguruan_anggota" name="perguruan_anggota[]">
                                    <option value="" disabled selected>Silahkan Pilih</option>
                                    <option value="Universitas YARSI">Universitas YARSI</option>
                                    <option value="lainnya">Lainnya (isi sendiri)</option>
                                </select>
                                <!-- Field untuk skema lainnya, tampil jika "lainnya" dipilih -->
                                <input type="text" class="perguruan_lainnya" name="perguruan_lainnya[]" placeholder="Isi perguruan yang lainnya" style="display:none;">

                                <label for="fakultas_anggota">Fakultas:</label>
                                <select id="fakultas_anggota" name="fakultas_anggota[]">
                                    <option value="" disabled selected>Silahkan Pilih</option>
                                    <option value="Fakultas Teknologi Informasi (FTI)">Fakultas Teknologi Informasi (FTI)</option>
                                    <option value="lainnya">Lainnya (isi sendiri)</option>
                                </select>
                                <!-- Field untuk skema lainnya, tampil jika "lainnya" dipilih -->
                                <input type="text" class="fakultas_lainnya" name="fakultas_lainnya[]" placeholder="Isi fakultas yang lainnya" style="display:none;">

                                <label for="prodi_anggota">Program Studi:</label>
                                <select id="prodi_anggota" name="prodi_anggota[]">
                                    <option value="" disabled selected>Silahkan Pilih</option>
                                    <option value="Teknik Informatika">Teknik Informatika</option>
                                    <option value="Perpustakaan dan Sains Informasi">Perpustakaan dan Sains Informasi</option>
                                    <option value="lainnya">Lainnya (isi sendiri)</option>
                                </select>
                                <!-- Field untuk skema lainnya, tampil jika "lainnya" dipilih -->
                                <input type="text" class="prodi_lainnya" name="prodi_lainnya[]" placeholder="Isi program studi yang lainnya" style="display:none;">

                                <button type="button" class="hapusAnggotaBtn">Hapus Anggota</button>
                            </div>
                        </div>

                        <!-- Tombol untuk menambah anggota -->
                        <button type="button" id="tambahAnggotaBtn">Tambah Anggota</button>

                        <div class="button_bawah">
                            <label for="berkas_proposal">Unggah File Proposal:</label>
                            <input type="file" id="berkas_proposal" name="berkas_proposal" accept=".pdf">
                            <?php if (session()->getFlashdata('errFile')): ?>
                                <div class="invalid-feedback">
                                    <?php echo session()->getFlashdata('errFile') ?>
                                </div>
                            <?php endif; ?>
                            <button type="submit">Unggah</button>
                        </div>

                    </form>
                </div>
            </div>


            <!-- Modal untuk Edit Proposal Penelitian -->
            <div id="editProposalModal" class="modal">
                <div class="modal-content">
                    <span class="close-modal" onclick="closeEditProposalModal()">&times;</span>
                    <form id="editProposalForm" onsubmit="submitUpdateProposal(event)">
                        <h2>Edit Proposal Penelitian</h2>
                        <input type="hidden" id="updateProposalId" name="proposalId">

                        <label for="judulPenelitianEdit">Judul Penelitian:</label>
                        <input type="text" id="judulPenelitianEdit" name="judulPenelitian" required>

                        <label for="skemaEdit">Skema:</label>
                        <select id="skemaEdit" name="skema">
                            <option value="" disabled selected>Silahkan Pilih</option>
                            <option value="Hibah Eksternal">Hibah Eksternal</option>
                            <option value="Hibah Internal">Hibah Internal</option>
                            <option value="Mandiri">Mandiri</option>
                            <option value="lainnya">Lainnya (isi sendiri)</option>
                        </select>
                        <input type="text" id="skema_lainnya_edit" name="skema_lainnya" placeholder="Isi skema lainnya jika dipilih" style="display:none;">

                        <label for="biayaDiusulkanEdit">Biaya yang diusulkan:</label>
                        <input type="text" id="biayaDiusulkanEdit" name="biayaDiusulkan" required oninput="formatCurrency(this)">

                        <label for="biayaDidanaiEdit">Biaya yang didanai:</label>
                        <input type="text" id="biayaDidanaiEdit" name="biayaDidanai" required oninput="formatCurrency(this)">

                        <label for="sumberDanaEdit">Sumber Dana:</label>
                        <select id="sumberDanaEdit" name="sumberDana">
                            <option value="" disabled selected>Silahkan Pilih</option>
                            <option value="DIKTI">DIKTI</option>
                            <option value="BRIN">BRIN</option>
                            <option value="Yayasan YARSI">Yayasan YARSI</option>
                            <option value="lainnya">Lainnya (isi sendiri)</option>
                        </select>
                        <input type="text" id="dana_lainnya_edit" name="dana_lainnya" placeholder="Isi dana lainnya jika dipilih" style="display:none;">

                        <div id="editAnggotaContainer">
                            <div class="anggota">
                                <label>Nama Anggota:</label>
                                <input type="text" name="nama_anggota[]" placeholder="Nama anggota" required>

                                <label>NIDN Anggota:</label>
                                <input type="text" name="nidn_anggota[]" placeholder="NIDN" required>

                                <label>Jabatan Akademik:</label>
                                <input type="text" name="jabatan_anggota[]" placeholder="Jabatan" required>

                                <label for="perguruan_anggota_edit">Perguruan Tinggi:</label>
                                <select id="perguruan_anggota_edit" name="perguruan_anggota[]">
                                    <option value="" disabled selected>Silahkan Pilih</option>
                                    <option value="Universitas YARSI">Universitas YARSI</option>
                                    <option value="lainnya">Lainnya (isi sendiri)</option>
                                </select>
                                <input type="text" class="perguruan_lainnya_edit" name="perguruan_lainnya[]" placeholder="Isi perguruan yang lainnya" style="display:none;">

                                <label for="fakultas_anggota_edit">Fakultas:</label>
                                <select id="fakultas_anggota_edit" name="fakultas_anggota[]">
                                    <option value="" disabled selected>Silahkan Pilih</option>
                                    <option value="Fakultas Teknologi Informasi (FTI)">Fakultas Teknologi Informasi (FTI)</option>
                                    <option value="lainnya">Lainnya (isi sendiri)</option>
                                </select>
                                <input type="text" class="fakultas_lainnya_edit" name="fakultas_lainnya[]" placeholder="Isi fakultas yang lainnya" style="display:none;">

                                <label for="prodi_anggota_edit">Program Studi:</label>
                                <select id="prodi_anggota_edit" name="prodi_anggota[]">
                                    <option value="" disabled selected>Silahkan Pilih</option>
                                    <option value="Teknik Informatika">Teknik Informatika</option>
                                    <option value="Perpustakaan dan Sains Informasi">Perpustakaan dan Sains Informasi</option>
                                    <option value="lainnya">Lainnya (isi sendiri)</option>
                                </select>
                                <input type="text" class="prodi_lainnya_edit" name="prodi_lainnya[]" placeholder="Isi program studi yang lainnya" style="display:none;">

                                <button type="button" class="hapusAnggotaBtn">Hapus Anggota</button>
                            </div>
                        </div>

                        <button type="button" id="tambahAnggotaBtnEdit">Tambah Anggota</button>
                        <div class="button_bawah">
                            <label for="berkas_proposal_edit">Unggah File Proposal:</label>
                            <input type="file" id="berkas_proposal_edit" name="berkas_proposal">
                            <button type="submit">Update Proposal</button>
                        </div>
                    </form>
                </div>
            </div>




            <!-- Modal untuk Preview PDF -->
            <div id="pdfPreviewModal" class="modal" style="display: none;">
                <div class="modal-content">
                    <span class="close-modal" onclick="closePreviewModal()">&times;</span>
                    <iframe id="pdfViewer" src=""></iframe>
                </div>
            </div>

            <div class="recent-orders">
                <h2>Daftar Proposal Penelitian</h2>
                <table id="proposalPenelitianTable" class="display full-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Proposal Penelitian</th>
                            <th>Tanggal Proposal Penelitian</th>
                            <th>Nama Anggota</th>
                            <th>Nama Dosen</th>
                            <th>Dana yang Didanai</th>
                            <th>File</th>
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
                                <td><?= date('d-m-Y', strtotime($proposal['tanggal_upload'])); ?></td>
                                <td><?= esc($proposal['anggota_nama'] ?? ''); ?></td>
                                <td><?= esc($proposal['nama'] ?? ''); ?></td>
                                <td>Rp. <?= number_format($proposal['biaya_didanai'] ?? 0, 0, ',', '.'); ?></td>
                                <td>
                                    <div>
                                        <a href="<?= base_url(); ?>ProposalPenelitianController/download/<?= $proposal['id']; ?>">Unduh</a>
                                    </div>
                                    <div>
                                        <a href="javascript:void(0);" onclick="openPreviewModal('<?= base_url('uploads/' . $proposal['file_proposal']);?>')">Preview</a>
                                    </div>
                                </td>
                                <?php if (session()->get('user_type') == 'dosen'): ?>
                                    <td>
                                        <span class="material-icons-sharp" onclick="openeditProposalModal(
                                        '<?= $proposal['id']; ?>',
                                        '<?= $proposal['skema']; ?>',
                                        '<?= $proposal['biaya_diusulkan']; ?>',
                                        '<?= $proposal['biaya_didanai']; ?>',
                                        '<?= $proposal['sumber_dana']; ?>',">edit</span>
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