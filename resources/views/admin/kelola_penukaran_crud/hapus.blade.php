<!-- Modal Hapus Penukaran -->
<div id="modal-hapus" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 backdrop-blur-sm transition-opacity">
    <div class="glass-card w-full max-w-md rounded-3xl p-8 relative shadow-2xl text-center transform scale-100 transition-transform">
        
        <!-- Ikon Peringatan -->
        <div class="w-20 h-20 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-4xl mx-auto mb-5 shadow-inner">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        
        <h3 class="text-2xl font-extrabold text-slate-800 mb-2">Konfirmasi Hapus</h3>
        <p class="text-slate-600 font-medium mb-8 leading-relaxed">
            Apakah Anda yakin ingin menghapus riwayat penukaran ID <span id="hapus-id-text" class="font-bold text-red-600 px-1 bg-red-50 rounded"></span>? Data yang dihapus tidak dapat dikembalikan.
        </p>
        
        <!-- Form Hapus -->
        <form action="{{ route('admin.penukarans.destroy') }}" method="POST" class="flex justify-center gap-3">
            @csrf
            <input type="hidden" id="hapus-id-input" name="id">
            
            <button type="button" onclick="closeModalHapus()" class="px-6 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold rounded-xl transition-colors w-1/2">
                Batal
            </button>
            <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-colors shadow-lg shadow-red-200 w-1/2 flex items-center justify-center gap-2">
                <i class="fa-solid fa-trash-can"></i> Hapus
            </button>
        </form>
    </div>
</div>