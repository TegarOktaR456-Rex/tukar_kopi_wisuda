<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Pelayan - Scanner Tukar Kopi</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- FontAwesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Google Fonts (Inter) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Three.js for 3D Animation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>

    <!-- HTML5 QR Code Library -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        'futuristic-blue': '#2563eb',
                        'futuristic-light': '#f8fafc',
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #f8fafc; overflow-x: hidden; position: relative; min-height: 100vh; }
        .abstract-bg {
            position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; z-index: -1;
            background-image: linear-gradient(rgba(37, 99, 235, 0.05) 1px, transparent 1px), linear-gradient(90deg, rgba(37, 99, 235, 0.05) 1px, transparent 1px);
            background-size: 40px 40px; transform: perspective(500px) rotateX(60deg) scale(2.5) translateY(-100px);
            transform-origin: top center; animation: moveGrid 15s linear infinite;
        }
        @keyframes moveGrid {
            0% { transform: perspective(500px) rotateX(60deg) scale(2.5) translateY(0); }
            100% { transform: perspective(500px) rotateX(60deg) scale(2.5) translateY(40px); }
        }
        .glow-blob { position: absolute; border-radius: 50%; filter: blur(80px); z-index: -1; opacity: 0.5; }
        .glass-header { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255, 255, 255, 0.5); }
        .glass-card {
            background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 25px 50px -12px rgba(37, 99, 235, 0.15), 0 0 0 1px rgba(255, 255, 255, 0.5) inset;
        }
        .btn-glow { box-shadow: 0 0 20px rgba(37, 99, 235, 0.4); transition: all 0.3s ease; }
        .btn-glow:hover { box-shadow: 0 0 30px rgba(37, 99, 235, 0.7); transform: translateY(-2px); }
        #canvas-container-pelayan { width: 100%; height: 100%; min-height: 400px; cursor: grab; }
        #canvas-container-pelayan:active { cursor: grabbing; }

        /* Dropdown Menu Styles */
        .dropdown-menu {
            display: none; position: absolute; top: calc(100% + 8px); right: 0;
            background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.6); box-shadow: 0 20px 40px rgba(30, 41, 59, 0.15);
            border-radius: 1rem; min-width: 200px; z-index: 999; overflow: hidden;
        }
        .dropdown-menu.open { display: block; animation: dropdownFadeIn 0.2s ease; }
        @keyframes dropdownFadeIn { from { opacity: 0; transform: translateY(-8px); } to   { opacity: 1; transform: translateY(0); } }
        .dropdown-item {
            display: flex; align-items: center; gap: 10px; padding: 12px 16px; font-weight: 600; font-size: 0.9rem;
            transition: background 0.2s ease; color: #1e293b; cursor: pointer; text-decoration: none;
        }
        .dropdown-item:hover { background: rgba(37, 99, 235, 0.08); color: #2563eb; }
        .dropdown-item.danger { color: #ef4444; }
        .dropdown-item.danger:hover { background: rgba(239, 68, 68, 0.08); color: #dc2626; }
        .dropdown-divider { height: 1px; background: rgba(30, 41, 59, 0.08); margin: 4px 0; }

        .cam-error-panel {
            display: none; background: linear-gradient(135deg, rgba(254,242,242,0.95), rgba(255,255,255,0.95));
            border: 1px solid rgba(239,68,68,0.25); border-radius: 1rem; padding: 20px; margin-top: 12px;
        }
        .cam-error-panel.show { display: block; }
        .cam-error-step { display: flex; align-items: flex-start; gap: 10px; font-size: 0.82rem; color: #475569; margin-top: 8px; line-height: 1.5; }
        .cam-error-step-num {
            min-width: 22px; height: 22px; border-radius: 50%; background: #ef4444; color: white; font-size: 0.7rem; font-weight: 700;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 1px;
        }

        #reader { width: 100%; border-radius: 1rem; overflow: hidden; border: none !important; }
        #reader video { object-fit: cover; border-radius: 1rem; }

        .modal-3d-overlay {
            position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(8px);
            z-index: 100; display: flex; align-items: center; justify-content: center; opacity: 0; pointer-events: none; transition: opacity 0.4s ease;
        }
        .modal-3d-overlay.active { opacity: 1; pointer-events: auto; }

        .scene-3d { width: 150px; height: 150px; perspective: 1000px; margin: 0 auto 20px auto; }
        .object-3d { width: 100%; height: 100%; position: relative; transform-style: preserve-3d; animation: rotate3d 3s infinite linear; }
        .face {
            position: absolute; width: 100%; height: 100%; border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 4rem; backface-visibility: hidden; box-shadow: inset 0 0 20px rgba(255,255,255,0.5), 0 0 30px currentColor;
        }
        .face-front { transform: rotateY(0deg); }
        .face-back { transform: rotateY(180deg); }
        @keyframes rotate3d { 0% { transform: rotateY(0deg) rotateX(10deg); } 100% { transform: rotateY(360deg) rotateX(10deg); } }

        .theme-success { color: #10b981; }
        .theme-success .face { background: linear-gradient(135deg, #34d399, #059669); color: white; }
        .theme-error { color: #ef4444; }
        .theme-error .face { background: linear-gradient(135deg, #f87171, #dc2626); color: white; }
    </style>
</head>
<body class="text-slate-800 antialiased flex flex-col min-h-screen">

    <div class="abstract-bg"></div>
    <div class="glow-blob bg-blue-300 w-96 h-96 top-0 left-[-100px]"></div>
    <div class="glow-blob bg-indigo-200 w-96 h-96 bottom-20 right-[-100px]"></div>

    <header class="glass-header fixed w-full top-0 z-50 px-6 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="relative flex items-center justify-center w-12 h-12 bg-amber-500 rounded-xl text-white transform rotate-3 shadow-lg">
                    <i class="fa-solid fa-qrcode text-2xl"></i>
                    <div class="absolute -bottom-1 -right-1 bg-white text-amber-500 rounded-full w-5 h-5 flex items-center justify-center text-[10px] shadow">
                        <i class="fa-solid fa-mug-hot"></i>
                    </div>
                </div>
                <div>
                    <h1 class="font-extrabold text-xl tracking-tight text-slate-800 leading-tight">
                        SCANNER<br><span class="text-amber-500">PELAYAN</span>
                    </h1>
                </div>
            </div>

            <!-- Bagian Kanan: Dropdown Menu Pelayan -->
            <div class="relative" id="dropdown-wrapper">
                <button id="dropdown-toggle" class="flex items-center gap-2 bg-slate-800 hover:bg-slate-700 text-white px-6 py-2 rounded-full transition-all duration-300 shadow-[0_0_15px_rgba(30,41,59,0.4)] hover:shadow-[0_0_25px_rgba(30,41,59,0.6)]">
                    <i class="fa-solid fa-user-tie w-5 h-5 flex items-center justify-center"></i>
                    <span class="font-semibold tracking-wide hidden sm:block">Menu Pelayan</span>
                    <i class="fa-solid fa-chevron-down text-xs ml-1 transition-transform duration-200" id="dropdown-chevron"></i>
                </button>
                <!-- Dropdown Menu -->
                <div class="dropdown-menu" id="dropdown-menu">
                    <!-- Link ke halaman manajemen pelayan -->
                    <a href="/pelayan/manajemen" class="dropdown-item">
                        <i class="fa-solid fa-clipboard-list text-amber-500"></i>
                        <span>Manajemen Pelayan</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <!-- Link ke form Logout -->
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item danger">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Keluar Sesi</span>
                    </a>
                </div>
            </div>
            
            <!-- Hidden Logout Form -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </header>

    <main class="flex-grow pt-32 pb-16 px-4 sm:px-6 relative z-10">
        <section class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-center w-full mb-16">
            <div class="space-y-6 text-center lg:text-left">
                <div class="inline-block bg-amber-100 text-amber-700 px-4 py-1.5 rounded-full text-sm font-semibold tracking-wide border border-amber-200">
                    🎓 Wisuda Oktober 2026
                </div>
                <h2 class="text-4xl lg:text-6xl font-extrabold leading-tight text-slate-900 drop-shadow-sm">
                    Selamat &amp; Sukses <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-500 to-orange-500">
                        Wisudawan &amp; Wisudawati
                    </span>
                </h2>
                <h3 class="text-xl lg:text-2xl font-semibold text-slate-700">
                    Universitas Muria Kudus
                </h3>
                <p class="text-lg text-slate-600 leading-relaxed border-l-4 border-amber-500 pl-4 bg-white/50 py-2 rounded-r-lg">
                    "Selamat atas gelar barunya! Perjalanan panjang, malam-malam begadang, dan segala perjuangan akhirnya terbayar lunas. Ini bukan akhir, melainkan awal dari petualangan hebat lainnya. Teruslah berkarya dan bawa perubahan!"
                </p>
                <div class="flex items-center gap-4 pt-4 justify-center lg:justify-start">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white font-bold shadow-lg">
                        <i class="fa-solid fa-mug-hot text-xl"></i>
                    </div>
                    <div>
                        <p class="font-bold text-slate-900 text-lg">Staff Pelayan</p>
                        <p class="text-sm text-amber-600 font-medium">Siap Melayani Penukaran Kopi</p>
                    </div>
                </div>
            </div>
            <div class="relative h-[400px] lg:h-[500px] w-full rounded-3xl bg-gradient-to-tr from-white/40 to-amber-50/40 backdrop-blur-md border border-white shadow-2xl flex items-center justify-center overflow-hidden">
                <div id="canvas-container-pelayan"></div>
                <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 bg-white/80 backdrop-blur px-4 py-2 rounded-full text-xs font-semibold text-amber-600 shadow-sm border border-amber-100 flex items-center gap-2 pointer-events-none">
                    <i class="fa-solid fa-hand-pointer animate-bounce"></i> Putar dengan mouse / sentuhan
                </div>
            </div>
        </section>

        <div class="flex flex-col items-center justify-center">
            <div class="text-center mb-8">
                <div class="inline-block bg-blue-100 text-blue-700 px-4 py-1.5 rounded-full text-sm font-semibold tracking-wide border border-blue-200 mb-4 shadow-sm">
                    <i class="fa-solid fa-camera mr-2 animate-pulse"></i> Scanner Kopi Gratis
                </div>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 drop-shadow-sm">
                    Arahkan QR Code Tamu
                </h2>
                <p class="text-slate-600 mt-2">Posisikan QR Code di dalam bingkai kamera untuk memvalidasi</p>
            </div>

            <div class="glass-card w-full max-w-lg rounded-3xl p-4 sm:p-6 relative">
                <div id="cam-controls" class="flex justify-center gap-4 mb-4">
                    <div id="cam-laptop" class="w-full hidden">
                        <div class="flex items-center justify-center gap-2 bg-blue-50 border border-blue-200 text-blue-700 text-sm font-semibold px-4 py-2 rounded-xl">
                            <i class="fa-solid fa-laptop"></i>
                            <span>Menggunakan Kamera Laptop</span>
                            <span id="cam-status-dot" class="w-2 h-2 rounded-full bg-green-400 animate-pulse ml-1"></span>
                        </div>
                    </div>
                    <div id="cam-mobile" class="w-full hidden flex gap-3">
                        <button id="btn-front-cam" class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-700 font-semibold py-2 px-4 rounded-xl border border-blue-200 transition-colors flex items-center justify-center gap-2">
                            <i class="fa-solid fa-mobile-screen"></i> Kamera Depan
                        </button>
                        <button id="btn-back-cam" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-xl shadow-md transition-colors flex items-center justify-center gap-2">
                            <i class="fa-solid fa-camera-rotate"></i> Kamera Belakang
                        </button>
                    </div>
                </div>

                <div class="relative rounded-2xl overflow-hidden bg-slate-900 shadow-inner min-h-[300px] flex items-center justify-center border-4 border-slate-100">
                    <div id="reader" class="w-full h-full"></div>
                    <div id="scan-line" class="absolute top-0 left-0 w-full h-1 bg-blue-500 shadow-[0_0_15px_#3b82f6] z-10 hidden"></div>
                </div>

                <div id="cam-error-panel" class="cam-error-panel">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-camera-slash text-red-500 text-lg"></i>
                        </div>
                        <div>
                            <p class="font-bold text-slate-800 text-sm" id="cam-error-title">Akses Kamera Ditolak</p>
                            <p class="text-xs text-red-500 font-medium" id="cam-error-desc">Browser tidak mengizinkan akses kamera</p>
                        </div>
                    </div>
                    <p class="text-xs font-semibold text-slate-600 mb-1">Cara mengizinkan kamera:</p>
                    <div id="cam-error-steps"></div>
                    <button id="btn-retry-cam" class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold py-2.5 rounded-xl transition-colors flex items-center justify-center gap-2 shadow">
                        <i class="fa-solid fa-rotate-right"></i> Coba Lagi
                    </button>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-white/80 backdrop-blur-md border-t border-slate-200 py-6 relative z-10">
        <div class="max-w-7xl mx-auto px-6 text-center text-slate-500 text-sm font-medium">
            &copy; 2026 Tukar Kopi Wisuda - Staff Pelayan Portal.
        </div>
    </footer>

    <!-- 3D MODAL NOTIFICATION (Berhasil & Gagal) -->
    <div id="result-modal" class="modal-3d-overlay">
        <div class="glass-card max-w-sm w-full mx-4 rounded-3xl p-8 text-center transform scale-95 transition-transform duration-300 relative overflow-hidden" id="modal-content">
            <button id="close-modal" class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-800 transition-colors z-10">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="scene-3d" id="scene-3d">
                <div class="object-3d">
                    <div class="face face-front" id="icon-front"><i class="fa-solid fa-check"></i></div>
                    <div class="face face-back" id="icon-back"><i class="fa-solid fa-check"></i></div>
                </div>
            </div>
            <h3 id="modal-title" class="text-2xl font-extrabold mb-2 text-slate-800">Title</h3>
            <p id="modal-message" class="text-slate-600 leading-relaxed font-medium">Message</p>
            <button id="btn-scan-lagi" class="mt-8 w-full bg-slate-800 hover:bg-slate-700 text-white font-bold py-3 px-4 rounded-xl transition-colors shadow-lg">
                Scan Tamu Selanjutnya
            </button>
        </div>
    </div>

    <!-- Dropdown Toggle Script -->
    <script>
        (function() {
            const toggle = document.getElementById('dropdown-toggle');
            const menu   = document.getElementById('dropdown-menu');
            const chevron = document.getElementById('dropdown-chevron');
            if(toggle) {
                toggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const isOpen = menu.classList.toggle('open');
                    chevron.style.transform = isOpen ? 'rotate(180deg)' : 'rotate(0deg)';
                });
                document.addEventListener('click', function() {
                    menu.classList.remove('open');
                    chevron.style.transform = 'rotate(0deg)';
                });
                menu.addEventListener('click', function(e) { e.stopPropagation(); });
            }
        })();
    </script>

    <!-- Scanner Logic & AJAX Database Validation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let html5QrCode;
            const scanLine = document.getElementById('scan-line');
            let isScanning = false;

            const isMobile = /Android|iPhone|iPad|iPod|Mobile/i.test(navigator.userAgent)
                             || (navigator.maxTouchPoints > 1 && window.innerWidth < 1024);

            const camLaptop = document.getElementById('cam-laptop');
            const camMobile = document.getElementById('cam-mobile');
            const btnFront  = document.getElementById('btn-front-cam');
            const btnBack   = document.getElementById('btn-back-cam');

            if (isMobile) {
                camMobile.classList.remove('hidden');
                camMobile.classList.add('flex');
            } else {
                camLaptop.classList.remove('hidden');
            }

            function setActiveBtn(active) {
                if (!btnFront || !btnBack) return;
                if (active === 'front') {
                    btnFront.className = btnFront.className.replace('bg-blue-50 text-blue-700 border border-blue-200', '').trim();
                    btnFront.classList.add('bg-blue-600', 'text-white', 'shadow-md');
                    btnBack.classList.remove('bg-blue-600', 'text-white', 'shadow-md');
                    btnBack.classList.add('bg-blue-50', 'text-blue-700', 'border', 'border-blue-200');
                } else {
                    btnBack.classList.add('bg-blue-600', 'text-white', 'shadow-md');
                    btnBack.classList.remove('bg-blue-50', 'text-blue-700', 'border', 'border-blue-200');
                    btnFront.classList.remove('bg-blue-600', 'text-white', 'shadow-md');
                    btnFront.classList.add('bg-blue-50', 'text-blue-700', 'border', 'border-blue-200');
                }
            }

            function startScanner(facingMode) {
                if (html5QrCode && isScanning) {
                    html5QrCode.stop().then(() => {
                        initScan(facingMode);
                    }).catch(err => console.log(err));
                } else {
                    initScan(facingMode);
                }
            }

            function initScan(facingMode) {
                document.getElementById('cam-error-panel').classList.remove('show');
                html5QrCode = new Html5Qrcode("reader");
                isScanning = true;
                scanLine.classList.remove('hidden');

                let pos = 0;
                let direction = 1;
                const animateLine = setInterval(() => {
                    if (!isScanning) { clearInterval(animateLine); return; }
                    pos += 2 * direction; 
                    if (pos > 95 || pos < 0) direction *= -1;
                    scanLine.style.top = `${pos}%`;
                }, 30);

                const config = { fps: 10, qrbox: { width: 250, height: 250 } };

                html5QrCode.start(
                    { facingMode: facingMode },
                    config,
                    onScanSuccess,
                    onScanFailure
                ).catch(err => {
                    isScanning = false;
                    scanLine.classList.add('hidden');
                    const errStr = String(err);
                    if (facingMode === 'environment' && (errStr.includes('NotFound') || errStr.includes('OverconstrainedError'))) {
                        console.warn('Kamera belakang tidak tersedia, fallback ke depan.');
                        initScan('user');
                    } else {
                        showCameraError(errStr);
                    }
                });
            }

            function showCameraError(errStr) {
                const panel  = document.getElementById('cam-error-panel');
                const title  = document.getElementById('cam-error-title');
                const desc   = document.getElementById('cam-error-desc');
                const steps  = document.getElementById('cam-error-steps');

                if (errStr.includes('NotAllowed') || errStr.includes('Permission')) {
                    title.textContent = 'Izin Kamera Ditolak';
                    desc.textContent  = 'Browser memblokir akses kamera pada halaman ini.';
                    steps.innerHTML = `
                        <div class="cam-error-step"><span class="cam-error-step-num">1</span><span>Buka <b>Pengaturan Browser</b> → Izin Situs → Kamera</span></div>
                        <div class="cam-error-step"><span class="cam-error-step-num">2</span><span>Izinkan akses kamera untuk halaman ini</span></div>
                        <div class="cam-error-step"><span class="cam-error-step-num">3</span><span>Klik tombol <b>Coba Lagi</b> di bawah</span></div>
                    `;
                } else {
                    title.textContent = 'Kamera Tidak Dapat Diakses';
                    desc.textContent  = errStr;
                    steps.innerHTML   = `<div class="cam-error-step"><span class="cam-error-step-num">!</span><span>Refresh halaman dan izinkan akses kamera saat browser meminta.</span></div>`;
                }
                panel.classList.add('show');
            }

            function onScanSuccess(decodedText, decodedResult) {
                if(isScanning) {
                    html5QrCode.stop();
                    isScanning = false;
                    scanLine.classList.add('hidden');

                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    fetch("{{ route('admin.scan') }}", {
                        method: 'POST',
                        headers: { 
                            'Content-Type': 'application/json', 
                            'X-CSRF-TOKEN': csrfToken 
                        },
                        body: JSON.stringify({ barcode: decodedText })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.status === 'success') {
                            showModal3D('success', "Validasi Berhasil!", data.message);
                        } else {
                            showModal3D('error', "Validasi Ditolak!", data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showModal3D('error', "Terjadi Kesalahan", "Gagal menghubungi server. Periksa koneksi internet Anda.");
                    });
                }
            }

            function onScanFailure(error) { }

            let lastFacingMode = 'user'; 
            if (isMobile && btnFront && btnBack) {
                btnFront.addEventListener('click', () => { lastFacingMode = 'user'; setActiveBtn('front'); startScanner('user'); });
                btnBack.addEventListener('click', () => { lastFacingMode = 'environment'; setActiveBtn('back'); startScanner('environment'); });
                lastFacingMode = 'environment'; setActiveBtn('back'); startScanner('environment');
            } else {
                lastFacingMode = 'user'; startScanner('user');
            }

            document.getElementById('btn-retry-cam').addEventListener('click', () => {
                document.getElementById('cam-error-panel').classList.remove('show');
                startScanner(lastFacingMode);
            });

            const modalOverlay = document.getElementById('result-modal');
            const modalContent = document.getElementById('modal-content');
            const scene3d = document.getElementById('scene-3d');
            const iconFront = document.getElementById('icon-front');
            const iconBack = document.getElementById('icon-back');
            const modalTitle = document.getElementById('modal-title');
            const modalMessage = document.getElementById('modal-message');

            function showModal3D(type, title, message) {
                scene3d.classList.remove('theme-success', 'theme-error');
                if(type === 'success') {
                    scene3d.classList.add('theme-success');
                    iconFront.innerHTML = '<i class="fa-solid fa-check"></i>';
                    iconBack.innerHTML = '<i class="fa-solid fa-check"></i>';
                } else {
                    scene3d.classList.add('theme-error');
                    iconFront.innerHTML = '<i class="fa-solid fa-xmark"></i>';
                    iconBack.innerHTML = '<i class="fa-solid fa-xmark"></i>';
                }
                modalTitle.innerText = title;
                modalMessage.innerHTML = message;
                modalOverlay.classList.add('active');
                modalContent.style.transform = 'scale(1)';
            }

            function closeModal() {
                modalOverlay.classList.remove('active');
                modalContent.style.transform = 'scale(0.95)';
                startScanner(lastFacingMode);
            }

            document.getElementById('close-modal').addEventListener('click', closeModal);
            document.getElementById('btn-scan-lagi').addEventListener('click', closeModal);
        });
    </script>

    <!-- 3D Hero Animation Script -->
    <script>
        window.addEventListener('load', function() { init3DAdmin(); });

        function init3DAdmin() {
            const container = document.getElementById('canvas-container-pelayan');
            if (!container || typeof THREE === 'undefined') return;

            const scene = new THREE.Scene();
            const camera = new THREE.PerspectiveCamera(45, container.clientWidth / container.clientHeight, 0.1, 1000);
            camera.position.set(0, 4, 15);

            const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
            renderer.setSize(container.clientWidth, container.clientHeight);
            renderer.setPixelRatio(window.devicePixelRatio);
            renderer.shadowMap.enabled = true;
            renderer.shadowMap.type = THREE.PCFSoftShadowMap;
            container.appendChild(renderer.domElement);

            const ambientLight = new THREE.AmbientLight(0xffffff, 0.6);
            scene.add(ambientLight);
            const directionalLight = new THREE.DirectionalLight(0xffffff, 0.8);
            directionalLight.position.set(5, 10, 7);
            directionalLight.castShadow = true;
            scene.add(directionalLight);
            const blueLight = new THREE.PointLight(0x3b82f6, 2, 20);
            blueLight.position.set(-5, 2, -5);
            scene.add(blueLight);

            const mainGroup = new THREE.Group();
            scene.add(mainGroup);

            const cupMaterial = new THREE.MeshPhysicalMaterial({ color: 0xffffff, metalness: 0.1, roughness: 0.2, clearcoat: 1.0, clearcoatRoughness: 0.1 });
            const cup = new THREE.Mesh(new THREE.CylinderGeometry(1.8, 1.4, 3.5, 32), cupMaterial);
            cup.position.y = -0.5;
            cup.castShadow = true;
            cup.receiveShadow = true;
            mainGroup.add(cup);

            const handle = new THREE.Mesh(new THREE.TorusGeometry(1, 0.25, 16, 32), cupMaterial);
            handle.position.set(1.8, -0.5, 0);
            handle.rotation.z = Math.PI / 2;
            handle.castShadow = true;
            mainGroup.add(handle);

            const coffeeMat = new THREE.MeshStandardMaterial({ color: 0x3d2314, roughness: 0.1, metalness: 0.1 });
            const coffee = new THREE.Mesh(new THREE.CylinderGeometry(1.7, 1.7, 0.1, 32), coffeeMat);
            coffee.position.y = 1.2;
            mainGroup.add(coffee);

            const capGroup = new THREE.Group();
            capGroup.rotation.x = -0.2;
            capGroup.rotation.z = 0.2;
            capGroup.position.y = 1.8;
            mainGroup.add(capGroup);

            const capMaterial = new THREE.MeshStandardMaterial({ color: 0x1a1a2e, roughness: 0.8 });
            const capBase = new THREE.Mesh(new THREE.CylinderGeometry(1.4, 1.4, 0.8, 32), capMaterial);
            capBase.castShadow = true;
            capGroup.add(capBase);

            const capBoard = new THREE.Mesh(new THREE.BoxGeometry(4.5, 0.15, 4.5), capMaterial);
            capBoard.position.y = 0.4;
            capBoard.castShadow = true;
            capGroup.add(capBoard);

            const tasselMat = new THREE.MeshStandardMaterial({ color: 0xf59e0b, roughness: 0.4 });
            const tasselString = new THREE.Mesh(new THREE.CylinderGeometry(0.04, 0.04, 1.5), tasselMat);
            tasselString.position.set(1.8, -0.3, 1.8);
            tasselString.rotation.x = 0.2;
            tasselString.rotation.z = -0.2;
            capGroup.add(tasselString);

            const tasselEnd = new THREE.Mesh(new THREE.CylinderGeometry(0.1, 0.1, 0.4), tasselMat);
            tasselEnd.position.set(2.0, -1.0, 2.0);
            tasselEnd.rotation.x = 0.2;
            tasselEnd.rotation.z = -0.2;
            capGroup.add(tasselEnd);

            let isDragging = false;
            let previousMousePosition = { x: 0, y: 0 };
            let autoRotateSpeed = 0.005;
            let targetRotation = { x: 0, y: 0 };

            container.addEventListener('mousedown', () => { isDragging = true; });
            container.addEventListener('mousemove', (e) => {
                if (isDragging) {
                    targetRotation.y += (e.offsetX - previousMousePosition.x) * 0.01; 
                    targetRotation.x += (e.offsetY - previousMousePosition.y) * 0.01; 
                }
                previousMousePosition = { x: e.offsetX, y: e.offsetY };
            });
            window.addEventListener('mouseup', () => { isDragging = false; });
            container.addEventListener('touchstart', (e) => {
                isDragging = true;
                previousMousePosition = { x: e.touches[0].clientX, y: e.touches[0].clientY };
            }, { passive: true });
            container.addEventListener('touchmove', (e) => {
                if (isDragging) {
                    targetRotation.y += (e.touches[0].clientX - previousMousePosition.x) * 0.01; 
                    targetRotation.x += (e.touches[0].clientY - previousMousePosition.y) * 0.01; 
                }
                previousMousePosition = { x: e.touches[0].clientX, y: e.touches[0].clientY };
            }, { passive: true });
            window.addEventListener('touchend', () => { isDragging = false; });
            window.addEventListener('resize', () => {
                renderer.setSize(container.clientWidth, container.clientHeight);
                camera.aspect = container.clientWidth / container.clientHeight;
                camera.updateProjectionMatrix();
            });

            const clock = new THREE.Clock();
            function animate() {
                requestAnimationFrame(animate);
                const time = clock.getElapsedTime();
                if (!isDragging) {
                    targetRotation.y += autoRotateSpeed;
                    targetRotation.x += (0 - targetRotation.x) * 0.05; 
                }
                mainGroup.rotation.y += (targetRotation.y - mainGroup.rotation.y) * 0.1; 
                mainGroup.rotation.x += (targetRotation.x - mainGroup.rotation.x) * 0.1; 
                mainGroup.position.y = Math.sin(time * 2) * 0.3; 
                renderer.render(scene, camera);
            }
            animate();
        }
    </script>
</body>
</html>