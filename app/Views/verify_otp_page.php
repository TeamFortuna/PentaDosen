<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP</title>
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
                    }
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

<body class="min-h-screen flex items-center justify-center p-4 font-sans antialiased">
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

            <!-- Main card content -->
            <div class="card-gradient relative rounded-2xl border border-white/20 p-8 backdrop-blur-sm">
                <div class="text-center mb-8 animate-entry">
                    <div class="w-20 h-20 bg-gradient-to-r from-primary-500 to-secondary mx-auto rounded-2xl flex items-center justify-center shadow-lg mb-4 animate-pulse-slow hover:animate-wave cursor-pointer">
                        <i class="fas fa-shield-alt text-white text-3xl"></i>
                    </div>
                    <h1 class="text-3xl font-extrabold text-gray-800 transform transition-all duration-500 hover:scale-105 inline-block">
                        Verifikasi OTP
                    </h1>
                    <p class="mt-2 text-gray-600 transform transition-all duration-500 hover:scale-100 hover:translate-x-1 inline-block">
                        Masukkan 6 digit kode yang dikirim ke email Anda
                    </p>
                </div>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-xl animate-entry">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <form class="space-y-6" action="/verify-otp" method="post">
                    <div class="group animate-entry" style="animation-delay: 0.1s">
                        <label for="otp" class="block text-sm font-medium text-gray-700 mb-1 transition-all duration-300 group-focus-within:text-primary-600">
                            Kode OTP
                        </label>
                        <div class="relative transition-all duration-300">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary-500 transition-colors duration-300">
                                <i class="fas fa-key"></i>
                            </div>
                            <input type="text" id="otp" name="otp" maxlength="6"
                                class="input-glow block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl bg-white/80 focus:ring-2 focus:ring-primary-400 focus:border-transparent placeholder-gray-400 transition-all duration-300 shadow-sm hover:shadow-md"
                                placeholder="123456" required
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6)">
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl text-sm font-medium text-white bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-400 hover:to-primary-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-400 shadow-md hover:shadow-lg transition-all duration-300 animate-entry group"
                        style="animation-delay: 0.2s"
                        id="verifyButton">
                        <span class="mr-2 group-hover:translate-x-1 transition-transform duration-300">Verifikasi</span>
                        <i class="fas fa-check transform group-hover:translate-x-2 group-hover:scale-110 transition-transform duration-300"></i>
                    </button>

                    <div class="mt-6 text-center animate-entry" style="animation-delay: 0.3s">
                        <a href="/forgotpassword" class="text-sm font-medium text-primary-500 hover:text-primary-600 transition-colors duration-300 hover:underline">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-6 text-center animate-entry" style="animation-delay: 0.4s">
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

            // Shield icon hover effect
            const shield = document.querySelector('.fa-shield-alt');
            shield.parentElement.addEventListener('mouseenter', () => {
                gsap.to(shield, {
                    y: -5,
                    duration: 0.3,
                    repeat: 1,
                    yoyo: true,
                    ease: "power1.inOut"
                });
            });

            // Form submission effect
            const form = document.querySelector('form');
            form.addEventListener('submit', (e) => {
                const verifyButton = document.getElementById('verifyButton');

                // Button press animation
                gsap.to(verifyButton, {
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
                }, 800);
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
                const button = document.getElementById('verifyButton');
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
    </script>
</body>

</html>