<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User - Tukar Kopi Wisuda</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                }
            }
        }
    </script>
    <style>
        body { background-color: #f8fafc; font-family: 'Inter', sans-serif; overflow: hidden; }
        .abstract-bg {
            position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; z-index: -2;
            background-image: linear-gradient(rgba(37, 99, 235, 0.05) 1px, transparent 1px), linear-gradient(90deg, rgba(37, 99, 235, 0.05) 1px, transparent 1px);
            background-size: 40px 40px;
            animation: moveGrid 15s linear infinite;
        }
        @keyframes moveGrid {
            0% { transform: perspective(500px) rotateX(60deg) scale(2.5) translateY(0); }
            100% { transform: perspective(500px) rotateX(60deg) scale(2.5) translateY(40px); }
        }
        .glow-blob { position: absolute; border-radius: 50%; filter: blur(100px); z-index: -1; opacity: 0.4; }
        .glass-sidebar { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(20px); border-right: 1px solid rgba(255, 255, 255, 0.6); }
        .glass-card { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.8); box-shadow: 0 15px 30px -10px rgba(37, 99, 235, 0.1); }
        .nav-item:hover, .nav-item.active { background: linear-gradient(90deg, rgba(37, 99, 235, 0.1) 0%, transparent 100%); border-left: 4px solid #2563eb; color: #2563eb; }
        .nav-item.active i { color: #2563eb; }
        .table-row-hover:hover { background-color: rgba(37, 99, 235, 0.05); }
    </style>
</head>
<body class="text-slate-800 antialiased flex h-screen w-full">

    <div class="abstract-bg"></div>
    <div class="glow-blob bg-blue-400 w-[40rem] h-[40rem] top-[-10%] left-[10%]"></div>
    
    <!-- SIDEBAR -->
    <aside class="glass-sidebar w-72 h-full flex flex-col relative z-20 flex-shrink-0">
        <div class="p-6 flex items-center gap-3 border-b border-slate-200/60">
            <div class="relative flex items-center justify-center w-12 h-12 bg-blue-600 rounded-xl text-white transform -rotate-3 shadow-lg">
                <i class="fa-solid fa-graduation-cap text-2xl"></i>
            </div>
            <div>
                <h1 class="font-extrabold text-xl tracking-tight text-slate-800 leading-none">TUKAR<span class="text-blue-600">KOPI</span></h1>
                <span class="text-xs font-semibold text-slate-500 tracking-wider">ADMIN PANEL</span>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto py-6 flex flex-col gap-2 px-2">
            <a href="/admin/manajemen" class="nav-item flex items-center gap-4 px-4 py-3 rounded-lg text-slate-600 font-semibold border-l-4 border-transparent">
                <i class="fa-solid fa-chart-pie w-6 text-center text-lg"></i> Dashboard
            </a>
            <a href="/admin/users" class="nav-item active flex items-center gap-4 px-4 py-3 rounded-lg text-slate-600 font-semibold border-l-4 border-transparent">
                <i class="fa-solid fa-users w-6 text-center text-lg"></i> Kelola User
            </a>
            <a href="/admin/tamus" class="nav-item flex items-center gap-4 px-4 py-3 rounded-lg text-slate-600 font-semibold border-l-4 border-transparent">
                <i class="fa-solid fa-address-card w-6 text-center text-lg"></i> Kelola Tamu
            </a>
            <a href="/admin/penukarans" class="nav-item flex items-center gap-4 px-4 py-3 rounded-lg text-slate-600 font-semibold border-l-4 border-transparent">
                <i class="fa-solid fa-right-left w-6 text-center text-lg"></i> Kelola Penukaran
            </a>
        </nav>

        <div class="p-6 border-t border-slate-200/60">
            <!-- Kembali ke Dashboard Admin (Scanner) -->
            <a href="/admin/dashboard" class="flex items-center justify-center gap-2 w-full bg-red-50 hover:bg-red-500 hover:text-white text-red-600 font-bold py-3 px-4 rounded-xl transition-all shadow-sm">
                <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar
            </a>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden relative z-10">
        <header class="h-20 px-8 flex items-center justify-between bg-white/40 backdrop-blur-md border-b border-white/50 sticky top-0 z-20">
            <h2 class="text-2xl font-extrabold text-slate-800 drop-shadow-sm">Kelola Data User</h2>
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-white font-bold shadow-md ring-2 ring-white">
                    <i class="fa-solid fa-user"></i>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-6 sm:p-8 custom-scrollbar">
            <div class="max-w-6xl mx-auto space-y-6">
                
                <!-- Action Bar -->
                <div class="flex justify-between items-center">
                    <div class="relative">
                        <i class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400"></i>
                        <input type="text" placeholder="Cari user..." class="pl-10 pr-4 py-2 bg-white/60 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm">
                    </div>
                    <button onclick="openModalTambah()" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg shadow-blue-200 transition-all flex items-center gap-2">
                        <i class="fa-solid fa-plus"></i> Tambah User
                    </button>
                </div>

                <!-- Table Container -->
                <div class="glass-card rounded-2xl overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-100/50 border-b border-slate-200">
                                    <th class="py-4 px-6 font-bold text-slate-600 text-sm uppercase tracking-wider">ID</th>
                                    <th class="py-4 px-6 font-bold text-slate-600 text-sm uppercase tracking-wider">Nama Lengkap</th>
                                    <th class="py-4 px-6 font-bold text-slate-600 text-sm uppercase tracking-wider">Email</th>
                                    <th class="py-4 px-6 font-bold text-slate-600 text-sm uppercase tracking-wider">Role</th>
                                    <th class="py-4 px-6 font-bold text-slate-600 text-sm uppercase tracking-wider text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-slate-600">
                                <?php foreach ($users as$user): ?>
                                <tr class="border-b border-slate-100 table-row-hover transition-colors">
                                    <td class="py-4 px-6 font-medium text-slate-800"><?php echo $user->id; ?></td>
                                    <td class="py-4 px-6 font-semibold"><?php echo $user->name; ?></td>
                                    <td class="py-4 px-6"><?php echo $user->email; ?></td>
                                    <td class="py-4 px-6">
                                        <?php if($user->role == 'admin'): ?>
                                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">Admin</span>
                                        <?php elseif($user->role == 'pelayan'): ?>
                                            <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-bold">Pelayan</span>
                                        <?php else: ?>
                                            <span class="bg-slate-200 text-slate-700 px-3 py-1 rounded-full text-xs font-bold">Tamu</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-4 px-6 flex justify-center gap-2">
                                        <!-- Membawa data dinamis ke Javascript Pop up -->
                                        <button onclick="openModalEdit('<?php echo $user->id; ?>', '<?php echo addslashes($user->name); ?>', '<?php echo addslashes($user->email); ?>', '<?php echo$user->role; ?>')" class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 hover:bg-amber-500 hover:text-white transition-colors flex items-center justify-center"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <button onclick="openModalHapus('<?php echo $user->id; ?>', '<?php echo addslashes($user->name); ?>')" class="w-8 h-8 rounded-lg bg-red-100 text-red-600 hover:bg-red-500 hover:text-white transition-colors flex items-center justify-center"><i class="fa-solid fa-trash"></i></button>
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
                        &copy; 2026 Copyright by <span class="text-blue-600 font-bold">orex456eagle</span>
                    </p>
                    <a href="https://instagram.com/tegaro_r" target="_blank" class="text-xs text-slate-500 hover:text-pink-600 transition-colors flex items-center gap-1 font-medium">
                        <i class="fa-brands fa-instagram text-sm"></i> Instagram by @tegaro_r
                    </a>
                </div>
            </footer>
        </div>
    </main>

    <!-- MEMANGGIL FILE POP UP (MODALS) -->
    @include('admin.kelola_user_crud.tambah')
    @include('admin.kelola_user_crud.edit')
    @include('admin.kelola_user_crud.hapus')

    <!-- LOGIKA JAVASCRIPT UNTUK POP UP -->
    <script>
        // Fungsi untuk Pop up Tambah
        function openModalTambah() {
            const modal = document.getElementById('modal-tambah');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModalTambah() {
            const modal = document.getElementById('modal-tambah');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Fungsi untuk Pop up Edit
        function openModalEdit(id, name, email, role) {
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-email').value = email;
            document.getElementById('edit-role').value = role.toLowerCase();
            
            const modal = document.getElementById('modal-edit');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModalEdit() {
            const modal = document.getElementById('modal-edit');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Fungsi untuk Pop up Hapus
        function openModalHapus(id, name) {
            document.getElementById('hapus-id-text').innerText = id + ' (' + name + ')';
            document.getElementById('hapus-id-input').value = id;
            
            const modal = document.getElementById('modal-hapus');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModalHapus() {
            const modal = document.getElementById('modal-hapus');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</body>
</html>