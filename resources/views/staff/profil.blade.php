@extends('layouts.staff')

@section('content')
<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header E-Kinerja Style -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
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
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Profil Staff</h1>
            <p class="text-gray-600">Informasi profil dan pengaturan akun</p>
        </div>

        <!-- Profil Information -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pribadi</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <p class="text-sm text-gray-900">{{ session('staff_name', 'Staff') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">NIP</label>
                    <p class="text-sm text-gray-900">197801252011011006</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pangkat / Golongan</label>
                    <p class="text-sm text-gray-900">Penata Muda Tingkat I / III/b</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan</label>
                    <p class="text-sm text-gray-900">Pranata Komputer Ahli Pertama</p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Unit Kerja</label>
                    <p class="text-sm text-gray-900">Kantor Kementerian Agama Kabupaten Jombang</p>
                </div>
            </div>
        </div>

        <!-- Atasan Information -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Atasan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Atasan</label>
                    <p class="text-sm text-gray-900">Dr. MUHAJIR, S.Pd., M.Ag</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">NIP Atasan</label>
                    <p class="text-sm text-gray-900">197304131999031003</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pangkat / Golongan Atasan</label>
                    <p class="text-sm text-gray-900">Pembina Tingkat I / IV/b</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan Atasan</label>
                    <p class="text-sm text-gray-900">Kepala Kantor Kementerian Agama Kabupaten Jombang</p>
                </div>
            </div>
        </div>

        <!-- Account Settings -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Pengaturan Akun</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                    <p class="text-sm text-gray-900">staff</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status Akun</label>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Aktif
                    </span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Terakhir Login</label>
                    <p class="text-sm text-gray-900">{{ date('d M Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 