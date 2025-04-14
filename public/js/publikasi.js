$(document).ready(function() {
     // Nonaktifkan fitur bawaan DataTable (seperti pagination, filter, entries)
     const table = $('#publicationTable').DataTable({
        paging: false,
        searching: false,
        info: false,
        lengthChange: false,
    });


    $('#customSearchInput').on('keyup', function () {
        const searchValue = $(this).val().toLowerCase();
        $('#proposalPenelitianTable tbody tr').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1);
        });
    });
    

    // Implementasi manual entries (per halaman)
    $('#entriesSelect').on('change', function () {
        const pageLength = parseInt(this.value);
        table.page.len(pageLength).draw();
    });

    // Implementasi manual pagination
    $('#nextPageBtn').on('click', function () {
        table.page('next').draw('page');
    });

    $('#prevPageBtn').on('click', function () {
        table.page('previous').draw('page');
    });

    // Fungsi untuk memperbarui informasi jumlah entries
    function updateEntriesInfo() {
        const pageInfo = table.page.info();
        $('#entriesShowing').text(`Showing ${pageInfo.start + 1} to ${pageInfo.end} of ${pageInfo.recordsTotal} entries`);
    }

    // Panggil fungsi updateEntriesInfo saat halaman pertama kali dimuat
    updateEntriesInfo();

    // Update info entries setiap kali tabel diperbarui
    table.on('draw', function () {
        updateEntriesInfo();
    });
    
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
    <div class="anggota-penulis input-group">
        <div class="input-wrapper">
            <input 
                type="text"
                list="dosenList"
                name="penulisDosen[]"
                placeholder="Cari nama atau NIDN penulis dosen"
                autocomplete="off"
                required>
            <span class="hapusPenulisDosenIcon material-icons-sharp">remove</span>
        </div>
    </div>
    `;
    $('#penulisDosenContainer').append(newPenulisDosen);
});

// Fungsi untuk menghapus penulis dosen
$('#penulisDosenContainer').on('click', '.hapusPenulisDosenIcon', function () {
    $(this).closest('.input-group').remove();
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
