<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publikasi - Penta Dosen</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #f8fafc;
            --danger: #f43f5e;
            --warning: #f59e0b;
            --success: #10b981;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f8fafc;
            color: #334155;
        }

        .sidebar {
            width: 16rem;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            z-index: 10;
        }

        .sidebar-item:hover {
            background-color: #e2e8f0;
            transform: translateX(5px);
        }

        .sidebar-item.active {
            background: linear-gradient(90deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.3);
        }

        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 50;
            width: 90%;
            max-width: 800px;
            animation: modalFadeIn 0.3s ease-out;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translate(-50%, -60%);
            }

            to {
                opacity: 1;
                transform: translate(-50%, -50%);
            }
        }

        .modal.active {
            display: block;
        }

        .dropzone {
            border: 2px dashed #cbd5e1;
            border-radius: 0.5rem;
            transition: all 0.3s;
        }

        .dropzone.active {
            border-color: var(--primary);
            background-color: rgba(99, 102, 241, 0.05);
        }

        .author-tag {
            background-color: #e0e7ff;
            color: var(--primary);
            border-radius: 0.375rem;
            padding: 0.25rem 0.5rem;
            display: inline-flex;
            align-items: center;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .select2-container--default .select2-selection--multiple {
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            min-height: 42px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #e0e7ff;
            border: 1px solid #c7d2fe;
            border-radius: 0.25rem;
            padding: 0 0.5rem;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #818cf8;
            margin-right: 0.25rem;
        }

        .confirmation-modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 50;
            width: 90%;
            max-width: 400px;
            animation: modalFadeIn 0.3s ease-out;
        }

        .confirmation-modal.active {
            display: block;
        }

        .table-row-actions {
            opacity: 0;
            transition: opacity 0.2s;
        }

        tr:hover .table-row-actions {
            opacity: 1;
        }

        .filter-input {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .filter-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
        }

        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 12px 20px;
            border-radius: 8px;
            color: white;
            z-index: 1000;
            animation: slideIn 0.3s, fadeOut 0.5s 2.5s forwards;
        }

        .toast.success {
            background-color: var(--success);
        }

        .toast.error {
            background-color: var(--danger);
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }

        /* Preview Modal Styles */
        #documentViewer {
            min-height: 70vh;
            background-color: white;
        }

        #pdfViewer {
            width: 100%;
            height: 100%;
            overflow: auto;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: white;
        }

        #pdfViewer canvas {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin: 20px;
        }

        #wordViewer {
            background-color: white;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .toolbar-btn {
            transition: all 0.2s;
        }

        .toolbar-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Loading animation */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .fa-spinner {
            animation: spin 1s linear infinite;
        }

        /* New styles for action buttons */
        .action-buttons {
            display: flex;
            gap: 0.75rem;
            margin-top: 1rem;
            flex-wrap: wrap;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.2s ease;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .action-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .action-btn i {
            margin-right: 0.5rem;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .overlay {
                display: block;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 5;
            }

            .main-content {
                margin-left: 0;
            }

            .table-row-actions {
                opacity: 1;
            }

            .action-buttons {
                gap: 0.5rem;
            }

            .action-btn {
                padding: 0.5rem 0.75rem;
                font-size: 0.875rem;
            }
        }
    </style>
</head>

<body class="flex h-screen overflow-hidden bg-gray-50">
    <!-- Overlay (for mobile sidebar) -->
    <div class="overlay" id="overlay" style="display: none;"></div>

    <!-- Include Sidebar -->
    <?= view('partials/sidebar') ?>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden main-content">
        <!-- Top Bar -->
        <header class="bg-white shadow-sm z-10">
            <div class="flex items-center justify-between px-6 py-4">
                <div class="flex items-center">
                    <button class="menu-toggle mr-4 text-gray-600 md:hidden" id="openSidebar">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-book-open mr-2 text-indigo-500"></i>
                        Manajemen Publikasi
                    </h2>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="p-2 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 transition">
                        <i class="fas fa-bell"></i>
                    </button>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 overflow-y-auto p-6">
            <!-- Header and Add Button -->
            <div class="mb-6">
                <div class="flex flex-col">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">Daftar Publikasi</h1>
                            <p class="text-gray-600 mt-1">Kelola semua publikasi dosen di sini</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <?php if ($user['role'] === 'dosen' || $user['role'] === 'admin') : ?>
                            <button id="addPublicationBtn" class="action-btn bg-indigo-600 text-white hover:bg-indigo-700">
                                <i class="fas fa-plus"></i>
                                Tambah Publikasi
                            </button>
                        <?php endif; ?>

                        <button id="exportExcelBtn" class="action-btn bg-green-600 text-white hover:bg-green-700">
                            <i class="fas fa-file-excel"></i>
                            Export to Excel
                        </button>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div class="md:col-span-2">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" id="searchInput" class="filter-input pl-10 w-full" placeholder="Cari judul atau penulis...">
                        </div>
                    </div>
                    <div>
                        <select id="filterCategory" class="filter-input w-full">
                            <option value="">Semua Kategori</option>
                            <option value="karya-ilmiah">Karya Ilmiah</option>
                            <option value="buku-ilmiah">Buku Ilmiah</option>
                        </select>
                    </div>
                    <div>
                        <select id="filterType" class="filter-input w-full">
                            <option value="">Semua Jenis</option>
                            <option value="artikel">Artikel</option>
                            <option value="buku">Buku</option>
                            <option value="majalah">Majalah</option>
                        </select>
                    </div>
                    <div>
                        <select id="filterYear" class="filter-input w-full">
                            <option value="">Semua Tahun</option>
                            <?php
                            $currentYear = date('Y');
                            for ($year = $currentYear; $year >= $currentYear - 5; $year--) {
                                echo "<option value='$year'>$year</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Publikasi</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penulis</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File</th>
                                <?php if ($user['role'] === 'dosen' || $user['role'] === 'admin') : ?>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Aksi</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="publicationTableBody">
                            <!-- Data will be filled by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="flex flex-col md:flex-row justify-between items-center mt-4">
                <div class="text-sm text-gray-500 mb-4 md:mb-0">
                    Menampilkan <span id="startItem">1</span> sampai <span id="endItem">5</span> dari <span id="totalItems">0</span> publikasi
                </div>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300" id="prevPage">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="px-3 py-1 bg-indigo-600 text-white rounded" id="currentPage">1</button>
                    <button class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300" id="nextPage">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Add/Edit Publication -->
    <div class="modal" id="publicationModal">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden w-full max-w-4xl">
            <div class="px-6 py-4 border-b flex justify-between items-center bg-indigo-600 text-white">
                <h3 class="text-lg font-semibold" id="modalTitle">Tambah Publikasi Baru</h3>
                <button id="closeModal" class="text-white hover:text-indigo-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <form id="publicationForm">
                    <input type="hidden" id="publicationId">

                    <!-- Section 1: Informasi Publikasi -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-info-circle mr-2 text-indigo-500"></i>
                            Informasi Publikasi
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="publicationCategory" class="block text-sm font-medium text-gray-700 mb-1">Kategori Kegiatan*</label>
                                <select id="publicationCategory" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="karya-ilmiah">Publikasi Karya Ilmiah</option>
                                    <option value="buku-ilmiah">Publikasi Buku Ilmiah</option>
                                </select>
                            </div>

                            <div>
                                <label for="publicationType" class="block text-sm font-medium text-gray-700 mb-1">Jenis Publikasi*</label>
                                <select id="publicationType" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" required>
                                    <option value="">Pilih Jenis</option>
                                    <option value="artikel">Artikel</option>
                                    <option value="buku">Buku</option>
                                    <option value="majalah">Majalah</option>
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label for="publicationTitle" class="block text-sm font-medium text-gray-700 mb-1">Judul Publikasi*</label>
                                <input type="text" id="publicationTitle" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" required>
                            </div>

                            <div>
                                <label for="publicationDate" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Terbit*</label>
                                <input type="date" id="publicationDate" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" required>
                            </div>

                            <div>
                                <label for="publicationPages" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Halaman*</label>
                                <input type="number" id="publicationPages" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" required>
                            </div>

                            <div>
                                <label for="publicationPublisher" class="block text-sm font-medium text-gray-700 mb-1">Penerbit*</label>
                                <input type="text" id="publicationPublisher" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" required>
                            </div>

                            <div>
                                <label for="publicationISBN" class="block text-sm font-medium text-gray-700 mb-1">Nomor ISBN</label>
                                <input type="text" id="publicationISBN" pattern="\d{3}-\d{1,5}-\d{1,7}-\d{1,7}-\d{1}" maxlength="17" placeholder="Contoh: 978-602-03-7983-5" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                            </div>
                        </div>
                    </div>

                    <!-- Section 1.1: Penulis Dosen -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-users mr-2 text-indigo-500"></i>
                            Penulis Dosen
                        </h4>

                        <div>
                            <label for="publicationAuthors" class="block text-sm font-medium text-gray-700 mb-1">Daftar Penulis*</label>
                            <select id="publicationAuthors" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" multiple="multiple" required>
                                <?php if (isset($dosen) && is_array($dosen)): ?>
                                    <?php foreach ($dosen as $d) : ?>
                                        <option value="<?= $d['id'] ?>"><?= $d['nama'] ?></option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="">Tidak ada data dosen</option>
                                <?php endif; ?>
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Anda bisa memilih lebih dari satu penulis</p>
                        </div>

                        <div id="selectedAuthors" class="mt-3 flex flex-wrap">
                            <!-- Selected authors will appear here -->
                        </div>
                    </div>

                    <!-- File Upload -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-file-upload mr-2 text-indigo-500"></i>
                            Upload File Publikasi
                        </h4>

                        <div id="dropzone" class="dropzone p-8 text-center cursor-pointer">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-cloud-upload-alt text-4xl text-indigo-400 mb-3"></i>
                                <p class="font-medium text-gray-700">Drag & drop file publikasi di sini</p>
                                <p class="text-sm text-gray-500 mt-1">Format file: PDF atau Word (maks. 10MB)</p>
                                <button type="button" id="browseFileBtn" class="mt-4 px-4 py-2 bg-indigo-100 text-indigo-600 rounded-lg hover:bg-indigo-200 transition">Atau Pilih File</button>
                            </div>
                            <input type="file" id="publicationFile" accept=".pdf,.doc,.docx" class="hidden">
                        </div>

                        <div id="filePreview" class="mt-4 hidden">
                            <div class="flex items-center justify-between bg-gray-50 p-3 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-file-pdf text-red-500 text-2xl mr-3"></i>
                                    <div>
                                        <p id="fileName" class="font-medium"></p>
                                        <p id="fileSize" class="text-xs text-gray-500"></p>
                                    </div>
                                </div>
                                <button type="button" id="removeFileBtn" class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 pt-4 border-t">
                        <button type="button" id="cancelPublication" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">Batal</button>
                        <button type="submit" id="savePublication" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Simpan Publikasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Detail Publication -->
    <div class="modal" id="detailModal">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden w-full max-w-2xl">
            <div class="px-6 py-4 border-b flex justify-between items-center bg-indigo-600 text-white">
                <h3 class="text-lg font-semibold">Detail Publikasi</h3>
                <button id="closeDetailModal" class="text-white hover:text-indigo-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <div class="mb-6">
                    <h4 class="text-xl font-bold text-gray-800" id="detailTitle"></h4>
                    <div class="flex items-center mt-2">
                        <span class="text-sm px-2 py-1 rounded-md bg-indigo-100 text-indigo-800" id="detailCategory"></span>
                        <span class="text-sm px-2 py-1 rounded-md bg-blue-100 text-blue-800 ml-2" id="detailType"></span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h5 class="text-sm font-medium text-gray-500 mb-2">Tanggal Terbit</h5>
                        <p id="detailDate" class="text-gray-800"></p>
                    </div>
                    <div>
                        <h5 class="text-sm font-medium text-gray-500 mb-2">Penerbit</h5>
                        <p id="detailPublisher" class="text-gray-800"></p>
                    </div>
                    <div>
                        <h5 class="text-sm font-medium text-gray-500 mb-2">Jumlah Halaman</h5>
                        <p id="detailPages" class="text-gray-800"></p>
                    </div>
                    <div>
                        <h5 class="text-sm font-medium text-gray-500 mb-2">ISBN</h5>
                        <p id="detailISBN" class="text-gray-800"></p>
                    </div>
                </div>

                <div class="mb-6">
                    <h5 class="text-sm font-medium text-gray-500 mb-2">Penulis</h5>
                    <div id="detailAuthors" class="flex flex-wrap gap-2">
                        <!-- Authors will be added here -->
                    </div>
                </div>

                <div class="mb-6">
                    <h5 class="text-sm font-medium text-gray-500 mb-2">File Publikasi</h5>
                    <div id="detailFile" class="flex items-center justify-between bg-gray-50 p-3 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-file-pdf text-red-500 text-2xl mr-3"></i>
                            <div>
                                <p id="detailFileName" class="font-medium"></p>
                                <p id="detailFileSize" class="text-xs text-gray-500"></p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button id="previewFileBtn" class="px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
                                <i class="fas fa-eye mr-1"></i> Preview
                            </button>
                            <button id="downloadFileBtn" class="px-3 py-1 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-sm">
                                <i class="fas fa-download mr-1"></i> Unduh
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <button id="editPublicationBtn" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Edit</button>
                    <button id="closeDetail" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Preview Document Modal -->
    <div class="modal" id="previewModal">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden w-full max-w-6xl h-[90vh]">
            <div class="px-6 py-4 border-b flex justify-between items-center bg-indigo-600 text-white">
                <h3 class="text-lg font-semibold" id="previewTitle">Preview Dokumen</h3>
                <button id="closePreviewModal" class="text-white hover:text-indigo-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-4 h-full flex flex-col">
                <!-- Toolbar -->
                <div class="flex justify-between items-center mb-4 bg-gray-100 p-2 rounded-lg">
                    <div class="flex space-x-2">
                        <button id="zoomInBtn" class="p-2 bg-white rounded-lg hover:bg-gray-200">
                            <i class="fas fa-search-plus"></i>
                        </button>
                        <button id="zoomOutBtn" class="p-2 bg-white rounded-lg hover:bg-gray-200">
                            <i class="fas fa-search-minus"></i>
                        </button>
                        <button id="fitWidthBtn" class="p-2 bg-white rounded-lg hover:bg-gray-200">
                            <i class="fas fa-arrows-alt-h"></i> Fit Width
                        </button>
                        <button id="fitPageBtn" class="p-2 bg-white rounded-lg hover:bg-gray-200">
                            <i class="fas fa-expand"></i> Fit Page
                        </button>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span id="pageInfo" class="text-sm text-gray-600">Page 1 of 1</span>
                        <button id="prevPageBtn" class="p-2 bg-white rounded-lg hover:bg-gray-200 disabled:opacity-50" disabled>
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button id="nextPageBtn" class="p-2 bg-white rounded-lg hover:bg-gray-200 disabled:opacity-50" disabled>
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Document Viewer Container -->
                <div id="documentViewer" class="flex-1 border rounded-lg overflow-hidden relative">
                    <div class="absolute inset-0 flex items-center justify-center bg-gray-100">
                        <div class="text-center">
                            <i class="fas fa-spinner fa-spin text-4xl text-indigo-500 mb-3"></i>
                            <p class="text-gray-600">Memuat dokumen...</p>
                        </div>
                    </div>

                    <!-- PDF Viewer (canvas based) -->
                    <div id="pdfViewer" class="hidden w-full h-full"></div>

                    <!-- Word Viewer (will be shown for Word files) -->
                    <div id="wordViewer" class="hidden w-full h-full"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="confirmation-modal" id="confirmationModal">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden w-full max-w-md">
            <div class="px-6 py-4 border-b flex justify-between items-center bg-red-600 text-white">
                <h3 class="text-lg font-semibold">Konfirmasi Hapus</h3>
                <button id="closeConfirmationModal" class="text-white hover:text-red-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0 h-12 w-12 rounded-full bg-red-100 flex items-center justify-center">
                        <i class="fas fa-exclamation text-red-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">Hapus Publikasi</h3>
                        <div class="mt-1 text-sm text-gray-600">
                            Apakah Anda yakin ingin menghapus publikasi ini? Data yang dihapus tidak dapat dikembalikan.
                        </div>
                    </div>
                </div>
                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <button id="cancelDelete" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">Batal</button>
                    <button id="confirmDelete" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Sidebar Script -->
    <script src="<?= base_url('js/sidebar-script.js') ?>"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // Inisialisasi variabel
        let currentPage = 1;
        const itemsPerPage = 5;
        let publications = [];
        let filteredPublications = [];
        let publicationToDelete = null;
        const currentUserId = <?= $user['id'] ?>;
        const currentUserRole = '<?= $user['role'] ?>';

        // Initialize Select2 for authors
        $(document).ready(function() {
            $('#publicationAuthors').select2({
                placeholder: "Pilih penulis",
                width: '100%'
            });

            // Update selected authors display
            $('#publicationAuthors').on('change', function() {
                updateSelectedAuthors();
            });

            // Load initial data
            loadPublications();

            // Export to Excel button
            $('#exportExcelBtn').click(function() {
                const btn = $(this);
                btn.html('<i class="fas fa-spinner fa-spin mr-2"></i> Membuat Excel...');
                btn.prop('disabled', true);

                setTimeout(() => {
                    window.location.href = '/publikasi/export';
                    btn.html('<i class="fas fa-file-excel mr-2"></i> Export to Excel');
                    btn.prop('disabled', false);
                }, 500);
            });
        });

        function updateSelectedAuthors() {
            const selectedAuthors = $('#publicationAuthors').val() || [];
            const authorsContainer = $('#selectedAuthors');
            authorsContainer.empty();

            selectedAuthors.forEach(authorId => {
                const authorName = $(`#publicationAuthors option[value="${authorId}"]`).text();
                authorsContainer.append(`
                    <div class="author-tag">
                        ${authorName}
                        <button type="button" class="ml-2 text-indigo-600 hover:text-indigo-800 remove-author" data-id="${authorId}">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `);
            });

            // Add event listeners to remove buttons
            $('.remove-author').on('click', function() {
                const authorId = $(this).data('id');
                $('#publicationAuthors option[value="' + authorId + '"]').prop('selected', false);
                $('#publicationAuthors').trigger('change');
            });
        }

        // File upload handling
        const dropzone = document.getElementById('dropzone');
        const fileInput = document.getElementById('publicationFile');
        const filePreview = document.getElementById('filePreview');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');
        const removeFileBtn = document.getElementById('removeFileBtn');
        const browseFileBtn = document.getElementById('browseFileBtn');

        // Drag and drop events
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            dropzone.classList.add('active');
        }

        function unhighlight() {
            dropzone.classList.remove('active');
        }

        dropzone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        }

        browseFileBtn.addEventListener('click', () => {
            fileInput.click();
        });

        fileInput.addEventListener('change', () => {
            handleFiles(fileInput.files);
        });

        function handleFiles(files) {
            if (files.length > 0) {
                const file = files[0];

                // Validate file type
                const validTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
                if (!validTypes.includes(file.type)) {
                    showToast('Format file tidak didukung. Harap unggah file PDF atau Word.', 'error');
                    return;
                }

                // Validate file size (max 10MB)
                if (file.size > 10 * 1024 * 1024) {
                    showToast('Ukuran file terlalu besar. Maksimal 10MB.', 'error');
                    return;
                }

                // Display file info
                fileName.textContent = file.name;
                fileSize.textContent = formatFileSize(file.size);

                // Show file preview
                filePreview.classList.remove('hidden');

                // Change icon based on file type
                const fileIcon = filePreview.querySelector('i');
                if (file.type.includes('pdf')) {
                    fileIcon.className = 'fas fa-file-pdf text-red-500 text-2xl mr-3';
                } else {
                    fileIcon.className = 'fas fa-file-word text-blue-500 text-2xl mr-3';
                }
            }
        }

        removeFileBtn.addEventListener('click', () => {
            fileInput.value = '';
            filePreview.classList.add('hidden');
        });

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // Modal functions
        const publicationModal = document.getElementById('publicationModal');
        const detailModal = document.getElementById('detailModal');
        const previewModal = document.getElementById('previewModal');
        const confirmationModal = document.getElementById('confirmationModal');
        const closeModal = document.getElementById('closeModal');
        const closeDetailModal = document.getElementById('closeDetailModal');
        const closePreviewModal = document.getElementById('closePreviewModal');
        const closeConfirmationModal = document.getElementById('closeConfirmationModal');
        const cancelPublication = document.getElementById('cancelPublication');
        const closeDetail = document.getElementById('closeDetail');
        const cancelDelete = document.getElementById('cancelDelete');
        const confirmDelete = document.getElementById('confirmDelete');
        const addPublicationBtn = document.getElementById('addPublicationBtn');
        const publicationForm = document.getElementById('publicationForm');
        const searchInput = document.getElementById('searchInput');

        function openModal() {
            publicationModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModalFunc() {
            publicationModal.classList.remove('active');
            document.body.style.overflow = '';
            resetForm();
        }

        function openDetailModal() {
            detailModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeDetailModalFunc() {
            detailModal.classList.remove('active');
            document.body.style.overflow = '';
        }

        function openPreviewModal() {
            previewModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closePreviewModalFunc() {
            previewModal.classList.remove('active');
            document.body.style.overflow = '';
            pdfDoc = null;
            currentPageNum = 1;
            currentScale = 1.0;
        }

        function openConfirmationModal(pubId) {
            publicationToDelete = pubId;
            confirmationModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeConfirmationModalFunc() {
            confirmationModal.classList.remove('active');
            document.body.style.overflow = '';
            publicationToDelete = null;
        }

        closeModal.addEventListener('click', closeModalFunc);
        closeDetailModal.addEventListener('click', closeDetailModalFunc);
        closePreviewModal.addEventListener('click', closePreviewModalFunc);
        closeConfirmationModal.addEventListener('click', closeConfirmationModalFunc);
        cancelPublication.addEventListener('click', closeModalFunc);
        closeDetail.addEventListener('click', closeDetailModalFunc);
        cancelDelete.addEventListener('click', closeConfirmationModalFunc);

        confirmDelete.addEventListener('click', function() {
            if (publicationToDelete) {
                deletePublication(publicationToDelete);
                closeConfirmationModalFunc();
            }
        });

        addPublicationBtn.addEventListener('click', function() {
            document.getElementById('modalTitle').textContent = 'Tambah Publikasi Baru';
            resetForm();
            openModal();
        });

        function resetForm() {
            publicationForm.reset();
            document.getElementById('publicationId').value = '';
            $('#publicationAuthors').val(null).trigger('change');
            fileInput.value = '';
            filePreview.classList.add('hidden');
        }

        // Filter functions
        function applyFilters() {
            const searchTerm = searchInput.value.toLowerCase();
            const categoryFilter = document.getElementById('filterCategory').value;
            const typeFilter = document.getElementById('filterType').value;
            const yearFilter = document.getElementById('filterYear').value;

            renderPublications(searchTerm, categoryFilter, typeFilter, yearFilter);
        }

        // Add event listeners to filters
        document.getElementById('filterCategory').addEventListener('change', applyFilters);
        document.getElementById('filterType').addEventListener('change', applyFilters);
        document.getElementById('filterYear').addEventListener('change', applyFilters);
        searchInput.addEventListener('input', applyFilters);

        // Pagination functions
        document.getElementById('prevPage').addEventListener('click', function() {
            if (currentPage > 1) {
                currentPage--;
                renderPublications();
            }
        });

        document.getElementById('nextPage').addEventListener('click', function() {
            const totalPages = Math.ceil(filteredPublications.length / itemsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                renderPublications();
            }
        });

        // Render publications table
        function renderPublications(searchTerm = '', categoryFilter = '', typeFilter = '', yearFilter = '') {
            const tbody = document.getElementById('publicationTableBody');
            tbody.innerHTML = '';

            filteredPublications = [...publications];

            // Apply search
            if (searchTerm) {
                filteredPublications = filteredPublications.filter(pub =>
                    pub.judul.toLowerCase().includes(searchTerm) ||
                    pub.penulis.toLowerCase().includes(searchTerm)
                );
            }

            // Apply filters
            if (categoryFilter) {
                filteredPublications = filteredPublications.filter(pub => pub.kategori === categoryFilter);
            }

            if (typeFilter) {
                filteredPublications = filteredPublications.filter(pub => pub.jenis === typeFilter);
            }

            if (yearFilter) {
                filteredPublications = filteredPublications.filter(pub => {
                    const pubYear = new Date(pub.tanggal_terbit).getFullYear().toString();
                    return pubYear === yearFilter;
                });
            }

            // Update pagination info
            const totalItems = filteredPublications.length;
            document.getElementById('totalItems').textContent = totalItems;

            const totalPages = Math.ceil(totalItems / itemsPerPage);
            const startItem = (currentPage - 1) * itemsPerPage + 1;
            const endItem = Math.min(currentPage * itemsPerPage, totalItems);

            document.getElementById('startItem').textContent = startItem;
            document.getElementById('endItem').textContent = endItem;
            document.getElementById('currentPage').textContent = currentPage;

            // Disable/enable pagination buttons
            document.getElementById('prevPage').disabled = currentPage === 1;
            document.getElementById('nextPage').disabled = currentPage === totalPages;

            if (filteredPublications.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="${currentUserRole === 'admin' || currentUserRole === 'dosen' ? '8' : '7'}" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada data publikasi yang ditemukan
                        </td>
                    </tr>
                `;
                return;
            }

            // Paginate the results
            const paginatedPublications = filteredPublications.slice(startItem - 1, endItem);

            paginatedPublications.forEach((pub, index) => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50';

                // Format date
                const dateObj = new Date(pub.tanggal_terbit);
                const formattedDate = dateObj.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                });

                // Get category and type text
                const categoryText = pub.kategori === 'karya-ilmiah' ? 'Publikasi Karya Ilmiah' : 'Publikasi Buku Ilmiah';
                const typeText = pub.jenis === 'artikel' ? 'Artikel' :
                    pub.jenis === 'buku' ? 'Buku' : 'Majalah';

                // File icon
                let fileIcon = '';
                if (pub.file_path && pub.file_path.toLowerCase().endsWith('.pdf')) {
                    fileIcon = '<i class="fas fa-file-pdf text-red-500"></i>';
                } else {
                    fileIcon = '<i class="fas fa-file-word text-blue-500"></i>';
                }

                // Check if current user is the creator
                const isCreator = pub.created_by == currentUserId;

                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${startItem + index}</td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">${pub.judul}</div>
                        <div class="text-xs text-gray-500 mt-1">${pub.penerbit}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">${pub.penulis}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${formattedDate}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${categoryText}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${typeText}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <button class="text-indigo-600 hover:text-indigo-900 view-file" data-id="${pub.id}">
                            ${fileIcon} Lihat
                        </button>
                    </td>
                    ${currentUserRole === 'admin' || isCreator ? `
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium table-row-actions">
                        <button class="text-indigo-600 hover:text-indigo-900 mr-3 edit-pub" data-id="${pub.id}" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="text-red-600 hover:text-red-900 delete-pub" data-id="${pub.id}" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                    ` : ''}
                `;

                tbody.appendChild(row);
            });

            // Add event listeners to buttons
            document.querySelectorAll('.edit-pub').forEach(btn => {
                btn.addEventListener('click', function() {
                    const pubId = this.getAttribute('data-id');
                    editPublication(pubId);
                });
            });

            document.querySelectorAll('.delete-pub').forEach(btn => {
                btn.addEventListener('click', function() {
                    const pubId = this.getAttribute('data-id');
                    openConfirmationModal(pubId);
                });
            });

            document.querySelectorAll('.view-file').forEach(btn => {
                btn.addEventListener('click', function() {
                    const pubId = this.getAttribute('data-id');
                    viewPublication(pubId);
                });
            });
        }

        // Load publications from server
        function loadPublications() {
            let url = currentUserRole === 'admin' ? '/publikasi/admin' : '/publikasi';

            // Show loading state
            $('#publicationTableBody').html('<tr><td colspan="8" class="px-6 py-4 text-center">Memuat data...</td></tr>');

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response && response.status === 'success' && Array.isArray(response.data)) {
                        publications = response.data;
                        renderPublications();
                    } else {
                        console.error('Invalid response format:', response);
                        showToast('Gagal memuat data publikasi', 'error');
                        $('#publicationTableBody').html('<tr><td colspan="8" class="px-6 py-4 text-center text-gray-500">Gagal memuat data publikasi</td></tr>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error loading publications:', xhr.responseText);
                    showToast('Gagal memuat data publikasi: ' + error, 'error');
                    $('#publicationTableBody').html('<tr><td colspan="8" class="px-6 py-4 text-center text-gray-500">Gagal memuat data publikasi</td></tr>');
                }
            });
        }

        // Edit publication
        function editPublication(pubId) {
            const pub = publications.find(p => p.id == pubId);
            if (pub) {
                document.getElementById('modalTitle').textContent = 'Edit Publikasi';
                document.getElementById('publicationId').value = pub.id;
                document.getElementById('publicationTitle').value = pub.judul;
                document.getElementById('publicationCategory').value = pub.kategori;
                document.getElementById('publicationType').value = pub.jenis;
                document.getElementById('publicationDate').value = pub.tanggal_terbit;
                document.getElementById('publicationPages').value = pub.jumlah_halaman;
                document.getElementById('publicationPublisher').value = pub.penerbit;
                document.getElementById('publicationISBN').value = pub.isbn;

                // Set authors
                $.ajax({
                    url: `/publikasi/${pubId}/penulis`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(authors) {
                        const authorIds = authors.map(a => a.id.toString());
                        $('#publicationAuthors').val(authorIds).trigger('change');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading authors:', error);
                    }
                });

                // Set file info
                if (pub.file_path) {
                    fileName.textContent = pub.file_path;
                    fileSize.textContent = formatFileSize(pub.file_size);

                    if (pub.file_path.toLowerCase().endsWith('.pdf')) {
                        filePreview.querySelector('i').className = 'fas fa-file-pdf text-red-500 text-2xl mr-3';
                    } else {
                        filePreview.querySelector('i').className = 'fas fa-file-word text-blue-500 text-2xl mr-3';
                    }

                    filePreview.classList.remove('hidden');
                }

                openModal();
            }
        }

        // Delete publication
        function deletePublication(pubId) {
            $.ajax({
                url: `/publikasi/${pubId}`,
                type: 'DELETE',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        showToast('Publikasi berhasil dihapus', 'success');
                        loadPublications();
                    } else {
                        showToast('Gagal menghapus publikasi: ' + response.message, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    showToast('Terjadi kesalahan saat menghapus publikasi', 'error');
                    console.error('Error deleting publication:', error);
                }
            });
        }

        // View publication details
        function viewPublication(pubId) {
            const pub = publications.find(p => p.id == pubId);
            if (pub) {
                document.getElementById('detailTitle').textContent = pub.judul;

                // Set category and type
                const categoryText = pub.kategori === 'karya-ilmiah' ? 'Publikasi Karya Ilmiah' : 'Publikasi Buku Ilmiah';
                const typeText = pub.jenis === 'artikel' ? 'Artikel' :
                    pub.jenis === 'buku' ? 'Buku' : 'Majalah';

                document.getElementById('detailCategory').textContent = categoryText;
                document.getElementById('detailType').textContent = typeText;

                // Format date
                const dateObj = new Date(pub.tanggal_terbit);
                const formattedDate = dateObj.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
                document.getElementById('detailDate').textContent = formattedDate;

                document.getElementById('detailPublisher').textContent = pub.penerbit;
                document.getElementById('detailPages').textContent = pub.jumlah_halaman;
                document.getElementById('detailISBN').textContent = pub.isbn || '-';

                // Set authors (need to fetch from server)
                $.ajax({
                    url: `/publikasi/${pubId}/penulis`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(authors) {
                        const authorsContainer = document.getElementById('detailAuthors');
                        authorsContainer.innerHTML = '';
                        authors.forEach(author => {
                            authorsContainer.innerHTML += `
                                <span class="bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded">${author.nama}</span>
                            `;
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading authors:', error);
                    }
                });

                // Set file info
                document.getElementById('detailFileName').textContent = pub.file_path;
                document.getElementById('detailFileSize').textContent = formatFileSize(pub.file_size);

                // Change file icon based on type
                const fileIcon = document.querySelector('#detailFile i');
                if (pub.file_path && pub.file_path.toLowerCase().endsWith('.pdf')) {
                    fileIcon.className = 'fas fa-file-pdf text-red-500 text-2xl mr-3';
                } else {
                    fileIcon.className = 'fas fa-file-word text-blue-500 text-2xl mr-3';
                }

                // Set download button
                document.getElementById('downloadFileBtn').setAttribute('data-id', pub.id);
                document.getElementById('previewFileBtn').setAttribute('data-id', pub.id);

                // Set edit button (only show if user is creator or admin)
                const editBtn = document.getElementById('editPublicationBtn');
                if (pub.created_by == currentUserId || currentUserRole === 'admin') {
                    editBtn.style.display = 'inline-flex';
                    editBtn.setAttribute('data-id', pub.id);
                } else {
                    editBtn.style.display = 'none';
                }

                openDetailModal();
            }
        }

        // Preview Document Functionality
        const documentViewer = document.getElementById('documentViewer');
        const pdfViewer = document.getElementById('pdfViewer');
        const wordViewer = document.getElementById('wordViewer');
        const previewTitle = document.getElementById('previewTitle');
        const downloadFromPreviewBtn = document.getElementById('downloadFromPreviewBtn');
        const zoomInBtn = document.getElementById('zoomInBtn');
        const zoomOutBtn = document.getElementById('zoomOutBtn');
        const fitWidthBtn = document.getElementById('fitWidthBtn');
        const fitPageBtn = document.getElementById('fitPageBtn');
        const prevPageBtn = document.getElementById('prevPageBtn');
        const nextPageBtn = document.getElementById('nextPageBtn');
        const pageInfo = document.getElementById('pageInfo');

        let currentPreviewPubId = null;
        let pdfDoc = null;
        let currentPageNum = 1;
        let currentScale = 1.0;

        // Event listener untuk preview button di detail modal
        document.getElementById('previewFileBtn').addEventListener('click', function() {
            const pubId = this.getAttribute('data-id');
            currentPreviewPubId = pubId;
            const pub = publications.find(p => p.id == pubId);

            if (pub) {
                previewTitle.textContent = `Preview: ${pub.judul}`;
                openPreviewModal();
                loadDocumentForPreview(pub);
            }
        });

        // Event listener untuk download dari preview modal
        document.addEventListener('click', function(e) {
            if (e.target && e.target.id === 'downloadFromPreviewBtn') {
                if (currentPreviewPubId) {
                    window.location.href = `/publikasi/download/${currentPreviewPubId}`;
                }
            }
        });

        // Fungsi untuk memuat dokumen untuk preview
        function loadDocumentForPreview(pub) {
            // Reset viewer
            pdfViewer.classList.add('hidden');
            wordViewer.classList.add('hidden');

            // Tampilkan loading state
            documentViewer.querySelector('.absolute').classList.remove('hidden');

            // Ambil data preview dari server
            $.ajax({
                url: `/publikasi/preview/${pub.id}`,
                type: 'GET',
                success: function(response) {
                    if (response.status === 'success') {
                        if (response.type === 'pdf') {
                            // Load PDF
                            loadPDFForPreview(response.data, pub.file_path);
                        } else if (response.type === 'word') {
                            // Untuk file Word, tampilkan pesan dan tombol download
                            documentViewer.querySelector('.absolute').classList.add('hidden');
                            wordViewer.classList.remove('hidden');
                            wordViewer.innerHTML = `
                                <div class="text-center max-w-md p-6">
                                    <i class="fas fa-file-word text-blue-500 text-5xl mb-4"></i>
                                    <h4 class="text-xl font-semibold mb-2">Dokumen Word</h4>
                                    <p class="text-gray-600 mb-2">${response.filename}</p>
                                    <p class="text-gray-500 text-sm mb-4">${formatFileSize(response.size)}</p>
                                    <button id="downloadFromPreviewBtn" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                                        <i class="fas fa-download mr-2"></i> Unduh Dokumen
                                    </button>
                                </div>
                            `;
                        }
                    } else {
                        showErrorInPreview(response.message || 'Gagal memuat dokumen');
                    }
                },
                error: function(xhr, status, error) {
                    showErrorInPreview('Terjadi kesalahan saat memuat dokumen');
                }
            });
        }

        // Fungsi untuk memuat PDF (menggunakan PDF.js)
        function loadPDFForPreview(pdfData, filename) {
            // Load PDF menggunakan PDF.js
            pdfjsLib = window['pdfjs-dist/build/pdf'];
            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.worker.min.js';

            // Convert base64 to Uint8Array
            const binaryString = atob(pdfData);
            const bytes = new Uint8Array(binaryString.length);
            for (let i = 0; i < binaryString.length; i++) {
                bytes[i] = binaryString.charCodeAt(i);
            }

            // Loading PDF
            const loadingTask = pdfjsLib.getDocument({
                data: bytes
            });

            loadingTask.promise.then(function(pdf) {
                pdfDoc = pdf;
                documentViewer.querySelector('.absolute').classList.add('hidden');
                pdfViewer.classList.remove('hidden');

                // Update page info
                pageInfo.textContent = `Page 1 of ${pdf.numPages}`;

                // Enable/disable navigation buttons
                prevPageBtn.disabled = true;
                nextPageBtn.disabled = pdf.numPages <= 1;

                // Render first page
                renderPDFPage(1);

            }).catch(function(error) {
                console.error('Error loading PDF:', error);
                showErrorInPreview('Gagal memuat dokumen PDF');
            });
        }

        function showErrorInPreview(message) {
            documentViewer.querySelector('.absolute').classList.add('hidden');
            wordViewer.classList.remove('hidden');
            wordViewer.innerHTML = `
                <div class="text-center max-w-md p-6">
                    <i class="fas fa-exclamation-triangle text-yellow-500 text-5xl mb-4"></i>
                    <h4 class="text-xl font-semibold mb-2">Gagal Memuat Dokumen</h4>
                    <p class="text-gray-600 mb-4">${message}</p>
                    <button id="downloadFromPreviewBtn" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                        <i class="fas fa-download mr-2"></i> Unduh Dokumen
                    </button>
                </div>
            `;
        }

        // Fungsi untuk merender halaman PDF
        function renderPDFPage(pageNum) {
            if (!pdfDoc) return;

            currentPageNum = pageNum;
            pageInfo.textContent = `Page ${pageNum} of ${pdfDoc.numPages}`;

            // Update navigation buttons
            prevPageBtn.disabled = pageNum <= 1;
            nextPageBtn.disabled = pageNum >= pdfDoc.numPages;

            // Load the page
            pdfDoc.getPage(pageNum).then(function(page) {
                const viewport = page.getViewport({
                    scale: currentScale
                });

                // Create canvas for rendering
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                // Clear previous content
                pdfViewer.innerHTML = '';
                pdfViewer.appendChild(canvas);

                // Render PDF page
                page.render({
                    canvasContext: context,
                    viewport: viewport
                });
            });
        }

        // Navigation controls
        prevPageBtn.addEventListener('click', function() {
            if (pdfDoc && currentPageNum > 1) {
                renderPDFPage(currentPageNum - 1);
            }
        });

        nextPageBtn.addEventListener('click', function() {
            if (pdfDoc && currentPageNum < pdfDoc.numPages) {
                renderPDFPage(currentPageNum + 1);
            }
        });

        // Zoom controls
        zoomInBtn.addEventListener('click', function() {
            if (pdfDoc) {
                currentScale = Math.min(currentScale + 0.25, 3.0);
                renderPDFPage(currentPageNum);
            }
        });

        zoomOutBtn.addEventListener('click', function() {
            if (pdfDoc) {
                currentScale = Math.max(currentScale - 0.25, 0.5);
                renderPDFPage(currentPageNum);
            }
        });

        fitWidthBtn.addEventListener('click', function() {
            if (pdfDoc) {
                currentScale = 1.0; // Adjust this based on container width if needed
                renderPDFPage(currentPageNum);
            }
        });

        fitPageBtn.addEventListener('click', function() {
            if (pdfDoc) {
                currentScale = 1.0;
                renderPDFPage(currentPageNum);
            }
        });

        // Form submission
        publicationForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Show loading state
            const saveBtn = document.getElementById('savePublication');
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Menyimpan...';
            saveBtn.disabled = true;

            const pubId = document.getElementById('publicationId').value;
            const formData = new FormData();

            // Hanya tambahkan field yang diubah atau diperlukan
            if (pubId) {
                formData.append('_method', 'PUT'); // Untuk method override
            }

            // Tambahkan semua field wajib
            formData.append('judul', document.getElementById('publicationTitle').value);
            formData.append('kategori', document.getElementById('publicationCategory').value);
            formData.append('jenis', document.getElementById('publicationType').value);
            formData.append('tanggal_terbit', document.getElementById('publicationDate').value);
            formData.append('jumlah_halaman', document.getElementById('publicationPages').value);
            formData.append('penerbit', document.getElementById('publicationPublisher').value);

            // Field opsional
            const isbn = document.getElementById('publicationISBN').value;
            if (isbn) formData.append('isbn', isbn);

            // Tambahkan penulis
            const selectedAuthors = $('#publicationAuthors').val() || [];
            selectedAuthors.forEach(authorId => {
                formData.append('penulis[]', authorId);
            });

            // Hanya tambahkan file jika ada file yang dipilih
            const fileInput = document.getElementById('publicationFile');
            if (fileInput.files.length > 0) {
                formData.append('file', fileInput.files[0]);
            }

            const method = pubId ? 'POST' : 'POST'; // Selalu POST karena FormData
            const url = pubId ? `/publikasi/${pubId}` : '/publikasi';

            // Tambahkan header untuk PUT request
            const headers = {};
            if (pubId) {
                headers['X-HTTP-Method-Override'] = 'PUT';
            }

            $.ajax({
                url: url,
                type: method,
                data: formData,
                processData: false,
                contentType: false,
                headers: headers,
                success: function(response) {
                    saveBtn.innerHTML = 'Simpan Publikasi';
                    saveBtn.disabled = false;

                    if (response.status === 'success') {
                        showToast('Publikasi berhasil disimpan', 'success');
                        loadPublications();
                        closeModalFunc();
                    } else {
                        const errorMsg = response.message || 'Gagal menyimpan publikasi';
                        showToast(errorMsg, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    saveBtn.innerHTML = 'Simpan Publikasi';
                    saveBtn.disabled = false;

                    let errorMsg = 'Terjadi kesalahan saat menyimpan publikasi';

                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response && response.errors) {
                            // Format validation errors
                            errorMsg = Object.values(response.errors).join('<br>');
                        } else if (response && response.message) {
                            errorMsg = response.message;
                        }
                    } catch (e) {
                        console.error('Error parsing response:', e);
                    }

                    showToast(errorMsg, 'error');
                }
            });
        });

        // Edit button in detail modal
        document.getElementById('editPublicationBtn').addEventListener('click', function() {
            const pubId = this.getAttribute('data-id');
            closeDetailModalFunc();
            editPublication(pubId);
        });

        // Download button in detail modal
        document.getElementById('downloadFileBtn').addEventListener('click', function() {
            const pubId = this.getAttribute('data-id');
            window.location.href = `/publikasi/download/${pubId}`;
        });

        // Show toast notification
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            toast.textContent = message;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 3000);
        }

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            // ISBN input formatting
            document.getElementById('publicationISBN').addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                let formatted = '';

                if (value.length > 0) {
                    formatted = value.substring(0, 3);
                    if (value.length > 3) {
                        formatted += '-' + value.substring(3, 4);
                        if (value.length > 4) {
                            formatted += '-' + value.substring(4, 6);
                            if (value.length > 6) {
                                formatted += '-' + value.substring(6, 13);
                                if (value.length > 13) {
                                    formatted += '-' + value.substring(13, 14);
                                }
                            }
                        }
                    }
                }

                e.target.value = formatted;
            });
        });
    </script>
</body>

</html>