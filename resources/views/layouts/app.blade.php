{{-- Layout utama aplikasi untuk halaman realisasi kinerja --}}
{{-- Template dasar dengan navigation dan content area --}}
<!DOCTYPE html>
<html lang="id">
<head>
    {{-- Meta tags untuk charset dan responsive viewport --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Title dinamis dari config Laravel --}}
    <title>{{ config('app.name', 'Laravel') }}</title>
    
    {{-- CDN Tailwind CSS untuk styling --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Google Fonts Figtree untuk typography --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    {{-- Vite assets untuk CSS dan JS custom --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

{{-- Body dengan font sans dan antialiasing --}}
<body class="font-sans antialiased">
    {{-- Container utama dengan background abu-abu --}}
    <div class="min-h-screen bg-gray-100">
        
        {{-- Navigation bar dengan background putih --}}
        <nav class="bg-white border-b border-gray-100">
            {{-- Container navigation dengan max width dan padding --}}
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{-- Flex container untuk logo dan menu --}}
                <div class="flex justify-between h-16">
                    
                    {{-- Left side: Logo dan navigation links --}}
                    <div class="flex">
                        
                        {{-- Logo aplikasi dengan link ke realisasi kinerja --}}
                        <div class="shrink-0 flex items-center">
                            {{-- Link ke halaman utama realisasi kinerja --}}
                            <a href="{{ route('realisasi-kinerja.index') }}" class="text-xl font-bold text-gray-900">
                                Aplikasi Kinerja
                            </a>
                        </div>

                        {{-- Navigation links dengan responsive hiding --}}
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            {{-- Link ke realisasi kinerja dengan hover effects --}}
                            <a href="{{ route('realisasi-kinerja.index') }}" 
                               class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                Realisasi Kinerja
                            </a>
                        </div>
                    </div>

                    {{-- Right side: User settings dan logout --}}
                    @auth
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <div class="ml-3 relative">
                            {{-- Container untuk user info dan logout --}}
                            <div class="flex items-center">
                                {{-- Display nama user yang sedang login --}}
                                <span class="text-sm text-gray-700">{{ Auth::user()->name ?? 'User' }}</span>
                                
                                {{-- Form logout dengan CSRF protection --}}
                                <form method="POST" action="{{ route('logout') }}" class="ml-4">
                                    {{-- CSRF token untuk security --}}
                                    @csrf
                                    {{-- Button logout dengan hover effect --}}
                                    <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endauth
                </div>
            </div>
        </nav>

        {{-- Main content area --}}
        <main>
            {{-- Yield untuk content dari child views --}}
            @yield('content')
        </main>
    </div>
</body>
</html> 