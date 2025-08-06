<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - KASI Panel</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/js/app.js'])
    
    <style>
        /* Fallback styles jika Tailwind tidak load */
        body {
            font-family: 'Figtree', ui-sans-serif, system-ui, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9fafb;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .flex {
            display: flex;
        }
        
        .flex-col {
            flex-direction: column;
        }
        
        .items-center {
            align-items: center;
        }
        
        .justify-between {
            justify-content: space-between;
        }
        
        .bg-white {
            background-color: white;
        }
        
        .bg-gray-50 {
            background-color: #f9fafb;
        }
        
        .text-gray-900 {
            color: #111827;
        }
        
        .text-gray-600 {
            color: #4b5563;
        }
        
        .text-blue-600 {
            color: #2563eb;
        }
        
        .border {
            border-width: 1px;
        }
        
        .border-gray-200 {
            border-color: #e5e7eb;
        }
        
        .rounded-lg {
            border-radius: 0.5rem;
        }
        
        .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .p-4 {
            padding: 1rem;
        }
        
        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
        
        .py-4 {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
        
        .mb-8 {
            margin-bottom: 2rem;
        }
        
        .mb-6 {
            margin-bottom: 1.5rem;
        }
        
        .text-3xl {
            font-size: 1.875rem;
            line-height: 2.25rem;
        }
        
        .text-lg {
            font-size: 1.125rem;
            line-height: 1.75rem;
        }
        
        .font-bold {
            font-weight: 700;
        }
        
        .font-semibold {
            font-weight: 600;
        }
        
        .text-sm {
            font-size: 0.875rem;
            line-height: 1.25rem;
        }
        
        .text-xs {
            font-size: 0.75rem;
            line-height: 1rem;
        }
        
        .uppercase {
            text-transform: uppercase;
        }
        
        .tracking-wider {
            letter-spacing: 0.05em;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table th,
        .table td {
            padding: 0.75rem 1.5rem;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .table th {
            background-color: #f9fafb;
            font-weight: 500;
            color: #6b7280;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
            border: 2px solid transparent;
            cursor: pointer;
        }
        
        .btn-primary {
            background-color: #2563eb;
            color: white;
            border-color: #2563eb;
        }
        
        .btn-primary:hover {
            background-color: #1d4ed8;
            border-color: #1d4ed8;
        }
        
        .btn-primary:disabled {
            background-color: #d1d5db;
            border-color: #d1d5db;
            cursor: not-allowed;
        }
        
        .btn-outline {
            background-color: white;
            color: #374151;
            border-color: #d1d5db;
        }
        
        .btn-outline:hover {
            background-color: #f9fafb;
            border-color: #9ca3af;
        }
        
        .btn-selected {
            border-color: #2563eb;
            background-color: #eff6ff;
            color: #1d4ed8;
        }
        
        .badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .badge-gray {
            background-color: #f3f4f6;
            color: #374151;
        }
        
        .badge-green {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .badge-red {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 0 0.5rem;
            }
            
            .table {
                font-size: 0.875rem;
            }
            
            .table th,
            .table td {
                padding: 0.5rem 0.75rem;
            }
        }
        
        /* Ensure sidebar is always visible */
        .sidebar {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            position: relative !important;
            width: 16rem !important;
            min-width: 16rem !important;
            max-width: 16rem !important;
        }
        
        /* Ensure main layout structure */
        body > div:first-child {
            display: flex !important;
        }
        
        /* Ensure proper layout on all screen sizes */
        @media (max-width: 1024px) {
            .sidebar {
                position: relative;
                height: auto;
            }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar - Selalu terlihat -->
        <div class="w-64 bg-white shadow-lg sidebar">
            <div class="flex items-center justify-between h-16 px-6 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-lg">K</span>
                    </div>
                    <span class="ml-3 text-lg font-semibold text-gray-900">KASI Panel</span>
                </div>
            </div>
            
            <nav class="mt-6 px-3">
                <div class="space-y-1">
                    <a href="{{ route('kasi.dashboard') }}" 
                       class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200 {{ request()->routeIs('kasi.dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                        </svg>
                        Dashboard
                    </a>
                    
                    <a href="{{ route('kasi.penilaian') }}" 
                       class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200 {{ request()->routeIs('kasi.penilaian') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Penilaian
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

        <!-- Main content -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Top navigation -->
            <div class="bg-white shadow-sm border-b border-gray-200 px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                            <span class="text-white font-semibold text-sm">K</span>
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

            <!-- Flash Messages -->
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

            <!-- Page content -->
            <main class="flex-1 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>
    
    <script>
        // Ensure proper initialization
        document.addEventListener('DOMContentLoaded', function() {
            console.log('KASI Layout loaded successfully');
            
            // Ensure sidebar is always visible
            const sidebar = document.querySelector('.sidebar');
            if (sidebar) {
                sidebar.style.display = 'block';
                sidebar.style.visibility = 'visible';
                sidebar.style.opacity = '1';
                sidebar.style.position = 'relative';
                sidebar.style.width = '16rem';
                sidebar.style.minWidth = '16rem';
                sidebar.style.maxWidth = '16rem';
                console.log('Sidebar visibility ensured');
            }
            
            // Ensure main layout structure is maintained
            const mainContainer = document.querySelector('body > div:first-child');
            if (mainContainer) {
                mainContainer.style.display = 'flex';
                console.log('Main layout structure maintained');
            }
        });
        
        // Ensure sidebar visibility on any DOM changes
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                    const sidebar = document.querySelector('.sidebar');
                    if (sidebar && (sidebar.style.display === 'none' || sidebar.style.visibility === 'hidden')) {
                        sidebar.style.display = 'block';
                        sidebar.style.visibility = 'visible';
                        sidebar.style.opacity = '1';
                        console.log('Sidebar visibility restored after DOM change');
                    }
                }
            });
        });
        
        // Start observing when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar');
            if (sidebar) {
                observer.observe(sidebar, { attributes: true, attributeFilter: ['style'] });
            }
        });
    </script>
</body>
</html> 