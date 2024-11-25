$(document).ready(function () {
    // Inisialisasi DataTable
    $('#proposalPenelitianTable').DataTable();

    // Validasi ukuran file sebelum submit
    $('#berkas_proposal').on('change', function () {
        const maxSize = 10 * 1024 * 1024; // 10 MB
        const file = this.files[0];
        const alertDiv = $('#uploadAlert'); // Seleksi elemen alert

        if (file && file.size > maxSize) {
            // Tampilkan pesan error dengan Bootstrap alert
            alertDiv.text('Ukuran file terlalu besar! Maksimum 10 MB.');
            alertDiv.removeClass('d-none'); // Tampilkan alert
            alertDiv.addClass('alert-danger'); // Tambahkan warna merah
            this.value = ''; // Reset input file
        } else {
            // Sembunyikan alert jika file valid
            alertDiv.addClass('d-none');
        }
    });

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

 // Inisialisasi Select2 untuk dropdown dosen
function initSelect2Dropdown() {
    $('.select-dosen').select2({
        placeholder: "Cari nama dosen...",
        allowClear: true,
        width: '100%',
        minimumInputLength: 1, // Mulai pencarian setelah 1 karakter
        tags: true // Mengaktifkan opsi tags agar pengguna bisa melihat teks yang diketik
    });
}

// Panggil initSelect2Dropdown saat pertama kali halaman di-load
$(document).ready(function() {
    initSelect2Dropdown();
});

// Fungsi untuk menambah anggota internal
$('#tambahAnggotaInternalBtn').click(function () {
    const anggotaInternalHtml = `
         <div class="anggota-internal">
                                <label for="namaDosen">Nama Dosen:</label>
                                <div class="input-wrapper">
                                    <input type="text" id="anggotaInternal" name="nama_dosen_internal[]" placeholder="Masukkan nama dosen" autocomplete="off" required>
                                    <div id="suggestions" class="suggestions"></div>
                                    <span class="hapusAnggotaInternalIcon material-icons-sharp">remove</span>
                                </div>
                            </div>`;

    // Menambahkan anggota internal ke dalam container
    $('#anggotaInternalContainer').append(anggotaInternalHtml);

    // Re-inisialisasi Select2 untuk dropdown yang baru ditambahkan
    initSelect2Dropdown(); // Panggil ulang initSelect2Dropdown untuk elemen baru
});

// Fungsi untuk menghapus anggota internal
$('#anggotaInternalContainer').on('click', '.hapusAnggotaInternalIcon', function () {
    $(this).closest('.anggota-internal').remove();
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


// Fungsi untuk membuka konfirmasi delete menggunakan SweetAlert
function openDeleteModal(id) {
    // Menyimpan ID proposal yang akan dihapus
    document.getElementById("deleteProposalId").value = id;

    // Menampilkan konfirmasi delete dengan SweetAlert
    Swal.fire({
        title: 'Konfirmasi Penghapusan',
        text: 'Apakah Anda yakin ingin menghapus proposal ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Jika dikonfirmasi, panggil fungsi delete
            confirmDelete();
        }
    });
}

// Fungsi untuk mengkonfirmasi delete
function confirmDelete() {
    const proposalId = document.getElementById("deleteProposalId").value;

    // Kirim permintaan delete ke server
    fetch(`/deleteProposal/${proposalId}`, {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire(
                'Terhapus!',
                'Proposal berhasil dihapus.',
                'success'
            ).then(() => location.reload()); // Refresh halaman setelah berhasil delete
        } else {
            Swal.fire(
                'Gagal!',
                data.error || 'Proposal gagal dihapus.',
                'error'
            );
        }
    })
    .catch(error => {
        Swal.fire(
            'Kesalahan!',
            'Terjadi kesalahan: ' + error,
            'error'
        );
    });
    
}

