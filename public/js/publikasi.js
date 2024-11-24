$(document).ready(function() {
    $('#publicationTable').DataTable();

    var modal = document.getElementById("publicationModal");
    var btn = document.getElementById("openModalBtn");
    var closeBtn = document.getElementsByClassName("close-modal")[0]; // Perbaiki class di sini

    // Ketika tombol "Tambah Publikasi" diklik, tampilkan modal
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // Menutup modal ketika tombol 'X' diklik
    closeBtn.onclick = function() {
        modal.style.display = "none";
    }

    // Menutup modal jika pengguna mengklik di luar modal
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };

    // Fungsi untuk menambah penulis dosen
    $('#tambahPenulisDosenBtn').on('click', function () {
        var newPenulisDosen = `
          <div class="penulis-dosen">
                                <div class="input-wrapper">
                                    <input type="text" id="penulisDosen" name="penulisDosen[]" placeholder="Masukkan nama penulis dosen" autocomplete="off" required>
                                    <div id="suggestions" class="suggestions"></div>
                                    <span class="hapusPenulisDosenIcon material-icons-sharp">remove</span>
                                </div>
                            </div>
        `;
        $('#penulisDosenContainer').append(newPenulisDosen);
    });

    // Fungsi untuk menghapus penulis dosen
    $('#penulisDosenContainer').on('click', '.hapusPenulisDosenIcon', function () {
        $(this).closest('.penulis-dosen').remove();
    });
});
