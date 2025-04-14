$(document).ready(function () {
    // Nonaktifkan fitur bawaan DataTable (seperti pagination, filter, entries)
    const table = $('#proposalPenelitianTable').DataTable({
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
            sumberDana.append('<option value="Yayasan YARSI">Yayasan YARSI</option>');
        } else if (skemaValue === 'Hibah Eksternal') {
            sumberDana.append('<option value="DIKTI">DIKTI</option>');
            sumberDana.append('<option value="BRIN">BRIN</option>');
            sumberDana.append('<option value="lainnya">Lainnya</option>');
        } else if (skemaValue === 'Mandiri') {
            sumberDana.append('<option value="Pribadi">Pribadi</option>');
        } 
    });

    // Fungsi untuk menampilkan atau menyembunyikan field tambahan
const toggleAdditionalFields = (selector, targetField) => {
    // Menggunakan event 'change' untuk mendeteksi perubahan pada dropdown
    $(selector).change(function () {
        // Menampilkan atau menyembunyikan elemen target sesuai dengan nilai dropdown
        $(targetField).toggle(this.value === 'lainnya');
    });
};

// Pastikan jQuery sudah dimuat di halaman sebelum menjalankan kode ini
$(document).ready(function () {
    // Dropdown tambahan untuk skema lainnya
    toggleAdditionalFields('#skema', '#skema_lainnya');
    
    // Dropdown tambahan untuk sumber dana lainnya
    toggleAdditionalFields('#sumberDana', '#dana_lainnya');
});


    
});

document.addEventListener("DOMContentLoaded", function () {
    const tambahAnggotaBtn = document.getElementById("tambahAnggotaBtn");
    const anggotaContainer = document.getElementById("anggotaEksternal");

    tambahAnggotaBtn.addEventListener("click", function () {
        const anggotaDiv = document.createElement("div");
        anggotaDiv.className = "anggota card mt-3";
        
        anggotaDiv.innerHTML = `
            <div class="card-eksternal">
                <div class="form-group">
                    <label>Nama Anggota:</label>
                    <input type="text" name="nama_anggota[]" class="form-control" placeholder="Nama anggota" required>
                </div>
                <div class="form-group">
                    <label>NIDN Anggota:</label>
                    <input type="text" name="nidn_anggota[]" class="form-control" placeholder="NIDN" required>
                </div>
                <div class="form-group">
                    <label>Jabatan Akademik:</label>
                    <input type="text" name="jabatan_anggota[]" class="form-control" placeholder="Jabatan" required>
                </div>
                <div class="form-group">
                    <label for="perguruan_anggota">Perguruan Tinggi:</label>
                    <select class="form-control" name="perguruan_anggota[]">
                        <option value="" disabled selected>Silahkan Pilih</option>
                        <option value="Universitas YARSI">Universitas YARSI</option>
                        <option value="lainnya">Lainnya (isi sendiri)</option>
                    </select>
                    <input type="text" class="form-control mt-2 perguruan_lainnya" name="perguruan_lainnya[]" placeholder="Isi perguruan yang lainnya" style="display:none;">
                </div>
                <div class="form-group">
                    <label for="fakultas_anggota">Fakultas:</label>
                    <select class="form-control" name="fakultas_anggota[]">
                        <option value="" disabled selected>Silahkan Pilih</option>
                        <option value="Fakultas Teknologi Informasi (FTI)">Fakultas Teknologi Informasi (FTI)</option>
                        <option value="lainnya">Lainnya (isi sendiri)</option>
                    </select>
                    <input type="text" class="form-control mt-2 fakultas_lainnya" name="fakultas_lainnya[]" placeholder="Isi fakultas yang lainnya" style="display:none;">
                </div>
                <div class="form-group">
                    <label for="prodi_anggota">Program Studi:</label>
                    <select class="form-control" name="prodi_anggota[]">
                        <option value="" disabled selected>Silahkan Pilih</option>
                        <option value="Teknik Informatika">Teknik Informatika</option>
                        <option value="Perpustakaan dan Sains Informasi">Perpustakaan dan Sains Informasi</option>
                        <option value="lainnya">Lainnya (isi sendiri)</option>
                    </select>
                    <input type="text" class="form-control mt-2 prodi_lainnya" name="prodi_lainnya[]" placeholder="Isi program studi yang lainnya" style="display:none;">
                </div>
                <button type="button" class="btn btn-danger mt-3 hapusAnggotaBtn">Hapus Anggota</button>
            </div>
        `;

        anggotaContainer.appendChild(anggotaDiv);

        const hapusBtn = anggotaDiv.querySelector(".hapusAnggotaBtn");
        hapusBtn.addEventListener("click", function () {
            anggotaDiv.remove();
        });

        const toggleField = (selector, target) => {
            const dropdown = anggotaDiv.querySelector(selector);
            const inputField = anggotaDiv.querySelector(target);

            dropdown.addEventListener("change", function () {
                inputField.style.display = this.value === "lainnya" ? "block" : "none";
            });
        };

        toggleField("select[name='perguruan_anggota[]']", ".perguruan_lainnya");
        toggleField("select[name='fakultas_anggota[]']", ".fakultas_lainnya");
        toggleField("select[name='prodi_anggota[]']", ".prodi_lainnya");
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

function tambahAnggotaInternal() {
    const container = document.getElementById('anggotaInternalContainer');

    // Buat elemen div untuk anggota baru
    const anggotaDiv = document.createElement('div');
    anggotaDiv.className = 'anggota-internal';

    // Tambahkan isi HTML untuk elemen baru
    anggotaDiv.innerHTML = `
        <label for="anggotaInternal">Nama Dosen:</label>
        <div class="input-wrapper">
            <input
                type="text"
                list="dosenList"
                name="nama_anggota[]"
                placeholder="Masukkan nama dosen"
                autocomplete="off"
                required>
            <span class="hapusAnggotaInternalIcon material-icons-sharp" onclick="hapusAnggota(this)">remove</span>
        </div>
    `;

    // Tambahkan elemen baru ke dalam kontainer
    container.appendChild(anggotaDiv);
}

// Fungsi untuk menghapus anggota
function hapusAnggota(button) {
    const anggotaDiv = button.closest('.anggota-internal');
    anggotaDiv.remove();
}


// Fungsi untuk menampilkan modal dengan data dari server
function openEditModal(proposalId) {
    fetch(`/getProposalById/${proposalId}`)
        .then(response => response.json())
        .then(data => {
            if (!data) return console.error('Data tidak ditemukan.');

            // Isi data modal
            fillEditModalData(data);

            // Tampilkan modal
            document.getElementById('editProposalModal').style.display = 'block';
        })
        .catch(error => console.error('Error:', error));
}

// Fungsi untuk mengisi data modal
function fillEditModalData(data) {
    document.getElementById('editProposalId').value = data.id;
    document.getElementById('editJudulPenelitian').value = data.judul_penelitian;
    document.getElementById('editSkema').value = data.skema || '';
    document.getElementById('editSkemaLainnya').style.display = data.skema_lainnya ? 'block' : 'none';
    document.getElementById('editSkemaLainnya').value = data.skema_lainnya || '';
    document.getElementById('editBiayaDiusulkan').value = data.biaya_diusulkan || '';
    document.getElementById('editBiayaDidanai').value = data.biaya_didanai || '';
    document.getElementById('editSumberDana').value = data.sumber_dana || '';
    document.getElementById('editDanaLainnya').style.display = data.dana_lainnya ? 'block' : 'none';
    document.getElementById('editDanaLainnya').value = data.dana_lainnya || '';

    // Tampilkan anggota
    populateAnggota(data.anggota_kegiatan || []);

    // File Proposal
    const fileLink = document.getElementById('editCurrentBerkasProposal');
    fileLink.href = data.file_penelitian ? `/uploads/${data.file_penelitian}` : '#';
    fileLink.textContent = data.file_penelitian || 'Tidak ada file';
}

// Fungsi untuk menampilkan anggota dalam container
function populateAnggota(anggotaList) {
    const container = document.getElementById('editAnggotaKegiatanContainer');
    container.innerHTML = ''; // Bersihkan sebelumnya
    anggotaList.forEach(anggota => {
        const anggotaDiv = document.createElement('div');
        anggotaDiv.className = 'anggota-kegiatan';
        anggotaDiv.innerHTML = `
            <div class="input-wrapper">
                <input type="text" list="dosenList" name="nama_dosen_kegiatan[]" value="${anggota.nama_anggota || ''}" placeholder="Nama atau NIDN" required>
                <input type="hidden" name="anggota_dihapus[]" value="" class="anggotaDihapus">
                <span class="hapusAnggotaKegiatanIcon material-icons-sharp">remove</span>
            </div>
        `;
        container.appendChild(anggotaDiv);
    });
}

// Tambahkan anggota baru
document.getElementById('editTambahAnggotaKegiatanBtn').addEventListener('click', () => {
    const container = document.getElementById('editAnggotaKegiatanContainer');
    const anggotaDiv = document.createElement('div');
    anggotaDiv.className = 'anggota-kegiatan';
    anggotaDiv.innerHTML = `
        <div class="input-wrapper">
            <input type="text" list="dosenList" name="nama_dosen_kegiatan[]" placeholder="Nama atau NIDN" required>
            <input type="hidden" name="anggota_dihapus[]" value="" class="anggotaDihapus">
            <span class="hapusAnggotaKegiatanIcon material-icons-sharp">remove</span>
        </div>
    `;
    container.appendChild(anggotaDiv);
});

// Hapus anggota
document.getElementById('editAnggotaKegiatanContainer').addEventListener('click', (e) => {
    if (e.target && e.target.classList.contains('hapusAnggotaKegiatanIcon')) {
        const anggotaDiv = e.target.closest('.anggota-kegiatan');
        anggotaDiv.querySelector('.anggotaDihapus').value = 'true'; // Tandai sebagai dihapus
        anggotaDiv.remove(); // Sembunyikan elemen
    }
});




function closeEditProposalModal() {
    document.getElementById('editProposalModal').style.display = 'none';
}

document.addEventListener("DOMContentLoaded", function () {
    if (flashSuccess) {
        Swal.fire({
            title: 'Berhasil!',
            text: flashSuccess,
            icon: 'success',
            confirmButtonText: 'OK'
        });
    } else if (flashError) {
        Swal.fire({
            title: 'Gagal!',
            text: flashError,
            icon: 'error',
            confirmButtonText: 'OK'
        });
    }
});

document.addEventListener("DOMContentLoaded", () => {
    const exportToExcelBtn = document.getElementById("exportToExcelBtn");

    exportToExcelBtn.addEventListener("click", function () {
        console.log("Export to Excel button clicked!");

        // Ambil elemen tabel
        const table = document.getElementById("proposalPenelitianTable");

        // Buat salinan tabel tanpa kolom "Aksi"
        const clonedTable = table.cloneNode(true);

        // Hapus kolom "Aksi" dari clonedTable
        const aksiIndex = 9; // Indeks kolom "Aksi", sesuaikan sesuai urutan kolom
        Array.from(clonedTable.rows).forEach(row => {
            if (row.cells[aksiIndex]) {
                row.deleteCell(aksiIndex);
            }
        });

        // Gunakan SheetJS untuk membuat workbook
        const workbook = XLSX.utils.book_new();
        const worksheet = XLSX.utils.table_to_sheet(clonedTable, { raw: true });

        // Atur lebar kolom
        worksheet['!cols'] = [
            { wch: 5 },   // Kolom No
            { wch: 40 },  // Judul Penelitian
            { wch: 25 },  // Ketua Pengusul
            { wch: 30 },  // Anggota Pengusul
            { wch: 20 },  // Dana yang Disetujui
            { wch: 15 },  // Tanggal Pengisian
            { wch: 15 },  // Proposal
            { wch: 20 },  // Laporan Kemajuan
            { wch: 15 }   // Laporan Akhir
        ];

        // Tambahkan workbook dan worksheet
        XLSX.utils.book_append_sheet(workbook, worksheet, "Daftar Penelitian");

        // Dapatkan tanggal saat ini untuk nama file
        const currentDate = new Date();
        const year = currentDate.getFullYear();
        const month = String(currentDate.getMonth() + 1).padStart(2, '0'); // Bulan dalam format 2 digit
        const date = String(currentDate.getDate()).padStart(2, '0'); // Tanggal dalam format 2 digit
        const fileName = `Daftar_Penelitian_${year}_${month}_${date}.xlsx`;

        // Simpan file Excel
        XLSX.writeFile(workbook, fileName);
    });
});















