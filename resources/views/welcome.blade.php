{{-- Halaman welcome/landing page aplikasi E-Kinerja --}}
{{-- Menampilkan pilihan role untuk login (Kepala, KASI, Staff) --}}
<!DOCTYPE html>
<html lang="id">
<head>
    {{-- Meta tags untuk charset dan responsive viewport --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Title halaman --}}
    <title>Selamat datang di Aplikasi E-Kinerja</title>
    {{-- CDN Tailwind CSS untuk styling --}}
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Google Fonts Inter untuk typography --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    {{-- Custom CSS untuk animasi dan efek --}}
    <style>
        {{-- Set font family default ke Inter --}}
        body {
            font-family: 'Inter', sans-serif;
        }
        
        {{-- Class untuk animasi floating logo --}}
        .floating-logo {
            animation: float 3s ease-in-out infinite;
        }
        
        {{-- Keyframes untuk animasi floating up-down --}}
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        {{-- Class untuk efek hover pada card --}}
        .card-hover {
            transition: all 0.3s ease;
        }
        
        {{-- Efek hover: card naik ke atas dan shadow hijau --}}
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(10, 186, 39, 0.15);
        }
    </style>
</head>

{{-- Body dengan background putih dan centering --}}
<body class="bg-white min-h-screen flex items-center">
    {{-- Container utama dengan responsive padding --}}
    <div class="container mx-auto px-4 sm:px-6">
        
        {{-- Section logo dengan animasi floating --}}
        <div class="text-center mb-8 sm:mb-12 mt-16 sm:mt-32">
            {{-- Logo dengan class floating untuk animasi --}}
            <div class="floating-logo inline-block">
                {{-- Logo Kemenag dengan responsive size --}}
                <img src="/logo_kemenag.png" alt="Logo Kementerian Agama RI" class="w-16 h-16 sm:w-24 sm:h-24 mx-auto">
            </div>
        </div>

        {{-- Section welcome text dengan card --}}
        <div class="text-center mb-6 sm:mb-8">
            {{-- Card putih dengan shadow dan border --}}
            <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 max-w-3xl mx-auto border border-gray-100">
                {{-- Judul utama dengan warna hijau --}}
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-green-800 mb-2">
                    Selamat datang di Aplikasi E-Kinerja
                </h1>
                {{-- Subtitle instruksi --}}
                <p class="text-sm sm:text-base text-gray-600">
                    Silakan pilih peran Anda untuk masuk
                </p>
            </div>
        </div>

        {{-- Grid cards untuk pilihan role --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-8 mb-6 sm:mb-8">
            
            {{-- Card Kepala Kantor dengan link ke login --}}
            <a href="/login/kepala" class="block">
                {{-- Container card dengan hover effect --}}
                <div class="bg-white rounded-lg shadow-md p-4 sm:p-8 border border-gray-100 card-hover transition-all duration-300 cursor-pointer">
                    {{-- Icon building dengan background hijau --}}
                    <div class="w-12 h-12 sm:w-20 sm:h-20 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4 sm:mb-6">
                        {{-- SVG icon building --}}
                        <svg class="w-6 h-6 sm:w-10 sm:h-10 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    {{-- Judul role --}}
                    <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-2 text-center">Kepala Kantor</h3>
                    {{-- Deskripsi role --}}
                    <p class="text-xs sm:text-sm text-gray-600 text-center">Login sebagai Kepala Kantor</p>
                </div>
            </a>

            {{-- Card KASI dengan link ke login --}}
            <a href="/login/kasi" class="block">
                {{-- Container card dengan hover effect --}}
                <div class="bg-white rounded-lg shadow-md p-4 sm:p-8 border border-gray-100 card-hover transition-all duration-300 cursor-pointer">
                    {{-- Icon star dengan background hijau --}}
                    <div class="w-12 h-12 sm:w-20 sm:h-20 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4 sm:mb-6">
                        {{-- SVG icon star --}}
                        <svg class="w-6 h-6 sm:w-10 sm:h-10 text-green-700" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    {{-- Judul role --}}
                    <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-2 text-center">Kasi</h3>
                    {{-- Deskripsi role --}}
                    <p class="text-xs sm:text-sm text-gray-600 text-center">Login sebagai Kasi</p>
                </div>
            </a>

            {{-- Card Staff dengan link ke login --}}
            <a href="/login/staff" class="block sm:col-span-2 lg:col-span-1">
                {{-- Container card dengan hover effect --}}
                <div class="bg-white rounded-lg shadow-md p-4 sm:p-8 border border-gray-100 card-hover transition-all duration-300 cursor-pointer">
                    {{-- Icon user dengan background hijau --}}
                    <div class="w-12 h-12 sm:w-20 sm:h-20 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4 sm:mb-6">
                        {{-- SVG icon user --}}
                        <svg class="w-6 h-6 sm:w-10 sm:h-10 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    {{-- Judul role --}}
                    <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-2 text-center">Staff</h3>
                    {{-- Deskripsi role --}}
                    <p class="text-xs sm:text-sm text-gray-600 text-center">Login sebagai Staff</p>
                </div>
            </a>
        </div>

    </div>
</body>
</html>

