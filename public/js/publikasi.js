$(document).ready(function() {
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
                <input 
                    list="dosenList" 
                    type="text" 
                    name="penulisDosen[]" 
                    placeholder="Cari nama atau NIDN penulis dosen" 
                    autocomplete="off" 
                    required
                >
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

// Fungsi untuk membuka modal preview PDF
function openPreviewModal(filePath) {
    const modal = document.getElementById("pdfPreviewModal");
    const pdfViewer = document.getElementById("pdfViewer");
    const downloadButton = document.getElementById("downloadButton");

    if (modal && pdfViewer && downloadButton) {
        pdfViewer.src = filePath; // Menampilkan file PDF dalam iframe
        downloadButton.href = filePath; // Menyiapkan tautan untuk mengunduh file
        modal.style.display = "block"; // Menampilkan modal
    }
}

// Fungsi untuk menutup modal preview PDF
function closePreviewModal() {
    const modal = document.getElementById("pdfPreviewModal");
    const pdfViewer = document.getElementById("pdfViewer");
    if (modal && pdfViewer) {
        modal.style.display = "none"; // Menyembunyikan modal
        pdfViewer.src = ""; // Membersihkan sumber iframe
    }
}
