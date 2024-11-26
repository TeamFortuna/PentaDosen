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
            sumberDana.append('<option value="Yayasan YARSI">Yayasan YARSI</option>');
        } else if (skemaValue === 'Hibah Eksternal') {
            sumberDana.append('<option value="DIKTI">Dikti</option>');
            sumberDana.append('<option value="BRIN">Brin</option>');
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

    // Fungsi untuk menambahkan anggota kegiatan
    $('#tambahAnggotaKegiatanBtn').on('click', function () {
        const anggotaHtml = `
            <div class="anggota-kegiatan">
                <div class="input-wrapper">
                    <input type="text" name="nama_dosen_kegiatan[]" placeholder="Masukkan nama dosen" autocomplete="off">
                </div>
                <span class="hapusAnggotaKegiatanIcon material-icons-sharp">remove</span>
            </div>
        `;
        $('#anggotaKegiatanContainer').append(anggotaHtml);
    });

    // Fungsi untuk menghapus anggota kegiatan
    $('#anggotaKegiatanContainer').on('click', '.hapusAnggotaKegiatanIcon', function () {
        $(this).closest('.anggota-kegiatan').remove();
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

function openEditModal(proposalId) {
    fetch(`/getProposalById/${proposalId}`)
        .then(response => response.json())
        .then(data => {
            // Isi field modal dengan data dari server
            document.getElementById('editProposalId').value = data.id;
            document.getElementById('editJudulPenelitian').value = data.judul_penelitian;
            document.getElementById('editSkema').value = data.skema;

            // Tampilkan skema lainnya jika ada
            if (data.skema_lainnya) {
                document.getElementById('editSkemaLainnya').style.display = 'block';
                document.getElementById('editSkemaLainnya').value = data.skema_lainnya;
            }

            document.getElementById('editBiayaDiusulkan').value = data.biaya_diusulkan;
            document.getElementById('editBiayaDidanai').value = data.biaya_didanai;
            document.getElementById('editSumberDana').value = data.sumber_dana;

            // Tampilkan dana lainnya jika ada
            if (data.dana_lainnya) {
                document.getElementById('editDanaLainnya').style.display = 'block';
                document.getElementById('editDanaLainnya').value = data.dana_lainnya;
            }

            // Tambahkan logika untuk mengisi anggota kegiatan jika ada
            const anggotaContainer = document.getElementById('editAnggotaKegiatanContainer');
            anggotaContainer.innerHTML = ''; // Kosongkan field sebelumnya
            if (data.anggota_kegiatan) {
                data.anggota_kegiatan.forEach(anggota => {
                    const anggotaDiv = document.createElement('div');
                    anggotaDiv.className = 'anggota-kegiatan';
                    anggotaDiv.innerHTML = `
                        <div class="input-wrapper">
                            <input type="text" name="nama_dosen_kegiatan[]" value="${anggota}" autocomplete="off">
                        </div>
                        <span class="hapusAnggotaKegiatanIcon material-icons-sharp">remove</span>
                    `;
                    anggotaContainer.appendChild(anggotaDiv);
                });
            }

            // Tampilkan file proposal yang tersimpan
            const currentFileLink = document.getElementById('editCurrentBerkasProposal');
            currentFileLink.href = `/uploads/${data.file_proposal}`;
            currentFileLink.textContent = data.file_proposal || 'Tidak ada file';
            

            // Tampilkan modal
            document.getElementById('editProposalModal').style.display = 'block';
        })
        .catch(error => console.error('Error:', error));
}

document.getElementById('editTambahAnggotaKegiatanBtn').addEventListener('click', function() {
    const anggotaContainer = document.getElementById('editAnggotaKegiatanContainer');
    const anggotaDiv = document.createElement('div');
    anggotaDiv.className = 'anggota-kegiatan';
    anggotaDiv.innerHTML = `
        <div class="input-wrapper">
            <input type="text" name="nama_dosen_kegiatan[]" placeholder="Masukkan nama dosen" autocomplete="off">
        </div>
        <span class="hapusAnggotaKegiatanIcon material-icons-sharp">remove</span>
    `;
    anggotaContainer.appendChild(anggotaDiv);
});

document.getElementById('editAnggotaKegiatanContainer').addEventListener('click', function(e) {
    if (e.target && e.target.classList.contains('hapusAnggotaKegiatanIcon')) {
        const anggotaDiv = e.target.closest('.anggota-kegiatan');
        anggotaDiv.remove();
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









