<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat datang di Aplikasi E-Kinerja</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .floating-logo {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(10, 186, 39, 0.15);
        }
    </style>
</head>
<body class="bg-white min-h-screen flex items-center">
    <div class="container mx-auto px-4 sm:px-6">
        <!-- Logo Section dengan animasi floating -->
        <div class="text-center mb-8 sm:mb-12 mt-16 sm:mt-32">
            <div class="floating-logo inline-block">
                <img src="/logo_kemenag.png" alt="Logo Kementerian Agama RI" class="w-16 h-16 sm:w-24 sm:h-24 mx-auto">
            </div>
        </div>

        <!-- Welcome Text -->
        <div class="text-center mb-6 sm:mb-8">
            <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 max-w-3xl mx-auto border border-gray-100">
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-green-800 mb-2">
                    Selamat datang di Aplikasi E-Kinerja
                </h1>
                <p class="text-sm sm:text-base text-gray-600">
                    Silakan pilih peran Anda untuk masuk
                </p>
            </div>
        </div>

        <!-- Role Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-8 mb-6 sm:mb-8">
            <!-- Kepala Kantor Card -->
            <a href="/login/kepala" class="block">
                <div class="bg-white rounded-lg shadow-md p-4 sm:p-8 border border-gray-100 card-hover transition-all duration-300 cursor-pointer">
                    <div class="w-12 h-12 sm:w-20 sm:h-20 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4 sm:mb-6">
                        <svg class="w-6 h-6 sm:w-10 sm:h-10 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-2 text-center">Kepala Kantor</h3>
                    <p class="text-xs sm:text-sm text-gray-600 text-center">Login sebagai Kepala Kantor</p>
                </div>
            </a>

            <!-- Kasi Card -->
            <a href="/login/kasi" class="block">
                <div class="bg-white rounded-lg shadow-md p-4 sm:p-8 border border-gray-100 card-hover transition-all duration-300 cursor-pointer">
                    <div class="w-12 h-12 sm:w-20 sm:h-20 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4 sm:mb-6">
                        <svg class="w-6 h-6 sm:w-10 sm:h-10 text-green-700" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-2 text-center">Kasi</h3>
                    <p class="text-xs sm:text-sm text-gray-600 text-center">Login sebagai Kasi</p>
                </div>
            </a>

            <!-- Staff Card -->
            <a href="/login/staff" class="block sm:col-span-2 lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-4 sm:p-8 border border-gray-100 card-hover transition-all duration-300 cursor-pointer">
                    <div class="w-12 h-12 sm:w-20 sm:h-20 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4 sm:mb-6">
                        <svg class="w-6 h-6 sm:w-10 sm:h-10 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-2 text-center">Staff</h3>
                    <p class="text-xs sm:text-sm text-gray-600 text-center">Login sebagai Staff</p>
                </div>
            </a>
        </div>


    </div>
</body>
</html>

