<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            400: '#818cf8',
                            500: '#6366f1',
                            600: '#4f46e5',
                        },
                        secondary: '#f43f5e',
                        gradient: {
                            start: '#a78bfa',
                            mid: '#c084fc',
                            end: '#e879f9',
                        }
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'bounce-slow': 'bounce-slow 3s infinite',
                        'wave': 'wave 2s linear infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': {
                                transform: 'translateY(0)'
                            },
                            '50%': {
                                transform: 'translateY(-20px)'
                            },
                        },
                        'bounce-slow': {
                            '0%, 100%': {
                                transform: 'translateY(0)',
                                animationTimingFunction: 'cubic-bezier(0.8,0,1,1)'
                            },
                            '50%': {
                                transform: 'translateY(-15px)',
                                animationTimingFunction: 'cubic-bezier(0,0,0.2,1)'
                            }
                        },
                        'wave': {
                            '0%': {
                                transform: 'rotate(0deg)'
                            },
                            '10%': {
                                transform: 'rotate(14deg)'
                            },
                            '20%': {
                                transform: 'rotate(-8deg)'
                            },
                            '30%': {
                                transform: 'rotate(14deg)'
                            },
                            '40%': {
                                transform: 'rotate(-4deg)'
                            },
                            '50%': {
                                transform: 'rotate(10deg)'
                            },
                            '60%': {
                                transform: 'rotate(0deg)'
                            },
                            '100%': {
                                transform: 'rotate(0deg)'
                            },
                        }
                    },
                    fontFamily: {
                        montserrat: ['Montserrat', 'sans-serif']
                    },
                }
            }
        }
    </script>
    <style type="text/css">
        body {
            background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 50%, #fdf2f8 100%);
            background-attachment: fixed;
            background-size: 200% 200%;
            animation: gradient 15s ease infinite;
            overflow-x: hidden;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .card-gradient {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.95) 100%);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .input-glow:focus {
            box-shadow: 0 0 0 3px rgba(199, 210, 254, 0.5);
        }

        .animate-entry {
            opacity: 0;
            transform: translateY(20px);
        }

        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            opacity: 0;
            z-index: 10;
        }

        .form-step {
            display: none;
            animation: fadeIn 0.5s ease-out;
        }

        .form-step.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .progress-bar {
            height: 6px;
            background-color: #e5e7eb;
            border-radius: 3px;
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .progress {
            height: 100%;
            background: linear-gradient(to right, #6366f1, #8b5cf6);
            transition: width 0.4s ease;
        }

        /* Success Modal Styles */
        .success-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .success-modal.active {
            opacity: 1;
            pointer-events: all;
        }

        .success-content {
            background: white;
            border-radius: 20px;
            padding: 40px;
            max-width: 500px;
            width: 90%;
            text-align: center;
            position: relative;
            overflow: hidden;
            transform: scale(0.8);
            transition: transform 0.3s ease;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
        }

        .success-modal.active .success-content {
            transform: scale(1);
        }

        .checkmark-circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            margin: 0 auto 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            animation: scaleIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .checkmark {
            width: 50px;
            height: 50px;
            display: block;
            stroke-width: 5;
            stroke: #fff;
            stroke-miterlimit: 10;
            margin: 10% auto;
            animation: checkmark 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
        }

        .checkmark-check {
            transform-origin: 50% 50%;
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
        }

        @keyframes checkmark {
            0% {
                stroke-dashoffset: 48;
            }

            100% {
                stroke-dashoffset: 0;
            }
        }

        @keyframes scaleIn {
            0% {
                transform: scale(0);
            }

            80% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        .success-bg-circle {
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(99, 102, 241, 0.1);
            top: -150px;
            right: -150px;
            z-index: -1;
        }

        .success-bg-circle:nth-child(2) {
            top: auto;
            right: auto;
            bottom: -150px;
            left: -150px;
            background: rgba(139, 92, 246, 0.1);
        }

        .success-btn {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            margin-top: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(99, 102, 241, 0.3);
        }

        .success-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4);
        }

        .success-btn:active {
            transform: translateY(0);
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4 font-montserrat antialiased">
    <!-- Floating decorative elements -->
    <div class="fixed top-20 left-10 w-32 h-32 rounded-full bg-purple-100 opacity-40 blur-xl animate-float"></div>
    <div class="fixed bottom-20 right-10 w-40 h-40 rounded-full bg-pink-100 opacity-40 blur-xl animate-float animation-delay-2000"></div>
    <div class="fixed top-1/3 right-1/4 w-24 h-24 rounded-full bg-indigo-100 opacity-30 blur-xl animate-float animation-delay-3000"></div>

    <!-- Confetti container -->
    <div id="confetti-container"></div>

    <!-- Success Modal -->
    <div id="successModal" class="success-modal">
        <div class="success-content">
            <div class="success-bg-circle"></div>
            <div class="success-bg-circle"></div>

            <div class="checkmark-circle">
                <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                    <circle class="checkmark-circle-bg" cx="26" cy="26" r="25" fill="none" />
                    <path class="checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
                </svg>
            </div>

            <h2 class="text-3xl font-bold text-gray-800 mb-3">Registrasi Berhasil!</h2>
            <p class="text-gray-600 mb-6">Akun Anda berhasil dibuat. Silakan login untuk melanjutkan.</p>

            <button id="successBtn" class="success-btn">
                Lanjutkan ke Halaman Login
            </button>
        </div>
    </div>

    <div class="relative z-10 w-full max-w-md">
        <!-- Main card with subtle gradient border -->
        <div class="relative overflow-hidden rounded-2xl shadow-xl transform transition-all duration-500 hover:scale-[1.01]">
            <!-- Gradient border effect -->
            <div class="absolute inset-0 bg-gradient-to-br from-gradient-start via-gradient-mid to-gradient-end opacity-20"></div>

            <!-- Floating bubbles inside card -->
            <div class="absolute -top-10 -left-10 w-20 h-20 rounded-full bg-purple-200 opacity-20 animate-float"></div>
            <div class="absolute -bottom-5 -right-5 w-16 h-16 rounded-full bg-pink-200 opacity-20 animate-float animation-delay-1500"></div>

            <!-- Main card content -->
            <div class="card-gradient relative rounded-2xl border border-white/20 p-8 backdrop-blur-sm">
                <div class="text-center mb-6 animate-entry">
                    <div class="w-20 h-20 bg-gradient-to-r from-primary-500 to-secondary mx-auto rounded-2xl flex items-center justify-center shadow-lg mb-4 animate-pulse-slow hover:animate-wave cursor-pointer">
                        <i class="fas fa-user-plus text-white text-3xl"></i>
                    </div>
                    <h1 class="text-3xl font-extrabold text-gray-800 transform transition-all duration-500 hover:scale-105 inline-block">
                        Daftar Akun
                    </h1>
                    <p class="mt-2 text-gray-600 transform transition-all duration-500 hover:scale-100 hover:translate-x-1 inline-block">
                        Buat akun akademis Anda
                    </p>
                </div>

                <!-- Progress Bar -->
                <div class="progress-bar animate-entry" style="animation-delay: 0.1s">
                    <div class="progress" id="progressBar" style="width: 50%"></div>
                </div>


                <!-- Tambahkan setelah div card-gradient -->
                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">Error!</strong>
                        <ul>
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= $error ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                <?php endif ?>
                <form class="space-y-4" id="registerForm" action="<?= base_url('register') ?>" method="post">
                    <!-- STEP 1 - Personal & Academic Info -->
                    <div class="form-step active" id="step1">
                        <!-- Nama -->
                        <div class="group animate-entry" style="animation-delay: 0.1s">
                            <label for="nama" class="block text-sm font-medium text-gray-700 mb-1 transition-all duration-300 group-focus-within:text-primary-600">
                                Nama Lengkap
                            </label>
                            <div class="relative transition-all duration-300">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary-500 transition-colors duration-300">
                                    <i class="fas fa-user"></i>
                                </div>
                                <input type="text" id="nama" name="nama"
                                    class="input-glow block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl bg-white/80 focus:ring-2 focus:ring-primary-400 focus:border-transparent placeholder-gray-400 transition-all duration-300 shadow-sm hover:shadow-md"
                                    placeholder="Nama lengkap dan gelarnya" required>
                            </div>
                        </div>

                        <!-- NIDN -->
                        <div class="group animate-entry" style="animation-delay: 0.15s">
                            <label for="nidn" class="block text-sm font-medium text-gray-700 mb-1 transition-all duration-300 group-focus-within:text-primary-600">
                                NIDN
                            </label>
                            <div class="relative transition-all duration-300">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary-500 transition-colors duration-300">
                                    <i class="fas fa-id-card"></i>
                                </div>
                                <input type="text" id="nidn" name="nidn"
                                    class="input-glow block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl bg-white/80 focus:ring-2 focus:ring-primary-400 focus:border-transparent placeholder-gray-400 transition-all duration-300 shadow-sm hover:shadow-md"
                                    placeholder="Masukkan 10 digit NIDN"
                                    maxlength="12"
                                    required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span id="nidnStatus" class="text-xs hidden"></span>
                                </div>
                            </div>
                        </div>

                        <!-- NIP -->
                        <div class="group animate-entry" style="animation-delay: 0.2s">
                            <label for="nip" class="block text-sm font-medium text-gray-700 mb-1 transition-all duration-300 group-focus-within:text-primary-600">
                                NIP
                            </label>
                            <div class="relative transition-all duration-300">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary-500 transition-colors duration-300">
                                    <i class="fas fa-id-badge"></i>
                                </div>
                                <input type="text" id="nip" name="nip"
                                    class="input-glow block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl bg-white/80 focus:ring-2 focus:ring-primary-400 focus:border-transparent placeholder-gray-400 transition-all duration-300 shadow-sm hover:shadow-md"
                                    placeholder="Masukkan 18 digit NIP"
                                    maxlength="21"
                                    required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span id="nipStatus" class="text-xs hidden"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Inisial Nama -->
                        <div class="group animate-entry" style="animation-delay: 0.25s">
                            <label for="inisial" class="block text-sm font-medium text-gray-700 mb-1 transition-all duration-300 group-focus-within:text-primary-600">
                                Inisial Nama
                            </label>
                            <div class="relative transition-all duration-300">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary-500 transition-colors duration-300">
                                    <i class="fas fa-signature"></i>
                                </div>
                                <input type="text" id="inisial" name="inisial"
                                    class="input-glow block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl bg-white/80 focus:ring-2 focus:ring-primary-400 focus:border-transparent placeholder-gray-400 transition-all duration-300 shadow-sm hover:shadow-md"
                                    placeholder="cth. TH untuk Taufiqul Hakim" required readonly>
                            </div>
                        </div>

                        <!-- Jabatan Akademik -->
                        <div class="group animate-entry" style="animation-delay: 0.3s">
                            <label for="jabatan" class="block text-sm font-medium text-gray-700 mb-1 transition-all duration-300 group-focus-within:text-primary-600">
                                Jabatan Akademik
                            </label>
                            <div class="relative transition-all duration-300">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary-500 transition-colors duration-300">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <select id="jabatan" name="jabatan"
                                    class="input-glow block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl bg-white/80 focus:ring-2 focus:ring-primary-400 focus:border-transparent placeholder-gray-400 transition-all duration-300 shadow-sm hover:shadow-md appearance-none" required>
                                    <option value="" disabled selected>Pilih Jabatan Akademik</option>
                                    <option value="Asisten Ahli">Asisten Ahli</option>
                                    <option value="Lektor">Lektor</option>
                                    <option value="Lektor Kepala">Lektor Kepala</option>
                                    <option value="Guru Besar">Guru Besar</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Universitas -->
                        <div class="group animate-entry" style="animation-delay: 0.35s">
                            <label for="universitas" class="block text-sm font-medium text-gray-700 mb-1 transition-all duration-300 group-focus-within:text-primary-600">
                                Universitas
                            </label>
                            <div class="relative transition-all duration-300">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary-500 transition-colors duration-300">
                                    <i class="fas fa-university"></i>
                                </div>
                                <select id="universitas" name="universitas"
                                    class="input-glow block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl bg-white/80 focus:ring-2 focus:ring-primary-400 focus:border-transparent placeholder-gray-400 transition-all duration-300 shadow-sm hover:shadow-md appearance-none" required>
                                    <option value="" disabled selected>Pilih Universitas</option>
                                    <option value="Universitas Yarsi">Universitas Yarsi</option>
                                    <option value="Other">Lainnya (isi sendiri)</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Other University (hidden by default) -->
                        <div id="otherUnivContainer" class="group animate-entry hidden" style="animation-delay: 0.4s">
                            <label for="otherUniv" class="block text-sm font-medium text-gray-700 mb-1 transition-all duration-300 group-focus-within:text-primary-600">
                                Masukkan Universitas Anda
                            </label>
                            <div class="relative transition-all duration-300">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary-500 transition-colors duration-300">
                                    <i class="fas fa-edit"></i>
                                </div>
                                <input type="text" id="otherUniv" name="otherUniv"
                                    class="input-glow block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl bg-white/80 focus:ring-2 focus:ring-primary-400 focus:border-transparent placeholder-gray-400 transition-all duration-300 shadow-sm hover:shadow-md"
                                    placeholder="Enter your university name">
                            </div>
                        </div>

                        <!-- Next Button -->
                        <div class="pt-2 animate-entry" style="animation-delay: 0.45s">
                            <button type="button" id="nextBtn"
                                class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl text-sm font-medium text-white bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-400 hover:to-primary-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-400 shadow-md hover:shadow-lg transition-all duration-300 group">
                                <span class="mr-2 group-hover:translate-x-1 transition-transform duration-300">Lanjutkan</span>
                                <i class="fas fa-arrow-right transform group-hover:translate-x-2 group-hover:scale-110 transition-transform duration-300"></i>
                            </button>
                        </div>
                    </div>

                    <!-- STEP 2 - Faculty & Account Info -->
                    <div class="form-step" id="step2">
                        <!-- Fakultas -->
                        <div class="group animate-entry" style="animation-delay: 0.1s">
                            <label for="fakultas" class="block text-sm font-medium text-gray-700 mb-1 transition-all duration-300 group-focus-within:text-primary-600">
                                Fakultas
                            </label>
                            <div class="relative transition-all duration-300">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary-500 transition-colors duration-300">
                                    <i class="fas fa-building"></i>
                                </div>
                                <select id="fakultas" name="fakultas"
                                    class="input-glow block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl bg-white/80 focus:ring-2 focus:ring-primary-400 focus:border-transparent placeholder-gray-400 transition-all duration-300 shadow-sm hover:shadow-md appearance-none" required>
                                    <option value="" disabled selected>Pilih Fakultas</option>
                                    <option value="Fakultas Kedokteran">Fakultas Kedokteran</option>
                                    <option value="Fakultas Kedokteran Gigi">Fakultas Kedokteran Gigi</option>
                                    <option value="Fakultas Teknologi Informasi">Fakultas Teknologi Informasi</option>
                                    <option value="Fakultas Ekonomi Bisnis">Fakultas Ekonomi Bisnis</option>
                                    <option value="Fakultas Hukum">Fakultas Hukum</option>
                                    <option value="Fakultas Psikologi">Fakultas Psikologi</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Jurusan -->
                        <div class="group animate-entry" style="animation-delay: 0.15s">
                            <label for="jurusan" class="block text-sm font-medium text-gray-700 mb-1 transition-all duration-300 group-focus-within:text-primary-600">
                                Jurusan
                            </label>
                            <div class="relative transition-all duration-300">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary-500 transition-colors duration-300">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                <select id="jurusan" name="jurusan"
                                    class="input-glow block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl bg-white/80 focus:ring-2 focus:ring-primary-400 focus:border-transparent placeholder-gray-400 transition-all duration-300 shadow-sm hover:shadow-md appearance-none" required disabled>
                                    <option value="" disabled selected>Pilih Jurusan</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="group animate-entry" style="animation-delay: 0.2s">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1 transition-all duration-300 group-focus-within:text-primary-600">
                                Email Address
                            </label>
                            <div class="relative transition-all duration-300">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary-500 transition-colors duration-300">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <input type="email" id="email" name="email"
                                    class="input-glow block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl bg-white/80 focus:ring-2 focus:ring-primary-400 focus:border-transparent placeholder-gray-400 transition-all duration-300 shadow-sm hover:shadow-md"
                                    placeholder="your@email.com" required>
                            </div>
                        </div>

                        <!-- Username -->
                        <div class="group animate-entry" style="animation-delay: 0.25s">
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-1 transition-all duration-300 group-focus-within:text-primary-600">
                                Username
                            </label>
                            <div class="relative transition-all duration-300">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary-500 transition-colors duration-300">
                                    <i class="fas fa-at"></i>
                                </div>
                                <input type="text" id="username" name="username"
                                    class="input-glow block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl bg-white/80 focus:ring-2 focus:ring-primary-400 focus:border-transparent placeholder-gray-400 transition-all duration-300 shadow-sm hover:shadow-md"
                                    placeholder="Choose a username" required>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="group animate-entry" style="animation-delay: 0.3s">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1 transition-all duration-300 group-focus-within:text-primary-600">
                                Password
                            </label>
                            <div class="relative transition-all duration-300">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary-500 transition-colors duration-300">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <input type="password" id="password" name="password"
                                    class="input-glow block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl bg-white/80 focus:ring-2 focus:ring-primary-400 focus:border-transparent placeholder-gray-400 transition-all duration-300 shadow-sm hover:shadow-md"
                                    placeholder="••••••••" required>
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors duration-300 password-toggle">
                                    <i class="fas fa-eye-slash"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="group animate-entry" style="animation-delay: 0.35s">
                            <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-1 transition-all duration-300 group-focus-within:text-primary-600">
                                Confirm Password
                            </label>
                            <div class="relative transition-all duration-300">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary-500 transition-colors duration-300">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <input type="password" id="confirmPassword" name="confirmPassword"
                                    class="input-glow block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl bg-white/80 focus:ring-2 focus:ring-primary-400 focus:border-transparent placeholder-gray-400 transition-all duration-300 shadow-sm hover:shadow-md"
                                    placeholder="••••••••" required>
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors duration-300 password-toggle">
                                    <i class="fas fa-eye-slash"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="flex space-x-4 pt-2 animate-entry" style="animation-delay: 0.4s">
                            <!-- Back Button -->
                            <button type="button" id="backBtn"
                                class="w-1/2 flex justify-center items-center py-3 px-4 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-400 shadow-sm hover:shadow-md transition-all duration-300 group">
                                <i class="fas fa-arrow-left transform group-hover:-translate-x-1 group-hover:scale-110 transition-transform duration-300 mr-2"></i>
                                <span class="group-hover:-translate-x-0.5 transition-transform duration-300">Kembali</span>
                            </button>

                            <!-- Register Button -->
                            <button type="submit" id="registerButton"
                                class="w-1/2 flex justify-center items-center py-3 px-4 border border-transparent rounded-xl text-sm font-medium text-white bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-400 hover:to-primary-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-400 shadow-md hover:shadow-lg transition-all duration-300 group">
                                <span class="mr-2 group-hover:translate-x-1 transition-transform duration-300">Daftar</span>
                                <i class="fas fa-user-plus transform group-hover:translate-x-2 group-hover:scale-110 transition-transform duration-300"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <div class="mt-6 text-center animate-entry" style="animation-delay: 0.8s">
                    <p class="text-sm text-gray-600">
                        Sudah punya akun?
                        <a href="<?= site_url('login') ?>" class="font-medium text-primary-500 hover:text-primary-600 transition-colors duration-300 hover:underline">
                            Masuk
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-6 text-center animate-entry" style="animation-delay: 0.85s">
            <p class="text-xs text-gray-500 hover:text-gray-700 transition-colors duration-300">
                &copy; 2024 PentaDosen. All rights reserved.
            </p>
        </div>
    </div>

    <script>
        // Initialize GSAP animations
        document.addEventListener('DOMContentLoaded', () => {
            // Animate entry elements
            gsap.to('.animate-entry', {
                opacity: 1,
                y: 0,
                duration: 0.6,
                stagger: 0.1,
                ease: "back.out(1.2)"
            });

            // User icon hover effect
            const userIcon = document.querySelector('.fa-user-plus');
            userIcon.parentElement.addEventListener('mouseenter', () => {
                gsap.to(userIcon, {
                    y: -5,
                    duration: 0.3,
                    repeat: 1,
                    yoyo: true,
                    ease: "power1.inOut"
                });
            });

            // Form submission effect
            const form = document.getElementById('registerForm');
            form.addEventListener('submit', (e) => {
                e.preventDefault();

                // Button press animation
                gsap.to('#registerButton', {
                    scale: 0.95,
                    duration: 0.2,
                    yoyo: true,
                    repeat: 1,
                    ease: "power1.inOut",
                    onComplete: function() {
                        // Show success modal
                        showSuccessModal();

                        // In a real app, you would submit the form here
                        form.submit();
                    }
                });
            });

            // Success modal button - Redirect to login page
            document.getElementById('successBtn').addEventListener('click', function() {
                window.location.href = "<?= site_url('login') ?>";
            });
        });

        // Show success modal with animations
        function showSuccessModal() {
            const modal = document.getElementById('successModal');
            const confettiContainer = document.getElementById('confetti-container');

            // Show modal
            modal.classList.add('active');

            // Create confetti explosion
            createConfetti();

        }

        // Function to generate initials from full name
        function generateInitials(fullName) {
            // Split the name into parts
            const nameParts = fullName.split(' ');
            let initials = '';

            // Take the first letter of each part (up to 3 parts)
            for (let i = 0; i < Math.min(nameParts.length, 3); i++) {
                if (nameParts[i].length > 0) {
                    initials += nameParts[i][0].toUpperCase();
                }
            }

            return initials;
        }

        // Listen for input changes on the nama field
        document.getElementById('nama').addEventListener('input', function() {
            const fullName = this.value.trim();
            const initialsField = document.getElementById('inisial');

            if (fullName.length > 0) {
                // Generate and set the initials
                initialsField.value = generateInitials(fullName);
            } else {
                // Clear if name is empty
                initialsField.value = '';
            }
        });

        // Toggle password visibility
        document.querySelectorAll('.password-toggle').forEach(btn => {
            const input = btn.parentElement.querySelector('input');
            btn.addEventListener('click', () => {
                if (input.type === 'password') {
                    input.type = 'text';
                    btn.innerHTML = '<i class="fas fa-eye"></i>';
                    btn.classList.add('text-primary-500');
                } else {
                    input.type = 'password';
                    btn.innerHTML = '<i class="fas fa-eye-slash"></i>';
                    btn.classList.remove('text-primary-500');
                }
            });
        });

        // University selection handler
        document.getElementById('universitas').addEventListener('change', function() {
            const otherUnivContainer = document.getElementById('otherUnivContainer');
            if (this.value === 'Other') {
                otherUnivContainer.classList.remove('hidden');
                document.getElementById('otherUniv').required = true;
            } else {
                otherUnivContainer.classList.add('hidden');
                document.getElementById('otherUniv').required = false;
            }
        });

        // Faculty selection handler
        document.getElementById('fakultas').addEventListener('change', function() {
            const jurusanSelect = document.getElementById('jurusan');
            jurusanSelect.innerHTML = '<option value="" disabled selected>Select your department</option>';
            jurusanSelect.disabled = false;

            // Populate departments based on faculty
            switch (this.value) {
                case 'Fakultas Kedokteran':
                    jurusanSelect.innerHTML += '<option value="Kedokteran">Kedokteran</option>';
                    break;
                case 'Fakultas Kedokteran Gigi':
                    jurusanSelect.innerHTML += '<option value="Kedokteran Gigi">Kedokteran Gigi</option>';
                    break;
                case 'Fakultas Teknologi Informasi':
                    jurusanSelect.innerHTML += '<option value="Teknik Informatika">Teknik Informatika</option>';
                    jurusanSelect.innerHTML += '<option value="Perpustakaan dan Sains Informasi">Perpustakaan dan Sains Informasi</option>';
                    break;
                case 'Fakultas Ekonomi Bisnis':
                    jurusanSelect.innerHTML += '<option value="Manajemen">Manajemen</option>';
                    jurusanSelect.innerHTML += '<option value="Akuntansi">Akuntansi</option>';
                    break;
                case 'Fakultas Hukum':
                    jurusanSelect.innerHTML += '<option value="Hukum">Hukum</option>';
                    break;
                case 'Fakultas Psikologi':
                    jurusanSelect.innerHTML += '<option value="Psikologi">Psikologi</option>';
                    break;
                default:
                    jurusanSelect.disabled = true;
            }
        });

        // Auto-format NIDN (1-900501-123)
        document.getElementById('nidn').addEventListener('input', function(e) {
            // Only allow numbers
            this.value = this.value.replace(/[^0-9]/g, '');

            // Auto-insert hyphens at specific positions
            if (this.value.length > 1) {
                this.value = this.value.substring(0, 1) + '-' + this.value.substring(1);
            }
            if (this.value.length > 8) {
                this.value = this.value.substring(0, 8) + '-' + this.value.substring(8);
            }

            // Limit to 10 digits (plus 2 hyphens)
            if (this.value.length > 12) {
                this.value = this.value.substring(0, 12);
            }

            // Validate format
            const nidnStatus = document.getElementById('nidnStatus');
            if (this.value.length === 12) {
                this.classList.remove('border-red-300', 'bg-red-50');
                this.classList.add('border-green-300', 'bg-green-50');
                nidnStatus.textContent = '✓';
                nidnStatus.classList.remove('text-red-500', 'hidden');
                nidnStatus.classList.add('text-green-500');
            } else {
                this.classList.remove('border-green-300', 'bg-green-50');
                this.classList.add('border-red-300', 'bg-red-50');
                nidnStatus.textContent = 'Masukkan 10 digit';
                nidnStatus.classList.remove('text-green-500', 'hidden');
                nidnStatus.classList.add('text-red-500');
            }
        });

        // Auto-format NIP (19700101-199403-10-02)
        document.getElementById('nip').addEventListener('input', function(e) {
            // Only allow numbers
            this.value = this.value.replace(/[^0-9]/g, '');

            // Auto-insert hyphens at specific positions
            if (this.value.length > 8) {
                this.value = this.value.substring(0, 8) + '-' + this.value.substring(8);
            }
            if (this.value.length > 15) {
                this.value = this.value.substring(0, 15) + '-' + this.value.substring(15);
            }
            if (this.value.length > 18) {
                this.value = this.value.substring(0, 18) + '-' + this.value.substring(18);
            }

            // Limit to 18 digits (plus 3 hyphens)
            if (this.value.length > 21) {
                this.value = this.value.substring(0, 21);
            }

            // Validate format
            const nipStatus = document.getElementById('nipStatus');
            if (this.value.length === 21) {
                this.classList.remove('border-red-300', 'bg-red-50');
                this.classList.add('border-green-300', 'bg-green-50');
                nipStatus.textContent = '✓';
                nipStatus.classList.remove('text-red-500', 'hidden');
                nipStatus.classList.add('text-green-500');
            } else {
                this.classList.remove('border-green-300', 'bg-green-50');
                this.classList.add('border-red-300', 'bg-red-50');
                nipStatus.textContent = 'Masukkan 18 digit';
                nipStatus.classList.remove('text-green-500', 'hidden');
                nipStatus.classList.add('text-red-500');
            }
        });

        // Form Navigation
        const step1 = document.getElementById('step1');
        const step2 = document.getElementById('step2');
        const nextBtn = document.getElementById('nextBtn');
        const backBtn = document.getElementById('backBtn');
        const progressBar = document.getElementById('progressBar');

        nextBtn.addEventListener('click', function() {
            if (validateStep1()) {
                step1.classList.remove('active');
                step2.classList.add('active');
                progressBar.style.width = '100%';

                // Animate step 2 fields
                gsap.from('#step2 .animate-entry', {
                    opacity: 0,
                    y: 20,
                    duration: 0.5,
                    stagger: 0.1,
                    ease: "back.out(1.2)"
                });
            }
        });

        backBtn.addEventListener('click', function() {
            step2.classList.remove('active');
            step1.classList.add('active');
            progressBar.style.width = '50%';

            // Animate step 1 fields
            gsap.from('#step1 .animate-entry', {
                opacity: 0,
                y: 20,
                duration: 0.5,
                stagger: 0.1,
                ease: "back.out(1.2)"
            });
        });

        function validateStep1() {
            const requiredFields = ['nama', 'nidn', 'nip', 'inisial', 'jabatan', 'universitas'];
            let isValid = true;

            requiredFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (!field.value) {
                    field.classList.add('border-red-300', 'bg-red-50');
                    isValid = false;

                    // Shake animation for invalid fields
                    gsap.to(field, {
                        x: [-5, 5, -5, 5, 0],
                        duration: 0.4,
                        ease: "power1.out"
                    });
                } else {
                    field.classList.remove('border-red-300', 'bg-red-50');
                }
            });

            // Validate NIDN format (1-900501-123)
            const nidn = document.getElementById('nidn');
            if (nidn.value.length !== 12) {
                nidn.classList.add('border-red-300', 'bg-red-50');
                isValid = false;
                animateInvalidField(nidn);
            }

            // Validate NIP format (19700101-199403-10-02)
            const nip = document.getElementById('nip');
            if (nip.value.length !== 21) {
                nip.classList.add('border-red-300', 'bg-red-50');
                isValid = false;
                animateInvalidField(nip);
            }

            // Special check for "other university" field
            if (document.getElementById('universitas').value === 'Other' &&
                !document.getElementById('otherUniv').value) {
                const otherUniv = document.getElementById('otherUniv');
                otherUniv.classList.add('border-red-300', 'bg-red-50');
                isValid = false;

                gsap.to(otherUniv, {
                    x: [-5, 5, -5, 5, 0],
                    duration: 0.4,
                    ease: "power1.out"
                });
            }

            if (!isValid) {
                // Shake animation for next button
                gsap.to(nextBtn, {
                    x: [-5, 5, -5, 5, 0],
                    duration: 0.4,
                    ease: "power1.out"
                });
            }

            return isValid;
        }

        function animateInvalidField(field) {
            gsap.to(field, {
                x: [-5, 5, -5, 5, 0],
                duration: 0.4,
                ease: "power1.out"
            });
        }

        // Create confetti explosion
        function createConfetti() {
            const container = document.getElementById('confetti-container');
            const colors = ['#6366f1', '#8b5cf6', '#ec4899', '#f43f5e', '#f59e0b'];

            // Clear previous confetti
            container.innerHTML = '';

            // Create 100 confetti pieces
            for (let i = 0; i < 100; i++) {
                const confetti = document.createElement('div');
                confetti.classList.add('confetti');

                // Random properties
                const size = Math.random() * 10 + 5;
                const color = colors[Math.floor(Math.random() * colors.length)];
                const shape = Math.random() > 0.5 ? '50%' : '0';

                // Position at random points on screen
                const startX = Math.random() * window.innerWidth;
                const startY = -20;

                // Apply styles
                confetti.style.width = `${size}px`;
                confetti.style.height = `${size}px`;
                confetti.style.backgroundColor = color;
                confetti.style.borderRadius = shape;
                confetti.style.left = `${startX}px`;
                confetti.style.top = `${startY}px`;

                container.appendChild(confetti);

                // Random animation duration
                const duration = Math.random() * 3 + 2;

                // Animate confetti
                gsap.to(confetti, {
                    y: window.innerHeight + 100,
                    x: startX + (Math.random() * 200 - 100),
                    rotation: Math.random() * 360,
                    opacity: 1,
                    duration: duration,
                    delay: Math.random() * 0.5,
                    ease: "power1.in",
                    onComplete: () => {
                        gsap.to(confetti, {
                            opacity: 0,
                            duration: 0.5
                        });
                    }
                });
            }
        }
    </script>
</body>

</html>