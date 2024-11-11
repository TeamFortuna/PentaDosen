$(document).ready(function() {
    $('#proposalPenelitianTable').DataTable();

    var modal = document.getElementById("proposalPenelitianModal");
    var btn = document.getElementById("openModalBtn");
    var span = document.getElementsByClassName("close-modal")[0];


    // Membuka modal
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // Menutup modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // Menutup modal ketika klik di luar modal
    window.onclick = function(event) {
        if (event.target == modal) {    
            modal.style.display = "none";
        }
    }

    // Menampilkan field tambahan jika dropdown "Lainnya" dipilih
    $('#skema').change(function() {
        $('#skema_lainnya').toggle(this.value === 'lainnya');
    });

    $('#sumberDana').change(function () {
        $('#dana_lainnya').toggle(this.value === 'lainnya');
    });

    // Fungsi untuk menampilkan field lainnya ketika dropdown anggota berubah
    function setAnggotaEventHandlers(anggota) {
        anggota.find('.perguruan_anggota').change(function () {
            $(this).siblings('.perguruan_lainnya').toggle(this.value === 'lainnya');
        });
        anggota.find('.fakultas_anggota').change(function () {
            $(this).siblings('.fakultas_lainnya').toggle(this.value === 'lainnya');
        });
        anggota.find('.prodi_anggota').change(function () {
            $(this).siblings('.prodi_lainnya').toggle(this.value === 'lainnya');
        });
    }

    // Menetapkan event handler untuk anggota pertama
    setAnggotaEventHandlers($('.anggota').first());

    // Menambahkan anggota baru
    $('#tambahAnggotaBtn').click(function() {
        // Template untuk input anggota baru dengan kelas yang dapat dikenali untuk event listener
        var anggotaTemplate = `
            <div class="anggota">
                <label>Nama Anggota:</label>
                <input type="text" name="nama_anggota[]" placeholder="Nama anggota" required>

                <label>NIDN Anggota:</label>
                <input type="text" name="nidn_anggota[]" placeholder="NIDN" required>

                <label>Jabatan Akademik:</label>
                <input type="text" name="jabatan_anggota[]" placeholder="Jabatan" required>

                <label>Perguruan Tinggi:</label>
                <select class="perguruan_anggota" name="perguruan_anggota[]">
                    <option value="" disabled selected>Silahkan Pilih</option>
                    <option value="Universitas YARSI">Universitas YARSI</option>
                    <option value="lainnya">Lainnya (isi sendiri)</option>
                </select>
                <input type="text" class="perguruan_lainnya" name="perguruan_lainnya[]" placeholder="Isi perguruan yang lainnya" style="display:none;">

                <label>Fakultas:</label>
                <select class="fakultas_anggota" name="fakultas_anggota[]">
                    <option value="" disabled selected>Silahkan Pilih</option>
                    <option value="Fakultas Teknologi Informasi (FTI)">Fakultas Teknologi Informasi (FTI)</option>
                    <option value="lainnya">Lainnya (isi sendiri)</option>
                </select>
                <input type="text" class="fakultas_lainnya" name="fakultas_lainnya[]" placeholder="Isi fakultas yang lainnya" style="display:none;">

                <label>Program Studi:</label>
                <select class="prodi_anggota" name="prodi_anggota[]">
                    <option value="" disabled selected>Silahkan Pilih</option>
                    <option value="Teknik Informatika">Teknik Informatika</option>
                    <option value="Perpustakaan dan Sains Informasi">Perpustakaan dan Sains Informasi</option>
                    <option value="lainnya">Lainnya (isi sendiri)</option>
                </select>
                <input type="text" class="prodi_lainnya" name="prodi_lainnya[]" placeholder="Isi program studi yang lainnya" style="display:none;">

                <button type="button" class="hapusAnggotaBtn">Hapus Anggota</button>
            </div>
        `;

        // Tambahkan anggota baru ke dalam container
        var newAnggota = $(anggotaTemplate);
        setAnggotaEventHandlers(newAnggota); // Set event handlers untuk anggota baru
        $('#anggotaContainer').append(newAnggota);
    });

    // Hapus anggota ketika tombol "Hapus Anggota" diklik
    $('#anggotaContainer').on('click', '.hapusAnggotaBtn', function() {
        $(this).closest('.anggota').remove();
    });
});
