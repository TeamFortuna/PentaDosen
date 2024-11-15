$(document).ready(function () {
    // Inisialisasi DataTable
    $('#proposalPenelitianTable').DataTable();

    // Modal logika
    const initModalLogic = () => {
        const proposalModal = document.getElementById("proposalPenelitianModal");
        const openModalBtn = document.getElementById("openModalBtn");
        const closeModalSpan = document.querySelector(".close-modal");

        if (openModalBtn && proposalModal) {
            openModalBtn.onclick = () => proposalModal.style.display = "block";
            closeModalSpan.onclick = () => proposalModal.style.display = "none";
        }

        window.onclick = (event) => {
            if (event.target === proposalModal) proposalModal.style.display = "none";
        };
    };
    initModalLogic();

    // Dropdown tambahan untuk skema lainnya
    $('#skema').change(function () {
        const skemaValue = $(this).val(); // Ambil nilai skema yang dipilih
        const sumberDana = $('#sumberDana'); // Ambil dropdown sumber dana

        // Reset dropdown sumber dana
        sumberDana.empty();
        sumberDana.append('<option value="" disabled selected>Silahkan Pilih</option>');

        // Pilihan dropdown sumber dana berdasarkan skema
        if (skemaValue === 'Hibah Internal') {
            sumberDana.append('<option value="yayasan yarsi">yayasan yarsi</option>');
        } else if (skemaValue === 'Hibah Eksternal') {
            sumberDana.append('<option value="Dikti">Dikti</option>');
            sumberDana.append('<option value="Brin">Brin</option>');
            sumberDana.append('<option value="lainnya">Lainnya</option>');
        } else if (skemaValue === 'Mandiri') {
            sumberDana.append('<option value="pribadi">pribadi</option>');
        } 
    });

    // Fungsi untuk menampilkan atau menyembunyikan field tambahan
    const toggleAdditionalFields = (selector, targetField) => {
        $(selector).change(function () {
            $(targetField).toggle(this.value === 'lainnya');
        });
    };

    // Dropdown tambahan untuk skema lainnya
    toggleAdditionalFields('#skema', '#skema_lainnya');
    toggleAdditionalFields('#sumberDana', '#dana_lainnya');

    // Dropdown tambahan untuk anggota
    const anggotaSelectors = ['perguruan_anggota[]', 'fakultas_anggota[]', 'prodi_anggota[]'];
    anggotaSelectors.forEach(selector => {
        $('#anggotaContainer').on('change', `select[name="${selector}"]`, function () {
            $(this).next('.lainnya_field').toggle(this.value === 'lainnya');
        });
    });

    // Menambah anggota baru
    $('#tambahAnggotaBtn').click(function () {
        const anggotaHtml = `
            <div class="anggota">
                <label>Nama Anggota:</label>
                <input type="text" name="nama_anggota[]" placeholder="Nama anggota" required>
                <label>NIDN Anggota:</label>
                <input type="text" name="nidn_anggota[]" placeholder="NIDN" required>
                <label>Jabatan Akademik:</label>
                <input type="text" name="jabatan_anggota[]" placeholder="Jabatan" required>
                <label>Perguruan Tinggi:</label>
                <select name="perguruan_anggota[]" required>
                    <option value="" disabled selected>Silahkan Pilih</option>
                    <option value="Universitas YARSI">Universitas YARSI</option>
                    <option value="lainnya">Lainnya (isi sendiri)</option>
                </select>
                <input type="text" class="lainnya_field perguruan_lainnya" name="perguruan_lainnya[]" placeholder="Isi perguruan lainnya" style="display:none;">
                <label>Fakultas:</label>
                <select name="fakultas_anggota[]" required>
                    <option value="" disabled selected>Silahkan Pilih</option>
                    <option value="Fakultas Teknologi Informasi (FTI)">FTI</option>
                    <option value="lainnya">Lainnya (isi sendiri)</option>
                </select>
                <input type="text" class="lainnya_field fakultas_lainnya" name="fakultas_lainnya[]" placeholder="Isi fakultas lainnya" style="display:none;">
                <label>Program Studi:</label>
                <select name="prodi_anggota[]" required>
                    <option value="" disabled selected>Silahkan Pilih</option>
                    <option value="Teknik Informatika">Teknik Informatika</option>
                    <option value="lainnya">Lainnya (isi sendiri)</option>
                </select>
                <input type="text" class="lainnya_field prodi_lainnya" name="prodi_lainnya[]" placeholder="Isi prodi lainnya" style="display:none;">
                <button type="button" class="hapusAnggotaBtn">Hapus Anggota</button>
            </div>`;
        $('#anggotaContainer').append(anggotaHtml);
    });

    // Menghapus anggota
    $('#anggotaContainer').on('click', '.hapusAnggotaBtn', function () {
        $(this).closest('.anggota').remove();
    });
});

// Fungsi untuk membuka modal preview PDF
function openPreviewModal(filePath) {
    const modal = document.getElementById("pdfPreviewModal");
    const pdfViewer = document.getElementById("pdfViewer");
    if (modal && pdfViewer) {
        pdfViewer.src = filePath;
        modal.style.display = "block";
    }
}

// Fungsi untuk menutup modal preview PDF
function closePreviewModal() {
    const modal = document.getElementById("pdfPreviewModal");
    const pdfViewer = document.getElementById("pdfViewer");
    if (modal && pdfViewer) {
        modal.style.display = "none";
        pdfViewer.src = "";
    }
}
