<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
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
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4 font-montserrat antialiased">
    <!-- Floating decorative elements -->
    <div class="fixed top-20 left-10 w-32 h-32 rounded-full bg-purple-100 opacity-40 blur-xl animate-float"></div>
    <div class="fixed bottom-20 right-10 w-40 h-40 rounded-full bg-pink-100 opacity-40 blur-xl animate-float animation-delay-2000"></div>
    <div class="fixed top-1/3 right-1/4 w-24 h-24 rounded-full bg-indigo-100 opacity-30 blur-xl animate-float animation-delay-3000"></div>

    <!-- Confetti container -->
    <div id="confetti-container"></div>

    <div class="relative z-10 w-full max-w-md">
        <!-- Main card with subtle gradient border -->
        <div class="relative overflow-hidden rounded-2xl shadow-xl transform transition-all duration-500 hover:scale-[1.01]">
            <!-- Gradient border effect -->
            <div class="absolute inset-0 bg-gradient-to-br from-gradient-start via-gradient-mid to-gradient-end opacity-20"></div>

            <!-- Floating bubbles inside card -->
            <div class="absolute -top-10 -left-10 w-20 h-20 rounded-full bg-purple-200 opacity-20 animate-float"></div>
            <div class="absolute -bottom-5 -right-5 w-16 h-16 rounded-full bg-pink-200 opacity-20 animate-float animation-delay-1500"></div>

            <!-- Tambahkan ini di bagian atas form -->
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-xl animate-entry">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')) : ?>
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-xl animate-entry">
                    <ul>
                        <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                            <li><?= $error ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')) : ?>
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-xl animate-entry">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <!-- Main card content -->
            <div class="card-gradient relative rounded-2xl border border-white/20 p-8 backdrop-blur-sm">
                <div class="text-center mb-8 animate-entry">
                    <div class="w-20 h-20 bg-gradient-to-r from-primary-500 to-secondary mx-auto rounded-2xl flex items-center justify-center shadow-lg mb-4 animate-pulse-slow hover:animate-wave cursor-pointer">
                        <i class="fas fa-lock-open text-white text-3xl"></i>
                    </div>
                    <h1 class="text-3xl font-extrabold text-gray-800 transform transition-all duration-500 hover:scale-105 inline-block">
                        Selamat Datang
                    </h1>
                    <p class="mt-2 text-gray-600 transform transition-all duration-500 hover:scale-100 hover:translate-x-1 inline-block">
                        Masukkan akun Anda
                    </p>
                </div>

                <form class="space-y-6" id="loginForm">
                    <div class="group animate-entry" style="animation-delay: 0.1s">
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

                    <div class="group animate-entry" style="animation-delay: 0.2s">
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

                    <div class="flex items-center justify-between animate-entry" style="animation-delay: 0.3s">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox"
                                class="h-4 w-4 text-primary-500 focus:ring-primary-400 border-gray-300 rounded transition-all duration-300 hover:scale-110">
                            <label for="remember-me" class="ml-2 block text-sm text-gray-700 hover:text-gray-900 cursor-pointer transition-colors duration-300">
                                Ingat akun
                            </label>
                        </div>

                        <a href="<?= site_url('forgotpassword') ?>" class="text-sm font-medium text-primary-500 hover:text-primary-600 transition-colors duration-300 hover:underline">
                            Lupa password?
                        </a>
                    </div>

                    <button type="submit" href="<?= site_url('dashboard') ?>"
                        class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl text-sm font-medium text-white bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-400 hover:to-primary-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-400 shadow-md hover:shadow-lg transition-all duration-300 animate-entry group"
                        style="animation-delay: 0.4s"
                        id="loginButton">
                        <span class="mr-2 group-hover:translate-x-1 transition-transform duration-300">Masuk</span>
                        <i class="fas fa-arrow-right transform group-hover:translate-x-2 group-hover:scale-110 transition-transform duration-300"></i>
                    </button>
                </form>

                <div class="mt-8 animate-entry" style="animation-delay: 0.5s">
                    <div class="mt-8 text-center animate-entry" style="animation-delay: 0.9s">
                        <p class="text-sm text-gray-600">
                            Tidak punya akun?
                            <a href="<?= site_url('register') ?>" class="font-medium text-primary-500 hover:text-primary-600 transition-colors duration-300 hover:underline">
                                Daftar
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 text-center animate-entry" style="animation-delay: 1s">
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

            // Lock icon hover effect
            const lock = document.querySelector('.fa-lock-open');
            lock.parentElement.addEventListener('mouseenter', () => {
                gsap.to(lock, {
                    y: -5,
                    duration: 0.3,
                    repeat: 1,
                    yoyo: true,
                    ease: "power1.inOut"
                });
            });

            // Form submission effect
            const form = document.getElementById('loginForm');
            form.addEventListener('submit', (e) => {
                e.preventDefault();

                // Button press animation
                gsap.to('#loginButton', {
                    scale: 0.95,
                    duration: 0.2,
                    yoyo: true,
                    repeat: 1,
                    ease: "power1.inOut"
                });

                // Success animation after short delay
                setTimeout(() => {
                    createConfetti();

                    gsap.to('.card-gradient', {
                        y: -20,
                        duration: 0.5,
                        ease: "back.out(1.2)"
                    });

                    // Simulate successful login
                    setTimeout(() => {
                        // This would normally redirect to dashboard
                        window.location.href = "#"; // Replace with actual redirect
                    }, 1500);
                }, 800);
            });
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

        // Create confetti explosion
        function createConfetti() {
            const container = document.getElementById('confetti-container');
            const colors = ['#6366f1', '#8b5cf6', '#ec4899', '#f43f5e', '#f59e0b'];

            // Clear previous confetti
            container.innerHTML = '';

            // Create 50 confetti pieces
            for (let i = 0; i < 50; i++) {
                const confetti = document.createElement('div');
                confetti.classList.add('confetti');

                // Random properties
                const size = Math.random() * 10 + 5;
                const color = colors[Math.floor(Math.random() * colors.length)];
                const shape = Math.random() > 0.5 ? '50%' : '0';

                // Position at button
                const button = document.getElementById('loginButton');
                const buttonRect = button.getBoundingClientRect();
                const startX = buttonRect.left + buttonRect.width / 2;
                const startY = buttonRect.top;

                // Apply styles
                confetti.style.width = `${size}px`;
                confetti.style.height = `${size}px`;
                confetti.style.backgroundColor = color;
                confetti.style.borderRadius = shape;
                confetti.style.left = `${startX}px`;
                confetti.style.top = `${startY}px`;

                container.appendChild(confetti);

                // Animate confetti
                gsap.to(confetti, {
                    x: `${Math.random() * 400 - 200}px`,
                    y: `${Math.random() * 300 + 100}px`,
                    rotation: Math.random() * 360,
                    opacity: 1,
                    duration: 1.5,
                    delay: Math.random() * 0.5,
                    ease: "power1.out",
                    onComplete: () => {
                        gsap.to(confetti, {
                            opacity: 0,
                            duration: 0.5,
                            delay: 0.5
                        });
                    }
                });
            }
        }

        // Social button hover effects
        document.querySelectorAll('.social-btn').forEach(btn => {
            btn.addEventListener('mouseenter', () => {
                gsap.to(btn, {
                    scale: 1.05,
                    duration: 0.3,
                    ease: "back.out(1.2)"
                });
            });

            btn.addEventListener('mouseleave', () => {
                gsap.to(btn, {
                    scale: 1,
                    duration: 0.3,
                    ease: "back.out(1.2)"
                });
            });
        });
    </script>
</body>

</html>