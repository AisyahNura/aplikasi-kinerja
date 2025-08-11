{{-- Halaman login dinamis berdasarkan role yang dipilih --}}
{{-- Template login untuk KASI dan Staff dengan form yang berbeda --}}
<!DOCTYPE html>
<html lang="id">
<head>
    {{-- Meta tags untuk charset dan responsive viewport --}}
    <meta charset="UTF-8">
    {{-- Title dinamis berdasarkan role dari controller --}}
    <title>Login {{ $role }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Vite assets untuk CSS custom --}}
    @vite(['resources/css/app.css'])
</head>

{{-- Body dengan background abu-abu dan centering --}}
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    
    {{-- Container utama dengan card putih dan shadow --}}
    <div class="bg-white rounded-2xl shadow-xl p-4 sm:p-8 max-w-sm sm:max-w-md w-full text-center">
        
        {{-- Judul halaman dengan warna ungu dan responsive sizing --}}
        <h1 class="text-xl sm:text-2xl md:text-3xl font-extrabold mb-3 sm:mb-4 text-[#5B21B6]">Login {{ $role }}</h1>
        
        {{-- Conditional rendering berdasarkan role yang dipilih --}}
        @if($role === 'Kasi')
            {{-- Deskripsi untuk role KASI --}}
            <p class="text-sm sm:text-base text-gray-600 mb-4 sm:mb-6">Selamat datang di panel Kepala Seksi</p>
            
            {{-- Form Login untuk KASI dengan POST ke route kasi.login --}}
            <form method="POST" action="{{ route('kasi.login') }}" class="space-y-3 sm:space-y-4">
                {{-- CSRF token untuk security --}}
                @csrf
                
                {{-- Input field username --}}
                <div class="text-left">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Username</label>
                    {{-- Input text dengan focus ring ungu --}}
                    <input type="text" name="username" required 
                           class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B21B6] focus:outline-none"
                           placeholder="Masukkan username">
                </div>
                
                {{-- Input field password --}}
                <div class="text-left">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Password</label>
                    {{-- Input password dengan focus ring ungu --}}
                    <input type="password" name="password" required 
                           class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B21B6] focus:outline-none"
                           placeholder="Masukkan password">
                </div>
                
                {{-- Button submit untuk login KASI --}}
                <button type="submit" 
                        class="w-full px-4 sm:px-6 py-2 sm:py-3 text-sm sm:text-base rounded-lg bg-[#5B21B6] text-white font-semibold hover:bg-[#5B21B6]/90 transition-all">
                    Login sebagai KASI
                </button>
            </form>
            
        @elseif($role === 'Staf')
            {{-- Deskripsi untuk role Staff --}}
            <p class="text-sm sm:text-base text-gray-600 mb-4 sm:mb-6">Selamat datang di panel Staff</p>
            
            {{-- Form Login untuk STAFF dengan POST ke route staff.login --}}
            <form method="POST" action="{{ route('staff.login') }}" class="space-y-3 sm:space-y-4">
                {{-- CSRF token untuk security --}}
                @csrf
                
                {{-- Input field username --}}
                <div class="text-left">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Username</label>
                    {{-- Input text dengan focus ring ungu --}}
                    <input type="text" name="username" required 
                           class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B21B6] focus:outline-none"
                           placeholder="Masukkan username">
                </div>
                
                {{-- Input field password --}}
                <div class="text-left">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Password</label>
                    {{-- Input password dengan focus ring ungu --}}
                    <input type="password" name="password" required 
                           class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5B21B6] focus:outline-none"
                           placeholder="Masukkan password">
                </div>
                
                {{-- Button submit untuk login Staff --}}
                <button type="submit" 
                        class="w-full px-4 sm:px-6 py-2 sm:py-3 text-sm sm:text-base rounded-lg bg-[#5B21B6] text-white font-semibold hover:bg-[#5B21B6]/90 transition-all">
                    Login sebagai Staff
                </button>
            </form>
            
        @else
            {{-- Fallback untuk role yang tidak dikenali --}}
            <p class="text-sm sm:text-base text-gray-600 mb-4 sm:mb-6">Ini adalah halaman <b>{{ $role }}</b>.<br>Masih dalam tahap pengembangan.</p>
        @endif
        
        {{-- Tombol kembali ke landing page --}}
        <div class="mt-4 sm:mt-6">
            {{-- Link kembali dengan styling abu-abu --}}
            <a href="/" class="inline-block px-4 sm:px-6 py-2 text-sm sm:text-base rounded-lg bg-gray-500 text-white font-semibold hover:bg-gray-600 transition-all">
                Kembali ke Landing
            </a>
        </div>
    </div>
</body>
</html> 