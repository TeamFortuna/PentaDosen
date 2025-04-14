$(document).ready(function () {

    // Nonaktifkan fitur bawaan DataTable (seperti pagination, filter, entries)
    const table = $('#hakiTable').DataTable({
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

    // Mendapatkan elemen modal dan tombol
    const modal = document.getElementById("hakiModal");
    const btn = document.getElementById("openModalBtn");

    // Membuka modal saat tombol diklik
    btn.onclick = function () {
        modal.style.display = "block";
    };

    // Menutup modal saat klik di luar modal
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
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

// Fungsi untuk menutup modal
function closehakiModal() {
    const modal = document.getElementById("hakiModal");
    modal.style.display = "none";
}

function addPencipta() {
    const container = document.getElementById("penciptaContainer");
    const div = document.createElement("div");
    div.className = "anggota-pencipta input-group";
    div.innerHTML = `
        <div class="input-wrapper">
            <input
                type="text"
                list="dosenList"
                name="namaPencipta[]"
                placeholder="Masukkan nama pencipta"
                autocomplete="off"
                required>
            <span class="hapusNamaPencipta material-icons-sharp" onclick="hapusPencipta(this)">remove</span>
        </div>
    `;
    container.appendChild(div);
}

// Fungsi untuk menambah input nama pemegang hak cipta
function addPemegang() {
    const container = document.getElementById("pemegangContainer");
    const div = document.createElement("div");
    div.className = "anggota-pemegang input-group";
    div.innerHTML = `
        <div class="input-wrapper">
            <input
                type="text"
                list="dosenList"
                name="namaPemegang[]"
                placeholder="Masukkan nama pemegang"
                autocomplete="off"
                required>
            <span class="hapusNamaPemegang material-icons-sharp" onclick="hapusPemegang(this)">remove</span>
        </div>
    `;
    container.appendChild(div);
}

// Fungsi untuk menghapus input nama pencipta
function hapusPencipta(element) {
    const parent = element.closest(".input-group");
    parent.remove();
}

// Fungsi untuk menghapus input nama pemegang
function hapusPemegang(element) {
    const parent = element.closest(".input-group");
    parent.remove();
}


