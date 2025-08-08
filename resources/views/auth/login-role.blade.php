<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login {{ $role }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl p-4 sm:p-8 max-w-sm sm:max-w-md w-full text-center">
        <h1 class="text-xl sm:text-2xl md:text-3xl font-extrabold mb-3 sm:mb-4 text-[#5B21B6]">Login {{ $role }}</h1>
        
        @if($role === 'Kasi')
            <p class="text-sm sm:text-base text-gray-600 mb-4 sm:mb-6">Selamat datang di panel Kepala Seksi</p>
            
            <!-- Form Login untuk KASI -->
            <form method="POST" action="{{ route('kasi.login') }}" class="space-y-3 sm:space-y-4">
                @csrf
                <div class="text-left">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Username</label>
                    <input type="text" name="username" required 
                           class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B21B6] focus:outline-none"
                           placeholder="Masukkan username">
                </div>
                
                <div class="text-left">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required 
                           class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B21B6] focus:outline-none"
                           placeholder="Masukkan password">
                </div>
                
                <button type="submit" 
                        class="w-full px-4 sm:px-6 py-2 sm:py-3 text-sm sm:text-base rounded-lg bg-[#5B21B6] text-white font-semibold hover:bg-[#5B21B6]/90 transition-all">
                    Login sebagai KASI
                </button>
            </form>
        @elseif($role === 'Staf')
            <p class="text-sm sm:text-base text-gray-600 mb-4 sm:mb-6">Selamat datang di panel Staff</p>
            
            <!-- Form Login untuk STAFF -->
            <form method="POST" action="{{ route('staff.login') }}" class="space-y-3 sm:space-y-4">
                @csrf
                <div class="text-left">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Username</label>
                    <input type="text" name="username" required 
                           class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B21B6] focus:outline-none"
                           placeholder="Masukkan username">
                </div>
                
                <div class="text-left">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required 
                           class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B21B6] focus:outline-none"
                           placeholder="Masukkan password">
                </div>
                
                <button type="submit" 
                        class="w-full px-4 sm:px-6 py-2 sm:py-3 text-sm sm:text-base rounded-lg bg-[#5B21B6] text-white font-semibold hover:bg-[#5B21B6]/90 transition-all">
                    Login sebagai Staff
                </button>
            </form>
        @else
            <p class="text-sm sm:text-base text-gray-600 mb-4 sm:mb-6">Ini adalah halaman <b>{{ $role }}</b>.<br>Masih dalam tahap pengembangan.</p>
        @endif
        
        <div class="mt-4 sm:mt-6">
            <a href="/" class="inline-block px-4 sm:px-6 py-2 text-sm sm:text-base rounded-lg bg-gray-500 text-white font-semibold hover:bg-gray-600 transition-all">
                Kembali ke Landing
            </a>
        </div>
    </div>
</body>
</html> 