<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Penta Dosen</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.min.css">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f8fafc;
        }

        .sidebar {
            transition: all 0.3s ease;
            position: fixed;
            z-index: 50;
            transform: translateX(-100%);
        }

        .sidebar.active {
            transform: translateX(0);
        }

        .sidebar-item:hover {
            background-color: #e2e8f0;
            transform: translateX(5px);
        }

        .sidebar-item.active {
            background-color: #6366f1;
            color: white;
        }

        .sidebar-item.active:hover {
            background-color: #4f46e5;
        }

        .table-row:hover {
            background-color: #f1f5f9;
        }

        .search-input:focus {
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.3);
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
        }

        .overlay.active {
            display: block;
        }

        @media (min-width: 768px) {
            .sidebar {
                transform: translateX(0);
                position: relative;
            }

            .overlay {
                display: none !important;
            }

            .main-content {
                margin-left: 16rem;
            }

            .menu-toggle {
                display: none;
            }
        }

        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }

        /* Custom Select Style */
        .ts-dropdown {
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .ts-control {
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            background-color: white;
            transition: all 0.2s ease;
        }

        .ts-control.focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.3);
        }

        .ts-dropdown .active {
            background-color: #6366f1;
            color: white;
        }

        .ts-control,
        .ts-dropdown {
            min-width: 10rem !important;
            /* Atur lebar minimal agar dropdown dan input select lebih kecil */
        }

        /* Badge Style for Department */
        .department-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            line-height: 1.25rem;
        }

        /* Faculty Specific Colors */
        .badge-kedokteran {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        .badge-kedokteran-gigi {
            background-color: #fef3c7;
            color: #92400e;
        }

        .badge-teknik-informatika {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .badge-perpustakaan {
            background-color: #e0f2fe;
            color: #0369a1;
        }

        .badge-manajemen {
            background-color: #dcfce7;
            color: #166534;
        }

        .badge-akuntansi {
            background-color: #f0fdf4;
            color: #15803d;
        }

        .badge-hukum {
            background-color: #f5f3ff;
            color: #7c3aed;
        }

        .badge-psikologi {
            background-color: #fce7f3;
            color: #be185d;
        }

        .badge-default {
            background-color: #e5e7eb;
            color: #4b5563;
        }

        /* Faculty Badge */
        .faculty-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            line-height: 1.25rem;
            color: white;
        }

        /* Custom Faculty Colors */
        .faculty-kedokteran {
            background-color: #6a9256;
        }

        .faculty-kedokteran-gigi {
            background-color: #8773ae;
        }

        .faculty-teknologi-informasi {
            background-color: #e09a67;
        }

        .faculty-ekonomi-bisnis {
            background-color: #036aac;
        }

        .faculty-hukum {
            background-color: #a93246;
        }

        .faculty-psikologi {
            background-color: #8b3969;
        }

        /* Custom styles for select options */
        .ts-option {
            padding: 0.5rem 1rem;
        }

        .ts-option .badge-option {
            display: inline-block;
            width: 100%;
        }

        /* Loading spinner */
        .spinner {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body class="flex h-screen overflow-hidden">
    <!-- Overlay -->
    <div class="overlay" id="overlay"></div>

    <!-- Include Sidebar -->
    <?= view('partials/sidebar') ?>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Bar -->
        <header class="bg-white shadow-sm z-10">
            <div class="flex items-center justify-between px-6 py-4">
                <div class="flex items-center">
                    <button class="menu-toggle mr-4 text-gray-600 md:hidden" id="openSidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-tachometer-alt mr-2 text-indigo-500"></i>
                        Dashboard
                    </h2>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative hidden md:block">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" placeholder="Cari..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500">
                    </div>
                    <button class="p-2 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200">
                        <i class="fas fa-bell"></i>
                    </button>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
            <!-- Welcome Card -->
            <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-xl shadow-md p-6 text-white mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl font-bold mb-2">Selamat Datang, <?= $user['nama'] ?>!</h3>
                        <p class="opacity-90">Pantau aktivitas terbaru dan kelola penelitian Anda di sini.</p>
                    </div>
                    <div class="w-16 h-16 rounded-full bg-white bg-opacity-20 flex items-center justify-center">
                        <i class="fas fa-chart-line text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-indigo-500">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Penelitian</p>
                            <h3 class="text-2xl font-bold mt-1">12</h3>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center">
                            <i class="fas fa-microscope"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-3"><span class="text-green-500">+2</span> bulan ini</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Publikasi</p>
                            <h3 class="text-2xl font-bold mt-1">8</h3>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                            <i class="fas fa-book-open"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-3"><span class="text-green-500">+1</span> bulan ini</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total HKI</p>
                            <h3 class="text-2xl font-bold mt-1">5</h3>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-3"><span class="text-green-500">+1</span> bulan ini</p>
                </div>
            </div>

            <!-- Visualization Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Bar Chart - Penelitian per Fakultas -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Penelitian per Fakultas</h3>
                    <div class="chart-container">
                        <canvas id="researchChart"></canvas>
                    </div>
                </div>

                <!-- Doughnut Chart - Distribusi Publikasi -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Distribusi Publikasi</h3>
                    <div class="chart-container">
                        <canvas id="publicationChart"></canvas>
                    </div>
                </div>

                <!-- Horizontal Bar Chart - HKI per Fakultas -->
                <div class="bg-white rounded-xl shadow-sm p-6 lg:col-span-2">
                    <h3 class="font-semibold text-gray-800 mb-4">HKI per Fakultas</h3>
                    <div class="chart-container" style="height: 400px;">
                        <canvas id="hkiChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Activity Log -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0">
                    <h3 class="font-semibold text-gray-800">Log Aktivitas</h3>
                    <div class="flex flex-col md:flex-row w-full md:w-auto justify-between gap-4">
                        <!-- Filter group kiri -->
                        <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto">
                            <div class="relative w-full md:w-40 w-40">
                                <select id="filterFakultas" placeholder="Filter Fakultas..." autocomplete="off">
                                    <option value="">Semua Fakultas</option>
                                    <option value="Fakultas Kedokteran" <?= isset($filters['fakultas']) && $filters['fakultas'] === 'Fakultas Kedokteran' ? 'selected' : '' ?>>Fakultas Kedokteran</option>
                                    <option value="Fakultas Kedokteran Gigi" <?= isset($filters['fakultas']) && $filters['fakultas'] === 'Fakultas Kedokteran Gigi' ? 'selected' : '' ?>>Fakultas Kedokteran Gigi</option>
                                    <option value="Fakultas Teknologi Informasi" <?= isset($filters['fakultas']) && $filters['fakultas'] === 'Fakultas Teknologi Informasi' ? 'selected' : '' ?>>Fakultas Teknologi Informasi</option>
                                    <option value="Fakultas Ekonomi Bisnis" <?= isset($filters['fakultas']) && $filters['fakultas'] === 'Fakultas Ekonomi Bisnis' ? 'selected' : '' ?>>Fakultas Ekonomi Bisnis</option>
                                    <option value="Fakultas Hukum" <?= isset($filters['fakultas']) && $filters['fakultas'] === 'Fakultas Hukum' ? 'selected' : '' ?>>Fakultas Hukum</option>
                                    <option value="Fakultas Psikologi" <?= isset($filters['fakultas']) && $filters['fakultas'] === 'Fakultas Psikologi' ? 'selected' : '' ?>>Fakultas Psikologi</option>
                                </select>
                            </div>
                            <div class="relative w-full md:w-40 w-40">
                                <select id="filterJurusan" placeholder="Filter Jurusan..." autocomplete="off">
                                    <option value="">Semua Jurusan</option>
                                    <option value="Kedokteran" <?= isset($filters['jurusan']) && $filters['jurusan'] === 'Kedokteran' ? 'selected' : '' ?>>Kedokteran</option>
                                    <option value="Kedokteran Gigi" <?= isset($filters['jurusan']) && $filters['jurusan'] === 'Kedokteran Gigi' ? 'selected' : '' ?>>Kedokteran Gigi</option>
                                    <option value="Teknik Informatika" <?= isset($filters['jurusan']) && $filters['jurusan'] === 'Teknik Informatika' ? 'selected' : '' ?>>Teknik Informatika</option>
                                    <option value="Perpustakaan dan Sains Informasi" <?= isset($filters['jurusan']) && $filters['jurusan'] === 'Perpustakaan dan Sains Informasi' ? 'selected' : '' ?>>Perpustakaan dan Sains Informasi</option>
                                    <option value="Manajemen" <?= isset($filters['jurusan']) && $filters['jurusan'] === 'Manajemen' ? 'selected' : '' ?>>Manajemen</option>
                                    <option value="Akuntansi" <?= isset($filters['jurusan']) && $filters['jurusan'] === 'Akuntansi' ? 'selected' : '' ?>>Akuntansi</option>
                                    <option value="Hukum" <?= isset($filters['jurusan']) && $filters['jurusan'] === 'Hukum' ? 'selected' : '' ?>>Hukum</option>
                                    <option value="Psikologi" <?= isset($filters['jurusan']) && $filters['jurusan'] === 'Psikologi' ? 'selected' : '' ?>>Psikologi</option>
                                </select>
                            </div>
                            <div class="relative w-full md:w-40 w-40">
                                <select id="filterAktivitas" placeholder="Filter Aktivitas..." autocomplete="off">
                                    <option value="">Semua Aktivitas</option>
                                    <option value="Login" <?= isset($filters['activity']) && $filters['activity'] === 'Login' ? 'selected' : '' ?>>Login</option>
                                    <option value="Logout" <?= isset($filters['activity']) && $filters['activity'] === 'Logout' ? 'selected' : '' ?>>Logout</option>
                                    <option value="Create" <?= isset($filters['activity']) && $filters['activity'] === 'Create' ? 'selected' : '' ?>>Create</option>
                                    <option value="Update" <?= isset($filters['activity']) && $filters['activity'] === 'Update' ? 'selected' : '' ?>>Update</option>
                                    <option value="Delete" <?= isset($filters['activity']) && $filters['activity'] === 'Delete' ? 'selected' : '' ?>>Delete</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Search bawah filter, memanjang -->
                    <div class="relative w-full mt-4">
                        <input type="text" id="searchLog" placeholder="Cari aktivitas atau nama user..." value="<?= isset($filters['search']) ? esc($filters['search']) : '' ?>" class="search-input pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fakultas & Jurusan</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aktivitas</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="logTable">
                            <?php foreach ($activity_logs as $log): ?>
                                <?php
                                // Determine faculty based on department
                                $fakultas = '';
                                $facultyClass = '';
                                if (isset($log['user_jurusan'])) {
                                    switch ($log['user_jurusan']) {
                                        case 'Kedokteran':
                                            $fakultas = 'Fakultas Kedokteran';
                                            $facultyClass = 'faculty-kedokteran';
                                            $badgeClass = 'badge-kedokteran';
                                            break;
                                        case 'Kedokteran Gigi':
                                            $fakultas = 'Fakultas Kedokteran Gigi';
                                            $facultyClass = 'faculty-kedokteran-gigi';
                                            $badgeClass = 'badge-kedokteran-gigi';
                                            break;
                                        case 'Teknik Informatika':
                                            $fakultas = 'Fakultas Teknologi Informasi';
                                            $facultyClass = 'faculty-teknologi-informasi';
                                            $badgeClass = 'badge-teknik-informatika';
                                            break;
                                        case 'Perpustakaan dan Sains Informasi':
                                            $fakultas = 'Fakultas Teknologi Informasi';
                                            $facultyClass = 'faculty-teknologi-informasi';
                                            $badgeClass = 'badge-perpustakaan';
                                            break;
                                        case 'Manajemen':
                                        case 'Akuntansi':
                                            $fakultas = 'Fakultas Ekonomi Bisnis';
                                            $facultyClass = 'faculty-ekonomi-bisnis';
                                            $badgeClass = $log['user_jurusan'] === 'Manajemen' ? 'badge-manajemen' : 'badge-akuntansi';
                                            break;
                                        case 'Hukum':
                                            $fakultas = 'Fakultas Hukum';
                                            $facultyClass = 'faculty-hukum';
                                            $badgeClass = 'badge-hukum';
                                            break;
                                        case 'Psikologi':
                                            $fakultas = 'Fakultas Psikologi';
                                            $facultyClass = 'faculty-psikologi';
                                            $badgeClass = 'badge-psikologi';
                                            break;
                                        default:
                                            $fakultas = '';
                                            $facultyClass = '';
                                            $badgeClass = 'badge-default';
                                    }
                                }
                                ?>
                                <tr class="table-row">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900"><?= $log['user_name'] ?? 'System' ?></div>
                                                <div class="text-xs text-gray-500"><?= $log['user_jurusan'] ?? '-' ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col space-y-1">
                                            <?php if ($fakultas): ?>
                                                <span class="faculty-badge <?= $facultyClass ?>"><?= $fakultas ?></span>
                                            <?php endif; ?>
                                            <span class="department-badge <?= $badgeClass ?>">
                                                <?= $log['user_jurusan'] ?? '-' ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full 
                                                <?= $log['activity'] === 'Login' ? 'bg-green-100 text-green-600' : ($log['activity'] === 'Logout' ? 'bg-purple-100 text-purple-600' : ($log['activity'] === 'Create' ? 'bg-blue-100 text-blue-600' : ($log['activity'] === 'Update' ? 'bg-yellow-100 text-yellow-600' :
                                                    'bg-red-100 text-red-600'))) ?> 
                                                flex items-center justify-center">
                                                <i class="fas 
                                                    <?= $log['activity'] === 'Login' ? 'fa-sign-in-alt' : ($log['activity'] === 'Logout' ? 'fa-sign-out-alt' : ($log['activity'] === 'Create' ? 'fa-plus-circle' : ($log['activity'] === 'Update' ? 'fa-edit' :
                                                        'fa-trash-alt'))) ?>"></i>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900"><?= $log['activity'] ?></div>
                                                <div class="text-xs text-gray-500"><?= date('H:i', strtotime($log['created_at'])) ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 max-w-xs truncate"><?= $log['description'] ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900"><?= date('d M Y', strtotime($log['created_at'])) ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            <?= $log['activity'] === 'Login' ? 'bg-green-100 text-green-800' : ($log['activity'] === 'Logout' ? 'bg-purple-100 text-purple-800' : ($log['activity'] === 'Create' ? 'bg-blue-100 text-blue-800' : ($log['activity'] === 'Update' ? 'bg-yellow-100 text-yellow-800' :
                                                'bg-red-100 text-red-800'))) ?>">
                                            <?= $log['activity'] === 'Login' ? 'Success' : ($log['activity'] === 'Logout' ? 'Success' : ($log['activity'] === 'Create' ? 'Created' : ($log['activity'] === 'Update' ? 'Updated' :
                                                'Deleted'))) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
                    <div class="text-sm text-gray-500 pagination-info">
                        Menampilkan <span class="font-medium">1</span> sampai <span class="font-medium"><?= count($activity_logs) ?></span> dari <span class="font-medium"><?= count($activity_logs) ?></span> aktivitas
                    </div>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 border rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Previous
                        </button>
                        <button class="px-3 py-1 border rounded-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                            1
                        </button>
                        <button class="px-3 py-1 border rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Include Sidebar Script -->
    <script src="<?= base_url('js/sidebar-script.js') ?>"></script>
    <!-- Tom Select Library -->
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    <script>
        // Helper function to get faculty class
        function getFacultyClass(fakultas) {
            switch (fakultas) {
                case 'Fakultas Kedokteran':
                    return 'faculty-kedokteran';
                case 'Fakultas Kedokteran Gigi':
                    return 'faculty-kedokteran-gigi';
                case 'Fakultas Teknologi Informasi':
                    return 'faculty-teknologi-informasi';
                case 'Fakultas Ekonomi Bisnis':
                    return 'faculty-ekonomi-bisnis';
                case 'Fakultas Hukum':
                    return 'faculty-hukum';
                case 'Fakultas Psikologi':
                    return 'faculty-psikologi';
                default:
                    return '';
            }
        }

        // Helper function to get badge class
        function getBadgeClass(jurusan) {
            switch (jurusan) {
                case 'Kedokteran':
                    return 'badge-kedokteran';
                case 'Kedokteran Gigi':
                    return 'badge-kedokteran-gigi';
                case 'Teknik Informatika':
                    return 'badge-teknik-informatika';
                case 'Perpustakaan dan Sains Informasi':
                    return 'badge-perpustakaan';
                case 'Manajemen':
                    return 'badge-manajemen';
                case 'Akuntansi':
                    return 'badge-akuntansi';
                case 'Hukum':
                    return 'badge-hukum';
                case 'Psikologi':
                    return 'badge-psikologi';
                default:
                    return 'badge-default';
            }
        }

        // Initialize Tom Select for faculty filter
        new TomSelect('#filterFakultas', {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            },
            render: {
                option: function(data, escape) {
                    const facultyClass = getFacultyClass(data.value);
                    return `<div class="ts-option">
                        <span class="badge-option faculty-badge ${facultyClass}">${data.value}</span>
                    </div>`;
                },
                item: function(data, escape) {
                    const facultyClass = getFacultyClass(data.value);
                    return `<div>
                        <span class="faculty-badge ${facultyClass}">${data.value}</span>
                    </div>`;
                }
            }
        });

        // Initialize Tom Select for department filter
        new TomSelect('#filterJurusan', {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            },
            render: {
                option: function(data, escape) {
                    const badgeClass = getBadgeClass(data.value);
                    return `<div class="ts-option">
                        <span class="badge-option department-badge ${badgeClass}">${data.value}</span>
                    </div>`;
                },
                item: function(data, escape) {
                    const badgeClass = getBadgeClass(data.value);
                    return `<div>
                        <span class="department-badge ${badgeClass}">${data.value}</span>
                    </div>`;
                }
            }
        });

        // Initialize Tom Select for activity filter
        new TomSelect('#filterAktivitas', {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });

        // Chart Initialization
        document.addEventListener('DOMContentLoaded', function() {
            // Data Fakultas
            const faculties = [
                'Fakultas Kedokteran',
                'Fakultas Kedokteran Gigi',
                'Fakultas Teknologi Informasi',
                'Fakultas Ekonomi Bisnis',
                'Fakultas Hukum',
                'Fakultas Psikologi'
            ];

            // Warna untuk chart sesuai permintaan
            const colors = [
                '#6a9256', // Kedokteran
                '#8773ae', // Kedokteran Gigi
                '#e09a67', // Teknologi Informasi
                '#036aac', // Ekonomi Bisnis
                '#a93246', // Hukum
                '#8b3969' // Psikologi
            ];

            // Chart Penelitian per Fakultas (Bar Chart)
            const researchCtx = document.getElementById('researchChart').getContext('2d');
            const researchChart = new Chart(researchCtx, {
                type: 'bar',
                data: {
                    labels: faculties,
                    datasets: [{
                        label: 'Jumlah Penelitian',
                        data: [15, 8, 12, 6, 4, 7],
                        backgroundColor: colors,
                        borderColor: colors.map(c => c.replace('0.8', '1')),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `Penelitian: ${context.raw}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 5
                            }
                        }
                    }
                }
            });

            // Chart Distribusi Publikasi (Doughnut Chart)
            const publicationCtx = document.getElementById('publicationChart').getContext('2d');
            const publicationChart = new Chart(publicationCtx, {
                type: 'doughnut',
                data: {
                    labels: faculties,
                    datasets: [{
                        label: 'Jumlah Publikasi',
                        data: [10, 5, 8, 4, 3, 6],
                        backgroundColor: colors,
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    },
                    cutout: '65%'
                }
            });

            // Chart HKI per Fakultas (Horizontal Bar Chart)
            const hkiCtx = document.getElementById('hkiChart').getContext('2d');
            const hkiChart = new Chart(hkiCtx, {
                type: 'bar',
                data: {
                    labels: faculties,
                    datasets: [{
                        label: 'HKI',
                        data: [5, 2, 8, 3, 1, 4],
                        backgroundColor: colors,
                        borderColor: colors.map(c => c.replace('0.8', '1')),
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `HKI: ${context.raw}`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 2
                            }
                        }
                    }
                }
            });

            // Filter Functionality
            const filterFakultas = document.getElementById('filterFakultas');
            const filterJurusan = document.getElementById('filterJurusan');
            const filterAktivitas = document.getElementById('filterAktivitas');
            const searchLog = document.getElementById('searchLog');

            // Debounce function untuk pencarian
            let searchTimeout;

            // Fungsi untuk memuat data via AJAX
            function loadFilteredLogs() {
                const fakultas = filterFakultas.value;
                const jurusan = filterJurusan.value;
                const aktivitas = filterAktivitas.value;
                const searchTerm = searchLog.value;

                // Tampilkan loading indicator
                document.getElementById('logTable').innerHTML = `
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center">
                            <i class="fas fa-spinner fa-spin mr-2"></i> Memuat data...
                        </td>
                    </tr>
                `;

                // Buat URL dengan parameter filter
                let params = new URLSearchParams();
                if (fakultas) params.append('fakultas', fakultas);
                if (jurusan) params.append('jurusan', jurusan);
                if (aktivitas) params.append('activity', aktivitas);
                if (searchTerm) params.append('search', searchTerm);

                // Kirim request AJAX
                fetch(`/dashboard?${params.toString()}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        renderLogs(data);
                        updatePaginationInfo(data.length);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById('logTable').innerHTML = `
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-red-500">
                                <i class="fas fa-exclamation-circle mr-2"></i> Gagal memuat data
                            </td>
                        </tr>
                    `;
                    });
            }

            // Fungsi untuk merender log
            function renderLogs(logs) {
                const logTable = document.getElementById('logTable');

                if (logs.length === 0) {
                    logTable.innerHTML = `
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada data yang ditemukan
                            </td>
                        </tr>
                    `;
                    return;
                }

                let html = '';
                logs.forEach(log => {
                    // Determine faculty based on department
                    let fakultas = '';
                    let facultyClass = '';
                    let badgeClass = 'badge-default';

                    if (log.user_jurusan) {
                        switch (log.user_jurusan) {
                            case 'Kedokteran':
                                fakultas = 'Fakultas Kedokteran';
                                facultyClass = 'faculty-kedokteran';
                                badgeClass = 'badge-kedokteran';
                                break;
                            case 'Kedokteran Gigi':
                                fakultas = 'Fakultas Kedokteran Gigi';
                                facultyClass = 'faculty-kedokteran-gigi';
                                badgeClass = 'badge-kedokteran-gigi';
                                break;
                            case 'Teknik Informatika':
                                fakultas = 'Fakultas Teknologi Informasi';
                                facultyClass = 'faculty-teknologi-informasi';
                                badgeClass = 'badge-teknik-informatika';
                                break;
                            case 'Perpustakaan dan Sains Informasi':
                                fakultas = 'Fakultas Teknologi Informasi';
                                facultyClass = 'faculty-teknologi-informasi';
                                badgeClass = 'badge-perpustakaan';
                                break;
                            case 'Manajemen':
                            case 'Akuntansi':
                                fakultas = 'Fakultas Ekonomi Bisnis';
                                facultyClass = 'faculty-ekonomi-bisnis';
                                badgeClass = log.user_jurusan === 'Manajemen' ? 'badge-manajemen' : 'badge-akuntansi';
                                break;
                            case 'Hukum':
                                fakultas = 'Fakultas Hukum';
                                facultyClass = 'faculty-hukum';
                                badgeClass = 'badge-hukum';
                                break;
                            case 'Psikologi':
                                fakultas = 'Fakultas Psikologi';
                                facultyClass = 'faculty-psikologi';
                                badgeClass = 'badge-psikologi';
                                break;
                            default:
                                fakultas = '';
                                facultyClass = '';
                                badgeClass = 'badge-default';
                        }
                    }

                    // Determine activity icon and color
                    let activityIcon, activityColor, statusColor, statusText;
                    switch (log.activity) {
                        case 'Login':
                            activityIcon = 'fa-sign-in-alt';
                            activityColor = 'bg-green-100 text-green-600';
                            statusColor = 'bg-green-100 text-green-800';
                            statusText = 'Success';
                            break;
                        case 'Logout':
                            activityIcon = 'fa-sign-out-alt';
                            activityColor = 'bg-purple-100 text-purple-600';
                            statusColor = 'bg-purple-100 text-purple-800';
                            statusText = 'Success';
                            break;
                        case 'Create':
                            activityIcon = 'fa-plus-circle';
                            activityColor = 'bg-blue-100 text-blue-600';
                            statusColor = 'bg-blue-100 text-blue-800';
                            statusText = 'Created';
                            break;
                        case 'Update':
                            activityIcon = 'fa-edit';
                            activityColor = 'bg-yellow-100 text-yellow-600';
                            statusColor = 'bg-yellow-100 text-yellow-800';
                            statusText = 'Updated';
                            break;
                        case 'Delete':
                            activityIcon = 'fa-trash-alt';
                            activityColor = 'bg-red-100 text-red-600';
                            statusColor = 'bg-red-100 text-red-800';
                            statusText = 'Deleted';
                            break;
                        default:
                            activityIcon = 'fa-info-circle';
                            activityColor = 'bg-gray-100 text-gray-600';
                            statusColor = 'bg-gray-100 text-gray-800';
                            statusText = 'Info';
                    }

                    const createdAt = new Date(log.created_at);
                    const timeString = createdAt.toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                    const dateString = createdAt.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'short',
                        year: 'numeric'
                    });

                    html += `
                        <tr class="table-row">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">${log.user_name || 'System'}</div>
                                        <div class="text-xs text-gray-500">${log.user_jurusan || '-'}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col space-y-1">
                                    ${fakultas ? `<span class="faculty-badge ${facultyClass}">${fakultas}</span>` : ''}
                                    <span class="department-badge ${badgeClass}">
                                        ${log.user_jurusan || '-'}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full ${activityColor} flex items-center justify-center">
                                        <i class="fas ${activityIcon}"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">${log.activity}</div>
                                        <div class="text-xs text-gray-500">${timeString}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 max-w-xs truncate">${log.description || ''}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">${dateString}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statusColor}">
                                    ${statusText}
                                </span>
                            </td>
                        </tr>
                    `;
                });

                logTable.innerHTML = html;
            }

            // Fungsi untuk memperbarui info pagination
            function updatePaginationInfo(count) {
                const paginationInfo = document.querySelector('.pagination-info');
                if (paginationInfo) {
                    paginationInfo.innerHTML = `
                        Menampilkan <span class="font-medium">1</span> sampai 
                        <span class="font-medium">${count}</span> dari 
                        <span class="font-medium">${count}</span> aktivitas
                    `;
                }
            }

            // Event listeners untuk filter
            filterFakultas.addEventListener('change', loadFilteredLogs);
            filterJurusan.addEventListener('change', loadFilteredLogs);
            filterAktivitas.addEventListener('change', loadFilteredLogs);

            // Event listener untuk search dengan debounce
            searchLog.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(loadFilteredLogs, 500);
            });
        });
    </script>
</body>

</html>