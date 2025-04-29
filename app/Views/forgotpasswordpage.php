<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        secondary: {
                            50: '#fef2f2',
                            100: '#fee2e2',
                            200: '#fecaca',
                            300: '#fca5a5',
                            400: '#f87171',
                            500: '#ef4444',
                            600: '#dc2626',
                            700: '#b91c1c',
                            800: '#991b1b',
                            900: '#7f1d1d',
                        },
                        gradient: {
                            start: '#8b5cf6',
                            mid: '#a855f7',
                            end: '#d946ef',
                        }
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'bounce-slow': 'bounce-slow 3s infinite',
                        'wave': 'wave 2s linear infinite',
                        'fade-in': 'fadeIn 0.5s ease-out forwards',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-15px)' },
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
                        wave: {
                            '0%': { transform: 'rotate(0deg)' },
                            '10%': { transform: 'rotate(14deg)' },
                            '20%': { transform: 'rotate(-8deg)' },
                            '30%': { transform: 'rotate(14deg)' },
                            '40%': { transform: 'rotate(-4deg)' },
                            '50%': { transform: 'rotate(10deg)' },
                            '60%': { transform: 'rotate(0deg)' },
                            '100%': { transform: 'rotate(0deg)' },
                        },
                        fadeIn: {
                            '0%': { opacity: 0, transform: 'translateY(10px)' },
                            '100%': { opacity: 1, transform: 'translateY(0)' }
                        }
                    },
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif']
                    },
                }
            }
        }
    </script>
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 50%, #f8fafc 100%);
            background-attachment: fixed;
            background-size: 200% 200%;
            animation: gradient 15s ease infinite;
            overflow-x: hidden;
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .card-glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .input-glow:focus {
            box-shadow: 0 0 0 3px rgba(56, 182, 248, 0.2);
            border-color: rgba(56, 182, 248, 0.5);
        }

        .btn-gradient {
            background: linear-gradient(135deg, #8b5cf6 0%, #a855f7 50%, #d946ef 100%);
            background-size: 200% auto;
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            background-position: right center;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .animate-delay-100 {
            animation-delay: 0.1s;
        }
        .animate-delay-200 {
            animation-delay: 0.2s;
        }
        .animate-delay-300 {
            animation-delay: 0.3s;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4 font-poppins antialiased">
    <!-- Floating decorative elements -->
    <div class="fixed top-20 left-10 w-32 h-32 rounded-full bg-purple-100 opacity-40 blur-xl animate-float"></div>
    <div class="fixed bottom-20 right-10 w-40 h-40 rounded-full bg-pink-100 opacity-40 blur-xl animate-float animation-delay-2000"></div>
    <div class="fixed top-1/3 right-1/4 w-24 h-24 rounded-full bg-indigo-100 opacity-30 blur-xl animate-float animation-delay-3000"></div>
    <div class="fixed top-2/3 left-1/4 w-28 h-28 rounded-full bg-blue-100 opacity-30 blur-xl animate-float animation-delay-1500"></div>

    <div class="relative z-10 w-full max-w-md">
        <div class="card-glass relative overflow-hidden rounded-2xl shadow-2xl transition-all duration-300 hover:shadow-3xl">
            <div class="absolute inset-0 bg-gradient-to-br from-gradient-start via-gradient-mid to-gradient-end opacity-10"></div>

            <div class="relative p-8">
                <!-- Logo and header -->
                <div class="text-center mb-8 animate-fade-in">
                    <div class="w-20 h-20 bg-gradient-to-r from-primary-500 to-secondary-500 mx-auto rounded-2xl flex items-center justify-center shadow-lg mb-4 animate-bounce-slow">
                        <i class="fas fa-lock-open text-white text-3xl"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-800">
                        Reset Password
                    </h1>
                    <p class="mt-2 text-gray-600 text-sm">
                        Masukkan alamat email Anda dan kami akan mengirimkan link untuk mereset password Anda.
                    </p>
                </div>

                <!-- Flash messages -->
                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg animate-fade-in animate-delay-100">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <span><?= session()->getFlashdata('error') ?></span>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('success')) : ?>
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg animate-fade-in animate-delay-100">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span><?= session()->getFlashdata('success') ?></span>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Form -->
                <form action="<?= site_url('forgotpassword/submit') ?>" method="post" class="space-y-6">
                    <div class="animate-fade-in animate-delay-200">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-envelope mr-2 text-primary-500"></i>
                            Alamat Email
                        </label>
                        <div class="relative">
                            <input type="email" id="email" name="email" required
                                class="input-glow block w-full px-4 py-3 border border-gray-200 rounded-xl bg-white/90 focus:ring-2 focus:ring-primary-400 focus:border-transparent placeholder-gray-400 transition-all duration-300 shadow-sm hover:shadow-md"
                                placeholder="contoh@email.com">
                        </div>
                    </div>

                    <div class="animate-fade-in animate-delay-300">
                        <button type="submit"
                            class="btn-gradient w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl text-sm font-medium text-white hover:shadow-lg transition-all duration-300">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Kirim Link Reset
                        </button>
                    </div>

                    <div class="text-center text-sm text-gray-500 animate-fade-in animate-delay-300">
                        Ingat password Anda? 
                        <a href="<?= site_url('login') ?>" class="text-primary-600 hover:text-primary-700 font-medium hover:underline transition-all duration-300 ml-1">
                            Masuk disini
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // GSAP animations for enhanced entrance
        document.addEventListener('DOMContentLoaded', () => {
            gsap.from('.card-glass', {
                duration: 0.8,
                y: 20,
                opacity: 0,
                ease: 'back.out(1.7)'
            });
            
            gsap.from('.animate-fade-in', {
                duration: 0.6,
                y: 10,
                opacity: 0,
                stagger: 0.1,
                delay: 0.3,
                ease: 'power2.out'
            });
        });
    </script>
</body>

</html>