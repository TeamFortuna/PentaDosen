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

        .sidebar-container {
            position: relative;
            z-index: 20;
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

        /* Notification Styles */
        .notification-container {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 9999;
            width: 320px;
            max-width: 100%;
        }

        .notification {
            position: relative;
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 0.5rem;
            color: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            animation: slideIn 0.3s ease-out forwards;
            display: flex;
            align-items: center;
        }

        .notification.success {
            background-color: var(--success);
        }

        .notification.error {
            background-color: var(--danger);
        }

        .notification.warning {
            background-color: var(--warning);
        }

        .notification.info {
            background-color: var(--primary);
        }

        .notification-icon {
            margin-right: 0.75rem;
            font-size: 1.25rem;
        }

        .notification-content {
            flex: 1;
        }

        .notification-title {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .notification-message {
            font-size: 0.875rem;
        }

        .notification-close {
            margin-left: 0.75rem;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.2s;
        }

        .notification-close:hover {
            opacity: 1;
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

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        .notification.hide {
            animation: slideOut 0.3s ease-in forwards;
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

            .notification-container {
                width: 90%;
                left: 5%;
                right: 5%;
                top: 1rem;
            }
        }
    </style>
</head>

<body class="flex h-screen overflow-hidden bg-gray-50">
    <!-- Notification Container -->
    <div class="notification-container" id="notificationContainer"></div>

    <!-- Overlay (for mobile sidebar) -->
    <div class="overlay" id="overlay" style="display: none;"></div>

    <!-- Modal Overlay -->
    <div class="modal-overlay" id="modalOverlay"></div>

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
                        <i class="fas fa-lightbulb mr-2 text-indigo-500"></i>
                        Manajemen HKI
                    </h2>
                </div>
                <div class="flex items-center space-x-4">
                    <button id="notificationBell" class="p-2 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 transition relative">
                        <i class="fas fa-bell"></i>
                        <span id="notificationCount" class="absolute -top-1 -right-1 bg-indigo-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center hidden">0</span>
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
                            <?php if (isset($hkis) && count($hkis) > 0): ?>
                                <?php foreach ($hkis as $i => $hki): ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $i + 1 ?></td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900 cursor-pointer text-indigo-600 hover:underline hki-title" data-id="<?= $hki['id'] ?>">
                                                <?= esc($hki['judul']) ?>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500"><?= esc($hki['nama_pencipta']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?= date('d M Y', strtotime($hki['tanggal_permohonan'])) ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= esc(ucwords(str_replace('-', ' ', $hki['jenis']))) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="status-badge status-<?= esc($hki['status']) ?>">
                                                <?= $hki['status'] == 'approved' ? 'Disetujui' : ($hki['status'] == 'pending' ? 'Pending' : 'Ditolak') ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= esc($hki['nomor_permohonan']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium table-row-actions">
                                            <button class="text-indigo-600 hover:text-indigo-900 mr-3 edit-hki" data-id="<?= $hki['id'] ?>" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="text-red-600 hover:text-red-900 delete-hki" data-id="<?= $hki['id'] ?>" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                        Tidak ada data HKI yang ditemukan
                                    </td>
                                </tr>
                            <?php endif; ?>
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
            <div class="px-6 py-4 border-b flex justify-between items-center bg-indigo-600 text-white sticky top-0 z-10">
                <h3 class="text-lg font-semibold" id="modalTitle">Tambah HKI Baru</h3>
                <button id="closeModal" class="text-white hover:text-indigo-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6 max-h-[90vh] overflow-y-auto">
                <form id="hkiForm" enctype="multipart/form-data">
                    <input type="hidden" id="hkiId" name="id">

                    <!-- Section 1: Informasi HKI -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-info-circle mr-2 text-indigo-500"></i>
                            Informasi HKI
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="hkiTitle" class="block text-sm font-medium text-gray-700 mb-1">Judul Ciptaan*</label>
                                <input type="text" id="hkiTitle" name="judul" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" required>
                            </div>
                            <div>
                                <label for="hkiType" class="block text-sm font-medium text-gray-700 mb-1">Jenis Ciptaan*</label>
                                <select id="hkiType" name="jenis" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" required>
                                    <option value="">Pilih Jenis</option>
                                    <option value="hak-cipta">Hak Cipta</option>
                                    <option value="paten">Paten</option>
                                    <option value="merek">Merek</option>
                                    <option value="desain-industri">Desain Industri</option>
                                    <option value="rahasia-dagang">Rahasia Dagang</option>
                                    <option value="dtlst">DTLST</option>
                                </select>
                            </div>
                            <div>
                                <label for="hkiNumber" class="block text-sm font-medium text-gray-700 mb-1">Nomor Permohonan*</label>
                                <input type="text" id="hkiNumber" name="nomor_permohonan" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" required>
                            </div>
                            <div>
                                <label for="hkiDate" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Permohonan*</label>
                                <input type="date" id="hkiDate" name="tanggal_permohonan" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" required>
                            </div>
                            <div>
                                <label for="hkiPlace" class="block text-sm font-medium text-gray-700 mb-1">Tempat Diumumkan Pertama Kali*</label>
                                <input type="text" id="hkiPlace" name="tempat_diumumkan" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" required>
                            </div>
                            <div>
                                <label for="hkiAnnounceDate" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Diumumkan Pertama Kali*</label>
                                <input type="date" id="hkiAnnounceDate" name="tanggal_diumumkan" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" required>
                            </div>
                            <div>
                                <label for="hkiRegistrationNumber" class="block text-sm font-medium text-gray-700 mb-1">Nomor Pencatatan</label>
                                <input type="text" id="hkiRegistrationNumber" name="nomor_pencatatan" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                            </div>
                            <div>
                                <label for="hkiStatus" class="block text-sm font-medium text-gray-700 mb-1">Status HKI*</label>
                                <select id="hkiStatus" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" required>
                                    <option value="pending">Pending</option>
                                    <option value="approved">Disetujui</option>
                                    <option value="rejected">Ditolak</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Section 1.1: Pencipta dan Pemegang -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-users mr-2 text-indigo-500"></i>
                            Pencipta dan Pemegang
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="hkiCreator" class="block text-sm font-medium text-gray-700 mb-1">Nama Pencipta*</label>
                                <select id="hkiCreator" name="pencipta_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" required>
                                    <option value="">Pilih Pencipta</option>
                                    <?php if (isset($users) && !empty($users)): ?>
                                        <?php foreach ($users as $dosen): ?>
                                            <option value="<?= $dosen['id'] ?>"><?= $dosen['nama'] ?> - <?= $dosen['nidn'] ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div>
                                <label for="hkiHolder" class="block text-sm font-medium text-gray-700 mb-1">Nama Pemegang*</label>
                                <select id="hkiHolder" name="pemegang_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" required>
                                    <option value="">Pilih Pemegang</option>
                                    <?php if (isset($users) && !empty($users)): ?>
                                        <?php foreach ($users as $dosen): ?>
                                            <option value="<?= $dosen['id'] ?>"><?= $dosen['nama'] ?> - <?= $dosen['nidn'] ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
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
                                <i class="fas fa-cloud-upload-alt text-3xl text-indigo-400 mb-2"></i>
                                <p class="font-medium text-gray-700 text-sm">Drag & drop dokumen HKI di sini</p>
                                <p class="text-xs text-gray-500 mt-1">Format file: PDF, Word, atau gambar (maks. 10MB)</p>
                                <button type="button" id="browseFileBtn" class="mt-2 px-3 py-1 bg-indigo-100 text-indigo-600 rounded-lg hover:bg-indigo-200 transition text-sm">Atau Pilih File</button>
                            </div>
                            <input type="file" id="hkiFile" name="file_hki" accept=".pdf,.doc,.docx" class="hidden">
                        </div>
                        <div id="filePreview" class="mt-4 hidden">
                            <div class="flex items-center justify-between bg-gray-50 p-2 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-file-pdf text-red-500 text-xl mr-2"></i>
                                    <div>
                                        <p id="fileName" class="font-medium text-sm"></p>
                                        <p id="fileSize" class="text-xs text-gray-500"></p>
                                    </div>
                                </div>
                                <button type="button" id="removeFileBtn" class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 pt-4 border-t bg-white sticky bottom-0 z-10">
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

    <!-- Notification Events Modal -->
    <div class="modal" id="notificationModal">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden w-full max-w-md">
            <div class="px-6 py-4 border-b flex justify-between items-center bg-indigo-600 text-white">
                <h3 class="text-lg font-semibold">Daftar Acara Mendatang</h3>
                <button id="closeNotificationModal" class="text-white hover:text-indigo-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-4 max-h-96 overflow-y-auto" id="eventsList">
                <!-- Daftar acara akan dimuat di sini -->
                <div class="text-center py-4 text-gray-500">
                    <i class="fas fa-spinner fa-spin mr-2"></i> Memuat acara...
                </div>
            </div>
            <div class="px-6 py-3 border-t flex justify-end">
                <button id="closeNotificationBtn" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Include Sidebar Script -->
    <script src="<?= base_url('js/sidebar-script.js') ?>"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script>
        // Notification System
        function showNotification(type, title, message, duration = 5000) {
            const container = document.getElementById('notificationContainer');
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;

            let icon;
            switch (type) {
                case 'success':
                    icon = 'fa-check-circle';
                    break;
                case 'error':
                    icon = 'fa-exclamation-circle';
                    break;
                case 'warning':
                    icon = 'fa-exclamation-triangle';
                    break;
                default:
                    icon = 'fa-info-circle';
            }

            notification.innerHTML = `
                <div class="notification-icon">
                    <i class="fas ${icon}"></i>
                </div>
                <div class="notification-content">
                    <div class="notification-title">${title}</div>
                    <div class="notification-message">${message}</div>
                </div>
                <div class="notification-close">
                    <i class="fas fa-times"></i>
                </div>
            `;

            container.appendChild(notification);

            // Auto remove after duration
            const timer = setTimeout(() => {
                notification.classList.add('hide');
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, duration);

            // Close button
            const closeBtn = notification.querySelector('.notification-close');
            closeBtn.addEventListener('click', () => {
                clearTimeout(timer);
                notification.classList.add('hide');
                setTimeout(() => {
                    notification.remove();
                }, 300);
            });
        }

        // Initialize Select2 for select elements
        $(document).ready(function() {
            $('#hkiCreator').select2();
            $('#hkiHolder').select2();
        });

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
                    showNotification('error', 'Error', 'Format file tidak didukung. Harap unggah file PDF, Word, atau gambar.');
                    return;
                }

                // Validate file size (max 10MB)
                if (file.size > 10 * 1024 * 1024) {
                    showNotification('error', 'Error', 'Ukuran file terlalu besar. Maksimal 10MB.');
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
                    fileIcon.className = 'fas fa-file-pdf text-red-500 text-xl mr-2';
                } else if (file.type.includes('word')) {
                    fileIcon.className = 'fas fa-file-word text-blue-500 text-xl mr-2';
                } else {
                    fileIcon.className = 'fas fa-file-image text-green-500 text-xl mr-2';
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
        const notificationModal = document.getElementById('notificationModal');
        const closeModal = document.getElementById('closeModal');
        const closeDetailModal = document.getElementById('closeDetailModal');
        const closeConfirmationModal = document.getElementById('closeConfirmationModal');
        const closeNotificationModal = document.getElementById('closeNotificationModal');
        const closeNotificationBtn = document.getElementById('closeNotificationBtn');
        const cancelHKI = document.getElementById('cancelHKI');
        const closeDetail = document.getElementById('closeDetail');
        const cancelDelete = document.getElementById('cancelDelete');
        const confirmDelete = document.getElementById('confirmDelete');
        const addHKIBtn = document.getElementById('addHKIBtn');
        const hkiForm = document.getElementById('hkiForm');
        const searchInput = document.getElementById('searchInput');
        const notificationBell = document.getElementById('notificationBell');

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

        function openNotificationModal() {
            notificationModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeNotificationModalFunc() {
            notificationModal.classList.remove('active');
            document.body.style.overflow = '';
        }

        closeModal.addEventListener('click', closeModalFunc);
        closeDetailModal.addEventListener('click', closeDetailModalFunc);
        closeConfirmationModal.addEventListener('click', closeConfirmationModalFunc);
        closeNotificationModal.addEventListener('click', closeNotificationModalFunc);
        closeNotificationBtn.addEventListener('click', closeNotificationModalFunc);
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

        // Notification Bell Functionality
        notificationBell.addEventListener('click', openNotificationModal);

        // Simpan data detail terakhir yang diambil untuk kebutuhan edit
        let lastDetailData = null;

        // Handle click on HKI title to show detail modal
        $(document).on('click', '.hki-title', function() {
            const hkiId = $(this).data('id');
            $.ajax({
                url: '<?= site_url('hki/detail') ?>/' + hkiId,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        const data = response.data;
                        lastDetailData = data; // simpan untuk edit
                        // Set detail modal fields
                        $('#detailTitle').text(data.judul);
                        $('#detailType').text(data.jenis ? data.jenis.replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase()) : '');
                        $('#detailStatus')
                            .text(data.status === 'approved' ? 'Disetujui' : (data.status === 'pending' ? 'Pending' : 'Ditolak'))
                            .removeClass().addClass('text-sm px-2 py-1 rounded-md ml-2')
                            .addClass(data.status === 'approved' ? 'bg-green-100 text-green-800' : (data.status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'));
                        $('#detailDate').text(data.tanggal_permohonan ? formatDate(data.tanggal_permohonan) : '-');
                        $('#detailNumber').text(data.nomor_permohonan || '-');
                        $('#detailCertificateDate').text(data.tanggal_diumumkan ? formatDate(data.tanggal_diumumkan) : '-');
                        $('#detailCertificateNumber').text(data.nomor_pencatatan || '-');
                        // Inventor
                        $('#detailInventors').html('');
                        if (data.nama_pencipta) {
                            $('#detailInventors').append('<span class="inventor-tag">' + data.nama_pencipta + '</span>');
                        }
                        // File
                        if (data.file_path) {
                            const fileName = data.file_path.split('/').pop();
                            $('#detailFileName').text(fileName);
                            $('#detailFileSize').text('-');
                            $('#downloadFileBtn').off('click').on('click', function() {
                                window.open('<?= base_url() ?>/' + data.file_path, '_blank');
                            });
                        } else {
                            $('#detailFileName').text('-');
                            $('#detailFileSize').text('-');
                            $('#downloadFileBtn').off('click');
                        }
                        openDetailModal();
                    } else {
                        showNotification('error', 'Error', response.message || 'Gagal mengambil detail data.');
                    }
                },
                error: function() {
                    showNotification('error', 'Error', 'Terjadi kesalahan saat mengambil detail data.');
                }
            });
        });

        // Fitur Edit langsung dari tabel (tombol edit)
        $(document).on('click', '.edit-hki', function() {
            const hkiId = $(this).data('id');
            $.ajax({
                url: '<?= site_url('hki/detail') ?>/' + hkiId,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        const data = response.data;
                        // Isi form edit
                        $('#modalTitle').text('Edit HKI');
                        $('#hkiId').val(data.id);
                        $('#hkiTitle').val(data.judul);
                        $('#hkiType').val(data.jenis);
                        $('#hkiNumber').val(data.nomor_permohonan);
                        $('#hkiDate').val(data.tanggal_permohonan);
                        $('#hkiPlace').val(data.tempat_diumumkan);
                        $('#hkiAnnounceDate').val(data.tanggal_diumumkan);
                        $('#hkiRegistrationNumber').val(data.nomor_pencatatan);
                        $('#hkiStatus').val(data.status);
                        $('#hkiCreator').val(data.pencipta_id);
                        $('#hkiHolder').val(data.pemegang_id);

                        // File preview (jika ada file)
                        if (data.file_path) {
                            const fileNameOnly = data.file_path.split('/').pop();
                            $('#fileName').text(fileNameOnly);
                            $('#fileSize').text('-');
                            $('#filePreview').removeClass('hidden');
                            // Icon
                            const ext = fileNameOnly.split('.').pop().toLowerCase();
                            const fileIcon = $('#filePreview').find('i');
                            if (ext === 'pdf') {
                                fileIcon.attr('class', 'fas fa-file-pdf text-red-500 text-xl mr-2');
                            } else if (ext === 'doc' || ext === 'docx') {
                                fileIcon.attr('class', 'fas fa-file-word text-blue-500 text-xl mr-2');
                            } else {
                                fileIcon.attr('class', 'fas fa-file-image text-green-500 text-xl mr-2');
                            }
                        } else {
                            $('#filePreview').addClass('hidden');
                            $('#fileName').text('');
                            $('#fileSize').text('');
                        }
                        // Kosongkan input file (user bisa upload file baru jika ingin)
                        $('#hkiFile').val('');

                        // Buka modal
                        hkiModal.classList.add('active');
                        document.body.style.overflow = 'hidden';
                    } else {
                        showNotification('error', 'Error', response.message || 'Gagal mengambil data untuk edit.');
                    }
                },
                error: function() {
                    showNotification('error', 'Error', 'Terjadi kesalahan saat mengambil data untuk edit.');
                }
            });
        });

        // Fitur Edit dari modal detail
        $('#editHKIBtn').on('click', function() {
            if (!lastDetailData) return;
            // Tutup modal detail
            closeDetailModalFunc();

            // Isi form edit
            $('#modalTitle').text('Edit HKI');
            $('#hkiId').val(lastDetailData.id);
            $('#hkiTitle').val(lastDetailData.judul);
            $('#hkiType').val(lastDetailData.jenis);
            $('#hkiNumber').val(lastDetailData.nomor_permohonan);
            $('#hkiDate').val(lastDetailData.tanggal_permohonan);
            $('#hkiPlace').val(lastDetailData.tempat_diumumkan);
            $('#hkiAnnounceDate').val(lastDetailData.tanggal_diumumkan);
            $('#hkiRegistrationNumber').val(lastDetailData.nomor_pencatatan);
            $('#hkiStatus').val(lastDetailData.status);
            $('#hkiCreator').val(lastDetailData.pencipta_id);
            $('#hkiHolder').val(lastDetailData.pemegang_id);

            // File preview (jika ada file)
            if (lastDetailData.file_path) {
                const fileNameOnly = lastDetailData.file_path.split('/').pop();
                $('#fileName').text(fileNameOnly);
                $('#fileSize').text('-');
                $('#filePreview').removeClass('hidden');
                // Icon
                const ext = fileNameOnly.split('.').pop().toLowerCase();
                const fileIcon = $('#filePreview').find('i');
                if (ext === 'pdf') {
                    fileIcon.attr('class', 'fas fa-file-pdf text-red-500 text-xl mr-2');
                } else if (ext === 'doc' || ext === 'docx') {
                    fileIcon.attr('class', 'fas fa-file-word text-blue-500 text-xl mr-2');
                } else {
                    fileIcon.attr('class', 'fas fa-file-image text-green-500 text-xl mr-2');
                }
            } else {
                $('#filePreview').addClass('hidden');
                $('#fileName').text('');
                $('#fileSize').text('');
            }
            // Kosongkan input file (user bisa upload file baru jika ingin)
            $('#hkiFile').val('');

            openModal();
        });

        // Saat modal edit dibuka manual (bukan dari edit), reset lastDetailData
        $('#addHKIBtn').on('click', function() {
            lastDetailData = null;
        });

        // Saat modal edit ditutup, reset form
        function resetForm() {
            hkiForm.reset();
            document.getElementById('hkiId').value = '';
            $('#hkiFile').val('');
            $('#filePreview').addClass('hidden');
            $('#fileName').text('');
            $('#fileSize').text('');
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

        // Export to Excel
        document.getElementById('exportExcelBtn').addEventListener('click', function() {
            // Ambil data dari tabel HTML
            const table = document.querySelector('table');
            const rows = [];
            // Ambil header
            const headers = [];
            table.querySelectorAll('thead th').forEach(th => {
                headers.push(th.innerText.trim());
            });
            rows.push(headers);

            // Ambil data body
            table.querySelectorAll('tbody tr').forEach(tr => {
                const row = [];
                tr.querySelectorAll('td').forEach(td => {
                    row.push(td.innerText.trim());
                });
                // Hanya tambahkan baris jika jumlah kolom sesuai header (hindari baris "tidak ada data")
                if (row.length === headers.length) {
                    rows.push(row);
                }
            });

            // Buat worksheet dan workbook
            const ws = XLSX.utils.aoa_to_sheet(rows);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Data HKI");

            // Download file
            XLSX.writeFile(wb, "data_hki.xlsx");
        });

        // Fungsi hapus HKI
        function deleteHKI(hkiId) {
            $.ajax({
                url: '<?= site_url('hki/delete') ?>/' + hkiId,
                type: 'DELETE',
                dataType: 'json',
                beforeSend: function() {
                    $('#confirmDelete').prop('disabled', true).text('Menghapus...');
                },
                success: function(response) {
                    $('#confirmDelete').prop('disabled', false).text('Hapus');
                    if (response.status === 'success') {
                        showNotification('success', 'Sukses', response.message);
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    } else {
                        showNotification('error', 'Error', response.message || 'Gagal menghapus data.');
                    }
                },
                error: function() {
                    $('#confirmDelete').prop('disabled', false).text('Hapus');
                    showNotification('error', 'Error', 'Terjadi kesalahan saat menghapus data.');
                }
            });
        }

        // Event listener tombol delete di tabel
        $(document).on('click', '.delete-hki', function() {
            const hkiId = $(this).data('id');
            openConfirmationModal(hkiId);
        });

        // Submit form HKI via AJAX
        $('#hkiForm').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            const hkiFileInput = document.getElementById('hkiFile');
            if (hkiFileInput.files.length > 0) {
                formData.append('file_hki', hkiFileInput.files[0]);
            }

            $('#saveHKI').prop('disabled', true).text('Menyimpan...');

            $.ajax({
                url: '<?= site_url('hki/save') ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    $('#saveHKI').prop('disabled', false).text('Simpan HKI');
                    if (response.status === 'success') {
                        showNotification('success', 'Sukses', response.message);
                        setTimeout(() => {
                            closeModalFunc();
                            location.reload();
                        }, 1500);
                    } else {
                        let msg = '';
                        if (typeof response.message === 'object') {
                            for (const key in response.message) {
                                msg += response.message[key] + "\n";
                            }
                        } else {
                            msg = response.message;
                        }
                        showNotification('error', 'Error', msg);
                    }
                },
                error: function() {
                    $('#saveHKI').prop('disabled', false).text('Simpan HKI');
                    showNotification('error', 'Error', 'Terjadi kesalahan saat menyimpan data.');
                }
            });
        });

        function formatDate(dateStr) {
            if (!dateStr) return '-';
            const date = new Date(dateStr);
            if (isNaN(date)) return dateStr;
            const options = {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            };
            return date.toLocaleDateString('id-ID', options);
        }

        // Load upcoming events for notification
        function loadUpcomingEvents() {
            const eventsList = document.getElementById('eventsList');
            eventsList.innerHTML = '<div class="text-center py-4 text-gray-500"><i class="fas fa-spinner fa-spin mr-2"></i> Memuat acara...</div>';

            // Get today's date and 7 days from now
            const today = new Date();
            const nextWeek = new Date();
            nextWeek.setDate(today.getDate() + 7);

            const startStr = today.toISOString().split('T')[0];
            const endStr = nextWeek.toISOString().split('T')[0];

            fetch(`<?= site_url('kalender/events') ?>?start=${startStr}&end=${endStr}`)
                .then(response => response.json())
                .then(events => {
                    if (events.length === 0) {
                        eventsList.innerHTML = '<div class="text-center py-4 text-gray-500">Tidak ada acara mendatang dalam 7 hari ke depan</div>';
                        document.getElementById('notificationCount').classList.add('hidden');
                        return;
                    }

                    // Update notification count
                    document.getElementById('notificationCount').textContent = events.length;
                    document.getElementById('notificationCount').classList.remove('hidden');

                    // Sort events by date
                    events.sort((a, b) => new Date(a.start) - new Date(b.start));

                    // Group events by date
                    const eventsByDate = {};
                    events.forEach(event => {
                        const eventDate = new Date(event.start);
                        const dateKey = eventDate.toLocaleDateString('id-ID', {
                            weekday: 'long',
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric'
                        });

                        if (!eventsByDate[dateKey]) {
                            eventsByDate[dateKey] = [];
                        }

                        eventsByDate[dateKey].push(event);
                    });

                    // Render events
                    let html = '';
                    for (const [date, dateEvents] of Object.entries(eventsByDate)) {
                        html += `<div class="mb-4">
                            <h4 class="font-medium text-gray-700 mb-2 flex items-center">
                                <i class="far fa-calendar-alt mr-2 text-indigo-500"></i>
                                ${date}
                            </h4>
                            <div class="space-y-2">`;

                        dateEvents.forEach(event => {
                            // Determine event type class
                            let eventTypeClass = 'event-research-item';
                            if (event.extendedProps?.type === 'publication') {
                                eventTypeClass = 'event-publication-item';
                            } else if (event.extendedProps?.type === 'hki') {
                                eventTypeClass = 'event-hki-item';
                            } else if (event.extendedProps?.type === 'deadline') {
                                eventTypeClass = 'event-deadline-item';
                            } else if (event.extendedProps?.type === 'other') {
                                eventTypeClass = 'event-other-item';
                            }

                            // Format time
                            let timeStr = 'Sepanjang hari';
                            if (event.start.includes('T')) {
                                const startTime = new Date(event.start);
                                timeStr = startTime.toLocaleTimeString('id-ID', {
                                    hour: '2-digit',
                                    minute: '2-digit'
                                });

                                if (event.end && event.end.includes('T')) {
                                    const endTime = new Date(event.end);
                                    timeStr += ' - ' + endTime.toLocaleTimeString('id-ID', {
                                        hour: '2-digit',
                                        minute: '2-digit'
                                    });
                                }
                            }

                            html += `<div class="event-item ${eventTypeClass}">
                                <div class="event-title">${event.title}</div>
                                <div class="event-date">
                                    <i class="far fa-clock"></i>
                                    ${timeStr}
                                </div>
                            </div>`;
                        });

                        html += `</div></div>`;
                    }

                    eventsList.innerHTML = html;
                })
                .catch(error => {
                    console.error('Error loading events:', error);
                    eventsList.innerHTML = '<div class="text-center py-4 text-red-500">Gagal memuat daftar acara</div>';
                });
        }

        // Load upcoming events count when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Get today's date and 7 days from now
            const today = new Date();
            const nextWeek = new Date();
            nextWeek.setDate(today.getDate() + 7);

            const startStr = today.toISOString().split('T')[0];
            const endStr = nextWeek.toISOString().split('T')[0];

            fetch(`<?= site_url('kalender/events') ?>?start=${startStr}&end=${endStr}`)
                .then(response => response.json())
                .then(events => {
                    if (events.length > 0) {
                        document.getElementById('notificationCount').textContent = events.length;
                        document.getElementById('notificationCount').classList.remove('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error loading events count:', error);
                });
        });
    </script>
</body>

</html>