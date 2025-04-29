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
    </style>
</head>

<body class="flex h-screen overflow-hidden">
    <!-- Overlay -->
    <div class="overlay" id="overlay"></div>

    <!-- Sidebar -->
    <div class="sidebar w-64 bg-white shadow-lg flex flex-col h-full" id="sidebar">
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
                    <a href="<?= site_url('dashboard') ?>" class="sidebar-item active flex items-center px-4 py-3 rounded-lg text-indigo-600 font-medium">
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
                    <a href="#" class="sidebar-item flex items-center px-4 py-3 rounded-lg text-gray-600 hover:text-indigo-600 font-medium">
                        <i class="fas fa-lightbulb mr-3"></i>
                        HKI
                    </a>
                </li>
            </ul>
        </div>

        <!-- User Profile -->
        <div class="p-4 border-t">
            <div class="flex items-center">
                <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="User" class="w-10 h-10 rounded-full mr-3">
                <div>
                    <p class="font-medium text-gray-800">Muhammad Syafi'ul Umam S.Kom.</p>
                    <p class="text-xs text-gray-500">Dosen Fakultas Teknik Informatika</p>
                </div>
            </div>
            <button class="mt-3 w-full py-2 px-4 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium text-gray-700 transition duration-200 flex items-center justify-center">
                <a href="<?= site_url('auth/logout') ?>">
                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                </a>
            </button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Bar -->
        <header class="bg-white shadow-sm z-10">
            <div class="flex items-center justify-between px-6 py-4">
                <div class="flex items-center">
                    <button class="menu-toggle mr-4 text-gray-600 md:hidden" id="openSidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h2 class="text-xl font-semibold text-gray-800">Dashboard</h2>
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
                        <h3 class="text-2xl font-bold mb-2">Selamat Datang, Pak Umam!</h3>
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
                    <div class="relative w-full md:w-64">
                        <input type="text" id="searchLog" placeholder="Cari aktivitas..." class="search-input pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aktivitas</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="logTable">
                            <tr class="table-row">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                            <i class="fas fa-sign-in-alt"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Login</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">Berhasil login ke sistem</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">15 Juni 2023, 08:30 WIB</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Success
                                    </span>
                                </td>
                            </tr>
                            <tr class="table-row">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                            <i class="fas fa-plus"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Create</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">Membuat penelitian baru "Pengaruh Obat X"</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">14 Juni 2023, 14:15 WIB</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Success
                                    </span>
                                </td>
                            </tr>
                            <tr class="table-row">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
                                            <i class="fas fa-edit"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Update</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">Memperbarui data publikasi "Jurnal Internasional"</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">13 Juni 2023, 10:45 WIB</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Success
                                    </span>
                                </td>
                            </tr>
                            <tr class="table-row">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-red-100 flex items-center justify-center text-red-600">
                                            <i class="fas fa-trash-alt"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Delete</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">Menghapus draft penelitian "Studi Kasus Y"</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">12 Juni 2023, 16:20 WIB</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Success
                                    </span>
                                </td>
                            </tr>
                            <tr class="table-row">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600">
                                            <i class="fas fa-sign-out-alt"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Logout</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">Keluar dari sistem</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">11 Juni 2023, 17:00 WIB</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Success
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
                    <div class="text-sm text-gray-500">
                        Menampilkan <span class="font-medium">1</span> sampai <span class="font-medium">5</span> dari <span class="font-medium">24</span> aktivitas
                    </div>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 border rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Previous
                        </button>
                        <button class="px-3 py-1 border rounded-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                            1
                        </button>
                        <button class="px-3 py-1 border rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            2
                        </button>
                        <button class="px-3 py-1 border rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Toggle sidebar on mobile
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const openSidebar = document.getElementById('openSidebar');
        const closeSidebar = document.getElementById('closeSidebar');

        openSidebar.addEventListener('click', () => {
            sidebar.classList.add('active');
            overlay.classList.add('active');
        });

        closeSidebar.addEventListener('click', () => {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });

        // Search functionality for activity log
        document.getElementById('searchLog').addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('#logTable tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Sidebar item active state
        document.querySelectorAll('.sidebar-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.sidebar-item').forEach(i => {
                    i.classList.remove('active', 'text-indigo-600');
                    i.classList.add('text-gray-600', 'hover:text-indigo-600');
                });
                this.classList.add('active', 'text-indigo-600');
                this.classList.remove('text-gray-600', 'hover:text-indigo-600');

                // Close sidebar on mobile after clicking menu item
                if (window.innerWidth < 768) {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                }
            });
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

            // Warna untuk chart
            const colors = [
                '#6366F1', '#8B5CF6', '#EC4899',
                '#F43F5E', '#F59E0B', '#10B981'
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
        });
    </script>
</body>

</html>