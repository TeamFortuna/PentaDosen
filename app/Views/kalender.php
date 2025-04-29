<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender Akademik - Penta Dosen</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
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

        .fc-event {
            cursor: pointer;
            border-radius: 6px;
            font-size: 0.875rem;
            padding: 4px 6px;
            border-left: 4px solid;
            transition: all 0.2s;
        }

        .fc-event:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 50;
            width: 90%;
            max-width: 500px;
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

        .weather-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .weather-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .calendar-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .fc .fc-toolbar-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary);
            text-transform: capitalize;
        }

        .fc .fc-button {
            background-color: white;
            border-color: #e2e8f0;
            color: #64748b;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .fc .fc-button:hover {
            background-color: #f1f5f9;
            border-color: #cbd5e1;
        }

        .fc .fc-button-primary:not(:disabled).fc-button-active {
            background-color: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        .fc .fc-daygrid-day.fc-day-today {
            background-color: rgba(224, 231, 255, 0.5);
        }

        .fc .fc-col-header-cell {
            background-color: #f8fafc;
            padding: 0.75rem 0;
        }

        .fc .fc-col-header-cell-cushion {
            color: #475569;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
        }

        .fc-event {
            border: none;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            font-weight: 500;
        }

        .fc-daygrid-event-dot {
            display: none;
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

            .fc .fc-toolbar {
                flex-direction: column;
                gap: 0.5rem;
            }

            .fc .fc-toolbar-title {
                font-size: 1.1rem;
                margin: 0.5rem 0;
            }

            .fc .fc-toolbar-chunk {
                display: flex;
                justify-content: center;
                width: 100%;
            }

            .weather-container {
                flex-direction: column;
            }

            .main-content {
                margin-left: 0;
            }
        }

        .event-research {
            border-left-color: #6366F1;
            background-color: rgba(99, 102, 241, 0.1);
            color: #6366F1;
        }

        .event-publication {
            border-left-color: #3B82F6;
            background-color: rgba(59, 130, 246, 0.1);
            color: #3B82F6;
        }

        .event-hki {
            border-left-color: #8B5CF6;
            background-color: rgba(139, 92, 246, 0.1);
            color: #8B5CF6;
        }

        .event-deadline {
            border-left-color: #F43F5E;
            background-color: rgba(244, 63, 94, 0.1);
            color: #F43F5E;
        }

        .event-other {
            border-left-color: #10B981;
            background-color: rgba(16, 185, 129, 0.1);
            color: #10B981;
        }

        .humidity-indicator {
            height: 6px;
            border-radius: 3px;
            background: linear-gradient(90deg, #3B82F6 0%, #10B981 50%, #F59E0B 100%);
        }

        .humidity-value {
            height: 100%;
            border-radius: 3px;
            background-color: var(--primary);
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
                    <i class="fas fa-calendar-alt text-xl"></i>
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
                    <a href="<?= site_url('kalender') ?>" class="sidebar-item active flex items-center px-4 py-3 rounded-lg text-white font-medium">
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
                        <i class="far fa-calendar-alt mr-2 text-indigo-500"></i>
                        Kalender Akademik
                    </h2>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <button id="weatherRefresh" class="p-2 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 transition">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                        <span class="absolute -top-1 -right-1 bg-indigo-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                            <span id="weatherTemp">0</span>°
                        </span>
                    </div>
                    <button class="p-2 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 transition">
                        <i class="fas fa-bell"></i>
                    </button>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 overflow-y-auto p-6">
            <!-- Weather and Calendar Tools -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <!-- Weather Widget -->
                <div class="weather-container bg-white rounded-xl shadow-sm p-4 flex flex-col">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-cloud-sun mr-2 text-indigo-500"></i>
                            Cuaca Hari Ini
                        </h3>
                        <div class="text-sm text-gray-500" id="weatherLocation">Loading lokasi...</div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="weather-card p-4 flex flex-col items-center justify-center">
                            <div class="text-4xl mb-2" id="weatherIcon">
                                <i class="fas fa-cloud-sun text-indigo-400"></i>
                            </div>
                            <div class="text-3xl font-bold" id="weatherTemperature">--°C</div>
                            <div class="text-sm text-gray-500" id="weatherDescription">--</div>
                        </div>

                        <div class="weather-card p-4">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-sm font-medium text-gray-600">Kelembapan</span>
                                <span class="text-sm font-semibold" id="weatherHumidity">--%</span>
                            </div>
                            <div class="humidity-indicator mb-1">
                                <div class="humidity-value" id="humidityBar"></div>
                            </div>
                            <div class="flex justify-between text-xs text-gray-500">
                                <span>Rendah</span>
                                <span>Sedang</span>
                                <span>Tinggi</span>
                            </div>
                        </div>
                    </div>

                    <div class="weather-card p-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <div class="text-sm font-medium text-gray-600">Perkiraan Minggu Ini</div>
                                <div class="text-xs text-gray-500" id="weatherForecastSummary">Memuat data cuaca...</div>
                            </div>
                            <button id="refreshWeather" class="p-2 rounded-full bg-indigo-100 text-indigo-600 hover:bg-indigo-200 transition">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Calendar Tools -->
                <div class="lg:col-span-2 flex flex-col">
                    <div class="bg-white rounded-xl shadow-sm p-4 flex-1">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <div class="flex space-x-2">
                                <button id="addEventBtn" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 flex items-center transition transform hover:-translate-y-0.5">
                                    <i class="fas fa-plus mr-2"></i>
                                    <span>Tambah Acara</span>
                                </button>
                            </div>

                            <div class="flex flex-wrap gap-3">
                                <div class="flex items-center space-x-2">
                                    <div class="w-4 h-4 rounded-full bg-indigo-500"></div>
                                    <span class="text-sm">Penelitian</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="w-4 h-4 rounded-full bg-blue-500"></div>
                                    <span class="text-sm">Publikasi</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="w-4 h-4 rounded-full bg-purple-500"></div>
                                    <span class="text-sm">HKI</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="w-4 h-4 rounded-full bg-green-500"></div>
                                    <span class="text-sm">Lainnya</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="w-4 h-4 rounded-full bg-red-500"></div>
                                    <span class="text-sm">Deadline</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Calendar -->
            <div class="calendar-container">
                <div id="calendar" class="p-4"></div>
            </div>
        </main>
    </div>

    <!-- Modal Event -->
    <div class="modal" id="eventModal">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden w-full max-w-md">
            <div class="px-6 py-4 border-b flex justify-between items-center bg-indigo-600 text-white">
                <h3 class="text-lg font-semibold" id="modalTitle">Tambah Acara Baru</h3>
                <button id="closeModal" class="text-white hover:text-indigo-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <form id="eventForm">
                    <input type="hidden" id="eventId">
                    <div class="mb-4">
                        <label for="eventTitle" class="block text-sm font-medium text-gray-700 mb-1">Judul Acara</label>
                        <input type="text" id="eventTitle" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" required>
                    </div>
                    <div class="mb-4">
                        <label for="eventDescription" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea id="eventDescription" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"></textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="eventStartDate" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                            <input type="date" id="eventStartDate" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" required>
                        </div>
                        <div>
                            <label for="eventEndDate" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                            <input type="date" id="eventEndDate" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" required>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="eventStartTime" class="block text-sm font-medium text-gray-700 mb-1">Waktu Mulai</label>
                            <input type="time" id="eventStartTime" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                        </div>
                        <div>
                            <label for="eventEndTime" class="block text-sm font-medium text-gray-700 mb-1">Waktu Selesai</label>
                            <input type="time" id="eventEndTime" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                        </div>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Warna Acara</label>
                        <div class="flex space-x-2">
                            <div class="color-option bg-indigo-500 selected" data-color="#6366F1" data-class="event-research"></div>
                            <div class="color-option bg-blue-500" data-color="#3B82F6" data-class="event-publication"></div>
                            <div class="color-option bg-purple-500" data-color="#8B5CF6" data-class="event-hki"></div>
                            <div class="color-option bg-green-500" data-color="#10B981" data-class="event-other"></div>
                            <div class="color-option bg-red-500" data-color="#F43F5E" data-class="event-deadline"></div>
                        </div>
                        <input type="hidden" id="eventColor" value="#6366F1">
                        <input type="hidden" id="eventClass" value="event-research">
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" id="deleteEvent" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition hidden">Hapus</button>
                        <button type="button" id="cancelEvent" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">Batal</button>
                        <button type="submit" id="saveEvent" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Detail Event -->
    <div class="modal" id="detailModal">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden w-full max-w-md">
            <div class="px-6 py-4 border-b flex justify-between items-center" id="detailHeader">
                <h3 class="text-lg font-semibold text-gray-800" id="detailTitle">Detail Acara</h3>
                <button id="closeDetailModal" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <div class="mb-4">
                    <h4 class="font-medium text-gray-800 text-lg" id="detailEventTitle"></h4>
                    <div class="flex items-center mt-2">
                        <span class="text-sm px-2 py-1 rounded-md font-medium" id="detailEventColor"></span>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded-lg" id="detailEventDescription">-</p>
                </div>
                <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                        <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded-lg flex items-center">
                            <i class="far fa-calendar-alt mr-2 text-indigo-500"></i>
                            <span id="detailEventDate"></span>
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Waktu</label>
                        <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded-lg flex items-center">
                            <i class="far fa-clock mr-2 text-indigo-500"></i>
                            <span id="detailEventTime"></span>
                        </p>
                    </div>
                </div>
                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <button type="button" id="editEvent" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Edit</button>
                    <button type="button" id="closeDetail" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/id.js'></script>
    <script>
        // Data acara (simulasi database)
        let events = [{
                id: '1',
                title: 'Pengumpulan Proposal Penelitian',
                description: 'Pengumpulan proposal penelitian tahap akhir untuk semester ini',
                start: new Date().toISOString().split('T')[0],
                color: '#F43F5E',
                className: 'event-deadline',
                type: 'deadline'
            },
            {
                id: '2',
                title: 'Seminar Hasil Penelitian',
                description: 'Presentasi hasil penelitian untuk tim Fakultas Kedokteran',
                start: new Date(new Date().setDate(new Date().getDate() + 5)) + 'T10:00:00',
                end: new Date(new Date().setDate(new Date().getDate() + 5)) + 'T12:00:00',
                color: '#6366F1',
                className: 'event-research',
                type: 'research'
            },
            {
                id: '3',
                title: 'Submit Jurnal Internasional',
                description: 'Batas akhir pengumpulan jurnal untuk publikasi internasional',
                start: new Date(new Date().setDate(new Date().getDate() + 10)).toISOString().split('T')[0],
                color: '#3B82F6',
                className: 'event-publication',
                type: 'publication'
            }
        ];

        // Inisialisasi sidebar untuk mobile
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

        // Color picker
        const colorOptions = document.querySelectorAll('.color-option');
        colorOptions.forEach(option => {
            option.addEventListener('click', function() {
                colorOptions.forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');
                document.getElementById('eventColor').value = this.dataset.color;
                document.getElementById('eventClass').value = this.dataset.class;
            });
        });

        // Modal functions
        const eventModal = document.getElementById('eventModal');
        const detailModal = document.getElementById('detailModal');
        const closeModal = document.getElementById('closeModal');
        const closeDetailModal = document.getElementById('closeDetailModal');
        const cancelEvent = document.getElementById('cancelEvent');
        const closeDetail = document.getElementById('closeDetail');
        const deleteEvent = document.getElementById('deleteEvent');
        const editEvent = document.getElementById('editEvent');
        const addEventBtn = document.getElementById('addEventBtn');
        const eventForm = document.getElementById('eventForm');

        function openModal() {
            eventModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModalFunc() {
            eventModal.classList.remove('active');
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

        closeModal.addEventListener('click', closeModalFunc);
        closeDetailModal.addEventListener('click', closeDetailModalFunc);
        cancelEvent.addEventListener('click', closeModalFunc);
        closeDetail.addEventListener('click', closeDetailModalFunc);

        addEventBtn.addEventListener('click', function() {
            document.getElementById('modalTitle').textContent = 'Tambah Acara Baru';
            document.getElementById('deleteEvent').classList.add('hidden');
            openModal();
        });

        function resetForm() {
            eventForm.reset();
            document.getElementById('eventId').value = '';
            document.getElementById('eventColor').value = '#6366F1';
            document.getElementById('eventClass').value = 'event-research';
            colorOptions.forEach(opt => opt.classList.remove('selected'));
            document.querySelector('.color-option[data-color="#6366F1"]').classList.add('selected');
        }

        // Initialize Calendar
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id',
                headerToolbar: {
                    left: 'prev,today,next',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: 'Hari Ini',
                    month: 'Bulan',
                    week: 'Minggu',
                    day: 'Hari'
                },
                events: events,
                dateClick: function(info) {
                    document.getElementById('eventStartDate').value = info.dateStr;
                    document.getElementById('eventEndDate').value = info.dateStr;
                    document.getElementById('modalTitle').textContent = 'Tambah Acara Baru';
                    document.getElementById('deleteEvent').classList.add('hidden');
                    openModal();
                },
                eventClick: function(info) {
                    const event = info.event;
                    const eventType = event.extendedProps.type || 'other';
                    let typeColor, typeText;

                    switch (eventType) {
                        case 'research':
                            typeColor = 'bg-indigo-100 text-indigo-800';
                            typeText = 'Penelitian';
                            break;
                        case 'publication':
                            typeColor = 'bg-blue-100 text-blue-800';
                            typeText = 'Publikasi';
                            break;
                        case 'hki':
                            typeColor = 'bg-purple-100 text-purple-800';
                            typeText = 'HKI';
                            break;
                        case 'deadline':
                            typeColor = 'bg-red-100 text-red-800';
                            typeText = 'Deadline';
                            break;
                        default:
                            typeColor = 'bg-gray-100 text-gray-800';
                            typeText = 'Acara';
                    }

                    // Set detail event
                    document.getElementById('detailEventTitle').textContent = event.title;
                    document.getElementById('detailEventDescription').textContent = event.extendedProps.description || '-';

                    // Format tanggal
                    const startDate = event.start ? new Date(event.start) : null;
                    const endDate = event.end ? new Date(event.end) : null;

                    let dateStr = '';
                    if (startDate) {
                        dateStr = startDate.toLocaleDateString('id-ID', {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        });

                        if (endDate && startDate.toDateString() !== endDate.toDateString()) {
                            dateStr += ' - ' + endDate.toLocaleDateString('id-ID', {
                                weekday: 'long',
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            });
                        }
                    }
                    document.getElementById('detailEventDate').textContent = dateStr;

                    // Format waktu
                    let timeStr = 'Sepanjang hari';
                    if (startDate && event.startStr.includes('T')) {
                        timeStr = startDate.toLocaleTimeString('id-ID', {
                            hour: '2-digit',
                            minute: '2-digit'
                        });

                        if (endDate && event.endStr.includes('T')) {
                            timeStr += ' - ' + endDate.toLocaleTimeString('id-ID', {
                                hour: '2-digit',
                                minute: '2-digit'
                            });
                        }
                    }
                    document.getElementById('detailEventTime').textContent = timeStr;

                    // Set warna
                    const colorSpan = document.getElementById('detailEventColor');
                    colorSpan.textContent = typeText;
                    colorSpan.className = `text-sm px-2 py-1 rounded-md ${typeColor}`;

                    // Set header color
                    const detailHeader = document.getElementById('detailHeader');
                    detailHeader.className = `px-6 py-4 border-b flex justify-between items-center ${event.extendedProps.type === 'deadline' ? 'bg-red-600 text-white' : 'bg-indigo-600 text-white'}`;

                    // Set event id untuk edit/hapus
                    detailModal.dataset.eventId = event.id;

                    openDetailModal();
                }
            });

            calendar.render();

            // Edit event button
            editEvent.addEventListener('click', function() {
                const eventId = detailModal.dataset.eventId;
                const event = events.find(e => e.id === eventId);

                if (event) {
                    document.getElementById('modalTitle').textContent = 'Edit Acara';
                    document.getElementById('eventId').value = event.id;
                    document.getElementById('eventTitle').value = event.title;
                    document.getElementById('eventDescription').value = event.extendedProps.description || '';

                    // Tanggal mulai
                    const startDate = event.start ? new Date(event.start) : new Date();
                    document.getElementById('eventStartDate').value = startDate.toISOString().split('T')[0];

                    // Tanggal selesai
                    const endDate = event.end ? new Date(event.end) : startDate;
                    document.getElementById('eventEndDate').value = endDate.toISOString().split('T')[0];

                    // Waktu mulai
                    if (event.startStr.includes('T')) {
                        const startTime = startDate.toTimeString().substring(0, 5);
                        document.getElementById('eventStartTime').value = startTime;
                    } else {
                        document.getElementById('eventStartTime').value = '';
                    }

                    // Waktu selesai
                    if (event.endStr.includes('T')) {
                        const endTime = endDate.toTimeString().substring(0, 5);
                        document.getElementById('eventEndTime').value = endTime;
                    } else {
                        document.getElementById('eventEndTime').value = '';
                    }

                    // Warna
                    document.getElementById('eventColor').value = event.color || '#6366F1';
                    document.getElementById('eventClass').value = event.className || 'event-research';
                    colorOptions.forEach(opt => opt.classList.remove('selected'));
                    document.querySelector(`.color-option[data-color="${event.color || '#6366F1'}"]`).classList.add('selected');

                    // Tampilkan tombol hapus
                    document.getElementById('deleteEvent').classList.remove('hidden');

                    closeDetailModalFunc();
                    openModal();
                }
            });

            // Delete event button
            deleteEvent.addEventListener('click', function() {
                if (confirm('Apakah Anda yakin ingin menghapus acara ini?')) {
                    const eventId = document.getElementById('eventId').value;
                    events = events.filter(e => e.id !== eventId);
                    calendar.refetchEvents();
                    closeModalFunc();
                }
            });

            // Form submit
            eventForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const eventId = document.getElementById('eventId').value;
                const title = document.getElementById('eventTitle').value;
                const description = document.getElementById('eventDescription').value;
                const startDate = document.getElementById('eventStartDate').value;
                const endDate = document.getElementById('eventEndDate').value;
                const startTime = document.getElementById('eventStartTime').value;
                const endTime = document.getElementById('eventEndTime').value;
                const color = document.getElementById('eventColor').value;
                const eventClass = document.getElementById('eventClass').value;

                // Format tanggal dan waktu
                let start = startDate;
                if (startTime) start += `T${startTime}`;

                let end = endDate;
                if (endTime) end += `T${endTime}`;

                // Jika tidak ada waktu, gunakan allday event
                if (!startTime && !endTime) {
                    end = endDate;
                }

                const eventData = {
                    id: eventId || Date.now().toString(),
                    title: title,
                    description: description,
                    start: start,
                    end: end,
                    color: color,
                    className: eventClass,
                    extendedProps: {
                        description: description,
                        type: color === '#F43F5E' ? 'deadline' : color === '#6366F1' ? 'research' : color === '#3B82F6' ? 'publication' : color === '#8B5CF6' ? 'hki' : 'other'
                    }
                };

                // Update atau tambah event
                if (eventId) {
                    const index = events.findIndex(e => e.id === eventId);
                    if (index !== -1) {
                        events[index] = eventData;
                    }
                } else {
                    events.push(eventData);
                }

                calendar.refetchEvents();
                closeModalFunc();
            });
        });

        // Weather API Integration
        async function fetchWeather() {
            try {
                // Untuk demo, kita gunakan lokasi Jakarta
                const lat = -6.2088;
                const lon = 106.8456;
                const apiKey = '04af4937eecc75bd9e81b78be9dcf95f'; // Ganti dengan API key Anda

                // Fetch current weather
                const currentResponse = await fetch(`https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=${apiKey}&units=metric&lang=id`);
                const currentData = await currentResponse.json();
                console.log(currentData); // Tambahkan ini untuk melihat isi datanya

                // Update UI dengan data cuaca
                document.getElementById('weatherLocation').textContent = currentData.name || 'Jakarta';
                document.getElementById('weatherTemperature').textContent = `${Math.round(currentData.main.temp)}°C`;
                document.getElementById('weatherTemp').textContent = Math.round(currentData.main.temp);
                document.getElementById('weatherDescription').textContent = currentData.weather[0].description;
                document.getElementById('weatherHumidity').textContent = `${currentData.main.humidity}%`;



                // Update humidity bar
                const humidityBar = document.getElementById('humidityBar');
                humidityBar.style.width = `${currentData.main.humidity}%`;

                // Set warna humidity berdasarkan nilai
                if (currentData.main.humidity > 70) {
                    humidityBar.style.backgroundColor = '#F59E0B'; // Kuning untuk kelembapan tinggi
                } else if (currentData.main.humidity > 40) {
                    humidityBar.style.backgroundColor = '#10B981'; // Hijau untuk kelembapan sedang
                } else {
                    humidityBar.style.backgroundColor = '#3B82F6'; // Biru untuk kelembapan rendah
                }

                // Update weather icon
                const weatherIcon = document.getElementById('weatherIcon');
                const weatherCode = currentData.weather[0].icon;
                let iconClass = 'fa-cloud-sun';

                if (weatherCode.includes('01')) iconClass = 'fa-sun';
                else if (weatherCode.includes('02')) iconClass = 'fa-cloud-sun';
                else if (weatherCode.includes('03') || weatherCode.includes('04')) iconClass = 'fa-cloud';
                else if (weatherCode.includes('09') || weatherCode.includes('10')) iconClass = 'fa-cloud-rain';
                else if (weatherCode.includes('11')) iconClass = 'fa-bolt';
                else if (weatherCode.includes('13')) iconClass = 'fa-snowflake';
                else if (weatherCode.includes('50')) iconClass = 'fa-smog';

                weatherIcon.innerHTML = `<i class="fas ${iconClass} text-indigo-400 text-4xl"></i>`;

                // Untuk forecast summary (sederhana)
                document.getElementById('weatherForecastSummary').textContent =
                    `Suhu antara ${Math.round(currentData.main.temp_min)}°C - ${Math.round(currentData.main.temp_max)}°C, ${currentData.weather[0].description}`;

            } catch (error) {
                console.error('Error fetching weather data:', error);
                // Fallback data jika API gagal
                document.getElementById('weatherTemperature').textContent = '10°C';
                document.getElementById('weatherDescription').textContent = 'Cerah Berawan';
                document.getElementById('weatherHumidity').textContent = '45%';
                document.getElementById('humidityBar').style.width = '45%';
                document.getElementById('humidityBar').style.backgroundColor = '#10B981';
                document.getElementById('weatherForecastSummary').textContent = 'Suhu antara 10°C - 20°C, dingin';
            }
        }

        // Panggil fungsi cuaca saat halaman dimuat
        document.addEventListener('DOMContentLoaded', fetchWeather);

        // Refresh weather data
        document.getElementById('refreshWeather').addEventListener('click', fetchWeather);
        document.getElementById('weatherRefresh').addEventListener('click', fetchWeather);
    </script>
</body>

</html>