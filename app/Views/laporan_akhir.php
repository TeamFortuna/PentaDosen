<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repositori</title>
    <link rel="stylesheet" href="<?= base_url('css/laporan_akhir.css'); ?>">

</head>

<body>
    <div class="container">

        <h2>Repositori</h2>
        <div class="card">
            <div class="card-header">
                <h4>Repositori</h4>
                <select class="dropdown">
                    <option>Tahun Akademik 2024/2025 Semester Ganjil (Aktif)</option>
                    <option>Tahun Akademik 2023/2024 Semester Genap</option>
                </select>
            </div>
            <div class="table-controls">
                <button class="btn excel">Excel</button>
                <button class="btn pdf">PDF</button>
                <div class="dropdown-wrapper">
                    <button class="btn column-visibility">Column visibility &#9660;</button>
                </div>
                <div class="entries">
                    Show
                    <select>
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                    </select> entries
                </div>
                <div class="search">
                    Search: <input type="text" placeholder="Search...">
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Deskripsi Singkat</th>
                        <th>Penulis</th>
                        <th>Prodi</th>
                        <th>Tanggal Unggah</th>
                        <th>Bidang</th>
                        <th>Kata Kunci</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="9" class="no-data">No data available in table</td>
                    </tr>
                </tbody>
            </table>
            <div class="table-footer">
                Showing 0 to 0 of 0 entries
                <div class="pagination">
                    <button class="btn prev">Previous</button>
                    <button class="btn next">Next</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>