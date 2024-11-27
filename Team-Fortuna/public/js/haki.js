$(document).ready(function () {
    // Inisialisasi DataTable
    $('#hakiTable').DataTable();

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

// Fungsi untuk menambah input nama pencipta
function addPencipta() {
    const container = document.getElementById("penciptaContainer");
    const div = document.createElement("div");
    div.className = "input-group";
    div.innerHTML = `
        <input type="text" name="namaPencipta[]" placeholder="Masukkan nama pencipta">
        <span class="hapusNamaPencipta material-icons-sharp" onclick="hapusPencipta(this)">remove</span>
    `;
    container.appendChild(div);
}

// Fungsi untuk menambah input nama pemegang hak cipta
function addPemegang() {
    const container = document.getElementById("pemegangContainer");
    const div = document.createElement("div");
    div.className = "input-group";
    div.innerHTML = `
        <input type="text" name="namaPemegang[]" placeholder="Masukkan nama pemegang hak cipta">
        <span class="hapusNamaPemegang material-icons-sharp" onclick="hapusPemegang(this)">remove</span>
    `;
    container.appendChild(div);
}

// Fungsi untuk menghapus nama pencipta
function hapusPencipta(element) {
    element.parentElement.remove();
}

// Fungsi untuk menghapus nama pemegang hak cipta
function hapusPemegang(element) {
    element.parentElement.remove();
}


