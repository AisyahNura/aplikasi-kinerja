@extends('layouts.kepala')

@section('content')
<div class="p-3 sm:p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header E-Kinerja Style -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-4 sm:mb-6">
            <div class="px-3 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                    <div class="flex items-center">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-purple-600 rounded-lg flex items-center justify-center mr-3 sm:mr-4">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-lg sm:text-xl font-bold text-gray-900">E-KINERJA</h1>
                            <p class="text-xs sm:text-sm text-gray-600">Sistem Informasi Kinerja Pegawai</p>
                        </div>
                    </div>
                    <div class="text-left sm:text-right">
                        <p class="text-xs sm:text-sm font-medium text-gray-900">PERIODE PENILAIAN</p>
                        <p class="text-xs sm:text-sm text-gray-600">1 Januari s.d. 31 Desember Tahun {{ date('Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Header -->
        <div class="mb-4 sm:mb-6">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1 sm:mb-2">Dashboard KEPALA KANTOR</h1>
            <p class="text-sm sm:text-base text-gray-600">Monitoring dan pengawasan kinerja keseluruhan</p>
        </div>

        <!-- Statistik Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 mb-6 sm:mb-8">
            <!-- Total Kasi -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-3 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-6 h-6 sm:w-8 sm:h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-2 sm:ml-4">
                        <p class="text-xs sm:text-sm font-medium text-gray-600">Total Kasi</p>
                        <p class="text-lg sm:text-2xl font-bold text-gray-900">{{ $totalKasi }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Staff -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-3 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-6 h-6 sm:w-8 sm:h-8 bg-green-600 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-2 sm:ml-4">
                        <p class="text-xs sm:text-sm font-medium text-gray-600">Total Staff</p>
                        <p class="text-lg sm:text-2xl font-bold text-gray-900">{{ $totalStaff }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Penilaian -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-3 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-6 h-6 sm:w-8 sm:h-8 bg-yellow-500 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-2 sm:ml-4">
                        <p class="text-xs sm:text-sm font-medium text-gray-600">Total Penilaian</p>
                        <p class="text-lg sm:text-2xl font-bold text-gray-900">{{ $totalPenilaian }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Realisasi -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-3 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-6 h-6 sm:w-8 sm:h-8 bg-purple-600 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-2 sm:ml-4">
                        <p class="text-xs sm:text-sm font-medium text-gray-600">Total Realisasi</p>
                        <p class="text-lg sm:text-2xl font-bold text-gray-900">{{ $totalRealisasi }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Data Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <!-- Recent Kasi -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-3 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900">Kasi Terbaru</h3>
                </div>
                <div class="p-3 sm:p-6">
                    @if($recentKasi->count() > 0)
                        <div class="space-y-3 sm:space-y-4">
                            @foreach($recentKasi as $kasi)
                                <div class="flex items-center justify-between p-2 sm:p-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-blue-600 rounded-full flex items-center justify-center">
                                            <span class="text-white font-semibold text-xs sm:text-sm">{{ strtoupper(substr($kasi->name, 0, 1)) }}</span>
                                        </div>
                                        <div class="ml-2 sm:ml-3">
                                            <p class="text-xs sm:text-sm font-medium text-gray-900">{{ $kasi->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $kasi->jabatan }}</p>
                                        </div>
                                    </div>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Kasi
                                    </span>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-3 sm:mt-4 text-center">
                            <a href="{{ route('kepala.data-pegawai') }}" class="text-xs sm:text-sm text-purple-600 hover:text-purple-800 font-medium">
                                Lihat Semua Kasi →
                            </a>
                        </div>
                    @else
                        <div class="text-center py-6 sm:py-8">
                            <p class="text-sm text-gray-500">Belum ada data Kasi</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Staff -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-3 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900">Staff Terbaru</h3>
                </div>
                <div class="p-3 sm:p-6">
                    @if($recentStaff->count() > 0)
                        <div class="space-y-3 sm:space-y-4">
                            @foreach($recentStaff as $staff)
                                <div class="flex items-center justify-between p-2 sm:p-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-green-600 rounded-full flex items-center justify-center">
                                            <span class="text-white font-semibold text-xs sm:text-sm">{{ strtoupper(substr($staff->name, 0, 1)) }}</span>
                                        </div>
                                        <div class="ml-2 sm:ml-3">
                                            <p class="text-xs sm:text-sm font-medium text-gray-900">{{ $staff->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $staff->jabatan }}</p>
                                        </div>
                                    </div>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Staff
                                    </span>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-3 sm:mt-4 text-center">
                            <a href="{{ route('kepala.data-pegawai') }}" class="text-xs sm:text-sm text-purple-600 hover:text-purple-800 font-medium">
                                Lihat Semua Staff →
                            </a>
                        </div>
                    @else
                        <div class="text-center py-6 sm:py-8">
                            <p class="text-sm text-gray-500">Belum ada data Staff</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Penilaian -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 sm:mb-8">
            <div class="px-3 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-2 sm:space-y-0">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900">Penilaian Terbaru</h3>
                    <a href="{{ route('kepala.penilaian-kasi') }}" class="text-xs sm:text-sm text-purple-600 hover:text-purple-800 font-medium">
                        Lihat Semua →
                    </a>
                </div>
            </div>
            <div class="p-3 sm:p-6">
                @if($recentPenilaian->count() > 0)
                    <div class="space-y-3 sm:space-y-4">
                        @foreach($recentPenilaian as $penilaian)
                            <div class="border border-gray-200 rounded-lg p-3 sm:p-4">
                                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between mb-3 space-y-2 sm:space-y-0">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-yellow-500 rounded-full flex items-center justify-center">
                                            <span class="text-white font-semibold text-xs sm:text-sm">{{ strtoupper(substr($penilaian->createdBy->name, 0, 1)) }}</span>
                                        </div>
                                        <div class="ml-2 sm:ml-3">
                                            <p class="text-xs sm:text-sm font-medium text-gray-900">{{ $penilaian->createdBy->name }}</p>
                                            <p class="text-xs text-gray-500">Kasi • {{ $penilaian->created_at->format('d M Y H:i') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 3; $i++)
                                                @if($i <= $penilaian->rating)
                                                    <span class="text-yellow-500 text-sm sm:text-base">⭐</span>
                                                @else
                                                    <span class="text-gray-300 text-sm sm:text-base">☆</span>
                                                @endif
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <p class="text-xs font-medium text-gray-500 mb-1">STAFF: {{ $penilaian->user->name }}</p>
                                    @if($penilaian->realisasiKinerja && $penilaian->realisasiKinerja->task)
                                        <p class="text-xs sm:text-sm font-medium text-gray-900">{{ $penilaian->realisasiKinerja->task->nama_tugas }}</p>
                                    @endif
                                </div>
                                <div class="bg-gray-50 rounded-lg p-2 sm:p-3">
                                    <p class="text-xs sm:text-sm text-gray-700">{{ Str::limit($penilaian->komentar, 150) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6 sm:py-8">
                        <svg class="mx-auto h-8 w-8 sm:h-12 sm:w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada penilaian</h3>
                        <p class="mt-1 text-xs sm:text-sm text-gray-500">Belum ada penilaian kinerja yang diberikan.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-6">
            <a href="{{ route('kepala.data-pegawai') }}" class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3 sm:ml-4">
                        <h3 class="text-sm sm:text-lg font-medium text-gray-900">Data Pegawai</h3>
                        <p class="text-xs sm:text-sm text-gray-500">Lihat data Kasi dan Staff</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('kepala.struktur-organisasi') }}" class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-purple-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3 sm:ml-4">
                        <h3 class="text-sm sm:text-lg font-medium text-gray-900">Struktur Organisasi</h3>
                        <p class="text-xs sm:text-sm text-gray-500">Hierarki Kasi dan Staff</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('kepala.penilaian-kasi') }}" class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-yellow-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3 sm:ml-4">
                        <h3 class="text-sm sm:text-lg font-medium text-gray-900">Penilaian Kasi</h3>
                        <p class="text-xs sm:text-sm text-gray-500">Lihat penilaian Kasi</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection 