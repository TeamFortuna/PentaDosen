<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PentaDosen - Platform Penelitian Dosen FTI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    fontFamily: {
                        montserrat: ['Montserrat', 'sans-serif']
                    }
                }
            }
        };
    </script>
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        }

        .feature-card {
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 25px -5px rgba(79, 70, 229, 0.1), 0 10px 10px -5px rgba(79, 70, 229, 0.04);
        }

        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        /* Smooth scroll behavior */
        html {
            scroll-behavior: smooth;
            scroll-padding-top: 80px;
            /* Tinggi navbar Anda */
        }
    </style>
</head>

<body class=" antialiased text-gray-800 bg-gray-50 font-montserrat">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <i class="bi bi-journal-bookmark-fill text-2xl text-indigo-600 mr-2"></i>
                    <span class="text-xl font-bold text-indigo-600">PentaDosen</span>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="#" class="font-medium text-gray-600 hover:text-indigo-800 transition">Beranda</a>
                    <a href="#fitur" class="font-medium text-gray-600 hover:text-indigo-600 transition">Fitur</a>
                    <a href="#alur" class="font-medium text-gray-600 hover:text-indigo-600 transition">Alur Kerja</a>
                    <a href="#tentang" class="font-medium text-gray-600 hover:text-indigo-600 transition">Tentang</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="<?= site_url('login') ?>" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition transform hover:scale-105">
                        Masuk
                    </a>
                    <a href="<?= site_url('register') ?>" class="hidden md:block px-4 py-2 border border-indigo-600 text-indigo-600 rounded-md hover:bg-indigo-50 transition transform hover:scale-105">
                        Daftar
                    </a>
                    <button class="md:hidden focus:outline-none" id="menu-toggle">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-gradient text-white overflow-hidden">
        <div class="container mx-auto px-4 py-20 md:py-32 relative">
            <!-- Floating elements -->
            <div class="absolute top-20 left-10 w-16 h-16 bg-white bg-opacity-10 rounded-full filter blur-md floating" style="animation-delay: 0s;"></div>
            <div class="absolute bottom-20 right-10 w-24 h-24 bg-white bg-opacity-5 rounded-full filter blur-md floating" style="animation-delay: 0.5s;"></div>
            <div class="absolute top-1/3 right-1/4 w-12 h-12 bg-white bg-opacity-7 rounded-full filter blur-md floating" style="animation-delay: 1s;"></div>

            <div class="max-w-4xl mx-auto text-center relative z-10">
                <h1 class="text-4xl md:text-5xl font-bold mb-6" data-aos="fade-up" data-aos-duration="800">
                    Platform Pengelolaan <span class="text-yellow-300">Kegiatan Penelitian</span> Dosen FTI
                </h1>
                <p class="text-xl md:text-2xl mb-8 opacity-90" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                    PentaDosen membantu dosen dalam mengelola proposal penelitian, pelaporan, pendanaan,
                    dan dokumentasi secara <span class="font-semibold">efisien</span> dan <span class="font-semibold">terstruktur</span>.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
                    <a href="<?= site_url('login') ?>" class="px-8 py-3 bg-white text-indigo-600 font-bold rounded-md hover:bg-gray-100 transition transform hover:scale-105 shadow-lg">
                        Mulai Sekarang <i class="bi bi-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold mb-4" data-aos="fade-up">Fitur <span class="text-indigo-600">Unggulan</span> PentaDosen</h2>
                <p class="max-w-2xl mx-auto text-gray-600" data-aos="fade-up" data-aos-delay="200">
                    Solusi lengkap untuk manajemen penelitian dosen dari awal hingga publikasi
                </p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card bg-white p-8 rounded-lg shadow-md" data-aos="fade-up" data-aos-delay="0">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mb-6 mx-auto">
                        <i class="bi bi-file-earmark-text text-3xl text-indigo-600"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-center">Pengelolaan Proposal</h3>
                    <p class="text-gray-600 text-center">
                        Unggah dan pantau status proposal penelitian secara real-time dengan notifikasi perkembangan.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card bg-white p-8 rounded-lg shadow-md" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mb-6 mx-auto">
                        <i class="bi bi-clipboard2-data text-3xl text-indigo-600"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-center">Pelaporan & Dokumentasi</h3>
                    <p class="text-gray-600 text-center">
                        Laporkan kemajuan penelitian dan simpan seluruh dokumentasi dalam satu platform terintegrasi.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card bg-white p-8 rounded-lg shadow-md" data-aos="fade-up" data-aos-delay="400">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mb-6 mx-auto">
                        <i class="bi bi-cash-stack text-3xl text-indigo-600"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-center">Akses Dana Penelitian</h3>
                    <p class="text-gray-600 text-center">
                        Kelola pengajuan dan pencairan dana penelitian dengan sistem yang transparan dan akuntabel.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="alur" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold mb-4" data-aos="fade-up">Alur Kerja <span class="text-indigo-600">PentaDosen</span></h2>
                <p class="max-w-2xl mx-auto text-gray-600" data-aos="fade-up" data-aos-delay="200">
                    Proses terintegrasi untuk memudahkan manajemen penelitian
                </p>
            </div>
            <div class="relative">
                <!-- Timeline line -->
                <div class="hidden md:block absolute left-1/2 top-0 bottom-0 w-1 bg-indigo-100 transform -translate-x-1/2" data-aos="fade-up"></div>

                <!-- Steps -->
                <div class="grid md:grid-cols-4 gap-8 relative">
                    <!-- Step 1 -->
                    <div class="text-center" data-aos="fade-up" data-aos-delay="0">
                        <div class="w-20 h-20 bg-indigo-600 rounded-full flex items-center justify-center mb-4 mx-auto relative z-10 shadow-lg transform hover:scale-110 transition">
                            <span class="text-2xl font-bold text-white">1</span>
                        </div>
                        <h3 class="font-bold mb-2">Pengajuan Proposal</h3>
                        <p class="text-gray-600 text-sm">
                            Unggah proposal penelitian melalui platform
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                        <div class="w-20 h-20 bg-indigo-600 rounded-full flex items-center justify-center mb-4 mx-auto relative z-10 shadow-lg transform hover:scale-110 transition">
                            <span class="text-2xl font-bold text-white">2</span>
                        </div>
                        <h3 class="font-bold mb-2">Review & Persetujuan</h3>
                        <p class="text-gray-600 text-sm">
                            Tim reviewer mengevaluasi proposal
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="text-center" data-aos="fade-up" data-aos-delay="400">
                        <div class="w-20 h-20 bg-indigo-600 rounded-full flex items-center justify-center mb-4 mx-auto relative z-10 shadow-lg transform hover:scale-110 transition">
                            <span class="text-2xl font-bold text-white">3</span>
                        </div>
                        <h3 class="font-bold mb-2">Pelaksanaan Penelitian</h3>
                        <p class="text-gray-600 text-sm">
                            Lapor perkembangan dan dokumentasikan
                        </p>
                    </div>

                    <!-- Step 4 -->
                    <div class="text-center" data-aos="fade-up" data-aos-delay="600">
                        <div class="w-20 h-20 bg-indigo-600 rounded-full flex items-center justify-center mb-4 mx-auto relative z-10 shadow-lg transform hover:scale-110 transition">
                            <span class="text-2xl font-bold text-white">4</span>
                        </div>
                        <h3 class="font-bold mb-2">Publikasi Hasil</h3>
                        <p class="text-gray-600 text-sm">
                            Arsipkan hasil akhir penelitian
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-indigo-600 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-6" data-aos="fade-up">Siap Mengoptimalkan <span class="text-yellow-300">Penelitian</span> Anda?</h2>
            <p class="max-w-2xl mx-auto mb-8 text-indigo-100" data-aos="fade-up" data-aos-delay="200">
                Daftar sekarang dan rasakan kemudahan mengelola penelitian secara digital
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4" data-aos="fade-up" data-aos-delay="400">
                <a href="<?= site_url('') ?>" class="px-8 py-3 bg-white text-indigo-600 font-bold rounded-md hover:bg-gray-100 transition transform hover:scale-105 shadow-lg">
                    Daftar Sekarang
                </a>
            </div>
        </div>
    </section>

    <!-- Floating CTA -->
    <div class="fixed bottom-6 right-6 z-50" data-aos="fade-left" data-aos-delay="800">
        <a href="/register" class="flex items-center justify-center w-16 h-16 bg-indigo-600 text-white rounded-full shadow-lg hover:bg-indigo-700 transition transform hover:scale-110">
            <i class="bi bi-chat-square-text text-2xl"></i>
        </a>
    </div>

    <!-- Di Balik Layar Section - Enhanced Version -->
    <section id="tentang" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-3xl font-bold mb-3 text-gray-800">Tim <span class="text-indigo-600">Kreator</span> PentaDosen</h2>
                <div class="w-20 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 mx-auto mb-6"></div>
                <p class="max-w-2xl mx-auto text-gray-600">
                    Para inovator di balik platform manajemen penelitian dosen yang revolusioner
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-xl overflow-hidden border border-gray-100" data-aos="fade-up" data-aos-delay="200">
                <!-- Team Tabs -->
                <div class="flex border-b border-gray-200">
                    <button class="team-tab active px-6 py-4 font-medium text-indigo-600 border-b-2 border-indigo-600" data-team="fortuna">
                        Tim Fortuna
                    </button>
                    <button class="team-tab px-6 py-4 font-medium text-gray-500 hover:text-indigo-500" data-team="duk">
                        Tim DUK
                    </button>
                </div>

                <div class="p-8 md:p-10">
                    <!-- Tim Fortuna Content -->
                    <div id="fortuna-team" class="team-content active">
                        <div class="grid md:grid-cols-3 gap-6">
                            <!-- Member 1 -->
                            <div class="team-member-card bg-gradient-to-br from-indigo-50 to-white p-6 rounded-lg border border-gray-100 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2">
                                <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4 relative">
                                    <i class="bi bi-code-square text-3xl text-indigo-600"></i>
                                    <div class="absolute -bottom-1 -right-1 bg-indigo-600 text-white text-xs px-2 py-1 rounded-full">TI</div>
                                </div>
                                <h5 class="font-bold text-lg text-center text-gray-800">Muhammad Syafi'ul Umam</h5>
                                <p class="text-sm text-indigo-600 font-medium text-center mb-3">Frontend Developer</p>
                                <div class="flex justify-center space-x-2 mb-3">
                                    <span class="bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded">Teknik Informatika</span>
                                    <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">1402022048</span>
                                </div>
                                <div class="flex justify-center space-x-3 mt-4">
                                    <a href="https://www.instagram.com/umamm.syafiul/" target="_blank" class="text-gray-400 hover:text-pink-600 transition">
                                        <i class="bi bi-instagram"></i>
                                    </a>
                                </div>
                            </div>

                            <!-- Member 2 -->
                            <div class="team-member-card bg-gradient-to-br from-indigo-50 to-white p-6 rounded-lg border border-gray-100 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2">
                                <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4 relative">
                                    <i class="bi bi-database text-3xl text-indigo-600"></i>
                                    <div class="absolute -bottom-1 -right-1 bg-indigo-600 text-white text-xs px-2 py-1 rounded-full">TI</div>
                                </div>
                                <h5 class="font-bold text-lg text-center text-gray-800">Rafly Eryan Azis</h5>
                                <p class="text-sm text-indigo-600 font-medium text-center mb-3">Backend Developer</p>
                                <div class="flex justify-center space-x-2 mb-3">
                                    <span class="bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded">Teknik Informatika</span>
                                    <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">1402022051</span>
                                </div>
                                <div class="flex justify-center space-x-3 mt-4">
                                    <a href="https://www.instagram.com/002_rafly/" target="_blank" class="text-gray-400 hover:text-pink-600 transition">
                                        <i class="bi bi-instagram"></i>
                                    </a>
                                </div>
                            </div>

                            <!-- Member 3 -->
                            <div class="team-member-card bg-gradient-to-br from-indigo-50 to-white p-6 rounded-lg border border-gray-100 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2">
                                <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4 relative">
                                    <i class="bi bi-palette text-3xl text-indigo-600"></i>
                                    <div class="absolute -bottom-1 -right-1 bg-indigo-600 text-white text-xs px-2 py-1 rounded-full">TI</div>
                                </div>
                                <h5 class="font-bold text-lg text-center text-gray-800">Rafi Daniswara</h5>
                                <p class="text-sm text-indigo-600 font-medium text-center mb-3">UI/UX Designer</p>
                                <div class="flex justify-center space-x-2 mb-3">
                                    <span class="bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded">Teknik Informatika</span>
                                    <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">1402022050</span>
                                </div>
                                <div class="flex justify-center space-x-3 mt-4">
                                    <a href="https://www.instagram.com/ravidnss/" target="_blank" class="text-gray-400 hover:text-pink-600 transition">
                                        <i class="bi bi-instagram"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tim DUK Content -->
                    <div id="duk-team" class="team-content hidden">
                        <div class="grid md:grid-cols-3 gap-6">
                            <!-- Member 1 -->
                            <div class="team-member-card bg-gradient-to-br from-indigo-50 to-white p-6 rounded-lg border border-gray-100 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2">
                                <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4 relative">
                                    <i class="bi bi-cloud text-3xl text-indigo-600"></i>
                                    <div class="absolute -bottom-1 -right-1 bg-indigo-600 text-white text-xs px-2 py-1 rounded-full">TI</div>
                                </div>
                                <h5 class="font-bold text-lg text-center text-gray-800">Kiki Aimar Wicaksana</h5>
                                <p class="text-sm text-indigo-600 font-medium text-center mb-3">Cloud Engineer</p>
                                <div class="flex justify-center space-x-2 mb-3">
                                    <span class="bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded">Teknik Informatika</span>
                                    <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">1402022030</span>
                                </div>
                                <div class="flex justify-center space-x-3 mt-4">
                                    <a href="https://www.instagram.com/kim.aimarr/" target="_blank" class="text-gray-400 hover:text-pink-600 transition">
                                        <i class="bi bi-instagram"></i>
                                    </a>
                                </div>
                            </div>

                            <!-- Member 2 -->
                            <div class="team-member-card bg-gradient-to-br from-indigo-50 to-white p-6 rounded-lg border border-gray-100 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2">
                                <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4 relative">
                                    <i class="bi bi-code-slash text-3xl text-indigo-600"></i>
                                    <div class="absolute -bottom-1 -right-1 bg-indigo-600 text-white text-xs px-2 py-1 rounded-full">TI</div>
                                </div>
                                <h5 class="font-bold text-lg text-center text-gray-800">Muhammad Syafi'ul Umam</h5>
                                <p class="text-sm text-indigo-600 font-medium text-center mb-3">Fullstack Developer</p>
                                <div class="flex justify-center space-x-2 mb-3">
                                    <span class="bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded">Teknik Informatika</span>
                                    <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">1402022048</span>
                                </div>
                                <div class="flex justify-center space-x-3 mt-4">
                                    <a href="https://www.instagram.com/umamm.syafiul/" target="_blank" class="text-gray-400 hover:text-pink-600 transition">
                                        <i class="bi bi-instagram"></i>
                                    </a>
                                </div>
                            </div>

                            <!-- Member 3 -->
                            <div class="team-member-card bg-gradient-to-br from-indigo-50 to-white p-6 rounded-lg border border-gray-100 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2">
                                <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4 relative">
                                    <i class="bi bi-palette text-3xl text-indigo-600"></i>
                                    <div class="absolute -bottom-1 -right-1 bg-indigo-600 text-white text-xs px-2 py-1 rounded-full">TI</div>
                                </div>
                                <h5 class="font-bold text-lg text-center text-gray-800">Rafi Daniswara</h5>
                                <p class="text-sm text-indigo-600 font-medium text-center mb-3">UI/UX Designer</p>
                                <div class="flex justify-center space-x-2 mb-3">
                                    <span class="bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded">Teknik Informatika</span>
                                    <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">1402022050</span>
                                </div>
                                <div class="flex justify-center space-x-3 mt-4">
                                    <a href="https://www.instagram.com/ravidnss/" target="_blank" class="text-gray-400 hover:text-pink-600 transition">
                                        <i class="bi bi-instagram"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Team Quote -->
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6 text-center">
                    <i class="bi bi-quote text-3xl text-white opacity-30 mb-4"></i>
                    <p class="text-white font-medium text-lg">
                        "Inovasi adalah hasil dari kolaborasi tim yang solid dan dedikasi tanpa batas."
                    </p>
                    <p class="text-indigo-200 text-sm mt-2">- Tim PentaDosen -</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white pt-12 pb-6">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="grid md:grid-cols-3 gap-8 mb-8">
                <!-- Brand Info -->
                <div data-aos="fade-up" class="md:col-span-1">
                    <div class="flex items-center mb-4">
                        <i class="bi bi-journal-bookmark-fill text-2xl text-indigo-400 mr-2"></i>
                        <span class="text-xl font-bold">PentaDosen</span>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Platform Pengelolaan Kegiatan Penelitian Dosen FTI yang membantu proses penelitian dari proposal hingga publikasi.
                    </p>
                </div>

                <!-- Quick Links -->
                <div data-aos="fade-up" data-aos-delay="200" class="md:col-span-1">
                    <h4 class="text-lg font-bold mb-4 text-indigo-300">Navigasi Cepat</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-white transition flex items-center">
                                <i class="bi bi-chevron-right text-xs mr-2 text-indigo-400"></i> Beranda
                            </a></li>
                        <li><a href="#fitur" class="text-gray-400 hover:text-white transition flex items-center">
                                <i class="bi bi-chevron-right text-xs mr-2 text-indigo-400"></i> Fitur
                            </a></li>
                        <li><a href="#alur" class="text-gray-400 hover:text-white transition flex items-center">
                                <i class="bi bi-chevron-right text-xs mr-2 text-indigo-400"></i> Alur Kerja
                            </a></li>
                        <li><a href="#testimoni" class="text-gray-400 hover:text-white transition flex items-center">
                                <i class="bi bi-chevron-right text-xs mr-2 text-indigo-400"></i> Testimoni
                            </a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div data-aos="fade-up" data-aos-delay="400" class="md:col-span-1">
                    <h4 class="text-lg font-bold mb-4 text-indigo-300">Hubungi Kami</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li class="flex items-start">
                            <i class="bi bi-geo-alt text-indigo-400 mt-1 mr-3"></i>
                            <span class="text-sm">Menara Yarsi, Jl. Letjen Suprapto No.Kav.13, RT.10/RW.5, Cemp. Putih Tim., Kec. Cemp. Putih, Kota Jakarta Pusat</span>
                        </li>
                        <li class="flex items-center">
                            <i class="bi bi-envelope text-indigo-400 mr-3"></i>
                            <span class="text-sm">fortunateams3@gmail.com</span>
                        </li>
                        <li class="flex items-center">
                            <i class="bi bi-telephone text-indigo-400 mr-3"></i>
                            <span class="text-sm">(021) 4206674</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-gray-700 pt-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-400 text-xs mb-4 md:mb-0">
                        &copy; 2024 PentaDosen. All rights reserved.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="bi bi-linkedin"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true
        });

        // Counter animation
        const counters = document.querySelectorAll('.counter');
        const speed = 200;

        counters.forEach(counter => {
            const updateCount = () => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText;
                const increment = target / speed;

                if (count < target) {
                    counter.innerText = Math.ceil(count + increment);
                    setTimeout(updateCount, 1);
                } else {
                    counter.innerText = target;
                }
            }

            updateCount();
        });

        // Mobile menu toggle
        document.getElementById('menu-toggle').addEventListener('click', function() {
            const menu = document.querySelector('.md\\:flex.space-x-8');
            menu.classList.toggle('hidden');
            menu.classList.toggle('flex');
            menu.classList.toggle('flex-col');
            menu.classList.toggle('absolute');
            menu.classList.toggle('top-16');
            menu.classList.toggle('left-0');
            menu.classList.toggle('right-0');
            menu.classList.toggle('bg-white');
            menu.classList.toggle('p-4');
            menu.classList.toggle('shadow-md');
        });

        // Smooth scroll dengan offset
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                if (this.getAttribute('href') === '#') return;

                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                const navbarHeight = document.querySelector('nav').offsetHeight;

                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - navbarHeight,
                        behavior: 'smooth'
                    });

                    // Update URL tanpa trigger scroll
                    history.pushState(null, null, this.getAttribute('href'));
                }
            });
        });

        // Team Tab Functionality
        document.querySelectorAll('.team-tab').forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active class from all tabs and contents
                document.querySelectorAll('.team-tab').forEach(t => t.classList.remove('active', 'text-indigo-600', 'border-indigo-600'));
                document.querySelectorAll('.team-tab').forEach(t => t.classList.add('text-gray-500'));
                document.querySelectorAll('.team-content').forEach(c => c.classList.add('hidden'));

                // Add active class to clicked tab and show corresponding content
                tab.classList.add('active', 'text-indigo-600', 'border-indigo-600');
                tab.classList.remove('text-gray-500');
                document.getElementById(`${tab.dataset.team}-team`).classList.remove('hidden');
            });
        });

        // Add hover animation to team member cards
        document.querySelectorAll('.team-member-card').forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.querySelector('i').classList.add('animate-pulse');
            });
            card.addEventListener('mouseleave', () => {
                card.querySelector('i').classList.remove('animate-pulse');
            });
        });
    </script>
</body>

</html>