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


