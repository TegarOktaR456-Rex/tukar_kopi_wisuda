<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pelayan - Tukar Kopi Wisuda</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Chart.js for Data Visualization -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
            font-family: 'Inter', sans-serif;
            overflow: hidden; /* Prevent body scroll, use inner scroll */
        }

        /* Abstract Lines Background */
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
            filter: blur(100px);
            z-index: -1;
            opacity: 0.4;
        }

        /* Glassmorphism Styles */
        .glass-sidebar {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 10px 0 30px -10px rgba(37, 99, 235, 0.1);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 15px 30px -10px rgba(37, 99, 235, 0.1), 
                        0 0 0 1px rgba(255, 255, 255, 0.5) inset;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px -10px rgba(37, 99, 235, 0.2), 
                        0 0 0 1px rgba(255, 255, 255, 0.6) inset;
        }

        /* Sidebar Nav Link Hover */
        .nav-item {
            transition: all 0.3s ease;
        }
        .nav-item:hover, .nav-item.active {
            background: linear-gradient(90deg, rgba(37, 99, 235, 0.1) 0%, transparent 100%);
            border-left: 4px solid #2563eb;
            color: #2563eb;
        }
        .nav-item.active i {
            color: #2563eb;
        }

        /* CSS Circular Progress */
        .progress-circle {
            position: relative;
            width: 160px;
            height: 160px;
            border-radius: 50%;
            background: conic-gradient(var(--progress-color) calc(var(--value) * 1%), #e2e8f0 0);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
            animation: popIn 1s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        }
        .progress-circle::after {
            content: '';
            position: absolute;
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
            border-radius: 50%;
            box-shadow: inset 0 4px 6px -1px rgba(0,0,0,0.05);
        }
        .progress-value {
            position: relative;
            z-index: 1;
            font-size: 2.2rem;
            font-weight: 800;
            color: #1e293b;
            display: flex;
            align-items: baseline;
        }
        .progress-value span {
            font-size: 1rem;
            margin-left: 2px;
            color: #64748b;
        }

        @keyframes popIn {
            0% { transform: scale(0.5); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
    </style>
</head>
<body class="text-slate-800 antialiased flex h-screen w-full">

    <!-- Background Elements -->
    <div class="abstract-bg"></div>
    <div class="glow-blob bg-amber-200 w-[40rem] h-[40rem] top-[-10%] left-[10%]"></div>
    <div class="glow-blob bg-blue-300 w-[30rem] h-[30rem] bottom-[-10%] right-[-5%]"></div>

    <!-- SIDEBAR -->
    <aside class="glass-sidebar w-72 h-full flex flex-col relative z-20 flex-shrink-0 transition-transform duration-300">
        <!-- Logo -->
        <div class="p-6 flex items-center gap-3 border-b border-slate-200/60">
            <div class="relative flex items-center justify-center w-12 h-12 bg-amber-500 rounded-xl text-white transform -rotate-3 shadow-lg">
                <i class="fa-solid fa-graduation-cap text-2xl"></i>
                <div class="absolute -bottom-1 -right-1 bg-white text-amber-500 rounded-full w-5 h-5 flex items-center justify-center text-[10px] shadow">
                    <i class="fa-solid fa-mug-hot"></i>
                </div>
            </div>
            <div>
                <h1 class="font-extrabold text-xl tracking-tight text-slate-800 leading-none">
                    TUKAR<span class="text-amber-500">KOPI</span>
                </h1>
                <span class="text-xs font-semibold text-slate-500 tracking-wider">STAFF PELAYAN</span>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-6 flex flex-col gap-2 px-2">
            <!-- Menu Manajemen Aktif -->
            <a href="{{ route('pelayan.manajemen') }}" class="nav-item active flex items-center gap-4 px-4 py-3 rounded-lg text-slate-600 font-semibold border-left-transparent border-l-4">
                <i class="fa-solid fa-chart-pie w-6 text-center text-lg transition-colors"></i>
                Dashboard Statistik
            </a>
            
            <a href="{{ route('pelayan.tamus') }}" class="nav-item flex items-center gap-4 px-4 py-3 rounded-lg text-slate-600 font-semibold border-left-transparent border-l-4">
                <i class="fa-solid fa-address-card w-6 text-center text-lg transition-colors"></i>
                Kelola Tamu
            </a>

            <a href="{{ route('pelayan.penukarans') }}" class="nav-item flex items-center gap-4 px-4 py-3 rounded-lg text-slate-600 font-semibold border-left-transparent border-l-4">
                <i class="fa-solid fa-right-left w-6 text-center text-lg transition-colors"></i>
                Kelola Penukaran
            </a>
        </nav>

        <!-- Logout Button -->
        <div class="p-6 border-t border-slate-200/60">
            <!-- Form untuk Keluar Sesi dan masuk ke halaman Login -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center justify-center gap-2 w-full bg-red-50 hover:bg-red-500 hover:text-white text-red-600 font-bold py-3 px-4 rounded-xl transition-all shadow-sm">
                    <i class="fa-solid fa-right-from-bracket"></i> Keluar Sesi
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden relative z-10">
        
        <!-- Header Topbar -->
        <header class="h-20 px-8 flex items-center justify-between bg-white/40 backdrop-blur-md border-b border-white/50 sticky top-0 z-20">
            <h2 class="text-2xl font-extrabold text-slate-800 drop-shadow-sm">Dashboard Overview</h2>
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-amber-500 to-orange-600 flex items-center justify-center text-white font-bold shadow-md ring-2 ring-white">
                    <i class="fa-solid fa-mug-hot"></i>
                </div>
                <div class="hidden md:block text-right">
                    <p class="text-sm font-bold text-slate-800 leading-none">Staff Pelayan</p>
                    <p class="text-xs text-amber-600 font-semibold">Tukar Kopi Wisuda</p>
                </div>
            </div>
        </header>

        <!-- Scrollable Content Area -->
        <div class="flex-1 overflow-y-auto p-6 sm:p-8 custom-scrollbar">
            
            <div class="max-w-6xl mx-auto space-y-8">
                
                <!-- Top Visualisasi: Total Mahasiswa -->
                <div class="glass-card rounded-3xl p-6 sm:p-8 flex flex-col lg:flex-row items-center gap-8 relative overflow-hidden">
                    <!-- Accent decorative -->
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-blue-100 rounded-full blur-2xl opacity-60 pointer-events-none"></div>

                    <!-- Text Data -->
                    <div class="lg:w-1/3 w-full text-center lg:text-left space-y-4 relative z-10">
                        <div class="inline-flex items-center gap-2 bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold tracking-wide border border-blue-200">
                            <i class="fa-solid fa-calendar-check"></i> Periode Oktober 2026
                        </div>
                        <h3 class="text-xl font-bold text-slate-600">Total Mahasiswa SI</h3>
                        <p class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 drop-shadow-sm">
                            {{ $totalMahasiswa }} <span class="text-lg text-slate-500 font-semibold">Orang</span>
                        </p>
                        <p class="text-sm text-slate-500 leading-relaxed border-l-4 border-blue-500 pl-3">
                            Visualisasi data jumlah mahasiswa Sistem Informasi yang terdaftar untuk mengikuti Wisuda dan berhak menukarkan kopi.
                        </p>
                    </div>

                    <!-- Chart.js Graph -->
                    <div class="lg:w-2/3 w-full h-[250px] relative z-10 bg-white/50 rounded-2xl p-4 border border-white">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>

                <!-- Bottom Visualisasi: 2 Kolom Persentase -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <!-- Kiri: Sudah Tukar -->
                    <div class="glass-card rounded-3xl p-8 flex flex-col items-center justify-center text-center group relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-1 bg-green-500"></div>
                        <div class="w-12 h-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-check-double"></i>
                        </div>
                        <h4 class="text-lg font-bold text-slate-700 mb-6">Sudah Menukar Kopi</h4>
                        
                        <!-- Circular Progress terhubung dengan Database -->
                        <div class="progress-circle" style="--value: {{ $persenSudah }}; --progress-color: #22c55e;">
                            <div class="progress-value" id="val-sudah">0<span>%</span></div>
                        </div>
                        
                        <p class="mt-6 text-sm text-slate-500 font-medium bg-slate-100 px-4 py-2 rounded-lg border border-slate-200">
                            <span class="font-bold text-slate-800">{{ $sudahTukar }}</span> dari {{$totalMahasiswa }} Mahasiswa
                        </p>
                    </div>

                    <!-- Kanan: Belum Tukar -->
                    <div class="glass-card rounded-3xl p-8 flex flex-col items-center justify-center text-center group relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-1 bg-amber-500"></div>
                        <div class="w-12 h-12 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>
                        <h4 class="text-lg font-bold text-slate-700 mb-6">Belum Menukar Kopi</h4>
                        
                        <!-- Circular Progress terhubung dengan Database -->
                        <div class="progress-circle" style="--value: {{ $persenBelum }}; --progress-color: #f59e0b;">
                            <div class="progress-value" id="val-belum">0<span>%</span></div>
                        </div>

                        <p class="mt-6 text-sm text-slate-500 font-medium bg-slate-100 px-4 py-2 rounded-lg border border-slate-200">
                            <span class="font-bold text-slate-800">{{ $belumTukar }}</span> dari {{$totalMahasiswa }} Mahasiswa
                        </p>
                    </div>

                </div>

            </div>

            <!-- Footer Area inside scrollable content -->
            <footer class="mt-12 mb-4 text-center">
                <div class="inline-flex flex-col items-center justify-center px-6 py-4 bg-white/40 backdrop-blur-sm rounded-2xl border border-white/60 shadow-sm">
                    <p class="text-sm font-semibold text-slate-600 mb-1">
                        &copy; 2026 Copyright by <span class="text-amber-500 font-bold">orex456eagle</span>
                    </p>
                    <a href="https://instagram.com/tegaro_r" target="_blank" class="text-xs text-slate-500 hover:text-pink-600 transition-colors flex items-center gap-1 font-medium">
                        <i class="fa-brands fa-instagram text-sm"></i> Instagram by @tegaro_r
                    </a>
                </div>
            </footer>

        </div>
    </main>

    <!-- Script for Charts and Animations -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // 1. Animasi Angka Persentase pada Circular Progress (Counter Up)
            function animateValue(id, start, end, duration) {
                if (start === end) return;
                let range = end - start;
                let current = start;
                let increment = end > start ? 1 : -1;
                let stepTime = Math.abs(Math.floor(duration / range));
                let obj = document.getElementById(id);
                let timer = setInterval(function() {
                    current += increment;
                    obj.innerHTML = current + "<span>%</span>";
                    if (current == end) {
                        clearInterval(timer);
                    }
                }, stepTime);
            }

            // Panggil animasi menggunakan persentase asli dari Database
            setTimeout(() => {
                animateValue("val-sudah", 0, {{ $persenSudah }}, 1500);
                animateValue("val-belum", 0, {{ $persenBelum }}, 1500);
            }, 300);

            // 2. Inisialisasi Chart.js untuk Grafik Tren
            const ctx = document.getElementById('trendChart').getContext('2d');
            
            // Membuat Gradient untuk Fill Area Grafik
            let gradient = ctx.createLinearGradient(0, 0, 0, 250);
            gradient.addColorStop(0, 'rgba(37, 99, 235, 0.4)'); // Blue
            gradient.addColorStop(1, 'rgba(37, 99, 235, 0.0)'); // Transparent

            const trendChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Hari H'],
                    datasets: [{
                        label: 'Antusiasme Penukaran',
                        data: [10, 25, 40, 65, 110, 150, 183],
                        borderColor: '#2563eb',
                        backgroundColor: gradient,
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#2563eb',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4 // Smooth curve
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
                            backgroundColor: 'rgba(15, 23, 42, 0.8)',
                            titleFont: { family: 'Inter', size: 13 },
                            bodyFont: { family: 'Inter', size: 14, weight: 'bold' },
                            padding: 10,
                            cornerRadius: 8,
                            displayColors: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)',
                                drawBorder: false,
                            },
                            ticks: {
                                font: { family: 'Inter', size: 11 },
                                color: '#64748b'
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false,
                            },
                            ticks: {
                                font: { family: 'Inter', size: 11 },
                                color: '#64748b'
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                }
            });
        });
    </script>
</body>
</html>