<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tukar Kopi Wisuda 2026</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- FontAwesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Google Fonts (Inter) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Three.js for 3D Animation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        'futuristic-blue': '#2563eb',
                        'futuristic-light': '#f8fafc',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #f8fafc;
            overflow-x: hidden;
            position: relative;
        }

        /* Abstract Lines Background */
        .abstract-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -1;
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

        /* Futuristic Glow Elements */
        .glow-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: -1;
            opacity: 0.5;
        }
        
        .glass-header {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.5);
        }

        .btn-glow {
            box-shadow: 0 0 20px rgba(37, 99, 235, 0.4);
            transition: all 0.3s ease;
        }
        .btn-glow:hover {
            box-shadow: 0 0 30px rgba(37, 99, 235, 0.7);
            transform: translateY(-2px);
        }

        /* 3D Canvas Container */
        #canvas-container {
            width: 100%;
            height: 100%;
            min-height: 400px;
            cursor: grab;
        }
        #canvas-container:active {
            cursor: grabbing;
        }
    </style>
</head>
<body class="text-slate-800 antialiased flex flex-col min-h-screen">

    <!-- Background Elements -->
    <div class="abstract-bg"></div>
    <div class="glow-blob bg-blue-300 w-96 h-96 top-0 left-[-100px]"></div>
    <div class="glow-blob bg-indigo-200 w-96 h-96 bottom-20 right-[-100px]"></div>

    <!-- Header -->
    <header class="glass-header fixed w-full top-0 z-50 px-6 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <!-- Left: Logo -->
            <div class="flex items-center gap-3">
                <div class="relative flex items-center justify-center w-12 h-12 bg-blue-600 rounded-xl text-white transform rotate-3 shadow-lg">
                    <i class="fa-solid fa-graduation-cap text-2xl"></i>
                    <!-- Stylized coffee bean accent -->
                    <div class="absolute -bottom-1 -right-1 bg-white text-blue-600 rounded-full w-5 h-5 flex items-center justify-center text-[10px] shadow">
                        <i class="fa-solid fa-mug-hot"></i>
                    </div>
                </div>
                <div>
                    <h1 class="font-extrabold text-xl tracking-tight text-slate-800 leading-tight">
                        TUKAR_KOPI<br><span class="text-blue-600">WISUDA</span>
                    </h1>
                </div>
            </div>

            <!-- Right: Action Button -->
            <!-- Note: Ganti "/login" dengan route ke login-admin.blade.php di Laravel Anda -->
           <!-- Ubah atribut href menjadi seperti ini -->
            <a href="{{ route('login') }}" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-500 text-white px-6 py-2 rounded-full transition-all duration-300 shadow-[0_0_15px_rgba(37,99,235,0.5)] hover:shadow-[0_0_25px_rgba(37,99,235,0.8)]">
                <!-- Icon Play -->
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4 4l12 6-12 6V4z"></path>
                </svg>
                <span class="font-semibold tracking-wide">Tukar Kopi</span>
            </a>
        </div>
    </header>

    <!-- Main Body / Hero Section -->
    <main class="flex-grow pt-32 pb-16 px-6 relative z-10 flex items-center">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-center w-full">
            
            <!-- Left Text Content -->
            <div class="space-y-6 text-center lg:text-left">
                <div class="inline-block bg-blue-100 text-blue-700 px-4 py-1.5 rounded-full text-sm font-semibold tracking-wide border border-blue-200">
                    🎓 Wisuda Oktober 2026
                </div>
                
                <h2 class="text-4xl lg:text-6xl font-extrabold leading-tight text-slate-900 drop-shadow-sm">
                    Selamat & Sukses <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-500">
                        Wisudawan & Wisudawati
                    </span>
                </h2>
                
                <h3 class="text-xl lg:text-2xl font-semibold text-slate-700">
                    Universitas Muria Kudus
                </h3>
                
                <p class="text-lg text-slate-600 leading-relaxed border-l-4 border-blue-500 pl-4 bg-white/50 py-2 rounded-r-lg">
                    "Selamat atas gelar barunya! Perjalanan panjang, malam-malam begadang, dan segala perjuangan akhirnya terbayar lunas. Ini bukan akhir, melainkan awal dari petualangan hebat lainnya. Teruslah berkarya dan bawa perubahan!"
                </p>

                <div class="flex items-center gap-4 pt-4 justify-center lg:justify-start">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold shadow-lg">
                        DR
                    </div>
                    <div>
                        <p class="font-bold text-slate-900 text-lg">DR Rex</p>
                        <p class="text-sm text-blue-600 font-medium">Pengirim Pesan Spesial</p>
                    </div>
                </div>
            </div>

            <!-- Right 3D Interactive Visual -->
            <div class="relative h-[400px] lg:h-[600px] w-full rounded-3xl bg-gradient-to-tr from-white/40 to-blue-50/40 backdrop-blur-md border border-white shadow-2xl flex items-center justify-center overflow-hidden">
                <!-- 3D Canvas will be injected here -->
                <div id="canvas-container"></div>
                
                <!-- Floating Labels -->
                <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 bg-white/80 backdrop-blur px-4 py-2 rounded-full text-xs font-semibold text-blue-600 shadow-sm border border-blue-100 flex items-center gap-2 pointer-events-none">
                    <i class="fa-solid fa-hand-pointer animate-bounce"></i> Putar dengan mouse / sentuhan
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white/80 backdrop-blur-md border-t border-slate-200 py-8 relative z-10">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="text-slate-500 text-sm font-medium">
                &copy; 2026 Tukar Kopi Wisuda - Universitas Muria Kudus. All rights reserved.
            </div>
            
            <div class="flex items-center gap-4">
                <a href="#" class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-blue-600 hover:text-white transition-colors">
                    <i class="fa-brands fa-instagram text-lg"></i>
                </a>
                <a href="#" class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-blue-600 hover:text-white transition-colors">
                    <i class="fa-brands fa-twitter text-lg"></i>
                </a>
                <a href="#" class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-blue-600 hover:text-white transition-colors">
                    <i class="fa-brands fa-facebook-f text-lg"></i>
                </a>
            </div>
        </div>
    </footer>

    <!-- 3D Animation Script -->
    <script>
        window.onload = function() {
            init3D();
        };

        function init3D() {
            const container = document.getElementById('canvas-container');
            
            // Scene Setup
            const scene = new THREE.Scene();
            
            // Camera Setup
            const camera = new THREE.PerspectiveCamera(45, container.clientWidth / container.clientHeight, 0.1, 1000);
            camera.position.set(0, 4, 15);
            
            // Renderer Setup
            const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
            renderer.setSize(container.clientWidth, container.clientHeight);
            renderer.setPixelRatio(window.devicePixelRatio);
            // Soft shadows
            renderer.shadowMap.enabled = true;
            renderer.shadowMap.type = THREE.PCFSoftShadowMap;
            container.appendChild(renderer.domElement);

            // Lighting (Futuristic look)
            const ambientLight = new THREE.AmbientLight(0xffffff, 0.6);
            scene.add(ambientLight);

            const directionalLight = new THREE.DirectionalLight(0xffffff, 0.8);
            directionalLight.position.set(5, 10, 7);
            directionalLight.castShadow = true;
            scene.add(directionalLight);

            const blueLight = new THREE.PointLight(0x3b82f6, 2, 20);
            blueLight.position.set(-5, 2, -5);
            scene.add(blueLight);

            // Group to hold everything
            const mainGroup = new THREE.Group();
            scene.add(mainGroup);

            // --- CREATE COFFEE CUP ---
            // Cup Material (Glossy white plastic/ceramic)
            const cupMaterial = new THREE.MeshPhysicalMaterial({ 
                color: 0xffffff, 
                metalness: 0.1,
                roughness: 0.2,
                clearcoat: 1.0,
                clearcoatRoughness: 0.1
            });

            // Cup Body
            const cupGeo = new THREE.CylinderGeometry(1.8, 1.4, 3.5, 32);
            const cup = new THREE.Mesh(cupGeo, cupMaterial);
            cup.position.y = -0.5;
            cup.castShadow = true;
            cup.receiveShadow = true;
            mainGroup.add(cup);

            // Cup Handle
            const handleGeo = new THREE.TorusGeometry(1, 0.25, 16, 32);
            const handle = new THREE.Mesh(handleGeo, cupMaterial);
            handle.position.set(1.8, -0.5, 0);
            handle.rotation.z = Math.PI / 2;
            handle.castShadow = true;
            mainGroup.add(handle);

            // Coffee Inside (Dark Brown)
            const coffeeGeo = new THREE.CylinderGeometry(1.7, 1.7, 0.1, 32);
            const coffeeMat = new THREE.MeshStandardMaterial({ color: 0x3d2314, roughness: 0.1, metalness: 0.1 });
            const coffee = new THREE.Mesh(coffeeGeo, coffeeMat);
            coffee.position.y = 1.2;
            mainGroup.add(coffee);

            // --- CREATE GRADUATION CAP (TOGA) ---
            const capGroup = new THREE.Group();
            // Tilt the cap slightly dynamically
            capGroup.rotation.x = -0.2;
            capGroup.rotation.z = 0.2;
            capGroup.position.y = 1.8; 
            mainGroup.add(capGroup);

            const capMaterial = new THREE.MeshStandardMaterial({ 
                color: 0x1a1a2e, // Dark navy/black
                roughness: 0.8
            });

            // Cap Base (Skull cap)
            const baseGeo = new THREE.CylinderGeometry(1.4, 1.4, 0.8, 32);
            const capBase = new THREE.Mesh(baseGeo, capMaterial);
            capBase.position.y = 0;
            capBase.castShadow = true;
            capGroup.add(capBase);

            // Cap Board (Square top)
            const boardGeo = new THREE.BoxGeometry(4.5, 0.15, 4.5);
            const capBoard = new THREE.Mesh(boardGeo, capMaterial);
            capBoard.position.y = 0.4;
            capBoard.castShadow = true;
            capGroup.add(capBoard);

            // Tassel String (Yellow/Gold)
            const tasselMat = new THREE.MeshStandardMaterial({ color: 0xf59e0b, roughness: 0.4 });
            const stringGeo = new THREE.CylinderGeometry(0.04, 0.04, 1.5);
            const tasselString = new THREE.Mesh(stringGeo, tasselMat);
            tasselString.position.set(1.8, -0.3, 1.8);
            tasselString.rotation.x = 0.2;
            tasselString.rotation.z = -0.2;
            capGroup.add(tasselString);

            // Tassel End
            const tasselEndGeo = new THREE.CylinderGeometry(0.1, 0.1, 0.4);
            const tasselEnd = new THREE.Mesh(tasselEndGeo, tasselMat);
            tasselEnd.position.set(2.0, -1.0, 2.0);
            tasselEnd.rotation.x = 0.2;
            tasselEnd.rotation.z = -0.2;
            capGroup.add(tasselEnd);

            // --- INTERACTION & ANIMATION ---
            let isDragging = false;
            let previousMousePosition = { x: 0, y: 0 };
            
            // Auto rotation speeds
            let autoRotateSpeed = 0.005;
            let targetRotation = { x: 0, y: 0 };
            
            // Mouse Events
            container.addEventListener('mousedown', (e) => {
                isDragging = true;
            });

            container.addEventListener('mousemove', (e) => {
                if (isDragging) {
                    const deltaMove = {
                        x: e.offsetX - previousMousePosition.x,
                        y: e.offsetY - previousMousePosition.y
                    };
                    
                    targetRotation.y += deltaMove.x * 0.01;
                    targetRotation.x += deltaMove.y * 0.01;
                }
                previousMousePosition = { x: e.offsetX, y: e.offsetY };
            });

            window.addEventListener('mouseup', () => {
                isDragging = false;
            });

            // Touch Events for Mobile
            container.addEventListener('touchstart', (e) => {
                isDragging = true;
                previousMousePosition = { x: e.touches[0].clientX, y: e.touches[0].clientY };
            }, {passive: true});

            container.addEventListener('touchmove', (e) => {
                if (isDragging) {
                    const deltaMove = {
                        x: e.touches[0].clientX - previousMousePosition.x,
                        y: e.touches[0].clientY - previousMousePosition.y
                    };
                    targetRotation.y += deltaMove.x * 0.01;
                    targetRotation.x += deltaMove.y * 0.01;
                }
                previousMousePosition = { x: e.touches[0].clientX, y: e.touches[0].clientY };
            }, {passive: true});

            window.addEventListener('touchend', () => {
                isDragging = false;
            });

            // Handle Resize
            window.addEventListener('resize', () => {
                const width = container.clientWidth;
                const height = container.clientHeight;
                renderer.setSize(width, height);
                camera.aspect = width / height;
                camera.updateProjectionMatrix();
            });

            // Floating animation variables
            let clock = new THREE.Clock();

            // Animation Loop
            function animate() {
                requestAnimationFrame(animate);

                let delta = clock.getDelta();
                let time = clock.getElapsedTime();

                // Smoothly interpolate rotation to target rotation (mouse drag)
                if(!isDragging) {
                    // Auto rotate if not dragging
                    targetRotation.y += autoRotateSpeed;
                    
                    // slowly return X rotation to center
                    targetRotation.x += (0 - targetRotation.x) * 0.05; 
                }

                mainGroup.rotation.y += (targetRotation.y - mainGroup.rotation.y) * 0.1;
                mainGroup.rotation.x += (targetRotation.x - mainGroup.rotation.x) * 0.1;

                // Floating Effect (Sine wave on Y position)
                mainGroup.position.y = Math.sin(time * 2) * 0.3;

                renderer.render(scene, camera);
            }

            // Start loop
            animate();
        }
    </script>
</body>
</html>