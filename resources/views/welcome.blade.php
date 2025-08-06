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
<body class="bg-white h-screen flex items-center">
    <div class="container mx-auto px-6">
        <!-- Logo Section dengan animasi floating -->
        <div class="text-center mb-12 mt-32">
            <div class="floating-logo inline-block">
                <img src="/logo_kemenag.png" alt="Logo Kementerian Agama RI" class="w-24 h-24 mx-auto">
            </div>
        </div>

        <!-- Welcome Text -->
        <div class="text-center mb-8">
            <div class="bg-white rounded-lg shadow-md p-6 max-w-3xl mx-auto border border-gray-100">
                <h1 class="text-3xl md:text-4xl font-bold text-green-800 mb-2">
                    Selamat datang di Aplikasi E-Kinerja
                </h1>
                <p class="text-gray-600 text-base">
                    Silakan pilih peran Anda untuk masuk
                </p>
            </div>
        </div>

        <!-- Role Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <!-- Kepala Kantor Card -->
            <a href="/login/kepala" class="block">
                <div class="bg-white rounded-lg shadow-md p-8 border border-gray-100 card-hover transition-all duration-300 cursor-pointer">
                    <div class="w-20 h-20 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2 text-center">Kepala Kantor</h3>
                    <p class="text-gray-600 text-center">Login sebagai Kepala Kantor</p>
                </div>
            </a>

            <!-- Kasi Card -->
            <a href="/login/kasi" class="block">
                <div class="bg-white rounded-lg shadow-md p-8 border border-gray-100 card-hover transition-all duration-300 cursor-pointer">
                    <div class="w-20 h-20 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-green-700" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2 text-center">Kasi</h3>
                    <p class="text-gray-600 text-center">Login sebagai Kasi</p>
                </div>
            </a>

            <!-- Staff Card -->
            <a href="/login/staff" class="block">
                <div class="bg-white rounded-lg shadow-md p-8 border border-gray-100 card-hover transition-all duration-300 cursor-pointer">
                    <div class="w-20 h-20 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2 text-center">Staff</h3>
                    <p class="text-gray-600 text-center">Login sebagai Staff</p>
                </div>
            </a>
        </div>

        <!-- Demo Login Section -->
        <div class="text-center">
            <div class="bg-white rounded-lg shadow-md p-6 max-w-3xl mx-auto border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Demo Login untuk Testing</h2>
                <div class="flex flex-col md:flex-row gap-4 justify-center">
                    <a href="/kepala/demo" class="inline-flex items-center px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Demo Kepala
                    </a>
                    <a href="/kasi/demo" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        Demo Kasi
                    </a>
                    <a href="/staff/demo" class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Demo Staff
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

