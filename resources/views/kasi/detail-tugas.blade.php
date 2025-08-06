@extends('layouts.kasi')

@section('content')
<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">Detail Tugas</h1>
                    <p class="text-gray-600">{{ $tugas['nama_staf'] }} - {{ $tugas['nama_tugas'] }}</p>
                </div>
                <a href="{{ route('kasi.penilaian') }}" 
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-md transition-colors duration-200">
                    ← Kembali
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Task Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Task Information -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Tugas</h3>
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Staf</label>
                                <p class="text-sm text-gray-900">{{ $tugas['nama_staf'] }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Tugas</label>
                                <p class="text-sm text-gray-900">{{ $tugas['nama_tugas'] }}</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Tugas</label>
                            <p class="text-sm text-gray-900">{{ $tugas['deskripsi_tugas'] }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Indikator Kinerja</label>
                            <ul class="list-disc list-inside text-sm text-gray-900 space-y-1">
                                @foreach($tugas['indikator_kinerja'] as $indikator)
                                    <li>{{ $indikator }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Performance Metrics -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Metrik Kinerja</h3>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Target</label>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex justify-between mb-2">
                                        <span class="text-sm text-gray-600">Kuantitas:</span>
                                        <span class="text-sm font-semibold">{{ $tugas['target_kuantitas'] }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Waktu:</span>
                                        <span class="text-sm font-semibold">{{ $tugas['target_waktu'] }} hari</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Realisasi</label>
                                <div class="bg-blue-50 rounded-lg p-4">
                                    <div class="flex justify-between mb-2">
                                        <span class="text-sm text-gray-600">Kuantitas:</span>
                                        <span class="text-sm font-semibold {{ $tugas['realisasi_kuantitas'] >= $tugas['target_kuantitas'] ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $tugas['realisasi_kuantitas'] }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Waktu:</span>
                                        <span class="text-sm font-semibold {{ $tugas['realisasi_waktu'] <= $tugas['target_waktu'] ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $tugas['realisasi_waktu'] }} hari
                                        </span>
                                    </div>
                                    <div class="flex justify-between mt-2">
                                        <span class="text-sm text-gray-600">Kualitas:</span>
                                        <span class="text-sm font-semibold text-blue-600">{{ $tugas['kualitas'] }}%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Evidence -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Bukti Kinerja</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Link Bukti</label>
                            <a href="{{ $tugas['link_bukti'] }}" target="_blank" 
                               class="inline-flex items-center text-blue-600 hover:text-blue-800">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                Lihat Bukti Kinerja
                            </a>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                                       {{ $tugas['status'] === 'dikirim' ? 'bg-blue-100 text-blue-800' : 
                                          ($tugas['status'] === 'verif' ? 'bg-green-100 text-green-800' : 
                                           ($tugas['status'] === 'revisi' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                                {{ ucfirst($tugas['status']) }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Submit</label>
                            <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($tugas['created_at'])->format('d F Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Assessment -->
            <div class="space-y-6">
                <!-- Assessment Panel -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Penilaian Kinerja</h3>
                    
                    @if($tugas['penilaian'])
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Penilaian Saat Ini</label>
                            <span class="inline-flex items-center px-3 py-1 text-sm font-semibold rounded-full
                                       {{ $tugas['penilaian'] === 'melebihi' ? 'bg-green-100 text-green-800' : 
                                          ($tugas['penilaian'] === 'sesuai' ? 'bg-gray-100 text-gray-800' : 'bg-red-100 text-red-800') }}">
                                @if($tugas['penilaian'] === 'melebihi')
                                    🌟 Melebihi Ekspektasi
                                @elseif($tugas['penilaian'] === 'sesuai')
                                    👍 Sesuai Ekspektasi
                                @else
                                    👎 Di Bawah Ekspektasi
                                @endif
                            </span>
                        </div>
                    @endif

                    <div class="space-y-3">
                        <button class="w-full flex items-center justify-between p-3 border-2 rounded-lg transition-all duration-200
                                     {{ $tugas['penilaian'] === 'dibawah' ? 'border-red-500 bg-red-50' : 'border-gray-200 hover:border-red-300' }}">
                            <div class="flex items-center">
                                <span class="text-lg mr-3">👎</span>
                                <span class="text-sm font-medium">Di Bawah Ekspektasi</span>
                            </div>
                            @if($tugas['penilaian'] === 'dibawah')
                                <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            @endif
                        </button>

                        <button class="w-full flex items-center justify-between p-3 border-2 rounded-lg transition-all duration-200
                                     {{ $tugas['penilaian'] === 'sesuai' ? 'border-gray-500 bg-gray-50' : 'border-gray-200 hover:border-gray-300' }}">
                            <div class="flex items-center">
                                <span class="text-lg mr-3">👍</span>
                                <span class="text-sm font-medium">Sesuai Ekspektasi</span>
                            </div>
                            @if($tugas['penilaian'] === 'sesuai')
                                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            @endif
                        </button>

                        <button class="w-full flex items-center justify-between p-3 border-2 rounded-lg transition-all duration-200
                                     {{ $tugas['penilaian'] === 'melebihi' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-green-300' }}">
                            <div class="flex items-center">
                                <span class="text-lg mr-3">🌟</span>
                                <span class="text-sm font-medium">Melebihi Ekspektasi</span>
                            </div>
                            @if($tugas['penilaian'] === 'melebihi')
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            @endif
                        </button>
                    </div>

                    @if($tugas['komentar'])
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Komentar</label>
                            <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded-lg">{{ $tugas['komentar'] }}</p>
                        </div>
                    @endif

                    <div class="mt-6">
                        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors duration-200">
                            Update Penilaian
                        </button>
                    </div>
                </div>

                <!-- Performance Summary -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Kinerja</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Pencapaian Target:</span>
                            <span class="text-sm font-semibold {{ $tugas['realisasi_kuantitas'] >= $tugas['target_kuantitas'] ? 'text-green-600' : 'text-red-600' }}">
                                {{ $tugas['realisasi_kuantitas'] >= $tugas['target_kuantitas'] ? 'Tercapai' : 'Tidak Tercapai' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Ketepatan Waktu:</span>
                            <span class="text-sm font-semibold {{ $tugas['realisasi_waktu'] <= $tugas['target_waktu'] ? 'text-green-600' : 'text-red-600' }}">
                                {{ $tugas['realisasi_waktu'] <= $tugas['target_waktu'] ? 'Tepat Waktu' : 'Terlambat' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Kualitas:</span>
                            <span class="text-sm font-semibold text-blue-600">{{ $tugas['kualitas'] }}%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 