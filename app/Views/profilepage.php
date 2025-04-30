<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Penta Dosen</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#6366f1',
                        secondary: '#8b5cf6',
                        dark: '#1e293b',
                        light: '#f8fafc',
                    }
                }
            }
        }
    </script>
    <style>
        .profile-bg {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .transition-all {
            transition: all 0.3s ease;
        }
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f8fafc;
        }
    </style>
</head>
<body>
    <div class="min-h-screen">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg">
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="p-4 border-b">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-lg bg-primary flex items-center justify-center text-white mr-3">
                            <i class="fas fa-flask text-xl"></i>
                        </div>
                        <h1 class="text-xl font-bold text-primary">Penta Dosen</h1>
                    </div>
                </div>

                <!-- Menu -->
                <div class="flex-1 overflow-y-auto py-4">
                    <ul class="space-y-1 px-4">
                        <li>
                            <a href="<?= site_url('dashboard') ?>" class="flex items-center px-4 py-3 rounded-lg text-gray-600 hover:text-primary hover:bg-gray-50 font-medium transition-all">
                                <i class="fas fa-tachometer-alt mr-3"></i>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url('kalender') ?>" class="flex items-center px-4 py-3 rounded-lg text-gray-600 hover:text-primary hover:bg-gray-50 font-medium transition-all">
                                <i class="far fa-calendar-alt mr-3"></i>
                                Kalender
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url('penelitian') ?>" class="flex items-center px-4 py-3 rounded-lg text-gray-600 hover:text-primary hover:bg-gray-50 font-medium transition-all">
                                <i class="fas fa-microscope mr-3"></i>
                                Penelitian
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url('publikasi') ?>" class="flex items-center px-4 py-3 rounded-lg text-gray-600 hover:text-primary hover:bg-gray-50 font-medium transition-all">
                                <i class="fas fa-book-open mr-3"></i>
                                Publikasi
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url('hki') ?>" class="flex items-center px-4 py-3 rounded-lg text-gray-600 hover:text-primary hover:bg-gray-50 font-medium transition-all">
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
                            <p class="font-medium text-gray-800"><?= $user['nama'] ?></p>
                            <p class="text-xs text-gray-500"><?= $user['jabatan'] ?></p>
                        </div>
                    </div>
                    <a href="<?= site_url('auth/logout') ?>" class="mt-3 w-full py-2 px-4 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium text-gray-700 transition-all flex items-center justify-center">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="ml-64">
            <!-- Profile Header -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all card-hover mx-6 mt-6">
                <div class="profile-bg h-32 md:h-40 w-full"></div>
                <div class="px-6 py-4 relative">
                    <div class="absolute -top-16 left-6">
                        <div class="h-32 w-32 rounded-full border-4 border-white bg-white shadow-lg overflow-hidden">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Profile" class="h-full w-full object-cover">
                        </div>
                    </div>
                    <div class="ml-40 md:ml-44 pt-2">
                        <h1 class="text-2xl md:text-3xl font-bold text-dark"><?= $user['nama'] ?></h1>
                        <p class="text-gray-600"><?= $user['jabatan'] ?></p>
                        <div class="flex items-center mt-2 space-x-4">
                            <span class="flex items-center text-gray-600">
                                <i class="fas fa-university mr-1 text-primary"></i>
                                <?= $user['universitas'] ?>
                            </span>
                            <span class="flex items-center text-gray-600">
                                <i class="fas fa-graduation-cap mr-1 text-primary"></i>
                                <?= $user['fakultas'] ?>
                            </span>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <a href="<?= site_url('profile/edit') ?>" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-secondary transition-all">
                            <i class="fas fa-edit mr-2"></i>Edit Profile
                        </a>
                        <button onclick="confirmDelete()" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-all">
                            <i class="fas fa-trash-alt mr-2"></i>Hapus Akun
                        </button>
                    </div>
                </div>
            </div>

            <!-- Profile Sections -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mx-6 mt-6">
                <!-- Left Column -->
                <div class="md:col-span-2 space-y-6">
                    <!-- About Section -->
                    <div class="bg-white rounded-xl shadow-md p-6 transition-all card-hover">
                        <h2 class="text-xl font-bold text-dark mb-4 flex items-center">
                            <i class="fas fa-user mr-2 text-primary"></i> Informasi Pribadi
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-gray-500 text-sm">NIDN</p>
                                <p class="text-gray-800 font-medium"><?= $user['nidn'] ?></p>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm">NIP</p>
                                <p class="text-gray-800 font-medium"><?= $user['nip'] ?></p>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm">Inisial</p>
                                <p class="text-gray-800 font-medium"><?= $user['inisial'] ?></p>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm">Jurusan</p>
                                <p class="text-gray-800 font-medium"><?= $user['jurusan'] ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Section -->
                    <div class="bg-white rounded-xl shadow-md p-6 transition-all card-hover">
                        <h2 class="text-xl font-bold text-dark mb-4 flex items-center">
                            <i class="fas fa-envelope mr-2 text-primary"></i> Kontak
                        </h2>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <div class="bg-gray-100 p-2 rounded-full mr-3">
                                    <i class="fas fa-envelope text-primary"></i>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Email</p>
                                    <p class="text-dark"><?= $user['email'] ?></p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="bg-gray-100 p-2 rounded-full mr-3">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Username</p>
                                    <p class="text-dark"><?= $user['username'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Quick Stats -->
                    <div class="bg-white rounded-xl shadow-md p-6 transition-all card-hover">
                        <h2 class="text-xl font-bold text-dark mb-4 flex items-center">
                            <i class="fas fa-chart-bar mr-2 text-primary"></i> Statistik
                        </h2>
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-gray-700">Penelitian</span>
                                    <span class="text-gray-500">12</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-primary h-2 rounded-full" style="width: 80%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-gray-700">Publikasi</span>
                                    <span class="text-gray-500">8</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-primary h-2 rounded-full" style="width: 60%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-gray-700">HKI</span>
                                    <span class="text-gray-500">5</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-primary h-2 rounded-full" style="width: 40%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activities -->
                    <div class="bg-white rounded-xl shadow-md p-6 transition-all card-hover">
                        <h2 class="text-xl font-bold text-dark mb-4 flex items-center">
                            <i class="fas fa-clock mr-2 text-primary"></i> Aktivitas Terbaru
                        </h2>
                        <div class="space-y-4">
                            <div class="border-l-2 border-primary pl-4">
                                <p class="text-gray-700">Menambahkan penelitian baru</p>
                                <p class="text-gray-500 text-sm">2 jam yang lalu</p>
                            </div>
                            <div class="border-l-2 border-primary pl-4">
                                <p class="text-gray-700">Mengupdate profil</p>
                                <p class="text-gray-500 text-sm">1 hari yang lalu</p>
                            </div>
                            <div class="border-l-2 border-primary pl-4">
                                <p class="text-gray-700">Mengupload publikasi</p>
                                <p class="text-gray-500 text-sm">3 hari yang lalu</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete() {
            if (confirm('Apakah Anda yakin ingin menghapus akun Anda? Tindakan ini tidak dapat dibatalkan.')) {
                window.location.href = '<?= site_url('profile/delete') ?>';
            }
        }
    </script>
</body>
</html> 