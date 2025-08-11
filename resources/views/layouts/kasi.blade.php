{{-- Layout khusus untuk role KASI dengan sidebar navigation --}}
{{-- Template dengan mobile responsive dan sidebar menu --}}
<!DOCTYPE html>
<html lang="id">
<head>
    {{-- Meta tags untuk charset dan responsive viewport --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- CSRF token untuk AJAX requests --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Title dengan suffix Kasi Panel --}}
    <title>{{ config('app.name', 'Laravel') }} - Kasi Panel</title>
    
    {{-- CDN Tailwind CSS untuk styling --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Google Fonts Figtree untuk typography --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    {{-- Vite assets untuk CSS dan JS custom --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- JavaScript untuk mobile menu functionality --}}
    <script>
        {{-- Mobile menu functionality dengan event listeners --}}
        document.addEventListener('DOMContentLoaded', function() {
            {{-- Get DOM elements untuk mobile menu --}}
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const closeSidebarButton = document.getElementById('close-sidebar');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            
            {{-- Function untuk membuka sidebar mobile --}}
            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
            
            {{-- Function untuk menutup sidebar mobile --}}
            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
                document.body.style.overflow = '';
            }
            
            {{-- Event listeners untuk tombol mobile menu --}}
            mobileMenuButton.addEventListener('click', openSidebar);
            closeSidebarButton.addEventListener('click', closeSidebar);
            sidebarOverlay.addEventListener('click', closeSidebar);
            
            {{-- Auto close sidebar saat klik navigation links di mobile --}}
            const navLinks = sidebar.querySelectorAll('a');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 1024) {
                        closeSidebar();
                    }
                });
            });
            
            {{-- Auto close sidebar saat resize window ke desktop --}}
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024) {
                    closeSidebar();
                }
            });
        });
    </script>
</head>

{{-- Body dengan font sans dan background abu-abu --}}
<body class="font-sans antialiased bg-gray-50">
    {{-- Flex container untuk sidebar dan main content --}}
    <div class="flex h-screen">
        
        {{-- Mobile menu button - hanya tampil di mobile --}}
        <div class="lg:hidden fixed top-4 left-4 z-50">
            {{-- Button hamburger menu dengan hover effects --}}
            <button id="mobile-menu-button" class="p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                {{-- Icon hamburger menu --}}
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        {{-- Sidebar navigation dengan responsive behavior --}}
        <div id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-white shadow-lg transform -translate-x-full lg:translate-x-0 lg:static lg:inset-0 transition-transform duration-300 ease-in-out">
            
            {{-- Header sidebar dengan logo dan close button --}}
            <div class="flex items-center justify-between h-16 px-4 sm:px-6 border-b border-gray-200">
                <div class="flex items-center">
                    {{-- Icon KASI dengan background biru --}}
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    {{-- Text Kasi Panel --}}
                    <span class="ml-3 text-base sm:text-lg font-semibold text-gray-900">Kasi Panel</span>
                </div>
                
                {{-- Close button untuk mobile - hanya tampil di mobile --}}
                <button id="close-sidebar" class="lg:hidden p-1 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100">
                    {{-- Icon close X --}}
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            {{-- Navigation menu dengan links --}}
            <nav class="mt-6 px-3">
                <div class="space-y-1">
                    {{-- Link Dashboard dengan active state --}}
                    <a href="{{ route('kasi.dashboard') }}" 
                       class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200 {{ request()->routeIs('kasi.dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                        {{-- Icon dashboard --}}
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                        </svg>
                        Dashboard
                    </a>
                    
                    <a href="{{ route('kasi.daftar-staff') }}" 
                       class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200 {{ request()->routeIs('kasi.daftar-staff') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Daftar Staff
                    </a>
                    
                    <a href="{{ route('kasi.penilaian') }}" 
                       class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200 {{ request()->routeIs('kasi.penilaian') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Penilaian Staff
                    </a>
                    

                    
                    <a href="{{ route('kasi.profil') }}" 
                       class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200 {{ request()->routeIs('kasi.profil') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Profil
                    </a>
                </div>
            </nav>
        </div>

        {{-- Overlay for mobile --}}
        <div id="sidebar-overlay" class="fixed inset-0 bg-gray-600 bg-opacity-75 z-30 lg:hidden hidden"></div>

        {{-- Main content --}}
        <div class="flex-1 flex flex-col lg:ml-0">
            {{-- Top navigation --}}
            <div class="bg-white shadow-sm border-b border-gray-200 px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="hidden sm:block">
                            <p class="text-sm font-medium text-gray-900">KASI</p>
                            <p class="text-xs text-gray-500">Kepala Seksi</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-500">{{ session('kasi_name', 'Kepala Seksi') }}</span>
                        <a href="/" class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-400 p-4 mx-4 mt-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mx-4 mt-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Page content --}}
            <main class="flex-1 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>
    
    {{-- JavaScript untuk sidebar visibility --}}
    <script>
        {{-- Ensure proper initialization --}}
        document.addEventListener('DOMContentLoaded', function() {
            console.log('KASI Layout loaded successfully');
            
            {{-- Ensure sidebar is always visible --}}
            const sidebar = document.getElementById('sidebar');
            if (sidebar) {
                sidebar.classList.remove('-translate-x-full');
                sidebar.style.visibility = 'visible';
                sidebar.style.opacity = '1';
                sidebar.style.position = 'relative';
                sidebar.style.width = '16rem';
                sidebar.style.minWidth = '16rem';
                sidebar.style.maxWidth = '16rem';
                console.log('Sidebar visibility ensured');
            }
            
            {{-- Ensure main layout structure is maintained --}}
            const mainContainer = document.querySelector('body > div:first-child');
            if (mainContainer) {
                mainContainer.style.display = 'flex';
                console.log('Main layout structure maintained');
            }
        });
        
        {{-- Ensure sidebar visibility on any DOM changes --}}
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                    const sidebar = document.getElementById('sidebar');
                    if (sidebar && (sidebar.style.display === 'none' || sidebar.style.visibility === 'hidden')) {
                        sidebar.classList.remove('-translate-x-full');
                        sidebar.style.visibility = 'visible';
                        sidebar.style.opacity = '1';
                        console.log('Sidebar visibility restored after DOM change');
                    }
                }
            });
        });
        
        {{-- Start observing when DOM is ready --}}
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            if (sidebar) {
                observer.observe(sidebar, { attributes: true, attributeFilter: ['style'] });
            }
        });
    </script>
</body>
</html> 