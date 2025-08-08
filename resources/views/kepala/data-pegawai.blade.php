@extends('layouts.kepala')

@section('content')
<div class="p-3 sm:p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-4 sm:mb-6">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1 sm:mb-2">Data Pegawai</h1>
            <p class="text-sm sm:text-base text-gray-600">Kelola data Kasi dan Staff</p>
        </div>

        <!-- Filter dan Search -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6 mb-4 sm:mb-6">
            <form method="GET" action="{{ route('kepala.data-pegawai') }}" class="flex flex-col md:flex-row gap-3 sm:gap-4">
                <div class="flex-1">
                    <label for="search" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Cari Pegawai</label>
                    <input type="text" 
                           id="search" 
                           name="search" 
                           value="{{ $search }}"
                           placeholder="Cari berdasarkan nama, NIP, atau email..."
                           class="block w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                </div>
                
                <div class="w-full md:w-48">
                    <label for="role" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Filter Role</label>
                    <select id="role" 
                            name="role" 
                            class="block w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                        <option value="all" {{ $role == 'all' ? 'selected' : '' }}>Semua Role</option>
                        <option value="kasi" {{ $role == 'kasi' ? 'selected' : '' }}>Kasi</option>
                        <option value="staff" {{ $role == 'staff' ? 'selected' : '' }}>Staff</option>
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button type="submit" 
                            class="w-full md:w-auto px-3 sm:px-4 py-2 text-sm sm:text-base bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-200">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Cari
                    </button>
                </div>
            </form>
        </div>

        <!-- Data Table -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-3 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-2 sm:space-y-0">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900">Daftar Pegawai</h3>
                    <div class="text-xs sm:text-sm text-gray-500">
                        Total: {{ $pegawai->total() }} pegawai
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pegawai
                            </th>
                            <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                NIP
                            </th>
                            <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                Jabatan
                            </th>
                            <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                                Email
                            </th>
                            <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Role
                            </th>
                            <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                Relasi
                            </th>
                            <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($pegawai as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 sm:h-10 sm:w-10">
                                            <div class="h-8 w-8 sm:h-10 sm:w-10 rounded-full flex items-center justify-center {{ $user->role == 'kasi' ? 'bg-blue-600' : 'bg-green-600' }}">
                                                <span class="text-white font-semibold text-xs sm:text-sm">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-2 sm:ml-4">
                                            <div class="text-xs sm:text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            <div class="text-xs sm:text-sm text-gray-500">Bergabung {{ $user->created_at->format('d M Y') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900 hidden sm:table-cell">
                                    {{ $user->nip }}
                                </td>
                                <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900 hidden md:table-cell">
                                    {{ $user->jabatan }}
                                </td>
                                <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900 hidden lg:table-cell">
                                    {{ $user->email }}
                                </td>
                                <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $user->role == 'kasi' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900 hidden md:table-cell">
                                    @if($user->role == 'staff' && $user->kasi)
                                        <span class="text-purple-600">{{ $user->kasi->name }}</span>
                                    @elseif($user->role == 'kasi')
                                        <span class="text-gray-500">-</span>
                                    @else
                                        <span class="text-red-500">Belum ditugaskan</span>
                                    @endif
                                </td>
                                <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-3 sm:px-6 py-8 text-center">
                                    <div class="text-gray-500">
                                        <svg class="mx-auto h-8 w-8 sm:h-12 sm:w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada pegawai</h3>
                                        <p class="mt-1 text-xs sm:text-sm text-gray-500">Belum ada data pegawai yang tersedia.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($pegawai->hasPages())
                <div class="px-3 sm:px-6 py-3 sm:py-4 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-xs sm:text-sm text-gray-700">
                            Menampilkan {{ $pegawai->firstItem() }} sampai {{ $pegawai->lastItem() }} dari {{ $pegawai->total() }} hasil
                        </div>
                        <div class="flex items-center space-x-2">
                            {{ $pegawai->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Kasi</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $pegawai->where('role', 'kasi')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Staff</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $pegawai->where('role', 'staff')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Pegawai</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $pegawai->total() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 