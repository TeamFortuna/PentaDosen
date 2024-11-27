<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/sidebar.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('css/laporan_akhir.css'); ?>"> <!-- Link CSS eksternal -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Link CSS DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <!-- Script untuk langsung menerapkan dark mode jika statusnya disimpan di localStorage -->
    <script>
        if (localStorage.getItem('darkMode') === 'enabled') {
            document.documentElement.classList.add('dark-mode-variables');
        }
    </script>

    <title>Laporan Akhir</title>
</head>

<body>
    <div class="container">
        <?= $this->include('partials/sidebar'); ?>

        <main>
            <h1>Laporan Akhir</h1>
            <p>Ini adalah halaman untuk Laporan Akhir.</p>

            <button id="openModalBtn" style="margin-bottom: 20px; margin-top: 15px; padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 13px; cursor: pointer; font-family: 'Montserrat';">Tambah Laporan Akhir</button>

            <!-- Modal untuk form Laporan Akhir -->
            <div id="laporanAkhirModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <form id="laporanAkhirForm" action="<?= base_url('Laporan Akhir/upload'); ?>" method="post" enctype="multipart/form-data">
                        <h2>Tambah Laporan Akhir</h2>

                        <label for="laporanAkhirName">Judul Penelitian:</label>
                        <input type="text" id="laporanAkhirName" name="laporanAkhirName" placeholder="Masukkan nama Laporan Akhir" required>

                        <label for="laporanAkhirDate">Kesimpulan Penelitian:</label>
                        <input type="date" id="laporanAkhirDate" name="laporanAkhirDate" required>

                        <label for="judulPenelitian">Pembahasan Temuan:</label>
                        <input type="text" id="judulPenelitian" name="judulPenelitian" placeholder="Masukkan judul penelitian" required>

                        <label for="deskripsiSingkat">Dampak Penelitian:</label>
                        <textarea id="deskripsiSingkat" name="deskripsiSingkat" required></textarea>

                        <label for="latarBelakang">Rekomendasi:</label>
                        <textarea id="latarBelakang" name="latarBelakang" required></textarea>

                        <label for="jadwalPenelitian">Tanggal Selesai:</label>
                        <input type="date" id="jadwalPenelitian" name="jadwalPenelitian" required>

                        <label for="berkas_proposal">File Laporan Akhir:</label>
                        <input type="file" name="berkas_proposal" id="berkas_proposal" required>

                        <label for="grupFavoritKpop">Grup Favorit Kpop:</label>
                        <input type="text" id="grupFavoritKpop" name="grupFavoritKpop" placeholder="Ketik nama grup Kpop" autocomplete="off" required>
                        <div id="suggestions" class="suggestions"></div>


                        <button type="submit">Unggah</button>
                    </form>
                </div>
            </div>

            <div class="recent-orders" style="width: 100%; height: auto; overflow-x: auto;">
                <h2>Daftar Laporan Akhir</h2>
                <table id="laporanAkhirTable" class="display full-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Laporan Akhir</th>
                            <th>Tanggal Laporan Akhir</th>
                            <th>File</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Contoh Judul Laporan Akhir 1</td>
                            <td>01/01/2024</td>
                            <td><a href="<?= base_url('uploads/Laporan Akhir1.pdf'); ?>" target="_blank">Unduh/Preview</a></td>
                            <td>
                                <button>Edit</button>
                                <button>Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Contoh Judul Laporan Akhir 2</td>
                            <td>02/01/2024</td>
                            <td><a href="<?= base_url('uploads/Laporan Akhir2.pdf'); ?>" target="_blank">Unduh/Preview</a></td>
                            <td>
                                <button>Edit</button>
                                <button>Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Pastikan jQuery dimuat terlebih dahulu -->
    <script>
        var searchKpopUrl = "<?= base_url('LaporanAkhirController/searchKpop'); ?>"; // PHP echo base_url here

        $(document).ready(function() {
            $('#laporanAkhirTable').DataTable();

            var modal = document.getElementById("laporanAkhirModal");
            var btn = document.getElementById("openModalBtn");
            var span = document.getElementsByClassName("close")[0];

            btn.onclick = function() {
                modal.style.display = "block";
            }

            span.onclick = function() {
                modal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }

            // Menutup modal saat tombol 'X' diklik
            document.querySelector('.close').onclick = function() {
                document.getElementById('laporanAkhirModal').style.display = 'none';
            };

            // Menutup modal jika pengguna mengklik di luar konten modal
            window.onclick = function(event) {
                const modal = document.getElementById('laporanAkhirModal');
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            };

            // Pencarian grup Kpop menggunakan AJAX
            $('#grupFavoritKpop').on('input', function() {
                let inputVal = $(this).val().toLowerCase();
                let suggestions = $('#suggestions');
                suggestions.empty().hide(); // Kosongkan dan sembunyikan dropdown

                if (inputVal) {
                    $.ajax({
                        url: searchKpopUrl, // Menggunakan variabel searchKpopUrl yang sudah didefinisikan
                        method: 'GET',
                        data: {
                            query: inputVal
                        },
                        dataType: 'json',
                        success: function(response) {
                            console.log(response); // Debugging untuk melihat apa yang dikembalikan dari server
                            if (response.length > 0) {
                                response.forEach(function(group) {
                                    suggestions.append(`<div class="suggestion-item">${group.nama}</div>`); // Pastikan field yang dipanggil sesuai dengan nama kolom di DB
                                });
                                suggestions.show();
                            }
                        }


                    });
                }
            });

            // Menangani klik pada suggestion
            $(document).on('click', '.suggestion-item', function() {
                $('#grupFavoritKpop').val($(this).text());
                $('#suggestions').empty().hide();
            });
        });
    </script>

    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

</body>

</html>