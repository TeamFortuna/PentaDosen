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

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
        }

        .modal-overlay.active {
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

        /* Notification Events Styles */
        .event-item {
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            border-radius: 0.5rem;
            border-left: 4px solid;
            background-color: rgba(241, 245, 249, 0.5);
            transition: all 0.2s;
        }

        .event-item:hover {
            transform: translateX(3px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .event-title {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .event-date {
            font-size: 0.75rem;
            color: #64748b;
            display: flex;
            align-items: center;
        }

        .event-date i {
            margin-right: 0.25rem;
            font-size: 0.65rem;
        }

        .event-research-item {
            border-left-color: #6366F1;
            background-color: rgba(99, 102, 241, 0.05);
        }

        .event-publication-item {
            border-left-color: #3B82F6;
            background-color: rgba(59, 130, 246, 0.05);
        }

        .event-hki-item {
            border-left-color: #8B5CF6;
            background-color: rgba(139, 92, 246, 0.05);
        }

        .event-deadline-item {
            border-left-color: #F43F5E;
            background-color: rgba(244, 63, 94, 0.05);
        }

        .event-other-item {
            border-left-color: #10B981;
            background-color: rgba(16, 185, 129, 0.05);
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

            .notification-container {
                width: 90%;
                left: 5%;
                right: 5%;
                top: 1rem;
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

        .color-option {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .color-option:hover {
            transform: scale(1.1);
        }

        .color-option.selected {
            transform: scale(1.1);
            box-shadow: 0 0 0 2px white, 0 0 0 4px var(--primary);
        }

        /* Delete Confirmation Modal Animation */
        #deleteConfirmationModal {
            animation: modalFadeIn 0.3s ease-out;
            z-index: 60;
        }

        /* Shake animation for delete button */
        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            20%,
            60% {
                transform: translateX(-5px);
            }

            40%,
            80% {
                transform: translateX(5px);
            }
        }

        .shake {
            animation: shake 0.5s cubic-bezier(.36, .07, .19, .97) both;
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
                    <button id="notificationBell" class="p-2 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 transition relative">
                        <i class="fas fa-bell"></i>
                        <span id="notificationCount" class="absolute -top-1 -right-1 bg-indigo-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center hidden">0</span>
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

    <!-- Delete Confirmation Modal -->
    <div class="modal" id="deleteConfirmationModal">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden w-full max-w-md">
            <div class="px-6 py-4 border-b flex justify-between items-center bg-red-600 text-white">
                <h3 class="text-lg font-semibold">Konfirmasi Penghapusan</h3>
                <button id="closeDeleteModal" class="text-white hover:text-red-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mb-4">
                        <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                    </div>
                    <h4 class="text-lg font-medium text-gray-800 mb-2">Apakah Anda yakin ingin menghapus acara ini?</h4>
                    <p class="text-gray-600 mb-6">Data yang sudah dihapus tidak dapat dikembalikan.</p>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" id="cancelDelete" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                        Batal
                    </button>
                    <button type="button" id="confirmDelete" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        Ya, Hapus
                    </button>
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
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/id.js'></script>
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
        const modalOverlay = document.getElementById('modalOverlay');

        function openModal() {
            eventModal.classList.add('active');
            modalOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModalFunc() {
            eventModal.classList.remove('active');
            modalOverlay.classList.remove('active');
            document.body.style.overflow = '';
            resetForm();
        }

        function openDetailModal() {
            detailModal.classList.add('active');
            modalOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeDetailModalFunc() {
            detailModal.classList.remove('active');
            modalOverlay.classList.remove('active');
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

        // Notification Bell Functionality
        const notificationBell = document.getElementById('notificationBell');
        const notificationModal = document.getElementById('notificationModal');
        const closeNotificationModal = document.getElementById('closeNotificationModal');
        const closeNotificationBtn = document.getElementById('closeNotificationBtn');
        const eventsList = document.getElementById('eventsList');
        const notificationCount = document.getElementById('notificationCount');

        // Function to open notification modal
        function openNotificationModal() {
            loadUpcomingEvents();
            notificationModal.classList.add('active');
            modalOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        // Function to close notification modal
        function closeNotificationModalFunc() {
            notificationModal.classList.remove('active');
            modalOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        // Event listeners for notification modal
        notificationBell.addEventListener('click', openNotificationModal);
        closeNotificationModal.addEventListener('click', closeNotificationModalFunc);
        closeNotificationBtn.addEventListener('click', closeNotificationModalFunc);
        modalOverlay.addEventListener('click', closeNotificationModalFunc);

        // Function to load upcoming events
        function loadUpcomingEvents() {
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
                        notificationCount.classList.add('hidden');
                        return;
                    }

                    // Update notification count
                    notificationCount.textContent = events.length;
                    notificationCount.classList.remove('hidden');

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
                events: function(fetchInfo, successCallback, failureCallback) {
                    fetch(`<?= site_url('kalender/events') ?>?start=${fetchInfo.startStr}&end=${fetchInfo.endStr}`)
                        .then(response => response.json())
                        .then(data => successCallback(data))
                        .catch(error => {
                            console.error('Error fetching events:', error);
                            failureCallback(error);
                        });
                },
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
                const event = calendar.getEventById(eventId);

                if (event) {
                    document.getElementById('modalTitle').textContent = 'Edit Acara';
                    document.getElementById('eventId').value = event.id;
                    document.getElementById('eventTitle').value = event.title;
                    document.getElementById('eventDescription').value = event.extendedProps.description || '';

                    // Format dates
                    const startDate = event.start ? new Date(event.start) : new Date();
                    const endDate = event.end ? new Date(event.end) : startDate;

                    // Set date values (YYYY-MM-DD format)
                    document.getElementById('eventStartDate').value = startDate.toISOString().split('T')[0];
                    document.getElementById('eventEndDate').value = endDate.toISOString().split('T')[0];

                    // Set time values if they exist
                    if (event.startStr.includes('T')) {
                        document.getElementById('eventStartTime').value =
                            startDate.getHours().toString().padStart(2, '0') + ':' +
                            startDate.getMinutes().toString().padStart(2, '0');
                    } else {
                        document.getElementById('eventStartTime').value = '';
                    }

                    if (event.endStr.includes('T')) {
                        document.getElementById('eventEndTime').value =
                            endDate.getHours().toString().padStart(2, '0') + ':' +
                            endDate.getMinutes().toString().padStart(2, '0');
                    } else {
                        document.getElementById('eventEndTime').value = '';
                    }

                    // Set color
                    document.getElementById('eventColor').value = event.backgroundColor || '#6366F1';
                    document.getElementById('eventClass').value = event.classNames[0] || 'event-research';

                    // Update color selection UI
                    colorOptions.forEach(opt => opt.classList.remove('selected'));
                    const selectedColor = event.backgroundColor || '#6366F1';
                    document.querySelector(`.color-option[data-color="${selectedColor}"]`).classList.add('selected');

                    // Show delete button
                    document.getElementById('deleteEvent').classList.remove('hidden');

                    closeDetailModalFunc();
                    openModal();
                }
            });

            // Delete event button with enhanced confirmation
            deleteEvent.addEventListener('click', function() {
                const eventId = document.getElementById('eventId').value;
                const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
                const closeDeleteModal = document.getElementById('closeDeleteModal');
                const cancelDelete = document.getElementById('cancelDelete');
                const confirmDelete = document.getElementById('confirmDelete');

                // Function to open delete confirmation modal
                function openDeleteModal() {
                    modalOverlay.classList.add('active');
                    deleteConfirmationModal.classList.add('active');
                    document.body.style.overflow = 'hidden';
                }

                // Function to close delete confirmation modal
                function closeDeleteModalFunc() {
                    modalOverlay.classList.remove('active');
                    deleteConfirmationModal.classList.remove('active');
                    document.body.style.overflow = '';
                }

                // Event listeners for delete modal
                closeDeleteModal.addEventListener('click', closeDeleteModalFunc);
                cancelDelete.addEventListener('click', closeDeleteModalFunc);
                modalOverlay.addEventListener('click', closeDeleteModalFunc);

                // Show the delete confirmation modal
                openDeleteModal();

                // Handle delete confirmation
                // Ganti kode event listener confirmDelete dengan ini:
                confirmDelete.addEventListener('click', function() {
                    const eventId = document.getElementById('eventId').value;
                    const eventToRemove = calendar.getEventById(eventId); // Dapatkan event dari kalender

                    fetch(`<?= site_url('kalender/delete') ?>/${eventId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.status === 'success') {
                                // Hapus event langsung dari kalender
                                if (eventToRemove) {
                                    eventToRemove.remove();
                                }

                                // Tutup modal
                                closeModalFunc();
                                closeDeleteModalFunc();

                                // Tampilkan notifikasi
                                showNotification('success', 'Berhasil', 'Acara berhasil dihapus');

                                // Refresh daftar acara mendatang
                                loadUpcomingEvents();
                            } else {
                                showNotification('error', 'Gagal', 'Gagal menghapus acara: ' + (data.message || 'Terjadi kesalahan'));
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showNotification('error', 'Error', 'Terjadi kesalahan saat menghapus acara');
                        });
                });
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

                // Format date and time
                let start = startDate;
                if (startTime) start += `T${startTime}:00`;

                let end = endDate;
                if (endTime) end += `T${endTime}:00`;

                // For all-day events
                if (!startTime && !endTime) {
                    end = endDate;
                }

                // Create form data
                const formData = new FormData();
                formData.append('title', title);
                formData.append('description', description);
                formData.append('start_date', start);
                formData.append('end_date', end);
                formData.append('color', color);
                formData.append('class_name', eventClass);

                const url = eventId ? `<?= site_url('kalender/update') ?>/${eventId}` : `<?= site_url('kalender/add') ?>`;
                const method = 'POST';

                fetch(url, {
                        method: method,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                        },
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.status === 'success') {
                            // Show success notification
                            const message = eventId ? 'Acara berhasil diperbarui' : 'Acara berhasil ditambahkan';
                            showNotification('success', 'Berhasil', message);

                            // Refresh calendar and close modal
                            if (calendar) {
                                calendar.refetchEvents();
                            }
                            loadUpcomingEvents();
                            closeModalFunc();
                        } else {
                            showNotification('error', 'Gagal', 'Gagal menyimpan acara: ' + (data.message || 'Terjadi kesalahan'));
                            console.error('Error details:', data);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('error', 'Error', 'Terjadi kesalahan saat menyimpan acara: ' + error.message);
                    });
            });

            // Load upcoming events count when page loads
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
                        notificationCount.textContent = events.length;
                        notificationCount.classList.remove('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error loading events count:', error);
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