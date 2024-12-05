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
            sumberDana.append('<option value="DIKTI">DIKTI</option>');
            sumberDana.append('<option value="BRIN">BRIN</option>');
            sumberDana.append('<option value="lainnya">Lainnya</option>');
        } else if (skemaValue === 'Mandiri') {
            sumberDana.append('<option value="Pribadi">Pribadi</option>');
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

    
});

document.addEventListener("DOMContentLoaded", function () {
    const tambahAnggotaBtn = document.getElementById("tambahAnggotaBtn");
    const anggotaContainer = document.getElementById("anggotaContainer");

    tambahAnggotaBtn.addEventListener("click", function () {
        const anggotaDiv = document.createElement("div");
        anggotaDiv.className = "anggota";

        anggotaDiv.innerHTML = `
            <label>Nama Anggota:</label>
            <input type="text" name="nama_anggota[]" placeholder="Nama anggota" required>
            
            <label>NIDN Anggota:</label>
            <input type="text" name="nidn_anggota[]" placeholder="NIDN" required>
            
            <label>Jabatan Akademik:</label>
            <input type="text" name="jabatan_anggota[]" placeholder="Jabatan" required>
            
            <label for="perguruan_anggota">Perguruan Tinggi:</label>
            <select id="perguruan_anggota" name="perguruan_anggota[]">
                <option value="" disabled selected>Silahkan Pilih</option>
                <option value="Universitas YARSI">Universitas YARSI</option>
                <option value="lainnya">Lainnya (isi sendiri)</option>
            </select>
            <input type="text" class="perguruan_lainnya" name="perguruan_lainnya[]" placeholder="Isi perguruan yang lainnya" style="display:none;">
            
            <label for="fakultas_anggota">Fakultas:</label>
            <select id="fakultas_anggota" name="fakultas_anggota[]">
                <option value="" disabled selected>Silahkan Pilih</option>
                <option value="Fakultas Teknologi Informasi (FTI)">Fakultas Teknologi Informasi (FTI)</option>
                <option value="lainnya">Lainnya (isi sendiri)</option>
            </select>
            <input type="text" class="fakultas_lainnya" name="fakultas_lainnya[]" placeholder="Isi fakultas yang lainnya" style="display:none;">
            
            <label for="prodi_anggota">Program Studi:</label>
            <select id="prodi_anggota" name="prodi_anggota[]">
                <option value="" disabled selected>Silahkan Pilih</option>
                <option value="Teknik Informatika">Teknik Informatika</option>
                <option value="Perpustakaan dan Sains Informasi">Perpustakaan dan Sains Informasi</option>
                <option value="lainnya">Lainnya (isi sendiri)</option>
            </select>
            <input type="text" class="prodi_lainnya" name="prodi_lainnya[]" placeholder="Isi program studi yang lainnya" style="display:none;">
            
            <button type="button" class="hapusAnggotaBtn">Hapus Anggota</button>
        `;

        // Tambahkan elemen baru ke dalam kontainer
        anggotaContainer.appendChild(anggotaDiv);

        // Tambahkan event listener untuk tombol Hapus Anggota
        const hapusBtn = anggotaDiv.querySelector(".hapusAnggotaBtn");
        hapusBtn.addEventListener("click", function () {
            anggotaDiv.remove();
        });

        // Tampilkan field tambahan jika "lainnya" dipilih
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
                name="nama_dosen_internal[]"
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


function openEditModal(proposalId) {
    fetch(`/getProposalById/${proposalId}`)
        .then(response => response.json())
        .then(data => {
            console.log('Data diterima:', data);
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

            if (data.anggota_kegiatan && data.anggota_kegiatan.length > 0) {
                const anggotaContainer = document.getElementById('editAnggotaContainer');
                anggotaContainer.innerHTML = ''; // Bersihkan field sebelumnya
            
                data.anggota_kegiatan.forEach(anggota => {
                    const anggotaDiv = document.createElement('div');
                    anggotaDiv.className = 'anggota';
                    anggotaDiv.innerHTML = `
                        <label>Nama Anggota:</label>
                        <input type="text" name="nama_anggota[]" value="${anggota.nama_anggota}" placeholder="Nama anggota" required>
                        <label>NIDN Anggota:</label>
                        <input type="text" name="nidn_anggota[]" value="${anggota.nidn_anggota}" placeholder="NIDN" required>
                        <label>Jabatan Akademik:</label>
                        <input type="text" name="jabatan_anggota[]" value="${anggota.jabatan_anggota}" placeholder="Jabatan" required>
                        <label>Perguruan Tinggi:</label>
                        <input type="text" name="perguruan_anggota[]" value="${anggota.perguruan_anggota}" placeholder="Perguruan Tinggi" required>
                        <label>Fakultas:</label>
                        <input type="text" name="fakultas_anggota[]" value="${anggota.fakultas_anggota}" placeholder="Fakultas" required>
                        <label>Program Studi:</label>
                        <input type="text" name="prodi_anggota[]" value="${anggota.prodi_anggota}" placeholder="Program Studi" required>
                        <button type="button" class="hapusAnggotaBtn">Hapus Anggota</button>
                    `;
                    anggotaContainer.appendChild(anggotaDiv);
                });
            } else {
                document.getElementById('editAnggotaContainer').innerHTML = '<p>Tidak ada anggota yang ditemukan.</p>';
            }
            
            

            // Tampilkan file proposal yang tersimpan
            const currentFileLink = document.getElementById('editCurrentBerkasProposal');
            currentFileLink.href = `/uploads/${data.file_penelitian}`;
            currentFileLink.textContent = data.file_penelitian || 'Tidak ada file';
            

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









