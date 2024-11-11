$(document).ready(function() {
    $('#proposalPenelitianTable').DataTable();

    var modal = document.getElementById("proposalPenelitianModal");
    var btn = document.getElementById("openModalBtn");
    var span = document.getElementsByClassName("close-modal")[0];

    // Membuka modal
    btn.onclick = function() {
        modal.style.display = "block";
    };

    // Menutup modal
    span.onclick = function() {
        modal.style.display = "none";
    };

    // Menutup modal ketika klik di luar modal
    window.onclick = function(event) {
        if (event.target == modal) {    
            modal.style.display = "none";
        }
    };

    // Menampilkan field tambahan jika dropdown "Lainnya" dipilih untuk skema dan sumber dana
    $('#skema').change(function() {
        $('#skema_lainnya').toggle(this.value === 'lainnya');
    });

    $('#sumberDana').change(function() {
        $('#dana_lainnya').toggle(this.value === 'lainnya');
    });

    // Fungsi untuk menampilkan field lainnya ketika dropdown perguruan tinggi, fakultas, dan program studi berubah
    $('#anggotaContainer').on('change', 'select[name="perguruan_anggota[]"]', function() {
        $(this).next('.perguruan_lainnya').toggle(this.value === 'lainnya');
    });

    $('#anggotaContainer').on('change', 'select[name="fakultas_anggota[]"]', function() {
        $(this).next('.fakultas_lainnya').toggle(this.value === 'lainnya');
    });

    $('#anggotaContainer').on('change', 'select[name="prodi_anggota[]"]', function() {
        $(this).next('.prodi_lainnya').toggle(this.value === 'lainnya');
    });

    // Fungsi untuk menambah anggota baru
    $('#tambahAnggotaBtn').click(function() {
        var anggotaHtml = `
            <div class="anggota">
                <label>Nama Anggota:</label>
                <input type="text" name="nama_anggota[]" placeholder="Nama anggota" required>

                <label>NIDN Anggota:</label>
                <input type="text" name="nidn_anggota[]" placeholder="NIDN" required>

                <label>Jabatan Akademik:</label>
                <input type="text" name="jabatan_anggota[]" placeholder="Jabatan" required>

                <label for="perguruan_anggota">Perguruan Tinggi:</label>
                <select name="perguruan_anggota[]" required>
                    <option value="" disabled selected>Silahkan Pilih</option>
                    <option value="Universitas YARSI">Universitas YARSI</option>
                    <option value="lainnya">Lainnya (isi sendiri)</option>
                </select>
                <input type="text" class="perguruan_lainnya" name="perguruan_lainnya[]" placeholder="Isi perguruan yang lainnya" style="display:none;">

                <label for="fakultas_anggota">Fakultas:</label>
                <select name="fakultas_anggota[]" required>
                    <option value="" disabled selected>Silahkan Pilih</option>
                    <option value="Fakultas Teknologi Informasi (FTI)">Fakultas Teknologi Informasi (FTI)</option>
                    <option value="lainnya">Lainnya (isi sendiri)</option>
                </select>
                <input type="text" class="fakultas_lainnya" name="fakultas_lainnya[]" placeholder="Isi fakultas yang lainnya" style="display:none;">

                <label for="prodi_anggota">Program Studi:</label>
                <select name="prodi_anggota[]" required>
                    <option value="" disabled selected>Silahkan Pilih</option>
                    <option value="Teknik Informatika">Teknik Informatika</option>
                    <option value="Perpustakaan dan Sains Informasi">Perpustakaan dan Sains Informasi</option>
                    <option value="lainnya">Lainnya (isi sendiri)</option>
                </select>
                <input type="text" class="prodi_lainnya" name="prodi_lainnya[]" placeholder="Isi program studi yang lainnya" style="display:none;">

                <button type="button" class="hapusAnggotaBtn">Hapus Anggota</button>
            </div>`;
        $('#anggotaContainer').append(anggotaHtml);
    });

    // Fungsi untuk menghapus anggota
    $('#anggotaContainer').on('click', '.hapusAnggotaBtn', function() {
        $(this).closest('.anggota').remove();
    });
});
