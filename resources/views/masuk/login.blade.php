<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pegawai - Tukar Kopi Wisuda</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- FontAwesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Google Fonts (Inter) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        'brand-blue': '#2563eb',
                        'brand-light': '#f8fafc',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #f8fafc;
            overflow: hidden;
            font-family: 'Inter', sans-serif;
        }

        .abstract-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -2;
            background-image: 
                linear-gradient(rgba(37, 99, 235, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(37, 99, 235, 0.05) 1px, transparent 1px);
            background-size: 40px 40px;
            transform: perspective(500px) rotateX(60deg) scale(2.5) translateY(-100px);
            transform-origin: top center;
            animation: moveGrid 15s linear infinite;
        }

        @keyframes moveGrid {
            0% { transform: perspective(500px) rotateX(60deg) scale(2.5) translateY(0); }
            100% { transform: perspective(500px) rotateX(60deg) scale(2.5) translateY(40px); }
        }

        .glow-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: -1;
            opacity: 0.6;
            animation: floatBlob 10s ease-in-out infinite alternate;
        }

        @keyframes floatBlob {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(30px, -30px) scale(1.1); }
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 25px 50px -12px rgba(37, 99, 235, 0.15), 
                        0 0 0 1px rgba(255, 255, 255, 0.5) inset;
            transform-style: preserve-3d;
            perspective: 1000px;
        }

        .input-group:focus-within label {
            color: #2563eb;
        }
        .input-group:focus-within i {
            color: #2563eb;
        }
        
        .btn-glow {
            box-shadow: 0 0 15px rgba(37, 99, 235, 0.3);
            transition: all 0.3s ease;
        }
        .btn-glow:hover {
            box-shadow: 0 0 25px rgba(37, 99, 235, 0.6);
            transform: translateY(-2px);
        }

        /* Efek Tilt Container */
        .tilt-wrapper {
            transition: transform 0.1s ease-out;
            will-change: transform;
        }
    </style>
</head>
<body class="text-slate-800 antialiased min-h-screen flex items-center justify-center p-4">

    <!-- Background Elements -->
    <div class="abstract-bg"></div>
    <div class="glow-blob bg-blue-400 w-[30rem] h-[30rem] top-[-10%] left-[-10%]"></div>
    <div class="glow-blob bg-indigo-300 w-[25rem] h-[25rem] bottom-[-10%] right-[-5%] animation-delay-2000"></div>

    <div class="tilt-wrapper w-full max-w-md z-10" id="tilt-card">
        <div class="glass-card rounded-3xl p-8 sm:p-10 relative overflow-hidden">
            
            <!-- Ornamen Dekoratif Card -->
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-gradient-to-br from-blue-100 to-transparent rounded-full opacity-50 pointer-events-none"></div>
            
            <!-- Header Card (Logo) -->
            <div class="text-center mb-8 flex flex-col items-center justify-center transform transition-transform" style="transform: translateZ(30px);">
                <div class="flex items-center gap-3 mb-4 cursor-default">
                    <div class="relative flex items-center justify-center w-14 h-14 bg-blue-600 rounded-2xl text-white transform -rotate-3 shadow-xl transition-transform hover:rotate-0">
                        <i class="fa-solid fa-graduation-cap text-3xl"></i>
                        <div class="absolute -bottom-1 -right-1 bg-white text-blue-600 rounded-full w-6 h-6 flex items-center justify-center text-xs shadow-md border-2 border-white">
                            <i class="fa-solid fa-mug-hot"></i>
                        </div>
                    </div>
                    <div class="text-left">
                        <h1 class="font-extrabold text-2xl tracking-tight text-slate-800 leading-none">
                            TUKAR_KOPI
                        </h1>
                        <span class="text-blue-600 font-bold text-lg leading-none tracking-wide">WISUDA</span>
                    </div>
                </div>
                
                <div class="inline-flex items-center justify-center gap-2 bg-slate-100/80 text-slate-600 px-3 py-1 rounded-full text-xs font-semibold border border-slate-200 shadow-sm mt-1">
                    <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                    Portal Akses Pegawai
                </div>
            </div>

            <!-- Notifikasi Error Jika Login Gagal -->
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4 text-sm" style="transform: translateZ(20px);">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-6" style="transform: translateZ(20px);">
                @csrf 

                <!-- Username Input -->
                <div class="input-group relative">
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-1 transition-colors">Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-regular fa-user text-slate-400 transition-colors"></i>
                        </div>
                        <input type="text" id="name" name="name" required placeholder="Masukkan username..." value="{{ old('name') }}"
                               class="w-full pl-11 pr-4 py-3 bg-white/50 border border-slate-300 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all shadow-sm">
                    </div>
                </div>

                <!-- Password Input -->
                <div class="input-group relative">
                    <div class="flex justify-between items-center mb-1">
                        <label for="password" class="block text-sm font-semibold text-slate-700 transition-colors">Kata Sandi</label>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-solid fa-lock text-slate-400 transition-colors"></i>
                        </div>
                        <input type="password" id="password" name="password" required placeholder="••••••••" 
                               class="w-full pl-11 pr-12 py-3 bg-white/50 border border-slate-300 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all shadow-sm">
                        
                        <!-- Toggle Password Visibility -->
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-blue-600 focus:outline-none transition-colors">
                            <i class="fa-regular fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input id="remember_me" name="remember" type="checkbox" 
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300 rounded cursor-pointer accent-blue-600">
                    <label for="remember_me" class="ml-2 block text-sm text-slate-600 cursor-pointer">
                        Ingat sesi saya
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-glow w-full flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-3.5 px-4 rounded-xl transition-all shadow-lg text-sm sm:text-base">
                    Masuk Dashboard 
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                </button>
            </form>

            <!-- Footer Form -->
            <div class="mt-8 text-center" style="transform: translateZ(10px);">
                <p class="text-sm text-slate-500">
                    Bukan pegawai? 
                    <a href="{{ route('beranda') }}" class="font-semibold text-blue-600 hover:text-blue-800 hover:underline transition-colors">Kembali ke Beranda</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            
            // 1. Fitur Toggle Password Visibility
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            togglePassword.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                if(type === 'text') {
                    eyeIcon.classList.remove('fa-eye');
                    eyeIcon.classList.add('fa-eye-slash');
                } else {
                    eyeIcon.classList.remove('fa-eye-slash');
                    eyeIcon.classList.add('fa-eye');
                }
            });

            // 2. Efek Interaktif 3D Tilt pada Card
            const tiltCard = document.getElementById('tilt-card');
            
            // Hanya aktifkan tilt di desktop agar tidak mengganggu touch device
            if (window.matchMedia("(pointer: fine)").matches) {
                
                document.addEventListener('mousemove', (e) => {
                    // Perbaikan typo perhitungan axis
                    const xAxis = (window.innerWidth / 2 - e.pageX) / 25;
                    const yAxis = (window.innerHeight / 2 - e.pageY) / 25;
                    
                    tiltCard.style.transform = `rotateY(${xAxis}deg) rotateX(${yAxis}deg)`;
                });

                // Reset posisi saat mouse keluar dari area layar
                document.addEventListener('mouseleave', () => {
                    tiltCard.style.transform = `rotateY(0deg) rotateX(0deg)`;
                    tiltCard.style.transition = 'transform 0.5s ease-out';
                });
                
                document.addEventListener('mouseenter', () => {
                    tiltCard.style.transition = 'transform 0.1s ease-out';
                });
            }
            
            // 3. Efek Form Submit Simulasi sebelum terkirim ke Laravel
            const form = document.querySelector('form');
            form.addEventListener('submit', (e) => {
                // Prevent default sementara untuk animasi
                e.preventDefault();
                const btn = form.querySelector('button[type="submit"]');
                
                // State loading
                btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Memverifikasi...';
                btn.disabled = true;
                btn.classList.add('opacity-80');
                
                // Delay singkat agar animasi loading terlihat lalu kirim ke server
                setTimeout(() => {
                    form.submit();
                }, 500);
            });
        });
    </script>
</body>
</html>