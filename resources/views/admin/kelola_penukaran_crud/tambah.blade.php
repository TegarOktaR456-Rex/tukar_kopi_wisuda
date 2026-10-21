<!-- Modal Tambah Penukaran -->
<div id="modal-tambah" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 backdrop-blur-sm transition-opacity">
    <div class="glass-card w-full max-w-lg rounded-3xl p-8 relative shadow-2xl transform scale-100 transition-transform">
        
        <!-- Tombol Close -->
        <button type="button" onclick="closeModalTambah()" class="absolute top-5 right-5 w-8 h-8 flex items-center justify-center rounded-full bg-slate-200 text-slate-500 hover:bg-red-100 hover:text-red-600 transition-colors">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <h3 class="text-2xl font-extrabold text-slate-800 mb-6 flex items-center gap-3">
            <i class="fa-solid fa-plus text-blue-600"></i> Tambah Penukaran
        </h3>

        <!-- Form Tambah -->
        <form action="{{ route('admin.penukarans.store') }}" method="POST" class="space-y-5">
            @csrf
            
            <div class="space-y-1">
                <label class="block text-sm font-semibold text-slate-700">Pelayan ID</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-user-tie text-slate-400"></i>
                    </div>
                    <input type="number" name="pelayan_id" required placeholder="Contoh: 1" class="w-full pl-11 pr-4 py-2.5 bg-white/60 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-slate-800">
                </div>
            </div>

            <div class="space-y-1">
                <label class="block text-sm font-semibold text-slate-700">Tamu ID</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-graduation-cap text-slate-400"></i>
                    </div>
                    <input type="number" name="tamu_id" required placeholder="Contoh: 10" class="w-full pl-11 pr-4 py-2.5 bg-white/60 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-slate-800">
                </div>
            </div>

            <div class="space-y-1">
                <label class="block text-sm font-semibold text-slate-700">Waktu Penukaran</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-regular fa-clock text-slate-400"></i>
                    </div>
                    <input type="datetime-local" name="waktu_penukaran" required class="w-full pl-11 pr-4 py-2.5 bg-white/60 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-slate-800">
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