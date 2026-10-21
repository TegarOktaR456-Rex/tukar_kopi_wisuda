<!-- Modal Tambah User -->
<div id="modal-tambah" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 backdrop-blur-sm transition-opacity">
    <div class="glass-card w-full max-w-lg rounded-3xl p-8 relative shadow-2xl transform scale-100 transition-transform">
        
        <!-- Tombol Close -->
        <button type="button" onclick="closeModalTambah()" class="absolute top-5 right-5 w-8 h-8 flex items-center justify-center rounded-full bg-slate-200 text-slate-500 hover:bg-red-100 hover:text-red-600 transition-colors">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <h3 class="text-2xl font-extrabold text-slate-800 mb-6 flex items-center gap-3">
            <i class="fa-solid fa-user-plus text-blue-600"></i> Tambah User Baru
        </h3>

        <!-- Form Tambah -->
        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-5">
            @csrf
            
            <div class="space-y-1">
                <label class="block text-sm font-semibold text-slate-700">Nama Lengkap</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-regular fa-user text-slate-400"></i>
                    </div>
                    <input type="text" name="name" required placeholder="Masukkan nama..." class="w-full pl-11 pr-4 py-2.5 bg-white/60 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-slate-800">
                </div>
            </div>

            <div class="space-y-1">
                <label class="block text-sm font-semibold text-slate-700">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-regular fa-envelope text-slate-400"></i>
                    </div>
                    <input type="email" name="email" required placeholder="contoh@tukarkopi.com" class="w-full pl-11 pr-4 py-2.5 bg-white/60 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-slate-800">
                </div>
            </div>

            <div class="space-y-1">
                <label class="block text-sm font-semibold text-slate-700">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-lock text-slate-400"></i>
                    </div>
                    <input type="password" name="password" required placeholder="••••••••" class="w-full pl-11 pr-4 py-2.5 bg-white/60 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-slate-800">
                </div>
            </div>

            <div class="space-y-1">
                <label class="block text-sm font-semibold text-slate-700">Role</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-user-shield text-slate-400"></i>
                    </div>
                    <!-- Menggunakan Select Dropdown untuk Role -->
                    <select name="role" required class="w-full pl-11 pr-4 py-2.5 bg-white/60 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-slate-800 appearance-none cursor-pointer">
                        <option value="admin">Admin</option>
                        <option value="pelayan">Pelayan</option>
                        <option value="tamu">Tamu</option>
                    </select>
                </div>
            </div>
            
            <!-- Aksi Form -->
            <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-slate-200/60">
                <button type="button" onclick="closeModalTambah()" class="px-5 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold rounded-xl transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-colors shadow-lg shadow-blue-200 flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Tambah
                </button>
            </div>
        </form>
    </div>
</div>