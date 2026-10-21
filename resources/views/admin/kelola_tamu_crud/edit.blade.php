<!-- Modal Edit Tamu -->
<div id="modal-edit" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 backdrop-blur-sm transition-opacity">
    <div class="glass-card w-full max-w-lg rounded-3xl p-8 relative shadow-2xl transform scale-100 transition-transform">
        
        <button type="button" onclick="closeModalEdit()" class="absolute top-5 right-5 w-8 h-8 flex items-center justify-center rounded-full bg-slate-200 text-slate-500 hover:bg-red-100 hover:text-red-600 transition-colors">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <h3 class="text-2xl font-extrabold text-slate-800 mb-6 flex items-center gap-3">
            <i class="fa-solid fa-pen-to-square text-blue-600"></i> Edit Data Tamu
        </h3>

        <form action="{{ route('admin.tamus.update') }}" method="POST" class="space-y-5">
            @csrf
            <input type="hidden" id="edit-id" name="id">
            
            <div class="space-y-1">
                <label class="block text-sm font-semibold text-slate-700">NIM</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-id-badge text-slate-400"></i>
                    </div>
                    <input type="text" id="edit-nim" name="nim" required class="w-full pl-11 pr-4 py-2.5 bg-white/60 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-slate-800">
                </div>
            </div>

            <div class="space-y-1">
                <label class="block text-sm font-semibold text-slate-700">Nama Lengkap</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-regular fa-user text-slate-400"></i>
                    </div>
                    <input type="text" id="edit-nama" name="nama" required class="w-full pl-11 pr-4 py-2.5 bg-white/60 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-slate-800">
                </div>
            </div>

            <div class="space-y-1">
                <label class="block text-sm font-semibold text-slate-700">Barcode</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-barcode text-slate-400"></i>
                    </div>
                    <input type="text" id="edit-barcode" name="barcode" required class="w-full pl-11 pr-4 py-2.5 bg-white/60 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-slate-800">
                </div>
            </div>

            <div class="space-y-1">
                <label class="block text-sm font-semibold text-slate-700">Status Kopi (Is Scanned)</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-mug-hot text-slate-400"></i>
                    </div>
                    <select id="edit-is_scanned" name="is_scanned" class="w-full pl-11 pr-4 py-2.5 bg-white/60 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-slate-800 appearance-none cursor-pointer">
                        <option value="1">True (Sudah Ditukar)</option>
                        <option value="0">False (Belum Ditukar)</option>
                    </select>
                </div>
            </div>
            
            <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-slate-200/60">
                <button type="button" onclick="closeModalEdit()" class="px-5 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold rounded-xl transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-colors shadow-lg shadow-blue-200 flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>