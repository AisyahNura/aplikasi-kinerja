@extends('layouts.kepala')

@section('content')
<div class="p-3 sm:p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-4 sm:mb-6">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1 sm:mb-2">Struktur Organisasi</h1>
            <p class="text-sm sm:text-base text-gray-600">Hierarki Kasi dan Staff di bawahnya</p>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-3 sm:p-6">
                <div class="flex items-center">
                    <div class="p-2 sm:p-3 rounded-full bg-purple-100">
                        <svg class="w-4 h-4 sm:w-6 sm:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <div class="ml-2 sm:ml-4">
                        <p class="text-xs sm:text-sm font-medium text-gray-600">Total Kasi</p>
                        <p class="text-lg sm:text-2xl font-semibold text-gray-900">{{ $totalKasi }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-3 sm:p-6">
                <div class="flex items-center">
                    <div class="p-2 sm:p-3 rounded-full bg-green-100">
                        <svg class="w-4 h-4 sm:w-6 sm:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-2 sm:ml-4">
                        <p class="text-xs sm:text-sm font-medium text-gray-600">Total Staff</p>
                        <p class="text-lg sm:text-2xl font-semibold text-gray-900">{{ $totalStaff }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-3 sm:p-6">
                <div class="flex items-center">
                    <div class="p-2 sm:p-3 rounded-full bg-blue-100">
                        <svg class="w-4 h-4 sm:w-6 sm:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-2 sm:ml-4">
                        <p class="text-xs sm:text-sm font-medium text-gray-600">Staff Terdaftar</p>
                        <p class="text-lg sm:text-2xl font-semibold text-gray-900">{{ $staffTerdaftar }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-3 sm:p-6">
                <div class="flex items-center">
                    <div class="p-2 sm:p-3 rounded-full bg-red-100">
                        <svg class="w-4 h-4 sm:w-6 sm:h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div class="ml-2 sm:ml-4">
                        <p class="text-xs sm:text-sm font-medium text-gray-600">Staff Belum Ditugaskan</p>
                        <p class="text-lg sm:text-2xl font-semibold text-gray-900">{{ $staffBelumDitugaskan }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Struktur Organisasi -->
        <div class="space-y-4 sm:space-y-6">
            @forelse($kasiList as $kasi)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <!-- Header Kasi -->
                    <div class="bg-gradient-to-r from-blue-50 to-purple-50 px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-blue-600 rounded-full flex items-center justify-center mr-3 sm:mr-4">
                                    <span class="text-white font-semibold text-xs sm:text-sm">{{ strtoupper(substr($kasi->name, 0, 1)) }}</span>
                                </div>
                                <div>
                                    <h3 class="text-base sm:text-lg font-semibold text-gray-900">{{ $kasi->name }}</h3>
                                    <p class="text-xs sm:text-sm text-gray-600">{{ $kasi->jabatan }} • {{ $kasi->nip }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $kasi->staffs->count() }} Staff
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Staff List -->
                    <div class="p-4 sm:p-6">
                        @if($kasi->staffs->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                                @foreach($kasi->staffs as $staff)
                                    <div class="bg-gray-50 rounded-lg p-3 sm:p-4 border border-gray-200">
                                        <div class="flex items-center">
                                            <div class="w-6 h-6 sm:w-8 sm:h-8 bg-green-600 rounded-full flex items-center justify-center mr-2 sm:mr-3">
                                                <span class="text-white font-semibold text-xs">{{ strtoupper(substr($staff->name, 0, 1)) }}</span>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">{{ $staff->name }}</p>
                                                <p class="text-xs text-gray-500 truncate">{{ $staff->jabatan }}</p>
                                                <p class="text-xs text-gray-400 truncate">{{ $staff->nip }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-6 sm:py-8">
                                <svg class="mx-auto h-8 w-8 sm:h-12 sm:w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada staff</h3>
                                <p class="mt-1 text-xs sm:text-sm text-gray-500">Belum ada staff yang ditugaskan kepada {{ $kasi->name }}.</p>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 sm:p-8 text-center">
                    <svg class="mx-auto h-8 w-8 sm:h-12 sm:w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada Kasi</h3>
                    <p class="mt-1 text-xs sm:text-sm text-gray-500">Belum ada data Kasi yang tersedia.</p>
                </div>
            @endforelse
        </div>

        <!-- Staff Belum Ditugaskan -->
        @if($staffBelumDitugaskan > 0)
            <div class="mt-6 sm:mt-8">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-red-50 to-orange-50 px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-red-600 rounded-full flex items-center justify-center mr-3 sm:mr-4">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base sm:text-lg font-semibold text-gray-900">Staff Belum Ditugaskan</h3>
                                <p class="text-xs sm:text-sm text-gray-600">Staff yang belum memiliki atasan (Kasi)</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 sm:p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                            @foreach($staffTanpaKasi as $staff)
                                <div class="bg-red-50 rounded-lg p-3 sm:p-4 border border-red-200">
                                    <div class="flex items-center">
                                        <div class="w-6 h-6 sm:w-8 sm:h-8 bg-red-600 rounded-full flex items-center justify-center mr-2 sm:mr-3">
                                            <span class="text-white font-semibold text-xs">{{ strtoupper(substr($staff->name, 0, 1)) }}</span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">{{ $staff->name }}</p>
                                            <p class="text-xs text-gray-500 truncate">{{ $staff->jabatan }}</p>
                                            <p class="text-xs text-red-500 truncate">Belum ditugaskan</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

