<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Models\Tamu;
use App\Models\Penukaran;
use App\Models\Pelayan;
use Carbon\Carbon;

// Route untuk halaman utama
Route::get('/', function () {
    return view('beranda');
})->name('beranda');

// Route untuk halaman form login
Route::get('/masuk', function () {
    return view('masuk.login'); 
})->name('login');

// Route untuk memproses form login
Route::post('/masuk', [AuthController::class, 'authenticate'])->name('login.post');

// Route Dashboard Admin (Hanya bisa diakses jika sudah login)
Route::middleware('auth')->group(function () {
    
    // ========================================================
    // BLOK ROUTE ADMIN
    // ========================================================
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard-admin');
    })->name('admin.dashboard');

    Route::post('/admin/scan-barcode', function (Request $request) {
        $barcode =$request->barcode;
        $tamu = Tamu::where('barcode',$barcode)->first();

        if (!$tamu) {
            return response()->json(['status' => 'error', 'message' => 'Barcode tidak terdaftar dalam sistem.']);
        }
        if ($tamu->is_scanned) {
            return response()->json(['status' => 'error', 'message' => 'Mohon maaf, QR Code ini sudah ditukarkan sebelumnya oleh ' . $tamu->nama . '.']);
        }

        $tamu->update(['is_scanned' => true]);

        $userId = Auth::id();$pelayan = Pelayan::where('user_id', $userId)->first();$pelayanId = $pelayan ? $pelayan->id : 1; 

        Penukaran::create([
            'pelayan_id' => $pelayanId,
            'tamu_id' => $tamu->id,
            'waktu_penukaran' => Carbon::now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Selamat <b>' . $tamu->nama . '</b> mendapatkan minuman kopi gratis.<br><br><b>Silahkan pilih menu ke pelayan.</b>'
        ]);
    })->name('admin.scan');

    Route::get('/admin/manajemen', function () {
        $totalMahasiswa = \App\Models\Tamu::count();
        $sudahTukar = \App\Models\Tamu::where('is_scanned', true)->count();$belumTukar = \App\Models\Tamu::where('is_scanned', false)->count();

        $persenSudah =$totalMahasiswa > 0 ? round(($sudahTukar / $totalMahasiswa) * 100) : 0;
        $persenBelum =$totalMahasiswa > 0 ? round(($belumTukar / $totalMahasiswa) * 100) : 0;

        return view('admin.manajemen', compact('totalMahasiswa', 'sudahTukar', 'belumTukar', 'persenSudah', 'persenBelum')); 
    })->name('admin.manajemen');

    Route::get('/admin/users', function () {
        $users = \App\Models\User::all(); 
        return view('admin.kelola_user', compact('users')); 
    })->name('admin.users');

    Route::post('/admin/users/store', function (Request $request) {
        \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
            'role' => $request->role,
        ]);
        return back(); 
    })->name('admin.users.store');
    
    Route::post('/admin/users/update', function (Request $request) {
        $user = \App\Models\User::find($request->id);
        if($user) {
            $user->update(['name' =>$request->name, 'email' => $request->email, 'role' =>$request->role]);
        }
        return back(); 
    })->name('admin.users.update');

    Route::post('/admin/users/destroy', function (Request $request) {
        $user = \App\Models\User::find($request->id);
        if($user) {$user->delete(); }
        return back(); 
    })->name('admin.users.destroy');

    Route::get('/admin/tamus', function (Request $request) {$query = \App\Models\Tamu::query();
        
        // Membungkus logic search agar tidak menimpa query lain
        if ($request->has('search') &&$request->search != '') {
            $search =$request->search;
            $query->where(function($q) use ($search) {
                $q->where('nim', 'like', "\%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%");
            });
        }
        
        $sort = $request->get('sort', 'id');$direction = $request->get('direction', 'asc');$allowedSorts = ['id', 'nim', 'nama', 'created_at'];
        if (in_array($sort, $allowedSorts)) {$query->orderBy($sort,$direction);
        }
        $tamus =$query->get();
        return view('admin.kelola_tamu', compact('tamus')); 
    })->name('admin.tamus');

    Route::post('/admin/tamus/store', function (Request $request) { \App\Models\Tamu::create(['nim' =>$request->nim, 'nama' => $request->nama, 'barcode' =>$request->barcode, 'is_scanned' => false]);
        return back(); 
    })->name('admin.tamus.store');

    Route::post('/admin/tamus/update', function (Request $request) {
        $tamu = \App\Models\Tamu::find($request->id);
        if($tamu) {$tamu->update(['nim' => $request->nim, 'nama' =>$request->nama, 'barcode' => $request->barcode, 'is_scanned' =>$request->is_scanned]);
        }
        return back(); 
    })->name('admin.tamus.update');

    Route::post('/admin/tamus/destroy', function (Request $request) {
        $tamu = \App\Models\Tamu::find($request->id);
        if($tamu) {$tamu->delete(); }
        return back(); 
    })->name('admin.tamus.destroy');

    Route::post('/admin/tamus/toggle', function (Request $request) {
        $tamu = \App\Models\Tamu::find($request->id);
        if($tamu) { $tamu->update(['is_scanned' => !$tamu->is_scanned]); }
        return back(); 
    })->name('admin.tamus.toggle');

    Route::get('/admin/penukarans', function () {
        $penukarans = \App\Models\Penukaran::with(['pelayan.user', 'tamu'])->latest()->get(); 
        return view('admin.kelola_penukaran', compact('penukarans')); 
    })->name('admin.penukarans');

    Route::post('/admin/penukarans/store', function (Request $request) { \App\Models\Penukaran::create(['pelayan_id' =>$request->pelayan_id, 'tamu_id' => $request->tamu_id, 'waktu_penukaran' =>$request->waktu_penukaran]);
        return back(); 
    })->name('admin.penukarans.store');

    Route::post('/admin/penukarans/update', function (Request $request) {
        $penukaran = \App\Models\Penukaran::find($request->id);
        if($penukaran) {
            $penukaran->update(['pelayan_id' =>$request->pelayan_id, 'tamu_id' => $request->tamu_id, 'waktu_penukaran' =>$request->waktu_penukaran]);
        }
        return back(); 
    })->name('admin.penukarans.update');

    Route::post('/admin/penukarans/destroy', function (Request $request) {
        $penukaran = \App\Models\Penukaran::find($request->id);
        if($penukaran) {
            $tamu = \App\Models\Tamu::find($penukaran->tamu_id);
            if ($tamu) { $tamu->update(['is_scanned' => false]); }$penukaran->delete(); 
        }
        return back(); 
    })->name('admin.penukarans.destroy');


    // ========================================================
    // BLOK ROUTE PELAYAN
    // ========================================================
    Route::get('/pelayan/beranda', function () {
        return view('pelayan.beranda-pelayan');
    })->name('pelayan.beranda');
    
    Route::get('/pelayan/manajemen', function () {
        $totalMahasiswa = \App\Models\Tamu::count();
        $sudahTukar = \App\Models\Tamu::where('is_scanned', true)->count();$belumTukar = \App\Models\Tamu::where('is_scanned', false)->count();

        $persenSudah =$totalMahasiswa > 0 ? round(($sudahTukar / $totalMahasiswa) * 100) : 0;
        $persenBelum =$totalMahasiswa > 0 ? round(($belumTukar / $totalMahasiswa) * 100) : 0;

        return view('pelayan.manajemen_pelayan', compact('totalMahasiswa', 'sudahTukar', 'belumTukar', 'persenSudah', 'persenBelum'));
    })->name('pelayan.manajemen');

    Route::get('/pelayan/tamus', function (Request $request) {$query = \App\Models\Tamu::query();

        // 1. Fitur Search (Dibungkus function agar tak tembus)
        if ($request->has('search') &&$request->search != '') {
            $search =$request->search;
            $query->where(function($q) use ($search) {
                $q->where('nim', 'like', "\%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%");
            });
        }

        // 2. Fitur Filter Is_Scanned
        if ($request->has('status') &&$request->status != '') {
            $status =$request->status == '1' ? true : false;
            $query->where('is_scanned',$status);
        }

        // 3. Fitur Pengurutan (Sort)
        $sort =$request->get('sort', 'id'); 
        $direction =$request->get('direction', 'asc'); 

        $allowedSorts = ['id', 'nim', 'nama', 'created_at'];
        if (in_array($sort, $allowedSorts)) {$query->orderBy($sort,$direction);
        }

        $tamus =$query->get();
        return view('pelayan.kelola_tamu', compact('tamus')); 
    })->name('pelayan.tamus');

    Route::get('/pelayan/penukarans', function (Request $request) {$query = \App\Models\Penukaran::with(['pelayan.user', 'tamu'])->latest(); 

        if ($request->has('tanggal') &&$request->tanggal != '') {
            $query->whereDate('waktu_penukaran',$request->tanggal);
        }

        if ($request->has('status') &&$request->status != '') {
            $status =$request->status == '1' ? true : false;
            $query->whereHas('tamu', function($q) use ($status) {
                $q->where('is_scanned',$status);
            });
        }

        $penukarans =$query->get(); 
        return view('pelayan.kelola_penukaran', compact('penukarans')); 
    })->name('pelayan.penukarans');
});

// Route untuk logout
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');