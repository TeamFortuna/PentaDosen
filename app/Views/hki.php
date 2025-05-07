<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HKI - Penta Dosen</title>
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

        .inventor-tag {
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

        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-approved {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-rejected {
            background-color: #fee2e2;
            color: #991b1b;
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
                    <a href="<?= site_url('publikasi') ?>" class="sidebar-item flex items-center px-4 py-3 rounded-lg text-gray-600 hover:text-indigo-600 font-medium">
                        <i class="fas fa-book-open mr-3"></i>
                        Publikasi
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('hki') ?>" class="sidebar-item active flex items-center px-4 py-3 rounded-lg text-white font-medium">
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
                        <i class="fas fa-lightbulb mr-2 text-indigo-500"></i>
                        Manajemen HKI
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
                    <h1 class="text-2xl font-bold text-gray-800">Daftar Hak Kekayaan Intelektual</h1>
                </div>
                <p class="text-gray-600 mb-4">Kelola semua HKI yang telah didaftarkan</p>
                <button id="addHKIBtn" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 flex items-center transition transform hover:-translate-y-0.5">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah HKI
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
                            <input type="text" id="searchInput" class="filter-input pl-10 w-full" placeholder="Cari judul atau inventor...">
                        </div>
                    </div>
                    <div>
                        <select id="filterType" class="filter-input w-full">
                            <option value="">Semua Jenis</option>
                            <option value="paten">Paten</option>
                            <option value="hak-cipta">Hak Cipta</option>
                            <option value="merek">Merek</option>
                            <option value="desain-industri">Desain Industri</option>
                        </select>
                    </div>
                    <div>
                        <select id="filterStatus" class="filter-input w-full">
                            <option value="">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Disetujui</option>
                            <option value="rejected">Ditolak</option>
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
                <div class="mt-4 flex">
                    <button id="exportExcelBtn" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 flex items-center justify-center text-center transition">
                        <i class="fas fa-file-excel mr-2"></i>
                        Export ke Excel
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul HKI</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Inventor</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor</th>
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
                    Menampilkan <span id="startItem">1</span> sampai <span id="endItem">5</span> dari <span id="totalItems">12</span> HKI
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

    <!-- Modal Add/Edit HKI -->
    <div class="modal" id="hkiModal">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden w-full max-w-4xl">
            <div class="px-6 py-4 border-b flex justify-between items-center bg-indigo-600 text-white">
                <h3 class="text-lg font-semibold" id="modalTitle">Tambah HKI Baru</h3>
                <button id="closeModal" class="text-white hover:text-indigo-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <form id="hkiForm">
                    <input type="hidden" id="hkiId">

                    <!-- Section 1: Informasi HKI -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-info-circle mr-2 text-indigo-500"></i>
                            Informasi HKI
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="hkiType" class="block text-sm font-medium text-gray-700 mb-1">Jenis HKI*</label>
                                <select id="hkiType" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" required>
                                    <option value="">Pilih Jenis</option>
                                    <option value="paten">Paten</option>
                                    <option value="hak-cipta">Hak Cipta</option>
                                    <option value="merek">Merek</option>
                                    <option value="desain-industri">Desain Industri</option>
                                    <option value="varietas-tanaman">Varietas Tanaman</option>
                                    <option value="rahasia-dagang">Rahasia Dagang</option>
                                </select>
                            </div>

                            <div>
                                <label for="hkiStatus" class="block text-sm font-medium text-gray-700 mb-1">Status*</label>
                                <select id="hkiStatus" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" required>
                                    <option value="pending">Pending</option>
                                    <option value="approved">Disetujui</option>
                                    <option value="rejected">Ditolak</option>
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label for="hkiTitle" class="block text-sm font-medium text-gray-700 mb-1">Judul HKI*</label>
                                <input type="text" id="hkiTitle" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" required>
                            </div>

                            <div>
                                <label for="hkiDate" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pendaftaran*</label>
                                <input type="date" id="hkiDate" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" required>
                            </div>

                            <div>
                                <label for="hkiNumber" class="block text-sm font-medium text-gray-700 mb-1">Nomor Pendaftaran</label>
                                <input type="text" id="hkiNumber" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                            </div>

                            <div>
                                <label for="hkiCertificateDate" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Sertifikat</label>
                                <input type="date" id="hkiCertificateDate" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                            </div>

                            <div>
                                <label for="hkiCertificateNumber" class="block text-sm font-medium text-gray-700 mb-1">Nomor Sertifikat</label>
                                <input type="text" id="hkiCertificateNumber" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                            </div>
                        </div>
                    </div>

                    <!-- Section 1.1: Inventor Dosen -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-users mr-2 text-indigo-500"></i>
                            Inventor Dosen
                        </h4>

                        <div>
                            <label for="hkiInventors" class="block text-sm font-medium text-gray-700 mb-1">Daftar Inventor*</label>
                            <select id="hkiInventors" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" multiple="multiple" required>
                                <option value="1">Prof. Dr. Andi Wijaya</option>
                                <option value="2">Dr. Budi Santoso, M.Kom</option>
                                <option value="3">Dr. Citra Dewi, S.T., M.T.</option>
                                <option value="4">Dian Pratama, S.Si., M.Si.</option>
                                <option value="5">Eka Putra, S.Kom., M.Kom.</option>
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Anda bisa memilih lebih dari satu inventor</p>
                        </div>

                        <div id="selectedInventors" class="mt-3 flex flex-wrap">
                            <!-- Selected inventors will appear here -->
                        </div>
                    </div>

                    <!-- File Upload -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-file-upload mr-2 text-indigo-500"></i>
                            Upload Dokumen HKI
                        </h4>

                        <div id="dropzone" class="dropzone p-8 text-center cursor-pointer">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-cloud-upload-alt text-4xl text-indigo-400 mb-3"></i>
                                <p class="font-medium text-gray-700">Drag & drop dokumen HKI di sini</p>
                                <p class="text-sm text-gray-500 mt-1">Format file: PDF, Word, atau gambar (maks. 10MB)</p>
                                <button type="button" id="browseFileBtn" class="mt-4 px-4 py-2 bg-indigo-100 text-indigo-600 rounded-lg hover:bg-indigo-200 transition">Atau Pilih File</button>
                            </div>
                            <input type="file" id="hkiFile" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="hidden">
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
                        <button type="button" id="cancelHKI" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">Batal</button>
                        <button type="submit" id="saveHKI" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Simpan HKI</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Detail HKI -->
    <div class="modal" id="detailModal">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden w-full max-w-2xl">
            <div class="px-6 py-4 border-b flex justify-between items-center bg-indigo-600 text-white">
                <h3 class="text-lg font-semibold">Detail HKI</h3>
                <button id="closeDetailModal" class="text-white hover:text-indigo-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <div class="mb-6">
                    <h4 class="text-xl font-bold text-gray-800" id="detailTitle"></h4>
                    <div class="flex items-center mt-2">
                        <span class="text-sm px-2 py-1 rounded-md bg-indigo-100 text-indigo-800" id="detailType"></span>
                        <span class="text-sm px-2 py-1 rounded-md ml-2" id="detailStatus"></span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h5 class="text-sm font-medium text-gray-500 mb-2">Tanggal Pendaftaran</h5>
                        <p id="detailDate" class="text-gray-800"></p>
                    </div>
                    <div>
                        <h5 class="text-sm font-medium text-gray-500 mb-2">Nomor Pendaftaran</h5>
                        <p id="detailNumber" class="text-gray-800"></p>
                    </div>
                    <div>
                        <h5 class="text-sm font-medium text-gray-500 mb-2">Tanggal Sertifikat</h5>
                        <p id="detailCertificateDate" class="text-gray-800"></p>
                    </div>
                    <div>
                        <h5 class="text-sm font-medium text-gray-500 mb-2">Nomor Sertifikat</h5>
                        <p id="detailCertificateNumber" class="text-gray-800"></p>
                    </div>
                </div>

                <div class="mb-6">
                    <h5 class="text-sm font-medium text-gray-500 mb-2">Inventor</h5>
                    <div id="detailInventors" class="flex flex-wrap gap-2">
                        <!-- Inventors will be added here -->
                    </div>
                </div>

                <div class="mb-6">
                    <h5 class="text-sm font-medium text-gray-500 mb-2">Dokumen HKI</h5>
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
                    <button id="editHKIBtn" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Edit</button>
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
                        <h3 class="text-lg font-medium text-gray-900">Hapus HKI</h3>
                        <div class="mt-1 text-sm text-gray-600">
                            Apakah Anda yakin ingin menghapus HKI ini? Data yang dihapus tidak dapat dikembalikan.
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script>
        // Sample data for HKIs
        let hkis = [{
                id: '1',
                title: 'Sistem Diagnosa Penyakit Jantung Berbasis AI',
                inventors: [{
                        id: '1',
                        name: 'Prof. Dr. Andi Wijaya'
                    },
                    {
                        id: '3',
                        name: 'Dr. Citra Dewi, S.T., M.T.'
                    }
                ],
                date: '2023-05-15',
                type: 'paten',
                typeText: 'Paten',
                status: 'approved',
                statusText: 'Disetujui',
                number: 'P00202300001',
                certificateDate: '2023-08-20',
                certificateNumber: 'IDP000123456',
                fileName: 'paten-diagnosa-jantung.pdf',
                fileSize: '2.4 MB',
                fileType: 'pdf'
            },
            {
                id: '2',
                title: 'Aplikasi Mobile untuk Monitoring Kesehatan Ibu Hamil',
                inventors: [{
                    id: '2',
                    name: 'Dr. Budi Santoso, M.Kom'
                }],
                date: '2023-03-22',
                type: 'hak-cipta',
                typeText: 'Hak Cipta',
                status: 'pending',
                statusText: 'Pending',
                number: 'HC00202300045',
                certificateDate: '',
                certificateNumber: '',
                fileName: 'hak-cipta-aplikasi-hamil.docx',
                fileSize: '5.7 MB',
                fileType: 'word'
            },
            {
                id: '3',
                title: 'Desain Kemasan Produk Herbal "Sehat Alami"',
                inventors: [{
                        id: '4',
                        name: 'Dian Pratama, S.Si., M.Si.'
                    },
                    {
                        id: '5',
                        name: 'Eka Putra, S.Kom., M.Kom.'
                    }
                ],
                date: '2023-07-10',
                type: 'desain-industri',
                typeText: 'Desain Industri',
                status: 'rejected',
                statusText: 'Ditolak',
                number: 'DI00202300123',
                certificateDate: '',
                certificateNumber: '',
                fileName: 'desain-kemasan-herbal.jpg',
                fileSize: '3.2 MB',
                fileType: 'image'
            },
            {
                id: '4',
                title: 'Merek Dagang "EduTech" untuk Layanan Pendidikan Digital',
                inventors: [{
                        id: '1',
                        name: 'Prof. Dr. Andi Wijaya'
                    },
                    {
                        id: '5',
                        name: 'Eka Putra, S.Kom., M.Kom.'
                    }
                ],
                date: '2022-11-05',
                type: 'merek',
                typeText: 'Merek',
                status: 'approved',
                statusText: 'Disetujui',
                number: 'M00202200321',
                certificateDate: '2023-01-15',
                certificateNumber: 'IDM000987654',
                fileName: 'sertifikat-merek-edutech.pdf',
                fileSize: '1.8 MB',
                fileType: 'pdf'
            },
            {
                id: '5',
                title: 'Algoritma Prediksi Harga Saham Berbasis Deep Learning',
                inventors: [{
                    id: '3',
                    name: 'Dr. Citra Dewi, S.T., M.T.'
                }],
                date: '2021-09-18',
                type: 'paten',
                typeText: 'Paten',
                status: 'approved',
                statusText: 'Disetujui',
                number: 'P00202100078',
                certificateDate: '2022-03-10',
                certificateNumber: 'IDP000567890',
                fileName: 'paten-algoritma-saham.pdf',
                fileSize: '4.5 MB',
                fileType: 'pdf'
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

        // Initialize Select2 for inventors
        $(document).ready(function() {
            $('#hkiInventors').select2({
                placeholder: "Pilih inventor",
                width: '100%'
            });

            // Update selected inventors display
            $('#hkiInventors').on('change', function() {
                updateSelectedInventors();
            });
        });

        function updateSelectedInventors() {
            const selectedInventors = $('#hkiInventors').val() || [];
            const inventorsContainer = $('#selectedInventors');
            inventorsContainer.empty();

            selectedInventors.forEach(inventorId => {
                const inventorName = $(`#hkiInventors option[value="${inventorId}"]`).text();
                inventorsContainer.append(`
                    <div class="inventor-tag">
                        ${inventorName}
                        <button type="button" class="ml-2 text-indigo-600 hover:text-indigo-800 remove-inventor" data-id="${inventorId}">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `);
            });

            // Add event listeners to remove buttons
            $('.remove-inventor').on('click', function() {
                const inventorId = $(this).data('id');
                $('#hkiInventors option[value="' + inventorId + '"]').prop('selected', false);
                $('#hkiInventors').trigger('change');
            });
        }

        // File upload handling
        const dropzone = document.getElementById('dropzone');
        const fileInput = document.getElementById('hkiFile');
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
                const validTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png'];
                if (!validTypes.includes(file.type)) {
                    alert('Format file tidak didukung. Harap unggah file PDF, Word, atau gambar.');
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
                } else if (file.type.includes('word')) {
                    fileIcon.className = 'fas fa-file-word text-blue-500 text-2xl mr-3';
                } else {
                    fileIcon.className = 'fas fa-file-image text-green-500 text-2xl mr-3';
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
        const hkiModal = document.getElementById('hkiModal');
        const detailModal = document.getElementById('detailModal');
        const confirmationModal = document.getElementById('confirmationModal');
        const closeModal = document.getElementById('closeModal');
        const closeDetailModal = document.getElementById('closeDetailModal');
        const closeConfirmationModal = document.getElementById('closeConfirmationModal');
        const cancelHKI = document.getElementById('cancelHKI');
        const closeDetail = document.getElementById('closeDetail');
        const cancelDelete = document.getElementById('cancelDelete');
        const confirmDelete = document.getElementById('confirmDelete');
        const addHKIBtn = document.getElementById('addHKIBtn');
        const hkiForm = document.getElementById('hkiForm');
        const searchInput = document.getElementById('searchInput');

        let hkiToDelete = null;

        function openModal() {
            hkiModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModalFunc() {
            hkiModal.classList.remove('active');
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

        function openConfirmationModal(hkiId) {
            hkiToDelete = hkiId;
            confirmationModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeConfirmationModalFunc() {
            confirmationModal.classList.remove('active');
            document.body.style.overflow = '';
            hkiToDelete = null;
        }

        closeModal.addEventListener('click', closeModalFunc);
        closeDetailModal.addEventListener('click', closeDetailModalFunc);
        closeConfirmationModal.addEventListener('click', closeConfirmationModalFunc);
        cancelHKI.addEventListener('click', closeModalFunc);
        closeDetail.addEventListener('click', closeDetailModalFunc);
        cancelDelete.addEventListener('click', closeConfirmationModalFunc);

        confirmDelete.addEventListener('click', function() {
            if (hkiToDelete) {
                deleteHKI(hkiToDelete);
                closeConfirmationModalFunc();
            }
        });

        addHKIBtn.addEventListener('click', function() {
            document.getElementById('modalTitle').textContent = 'Tambah HKI Baru';
            openModal();
        });

        function resetForm() {
            hkiForm.reset();
            document.getElementById('hkiId').value = '';
            $('#hkiInventors').val(null).trigger('change');
            fileInput.value = '';
            filePreview.classList.add('hidden');
        }

        // Filter functions
        function applyFilters() {
            const searchTerm = searchInput.value.toLowerCase();
            const typeFilter = document.getElementById('filterType').value;
            const statusFilter = document.getElementById('filterStatus').value;
            const yearFilter = document.getElementById('filterYear').value;

            renderHKIs(searchTerm, typeFilter, statusFilter, yearFilter);
        }

        // Add event listeners to filters
        document.getElementById('filterType').addEventListener('change', applyFilters);
        document.getElementById('filterStatus').addEventListener('change', applyFilters);
        document.getElementById('filterYear').addEventListener('change', applyFilters);
        searchInput.addEventListener('input', applyFilters);

        // Render HKIs table
        function renderHKIs(searchTerm = '', typeFilter = '', statusFilter = '', yearFilter = '') {
            const tbody = document.querySelector('tbody');
            tbody.innerHTML = '';

            let filteredHKIs = [...hkis];

            // Apply search
            if (searchTerm) {
                filteredHKIs = filteredHKIs.filter(hki =>
                    hki.title.toLowerCase().includes(searchTerm) ||
                    hki.inventors.some(inventor => inventor.name.toLowerCase().includes(searchTerm))
                );
            }

            // Apply filters
            if (typeFilter) {
                filteredHKIs = filteredHKIs.filter(hki => hki.type === typeFilter);
            }

            if (statusFilter) {
                filteredHKIs = filteredHKIs.filter(hki => hki.status === statusFilter);
            }

            if (yearFilter) {
                filteredHKIs = filteredHKIs.filter(hki => hki.date.startsWith(yearFilter));
            }

            // Update pagination info
            document.getElementById('totalItems').textContent = filteredHKIs.length;
            document.getElementById('startItem').textContent = 1;
            document.getElementById('endItem').textContent = filteredHKIs.length;

            if (filteredHKIs.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada data HKI yang ditemukan
                        </td>
                    </tr>
                `;
                return;
            }

            filteredHKIs.forEach((hki, index) => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50';

                // Format inventors names (just show first inventor if multiple)
                let inventorsDisplay = hki.inventors[0].name;
                if (hki.inventors.length > 1) {
                    inventorsDisplay += ` +${hki.inventors.length - 1}`;
                }

                // Format date
                const dateObj = new Date(hki.date);
                const formattedDate = dateObj.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                });

                // Status badge
                let statusClass = '';
                if (hki.status === 'pending') {
                    statusClass = 'status-pending';
                } else if (hki.status === 'approved') {
                    statusClass = 'status-approved';
                } else {
                    statusClass = 'status-rejected';
                }

                // File icon
                let fileIcon = '';
                if (hki.fileType === 'pdf') {
                    fileIcon = '<i class="fas fa-file-pdf text-red-500"></i>';
                } else if (hki.fileType === 'word') {
                    fileIcon = '<i class="fas fa-file-word text-blue-500"></i>';
                } else {
                    fileIcon = '<i class="fas fa-file-image text-green-500"></i>';
                }

                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${index + 1}</td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">${hki.title}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">${inventorsDisplay}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${formattedDate}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${hki.typeText}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="status-badge ${statusClass}">${hki.statusText}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${hki.number || '-'}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium table-row-actions">
                        <button class="text-indigo-600 hover:text-indigo-900 mr-3 edit-hki" data-id="${hki.id}" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="text-red-600 hover:text-red-900 delete-hki" data-id="${hki.id}" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;

                tbody.appendChild(row);
            });

            // Add event listeners to buttons
            document.querySelectorAll('.edit-hki').forEach(btn => {
                btn.addEventListener('click', function() {
                    const hkiId = this.getAttribute('data-id');
                    editHKI(hkiId);
                });
            });

            document.querySelectorAll('.delete-hki').forEach(btn => {
                btn.addEventListener('click', function() {
                    const hkiId = this.getAttribute('data-id');
                    openConfirmationModal(hkiId);
                });
            });

            document.querySelectorAll('.view-file').forEach(btn => {
                btn.addEventListener('click', function() {
                    const hkiId = this.getAttribute('data-id');
                    viewHKI(hkiId);
                });
            });
        }

        // Edit HKI
        function editHKI(hkiId) {
            const hki = hkis.find(h => h.id === hkiId);
            if (hki) {
                document.getElementById('modalTitle').textContent = 'Edit HKI';
                document.getElementById('hkiId').value = hki.id;
                document.getElementById('hkiTitle').value = hki.title;
                document.getElementById('hkiType').value = hki.type;
                document.getElementById('hkiStatus').value = hki.status;
                document.getElementById('hkiDate').value = hki.date;
                document.getElementById('hkiNumber').value = hki.number || '';
                document.getElementById('hkiCertificateDate').value = hki.certificateDate || '';
                document.getElementById('hkiCertificateNumber').value = hki.certificateNumber || '';

                // Set inventors
                const inventorIds = hki.inventors.map(i => i.id);
                $('#hkiInventors').val(inventorIds).trigger('change');

                // Simulate file upload (in real app, this would be handled differently)
                fileName.textContent = hki.fileName;
                fileSize.textContent = hki.fileSize;

                if (hki.fileType === 'pdf') {
                    filePreview.querySelector('i').className = 'fas fa-file-pdf text-red-500 text-2xl mr-3';
                } else if (hki.fileType === 'word') {
                    filePreview.querySelector('i').className = 'fas fa-file-word text-blue-500 text-2xl mr-3';
                } else {
                    filePreview.querySelector('i').className = 'fas fa-file-image text-green-500 text-2xl mr-3';
                }

                filePreview.classList.remove('hidden');

                openModal();
            }
        }

        // Delete HKI
        function deleteHKI(hkiId) {
            hkis = hkis.filter(h => h.id !== hkiId);
            renderHKIs();
        }

        // View HKI details
        function viewHKI(hkiId) {
            const hki = hkis.find(h => h.id === hkiId);
            if (hki) {
                document.getElementById('detailTitle').textContent = hki.title;
                document.getElementById('detailType').textContent = hki.typeText;

                // Set status with appropriate class
                const statusElement = document.getElementById('detailStatus');
                statusElement.textContent = hki.statusText;
                statusElement.className = 'text-sm px-2 py-1 rounded-md ml-2 ';
                if (hki.status === 'pending') {
                    statusElement.className += 'status-pending';
                } else if (hki.status === 'approved') {
                    statusElement.className += 'status-approved';
                } else {
                    statusElement.className += 'status-rejected';
                }

                // Format dates
                const dateObj = new Date(hki.date);
                const formattedDate = dateObj.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
                document.getElementById('detailDate').textContent = formattedDate;

                document.getElementById('detailNumber').textContent = hki.number || '-';

                if (hki.certificateDate) {
                    const certDateObj = new Date(hki.certificateDate);
                    const formattedCertDate = certDateObj.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });
                    document.getElementById('detailCertificateDate').textContent = formattedCertDate;
                } else {
                    document.getElementById('detailCertificateDate').textContent = '-';
                }

                document.getElementById('detailCertificateNumber').textContent = hki.certificateNumber || '-';

                // Set inventors
                const inventorsContainer = document.getElementById('detailInventors');
                inventorsContainer.innerHTML = '';
                hki.inventors.forEach(inventor => {
                    inventorsContainer.innerHTML += `
                        <span class="bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded">${inventor.name}</span>
                    `;
                });

                // Set file info
                document.getElementById('detailFileName').textContent = hki.fileName;
                document.getElementById('detailFileSize').textContent = hki.fileSize;

                // Change file icon based on type
                const fileIcon = document.querySelector('#detailFile i');
                if (hki.fileType === 'pdf') {
                    fileIcon.className = 'fas fa-file-pdf text-red-500 text-2xl mr-3';
                } else if (hki.fileType === 'word') {
                    fileIcon.className = 'fas fa-file-word text-blue-500 text-2xl mr-3';
                } else {
                    fileIcon.className = 'fas fa-file-image text-green-500 text-2xl mr-3';
                }

                // Set download button
                document.getElementById('downloadFileBtn').setAttribute('data-id', hki.id);

                // Set edit button
                document.getElementById('editHKIBtn').setAttribute('data-id', hki.id);

                openDetailModal();
            }
        }

        // Form submission
        hkiForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const hkiId = document.getElementById('hkiId').value;
            const title = document.getElementById('hkiTitle').value;
            const type = document.getElementById('hkiType').value;
            const typeText = document.getElementById('hkiType').options[document.getElementById('hkiType').selectedIndex].text;
            const status = document.getElementById('hkiStatus').value;
            const statusText = document.getElementById('hkiStatus').options[document.getElementById('hkiStatus').selectedIndex].text;
            const date = document.getElementById('hkiDate').value;
            const number = document.getElementById('hkiNumber').value;
            const certificateDate = document.getElementById('hkiCertificateDate').value;
            const certificateNumber = document.getElementById('hkiCertificateNumber').value;

            // Get selected inventors
            const selectedInventors = $('#hkiInventors').val() || [];
            const inventors = selectedInventors.map(id => {
                const name = $(`#hkiInventors option[value="${id}"]`).text();
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
                if (fileName.textContent.includes('.pdf')) {
                    fileInfo.fileType = 'pdf';
                } else if (fileName.textContent.includes('.doc')) {
                    fileInfo.fileType = 'word';
                } else {
                    fileInfo.fileType = 'image';
                }
            }

            const hkiData = {
                id: hkiId || Date.now().toString(),
                title,
                inventors,
                date,
                type,
                typeText,
                status,
                statusText,
                number,
                certificateDate,
                certificateNumber,
                fileName: fileInfo.fileName,
                fileSize: fileInfo.fileSize,
                fileType: fileInfo.fileType
            };

            // Update or add HKI
            if (hkiId) {
                const index = hkis.findIndex(h => h.id === hkiId);
                if (index !== -1) {
                    hkis[index] = hkiData;
                }
            } else {
                hkis.push(hkiData);
            }

            renderHKIs();
            closeModalFunc();
        });

        // Edit button in detail modal
        document.getElementById('editHKIBtn').addEventListener('click', function() {
            const hkiId = this.getAttribute('data-id');
            closeDetailModalFunc();
            editHKI(hkiId);
        });

        // Download button in detail modal
        document.getElementById('downloadFileBtn').addEventListener('click', function() {
            const hkiId = this.getAttribute('data-id');
            const hki = hkis.find(h => h.id === hkiId);
            if (hki) {
                alert(`Ini akan mengunduh file: ${hki.fileName}\n\nDalam implementasi nyata, ini akan mengunduh file dari server.`);
                // window.location.href = `/download/${hki.id}`;
            }
        });

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            renderHKIs();
        });

        // Export to Excel
        document.getElementById('exportExcelBtn').addEventListener('click', function() {
            // Ambil data yang sedang ditampilkan di tabel
            const rows = [];
            const headers = [
                "No", "Judul HKI", "Inventor", "Tanggal", "Jenis", "Status", "Nomor"
            ];
            rows.push(headers);

            // Ambil data yang sudah difilter
            const searchTerm = searchInput.value.toLowerCase();
            const typeFilter = document.getElementById('filterType').value;
            const statusFilter = document.getElementById('filterStatus').value;
            const yearFilter = document.getElementById('filterYear').value;

            let filteredHKIs = [...hkis];
            if (searchTerm) {
                filteredHKIs = filteredHKIs.filter(hki =>
                    hki.title.toLowerCase().includes(searchTerm) ||
                    hki.inventors.some(inventor => inventor.name.toLowerCase().includes(searchTerm))
                );
            }
            if (typeFilter) filteredHKIs = filteredHKIs.filter(hki => hki.type === typeFilter);
            if (statusFilter) filteredHKIs = filteredHKIs.filter(hki => hki.status === statusFilter);
            if (yearFilter) filteredHKIs = filteredHKIs.filter(hki => hki.date.startsWith(yearFilter));

            filteredHKIs.forEach((hki, index) => {
                let inventorsDisplay = hki.inventors.map(i => i.name).join(', ');
                const dateObj = new Date(hki.date);
                const formattedDate = dateObj.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                });
                rows.push([
                    index + 1,
                    hki.title,
                    inventorsDisplay,
                    formattedDate,
                    hki.typeText,
                    hki.statusText,
                    hki.number || '-'
                ]);
            });

            // Buat worksheet dan workbook
            const ws = XLSX.utils.aoa_to_sheet(rows);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Data HKI");

            // Download file
            XLSX.writeFile(wb, "data_hki.xlsx");
        });
    </script>
</body>

</html>