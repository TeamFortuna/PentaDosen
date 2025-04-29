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
        }
    </style>
</head>

<body class="flex h-screen overflow-hidden bg-gray-50">
    <!-- Overlay (for mobile sidebar) -->
    <div class="overlay" id="overlay" style="display: none;"></div>

    <!-- Sidebar -->
    <div class="sidebar flex flex-col h-full" id="sidebar">
        <!-- Logo and Toggle -->
        <div class="p-4 flex items-center justify-between border-b">
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-lg bg-indigo-500 flex items-center justify-center text-white mr-3">
                    <i class="fas fa-flask text-xl"></i>
                </div>
                <h1 class="text-xl font-bold text-indigo-600">Penta Dosen</h1>
            </div>
            <button class="menu-toggle md:hidden text-gray-500" id="closeSidebar">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Menu -->
        <div class="flex-1 overflow-y-auto py-4">
            <ul class="space-y-1 px-4">
                <li>
                    <a href="<?= site_url('dashboard') ?>" class="sidebar-item flex items-center px-4 py-3 rounded-lg text-gray-600 hover:text-indigo-600 font-medium">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('kalender') ?>" class="sidebar-item flex items-center px-4 py-3 rounded-lg text-gray-600 hover:text-indigo-600 font-medium">
                        <i class="far fa-calendar-alt mr-3"></i>
                        Kalender
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('penelitian') ?>" class="sidebar-item flex items-center px-4 py-3 rounded-lg text-gray-600 hover:text-indigo-600 font-medium">
                        <i class="fas fa-microscope mr-3"></i>
                        Penelitian
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('publikasi') ?>" class="sidebar-item active flex items-center px-4 py-3 rounded-lg text-white font-medium">
                        <i class="fas fa-book-open mr-3"></i>
                        Publikasi
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('hki') ?>" class="sidebar-item flex items-center px-4 py-3 rounded-lg text-gray-600 hover:text-indigo-600 font-medium">
                        <i class="fas fa-lightbulb mr-3"></i>
                        HKI
                    </a>
                </li>
            </ul>
        </div>

        <!-- User Profile -->
        <div class="p-4 border-t">
            <div class="flex items-center">
                <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="User" class="w-10 h-10 rounded-full mr-3 border-2 border-indigo-100">
                <div>
                    <p class="font-medium text-gray-800">Prof. Dr. Andi Wijaya</p>
                    <p class="text-xs text-gray-500">Dosen Fakultas Kedokteran</p>
                </div>
            </div>
            <button class="mt-3 w-full py-2 px-4 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium text-gray-700 transition duration-200 flex items-center justify-center">
                <a href="<?= site_url('homepage') ?>">
                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                </a>
            </button>
        </div>
    </div>

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
                <div class="flex justify-between items-center mb-3">
                    <h1 class="text-2xl font-bold text-gray-800">Daftar Publikasi</h1>
                </div>
                <p class="text-gray-600 mb-4">Kelola semua publikasi dosen di sini</p>
                <button id="addPublicationBtn" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 flex items-center transition transform hover:-translate-y-0.5">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Publikasi
                </button>
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
                            <option value="2023">2023</option>
                            <option value="2022">2022</option>
                            <option value="2021">2021</option>
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
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <!-- Data akan diisi oleh JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="flex flex-col md:flex-row justify-between items-center mt-4">
                <div class="text-sm text-gray-500 mb-4 md:mb-0">
                    Menampilkan <span id="startItem">1</span> sampai <span id="endItem">5</span> dari <span id="totalItems">12</span> publikasi
                </div>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="px-3 py-1 bg-indigo-600 text-white rounded">1</button>
                    <button class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">2</button>
                    <button class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">3</button>
                    <button class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
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
                                <option value="1">Prof. Dr. Andi Wijaya</option>
                                <option value="2">Dr. Budi Santoso, M.Kom</option>
                                <option value="3">Dr. Citra Dewi, S.T., M.T.</option>
                                <option value="4">Dian Pratama, S.Si., M.Si.</option>
                                <option value="5">Eka Putra, S.Kom., M.Kom.</option>
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
                        <button id="downloadFileBtn" class="px-3 py-1 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-sm">
                            <i class="fas fa-download mr-1"></i> Unduh
                        </button>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <button id="editPublicationBtn" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Edit</button>
                    <button id="closeDetail" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">Tutup</button>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // Sample data for publications
        let publications = [{
                id: '1',
                title: 'Pengaruh Teknologi Blockchain pada Sistem Keamanan Data',
                authors: [{
                        id: '1',
                        name: 'Prof. Dr. Andi Wijaya'
                    },
                    {
                        id: '3',
                        name: 'Dr. Citra Dewi, S.T., M.T.'
                    }
                ],
                date: '2023-05-15',
                category: 'karya-ilmiah',
                categoryText: 'Publikasi Karya Ilmiah',
                type: 'artikel',
                typeText: 'Artikel',
                pages: 12,
                publisher: 'Jurnal Teknologi Informasi',
                isbn: '978-602-03-7983-5',
                fileName: 'blockchain-security.pdf',
                fileSize: '2.4 MB',
                fileType: 'pdf'
            },
            {
                id: '2',
                title: 'Artificial Intelligence dalam Diagnosa Medis',
                authors: [{
                    id: '1',
                    name: 'Prof. Dr. Andi Wijaya'
                }],
                date: '2023-03-22',
                category: 'buku-ilmiah',
                categoryText: 'Publikasi Buku Ilmiah',
                type: 'buku',
                typeText: 'Buku',
                pages: 245,
                publisher: 'Penerbit Ilmu Komputer',
                isbn: '978-602-8511-23-4',
                fileName: 'ai-diagnosa-medis.docx',
                fileSize: '5.7 MB',
                fileType: 'word'
            },
            {
                id: '3',
                title: 'Implementasi IoT pada Smart City',
                authors: [{
                        id: '2',
                        name: 'Dr. Budi Santoso, M.Kom'
                    },
                    {
                        id: '4',
                        name: 'Dian Pratama, S.Si., M.Si.'
                    }
                ],
                date: '2023-07-10',
                category: 'karya-ilmiah',
                categoryText: 'Publikasi Karya Ilmiah',
                type: 'artikel',
                typeText: 'Artikel',
                pages: 8,
                publisher: 'Majalah Teknologi',
                isbn: '',
                fileName: 'iot-smart-city.pdf',
                fileSize: '1.8 MB',
                fileType: 'pdf'
            },
            {
                id: '4',
                title: 'Pengembangan Sistem Informasi Manajemen Rumah Sakit',
                authors: [{
                        id: '1',
                        name: 'Prof. Dr. Andi Wijaya'
                    },
                    {
                        id: '5',
                        name: 'Eka Putra, S.Kom., M.Kom.'
                    }
                ],
                date: '2022-11-05',
                category: 'karya-ilmiah',
                categoryText: 'Publikasi Karya Ilmiah',
                type: 'artikel',
                typeText: 'Artikel',
                pages: 15,
                publisher: 'Jurnal Sistem Informasi',
                isbn: '',
                fileName: 'sistem-informasi-rs.pdf',
                fileSize: '3.2 MB',
                fileType: 'pdf'
            },
            {
                id: '5',
                title: 'Machine Learning untuk Prediksi Penyakit Jantung',
                authors: [{
                    id: '3',
                    name: 'Dr. Citra Dewi, S.T., M.T.'
                }],
                date: '2021-09-18',
                category: 'buku-ilmiah',
                categoryText: 'Publikasi Buku Ilmiah',
                type: 'buku',
                typeText: 'Buku',
                pages: 320,
                publisher: 'Penerbit Kesehatan',
                isbn: '978-602-8511-45-6',
                fileName: 'ml-penyakit-jantung.docx',
                fileSize: '7.1 MB',
                fileType: 'word'
            }
        ];

        // Initialize sidebar for mobile
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const openSidebar = document.getElementById('openSidebar');
        const closeSidebar = document.getElementById('closeSidebar');

        openSidebar.addEventListener('click', () => {
            sidebar.classList.add('active');
            overlay.style.display = 'block';
        });

        closeSidebar.addEventListener('click', () => {
            sidebar.classList.remove('active');
            overlay.style.display = 'none';
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            overlay.style.display = 'none';
        });

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
                    alert('Format file tidak didukung. Harap unggah file PDF atau Word.');
                    return;
                }

                // Validate file size (max 10MB)
                if (file.size > 10 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar. Maksimal 10MB.');
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
        const confirmationModal = document.getElementById('confirmationModal');
        const closeModal = document.getElementById('closeModal');
        const closeDetailModal = document.getElementById('closeDetailModal');
        const closeConfirmationModal = document.getElementById('closeConfirmationModal');
        const cancelPublication = document.getElementById('cancelPublication');
        const closeDetail = document.getElementById('closeDetail');
        const cancelDelete = document.getElementById('cancelDelete');
        const confirmDelete = document.getElementById('confirmDelete');
        const addPublicationBtn = document.getElementById('addPublicationBtn');
        const publicationForm = document.getElementById('publicationForm');
        const searchInput = document.getElementById('searchInput');

        let publicationToDelete = null;

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

        // Render publications table
        function renderPublications(searchTerm = '', categoryFilter = '', typeFilter = '', yearFilter = '') {
            const tbody = document.querySelector('tbody');
            tbody.innerHTML = '';

            let filteredPublications = [...publications];

            // Apply search
            if (searchTerm) {
                filteredPublications = filteredPublications.filter(pub =>
                    pub.title.toLowerCase().includes(searchTerm) ||
                    pub.authors.some(author => author.name.toLowerCase().includes(searchTerm))
                );
            }

            // Apply filters
            if (categoryFilter) {
                filteredPublications = filteredPublications.filter(pub => pub.category === categoryFilter);
            }

            if (typeFilter) {
                filteredPublications = filteredPublications.filter(pub => pub.type === typeFilter);
            }

            if (yearFilter) {
                filteredPublications = filteredPublications.filter(pub => pub.date.startsWith(yearFilter));
            }

            // Update pagination info
            document.getElementById('totalItems').textContent = filteredPublications.length;
            document.getElementById('startItem').textContent = 1;
            document.getElementById('endItem').textContent = filteredPublications.length;

            if (filteredPublications.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada data publikasi yang ditemukan
                        </td>
                    </tr>
                `;
                return;
            }

            filteredPublications.forEach((pub, index) => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50';

                // Format authors names (just show first author if multiple)
                let authorsDisplay = pub.authors[0].name;
                if (pub.authors.length > 1) {
                    authorsDisplay += ` +${pub.authors.length - 1}`;
                }

                // Format date
                const dateObj = new Date(pub.date);
                const formattedDate = dateObj.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                });

                // File icon
                let fileIcon = '';
                if (pub.fileType === 'pdf') {
                    fileIcon = '<i class="fas fa-file-pdf text-red-500"></i>';
                } else {
                    fileIcon = '<i class="fas fa-file-word text-blue-500"></i>';
                }

                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${index + 1}</td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">${pub.title}</div>
                        <div class="text-xs text-gray-500 mt-1">${pub.publisher}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">${authorsDisplay}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${formattedDate}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${pub.categoryText}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${pub.typeText}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <button class="text-indigo-600 hover:text-indigo-900 view-file" data-id="${pub.id}">
                            ${fileIcon} Lihat
                        </button>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium table-row-actions">
                        <button class="text-indigo-600 hover:text-indigo-900 mr-3 edit-pub" data-id="${pub.id}" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="text-red-600 hover:text-red-900 delete-pub" data-id="${pub.id}" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
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

        // Edit publication
        function editPublication(pubId) {
            const pub = publications.find(p => p.id === pubId);
            if (pub) {
                document.getElementById('modalTitle').textContent = 'Edit Publikasi';
                document.getElementById('publicationId').value = pub.id;
                document.getElementById('publicationTitle').value = pub.title;
                document.getElementById('publicationCategory').value = pub.category;
                document.getElementById('publicationType').value = pub.type;
                document.getElementById('publicationDate').value = pub.date;
                document.getElementById('publicationPages').value = pub.pages;
                document.getElementById('publicationPublisher').value = pub.publisher;
                document.getElementById('publicationISBN').value = pub.isbn;

                // Set authors
                const authorIds = pub.authors.map(a => a.id);
                $('#publicationAuthors').val(authorIds).trigger('change');

                // Simulate file upload (in real app, this would be handled differently)
                fileName.textContent = pub.fileName;
                fileSize.textContent = pub.fileSize;

                if (pub.fileType === 'pdf') {
                    filePreview.querySelector('i').className = 'fas fa-file-pdf text-red-500 text-2xl mr-3';
                } else {
                    filePreview.querySelector('i').className = 'fas fa-file-word text-blue-500 text-2xl mr-3';
                }

                filePreview.classList.remove('hidden');

                openModal();
            }
        }

        // Delete publication
        function deletePublication(pubId) {
            publications = publications.filter(p => p.id !== pubId);
            renderPublications();
        }

        // View publication details
        function viewPublication(pubId) {
            const pub = publications.find(p => p.id === pubId);
            if (pub) {
                document.getElementById('detailTitle').textContent = pub.title;
                document.getElementById('detailCategory').textContent = pub.categoryText;
                document.getElementById('detailType').textContent = pub.typeText;

                // Format date
                const dateObj = new Date(pub.date);
                const formattedDate = dateObj.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
                document.getElementById('detailDate').textContent = formattedDate;

                document.getElementById('detailPublisher').textContent = pub.publisher;
                document.getElementById('detailPages').textContent = pub.pages;
                document.getElementById('detailISBN').textContent = pub.isbn || '-';

                // Set authors
                const authorsContainer = document.getElementById('detailAuthors');
                authorsContainer.innerHTML = '';
                pub.authors.forEach(author => {
                    authorsContainer.innerHTML += `
                        <span class="bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded">${author.name}</span>
                    `;
                });

                // Set file info
                document.getElementById('detailFileName').textContent = pub.fileName;
                document.getElementById('detailFileSize').textContent = pub.fileSize;

                // Change file icon based on type
                const fileIcon = document.querySelector('#detailFile i');
                if (pub.fileType === 'pdf') {
                    fileIcon.className = 'fas fa-file-pdf text-red-500 text-2xl mr-3';
                } else {
                    fileIcon.className = 'fas fa-file-word text-blue-500 text-2xl mr-3';
                }

                // Set download button
                document.getElementById('downloadFileBtn').setAttribute('data-id', pub.id);

                // Set edit button
                document.getElementById('editPublicationBtn').setAttribute('data-id', pub.id);

                openDetailModal();
            }
        }

        // Form submission
        publicationForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const pubId = document.getElementById('publicationId').value;
            const title = document.getElementById('publicationTitle').value;
            const category = document.getElementById('publicationCategory').value;
            const categoryText = document.getElementById('publicationCategory').options[document.getElementById('publicationCategory').selectedIndex].text;
            const type = document.getElementById('publicationType').value;
            const typeText = document.getElementById('publicationType').options[document.getElementById('publicationType').selectedIndex].text;
            const date = document.getElementById('publicationDate').value;
            const pages = document.getElementById('publicationPages').value;
            const publisher = document.getElementById('publicationPublisher').value;
            const isbn = document.getElementById('publicationISBN').value;

            // Get selected authors
            const selectedAuthors = $('#publicationAuthors').val() || [];
            const authors = selectedAuthors.map(id => {
                const name = $(`#publicationAuthors option[value="${id}"]`).text();
                return {
                    id,
                    name
                };
            });

            // Get file info (in a real app, this would handle actual file upload)
            let fileInfo = {
                fileName: 'file.pdf',
                fileSize: '0 KB',
                fileType: 'pdf'
            };

            if (!filePreview.classList.contains('hidden')) {
                fileInfo.fileName = fileName.textContent;
                fileInfo.fileSize = fileSize.textContent;
                fileInfo.fileType = fileName.textContent.includes('.pdf') ? 'pdf' : 'word';
            }

            const pubData = {
                id: pubId || Date.now().toString(),
                title,
                authors,
                date,
                category,
                categoryText,
                type,
                typeText,
                pages,
                publisher,
                isbn,
                fileName: fileInfo.fileName,
                fileSize: fileInfo.fileSize,
                fileType: fileInfo.fileType
            };

            // Update or add publication
            if (pubId) {
                const index = publications.findIndex(p => p.id === pubId);
                if (index !== -1) {
                    publications[index] = pubData;
                }
            } else {
                publications.push(pubData);
            }

            renderPublications();
            closeModalFunc();
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
            const pub = publications.find(p => p.id === pubId);
            if (pub) {
                alert(`Ini akan mengunduh file: ${pub.fileName}\n\nDalam implementasi nyata, ini akan mengunduh file dari server.`);
                // window.location.href = `/download/${pub.id}`;
            }
        });

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            renderPublications();

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