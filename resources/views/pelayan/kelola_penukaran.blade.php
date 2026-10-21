<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Penukaran - Staff Pelayan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'] } } } }
    </script>
    <style>
        body { background-color: #f8fafc; font-family: 'Inter', sans-serif; overflow: hidden; }
        .abstract-bg {
            position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; z-index: -2;
            background-image: linear-gradient(rgba(245, 158, 11, 0.05) 1px, transparent 1px), linear-gradient(90deg, rgba(245, 158, 11, 0.05) 1px, transparent 1px);
            background-size: 40px 40px; animation: moveGrid 15s linear infinite;
        }
        @keyframes moveGrid {
            0% { transform: perspective(500px) rotateX(60deg) scale(2.5) translateY(0); }
            100% { transform: perspective(500px) rotateX(60deg) scale(2.5) translateY(40px); }
        }
        .glow-blob { position: absolute; border-radius: 50%; filter: blur(100px); z-index: -1; opacity: 0.4; }
        .glass-sidebar { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(20px); border-right: 1px solid rgba(255, 255, 255, 0.6); }
        .glass-card { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.8); box-shadow: 0 15px 30px -10px rgba(245, 158, 11, 0.1); }
        .nav-item:hover, .nav-item.active { background: linear-gradient(90deg, rgba(245, 158, 11, 0.1) 0%, transparent 100%); border-left: 4px solid #f59e0b; color: #f59e0b; }
        .nav-item.active i { color: #f59e0b; }
        .table-row-hover:hover { background-color: rgba(245, 158, 11, 0.05); }
    </style>
</head>
<body class="text-slate-800 antialiased flex h-screen w-full">

    <div class="abstract-bg"></div>
    <div class="glow-blob bg-amber-200 w-[40rem] h-[40rem] bottom-[10%] right-[10%]"></div>
    
    <!-- SIDEBAR -->
    <aside class="glass-sidebar w-72 h-full flex flex-col relative z-20 flex-shrink-0">
        <div class="p-6 flex items-center gap-3 border-b border-slate-200/60">
            <div class="relative flex items-center justify-center w-12 h-12 bg-amber-500 rounded-xl text-white transform -rotate-3 shadow-lg">
                <i class="fa-solid fa-graduation-cap text-2xl"></i>
            </div>
            <div>
                <h1 class="font-extrabold text-xl tracking-tight text-slate-800 leading-none">TUKAR<span class="text-amber-500">KOPI</span></h1>
                <span class="text-xs font-semibold text-slate-500 tracking-wider">STAFF PELAYAN</span>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto py-6 flex flex-col gap-2 px-2">
            <a href="{{ route('pelayan.manajemen') }}" class="nav-item flex items-center gap-4 px-4 py-3 rounded-lg text-slate-600 font-semibold border-l-4 border-transparent">
                <i class="fa-solid fa-chart-pie w-6 text-center text-lg"></i> Dashboard Statistik
            </a>
            <a href="{{ route('pelayan.tamus') }}" class="nav-item flex items-center gap-4 px-4 py-3 rounded-lg text-slate-600 font-semibold border-l-4 border-transparent">
                <i class="fa-solid fa-address-card w-6 text-center text-lg"></i> Kelola Tamu
            </a>
            <a href="{{ route('pelayan.penukarans') }}" class="nav-item active flex items-center gap-4 px-4 py-3 rounded-lg text-slate-600 font-semibold border-l-4 border-transparent">
                <i class="fa-solid fa-right-left w-6 text-center text-lg"></i> Kelola Penukaran
            </a>
        </nav>

        <div class="p-6 border-t border-slate-200/60">
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
        <header class="h-20 px-8 flex items-center justify-between bg-white/40 backdrop-blur-md border-b border-white/50 sticky top-0 z-20">
            <h2 class="text-2xl font-extrabold text-slate-800 drop-shadow-sm">Riwayat Tabel Penukarans</h2>
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-amber-500 to-orange-600 flex items-center justify-center text-white font-bold shadow-md ring-2 ring-white">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="hidden md:block text-right">
                    <p class="text-sm font-bold text-slate-800 leading-none">Staff Pelayan</p>
                    <p class="text-xs text-amber-600 font-semibold">Tukar Kopi Wisuda</p>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-6 sm:p-8 custom-scrollbar">
            <div class="max-w-6xl mx-auto space-y-6">
                
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <!-- Form Wrapper untuk Fitur Filter -->
                    <form action="{{ route('pelayan.penukarans') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
                        <!-- Filter 1: Tanggal Penukaran -->
                        <div class="relative w-full sm:w-auto">
                            <i class="fa-solid fa-calendar-day absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400"></i>
                            <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="w-full pl-10 pr-4 py-2.5 bg-white/60 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 shadow-sm text-sm text-slate-600 font-medium transition-all" onchange="this.form.submit()">
                        </div>
                        
                        <!-- Filter 2: Dropdown Is Scanned -->
                        <div class="relative w-full sm:w-auto">
                            <select name="status" class="w-full pl-4 pr-10 py-2.5 bg-white/60 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 shadow-sm text-sm text-slate-600 font-medium appearance-none cursor-pointer transition-all" onchange="this.form.submit()">
                                <option value="">Semua Status Scan</option>
                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Sudah Scan (True)</option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Belum Scan (False)</option>
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-slate-400 pointer-events-none text-xs"></i>
                        </div>

                        <!-- Tombol Submit Tersembunyi -->
                        <button type="submit" class="hidden">Filter</button>
                    </form>

                    <div class="flex gap-3 w-full md:w-auto justify-end">
                        <button class="bg-amber-100 text-amber-700 hover:bg-amber-200 px-5 py-2.5 rounded-xl font-semibold shadow-sm transition-all flex items-center gap-2 text-sm">
                            <i class="fa-solid fa-print"></i> Cetak Laporan
                        </button>
                    </div>
                </div>

                <div class="glass-card rounded-2xl overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-100/50 border-b border-slate-200">
                                    <th class="py-4 px-6 font-bold text-slate-600 text-sm uppercase tracking-wider">ID</th>
                                    <th class="py-4 px-6 font-bold text-slate-600 text-sm uppercase tracking-wider">Pelayan ID</th>
                                    <th class="py-4 px-6 font-bold text-slate-600 text-sm uppercase tracking-wider">Tamu ID</th>
                                    <th class="py-4 px-6 font-bold text-slate-600 text-sm uppercase tracking-wider">Status Tamu</th>
                                    <th class="py-4 px-6 font-bold text-slate-600 text-sm uppercase tracking-wider">Waktu Penukaran</th>
                                    <th class="py-4 px-6 font-bold text-slate-600 text-sm uppercase tracking-wider text-right">Created At</th>
                                </tr>
                            </thead>
                            <tbody class="text-slate-600">
                                <?php foreach ($penukarans as$penukaran): ?>
                                <tr class="border-b border-slate-100 table-row-hover transition-colors">
                                    <td class="py-4 px-6 font-medium text-slate-800"><?php echo $penukaran->id; ?></td>
                                    <td class="py-4 px-6 font-semibold">
                                        <?php echo $penukaran->pelayan_id; ?> 
                                        <span class="text-xs text-slate-400 font-normal">
                                            (<?php echo htmlspecialchars($penukaran->pelayan->user->name ?? 'Unknown'); ?>)
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 font-semibold">
                                        <?php echo $penukaran->tamu_id; ?> 
                                        <span class="text-xs text-slate-400 font-normal">
                                            (<?php echo htmlspecialchars($penukaran->tamu->nama ?? 'Unknown'); ?>)
                                        </span>
                                    </td>
                                    <!-- Menampilkan Status Scan agar filternya lebih relevan saat dilihat -->
                                    <td class="py-4 px-6">
                                        <?php if($penukaran->tamu &&$penukaran->tamu->is_scanned): ?>
                                            <span class="inline-flex items-center gap-1.5 bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">
                                                True
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center gap-1.5 bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-xs font-bold">
                                                False
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-4 px-6 font-medium text-sm text-blue-600">
                                        <?php echo $penukaran->waktu_penukaran; ?>
                                    </td>
                                    <td class="py-4 px-6 text-sm text-slate-500 text-right">
                                        <?php echo $penukaran->created_at; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

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

</body>
</html>