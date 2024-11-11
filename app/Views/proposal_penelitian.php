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

            <!-- Modal untuk form Proposal Penelitian -->
            <div id="proposalPenelitianModal" class="modal">
                <div class="modal-content">
                    <span class="close-modal" onclick="closeproposalPenelitianModal()">&times;</span>
                    <form id="proposalPenelitianForm" action="<?= base_url('Proposal Penelitian/upload'); ?>" method="post" enctype="multipart/form-data">
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
                        <input type="text" id="judulPenelitian" name="judulPenelitian" required>

                        <label for="skema">Skema:</label>
                        <select id="skema" name="skema">
                            <option value="" disabled selected>Silahkan Pilih</option>
                            <option value="Hibah Eksternal">Hibah Eksternal</option>
                            <option value="Hibah Internal">Hibah Internal</option>
                            <option value="mandiri">Mandiri</option>
                            <option value="lainnya">Lainnya (isi sendiri)</option>
                        </select>
                        <!-- Field untuk skema lainnya, tampil jika "lainnya" dipilih -->
                        <input type="text" id="skema_lainnya" name="skema_lainnya" placeholder="Isi skema lainnya jika dipilih" style="display:none;">

                        <label for="biayaYangDiusulkan">Biaya yang diusulkan:</label>
                        <input type="text" id="biayaDiusulkan" name="biayaDiusulkan" required oninput="formatCurrency(this)">

                        <label for="biayaYangDidanai">Biaya yang didanai:</label>
                        <input type="text" id="biayaDidanai" name="biayaDidanai" required oninput="formatCurrency(this)">


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
                                <input type="text" name="nama_anggota[]" placeholder="Nama anggota" required>

                                <label>NIDN Anggota:</label>
                                <input type="text" name="nidn_anggota[]" placeholder="NIDN" required>

                                <label>Jabatan Akademik:</label>
                                <input type="text" name="jabatan_anggota[]" placeholder="Jabatan" required>

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
                            <input type="file" id="berkas_proposal" name="berkas_proposal">
                            <button type="submit">Unggah</button>
                        </div>

                    </form>
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
                            <th>File</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($proposals as $proposal): ?>
                            <tr>
                                <td><?= $proposal['id']; ?></td>
                                <td><?= $proposal['judul_penelitian']; ?></td>
                                <td><?= $proposal['tanggal_upload']; ?></td>
                                <td><a href="<?= base_url('uploads/' . $proposal['file_proposal']); ?>" target="_blank">Unduh/Preview</a></td>
                                <td>
                                    <button>Edit</button>
                                    <button>Delete</button>
                                </td>
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