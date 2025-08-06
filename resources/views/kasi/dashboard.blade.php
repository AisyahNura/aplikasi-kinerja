@extends('layouts.kasi')

@section('content')
<div class="p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header E-Kinerja Style -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-gray-900">E-KINERJA</h1>
                            <p class="text-sm text-gray-600">Sistem Informasi Kinerja Pegawai</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-900">PERIODE PENILAIAN</p>
                        <p class="text-sm text-gray-600">1 Januari s.d. 31 Desember Tahun {{ date('Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Dashboard KASI</h1>
            <p class="text-gray-600">Ringkasan kinerja dan aktivitas terbaru</p>
        </div>

        <!-- Profil Kasi dan Kepala -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Profil Kasi -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    PEGAWAI YANG DINILAI
                </h3>
                <div class="space-y-3">
                    <div>
                        <label class="text-xs font-medium text-gray-500 uppercase">NAMA</label>
                        <p class="text-sm font-medium text-gray-900">{{ $kasiName }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-500 uppercase">NIP</label>
                        <p class="text-sm text-gray-900">{{ $kasiNip }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-500 uppercase">PANGKAT / GOL RUANG</label>
                        <p class="text-sm text-gray-900">{{ $kasiPangkat }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-500 uppercase">JABATAN</label>
                        <p class="text-sm text-gray-900">{{ $kasiJabatan }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-500 uppercase">UNIT KERJA</label>
                        <p class="text-sm text-gray-900">{{ $kasiUnitKerja }}</p>
                    </div>
                </div>
            </div>

            <!-- Profil Kepala -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                    PEJABAT PENILAI KINERJA
                </h3>
                <div class="space-y-3">
                    <div>
                        <label class="text-xs font-medium text-gray-500 uppercase">NAMA</label>
                        <p class="text-sm font-medium text-gray-900">{{ $kepalaName }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-500 uppercase">NIP</label>
                        <p class="text-sm text-gray-900">{{ $kepalaNip }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-500 uppercase">PANGKAT / GOL RUANG</label>
                        <p class="text-sm text-gray-900">{{ $kepalaPangkat }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-500 uppercase">JABATAN</label>
                        <p class="text-sm text-gray-900">{{ $kepalaJabatan }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-500 uppercase">UNIT KERJA</label>
                        <p class="text-sm text-gray-900">{{ $kepalaUnitKerja }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Staf</p>
                        <p class="text-2xl font-semibold text-gray-900">12</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Sudah Dinilai</p>
                        <p class="text-2xl font-semibold text-gray-900">8</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Menunggu</p>
                        <p class="text-2xl font-semibold text-gray-900">4</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Rata-rata Nilai</p>
                        <p class="text-2xl font-semibold text-gray-900">85%</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik Penilaian -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Distribusi Penilaian</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="text-lg mr-2">🌟</span>
                            <span class="text-sm text-gray-600">Melebihi Ekspektasi</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                                <div class="bg-green-500 h-2 rounded-full" style="width: 40%"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-900">40%</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="text-lg mr-2">👍</span>
                            <span class="text-sm text-gray-600">Sesuai Ekspektasi</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                                <div class="bg-gray-500 h-2 rounded-full" style="width: 45%"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-900">45%</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="text-lg mr-2">👎</span>
                            <span class="text-sm text-gray-600">Di Bawah Ekspektasi</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                                <div class="bg-red-500 h-2 rounded-full" style="width: 15%"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-900">15%</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Staff Saya ({{ $totalStaff }} orang)
                </h3>
                <div class="space-y-3">
                    @if($staffList && $staffList->count() > 0)
                        @foreach($staffList as $staff)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-white font-semibold text-xs">{{ strtoupper(substr($staff->name, 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $staff->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $staff->jabatan }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Staff</span>
                                    <p class="text-xs text-gray-500 mt-1">NIP: {{ $staff->nip }}</p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada staff</h3>
                            <p class="mt-1 text-sm text-gray-500">Belum ada staff yang ditugaskan kepada Anda.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('kasi.penilaian') }}" 
                   class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <div class="p-2 rounded-full bg-blue-100 mr-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Penilaian Kinerja</p>
                        <p class="text-xs text-gray-500">Nilai kinerja staf</p>
                    </div>
                </a>

                <a href="#" 
                   class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <div class="p-2 rounded-full bg-green-100 mr-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Laporan Kinerja</p>
                        <p class="text-xs text-gray-500">Lihat laporan bulanan</p>
                    </div>
                </a>

                <a href="{{ route('kasi.profil') }}" 
                   class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <div class="p-2 rounded-full bg-purple-100 mr-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Profil</p>
                        <p class="text-xs text-gray-500">Kelola profil KASI</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 