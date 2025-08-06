@extends('layouts.staff')

@section('content')
<div class="p-6">
    <div class="max-w-7xl mx-auto">
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
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Kinerja Saya</h1>
            <p class="text-gray-600">Input dan kelola realisasi kinerja Anda</p>
        </div>

        <!-- Filter Form -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <form method="GET" action="{{ route('staff.kinerja-saya') }}" class="flex flex-wrap items-center gap-4">
                <div>
                    <label for="tahun" class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                    <select name="tahun" id="tahun" class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        @for($year = date('Y'); $year >= date('Y')-2; $year--)
                            <option value="{{ $year }}" {{ request('tahun', date('Y')) == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endfor
                    </select>
                </div>
                
                <div>
                    <label for="triwulan" class="block text-sm font-medium text-gray-700 mb-1">Triwulan</label>
                    <select name="triwulan" id="triwulan" class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="1" {{ request('triwulan', $triwulan) == '1' ? 'selected' : '' }}>Triwulan I</option>
                        <option value="2" {{ request('triwulan', $triwulan) == '2' ? 'selected' : '' }}>Triwulan II</option>
                        <option value="3" {{ request('triwulan', $triwulan) == '3' ? 'selected' : '' }}>Triwulan III</option>
                        <option value="4" {{ request('triwulan', $triwulan) == '4' ? 'selected' : '' }}>Triwulan IV</option>
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Daftar Tugas -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Daftar Tugas - {{ $tahun }} {{ $triwulan }}</h2>
            </div>
            
            <div class="p-6">
                @if($targets->count() > 0)
                    <div class="space-y-6">
                        @foreach($targets as $target)
                            @php
                                $realisasi = $realisasiKinerja->get($target->tugas_id);
                                $status = $realisasi ? $realisasi->status : 'draft';
                                $statusColors = [
                                    'draft' => 'bg-gray-100 text-gray-800',
                                    'dikirim' => 'bg-orange-100 text-orange-800',
                                    'disetujui_kasi' => 'bg-green-100 text-green-800',
                                    'disetujui_kepala' => 'bg-green-800 text-white',
                                    'dikembalikan' => 'bg-red-100 text-red-800'
                                ];
                                $statusLabels = [
                                    'draft' => 'Draft',
                                    'dikirim' => 'Menunggu',
                                    'disetujui_kasi' => 'Disetujui Kasi',
                                    'disetujui_kepala' => 'Disetujui Kepala',
                                    'dikembalikan' => 'Dikembalikan'
                                ];
                            @endphp
                            <div class="border border-gray-200 rounded-lg p-6">
                                <div class="grid grid-cols-1 lg:grid-cols-6 gap-4">
                                    <!-- Tugas -->
                                    <div class="lg:col-span-2">
                                        <h3 class="font-semibold text-gray-900 mb-1">{{ $target->task->nama_tugas }}</h3>
                                        <p class="text-sm text-gray-600">{{ $target->task->deskripsi }}</p>
                                    </div>
                                    
                                    <!-- Target -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Target</label>
                                        <div class="text-sm text-gray-900">
                                            <p>Kuantitas: {{ $target->target_kuantitas }}</p>
                                            <p>Waktu: {{ $target->target_waktu }} hari</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Realisasi -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Realisasi</label>
                                        <div class="space-y-2">
                                            <input type="number" name="realisasi_kuantitas" value="{{ $realisasi->realisasi_kuantitas ?? '' }}" 
                                                   class="w-full border border-gray-300 rounded-md px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                                   placeholder="Kuantitas">
                                            <input type="number" name="realisasi_waktu" value="{{ $realisasi->realisasi_waktu ?? '' }}" 
                                                   class="w-full border border-gray-300 rounded-md px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                                   placeholder="Waktu (hari)">
                                        </div>
                                    </div>
                                    
                                    <!-- Kualitas -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Kualitas (%)</label>
                                        <input type="number" name="kualitas" value="{{ $realisasi->kualitas ?? '' }}" 
                                               class="w-full border border-gray-300 rounded-md px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                               placeholder="0-100">
                                        @if($realisasi && $realisasi->kualitas)
                                            <p class="text-xs text-green-600 mt-1">{{ $realisasi->kualitas }}%</p>
                                        @endif
                                    </div>
                                    
                                    <!-- Link Bukti -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Link Bukti</label>
                                        <input type="url" name="link_bukti" value="{{ $realisasi->link_bukti ?? '' }}" 
                                               class="w-full border border-gray-300 rounded-md px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                               placeholder="https://...">
                                        @if($realisasi && $realisasi->link_bukti)
                                            <a href="{{ $realisasi->link_bukti }}" target="_blank" 
                                               class="text-xs text-blue-600 hover:text-blue-800 mt-1 block">Lihat Bukti</a>
                                        @endif
                                    </div>
                                    
                                    <!-- Status -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ $statusLabels[$status] ?? 'Draft' }}
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Action Button -->
                                <div class="mt-4 flex justify-end">
                                    <form method="POST" action="{{ route('staff.simpan-realisasi') }}" class="inline">
                                        @csrf
                                        <input type="hidden" name="tugas_id" value="{{ $target->tugas_id }}">
                                        <input type="hidden" name="tahun" value="{{ $tahun }}">
                                        <input type="hidden" name="triwulan" value="{{ $triwulan }}">
                                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                            Simpan
                                        </button>
                                    </form>
                                </div>
                                
                                <!-- Comment Section -->
                                @if($realisasi && $realisasi->status === 'dikembalikan' && $realisasi->comments->count() > 0)
                                    <div class="mt-4 p-4 bg-red-50 border-l-4 border-red-400 rounded">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <h4 class="text-sm font-medium text-red-800">Komentar/Revisi:</h4>
                                                @foreach($realisasi->comments as $comment)
                                                    <div class="mt-2 text-sm text-red-700">
                                                        <p class="font-medium">{{ $comment->createdBy->name ?? 'Kasi' }} - {{ $comment->created_at->format('d/m/Y H:i') }}</p>
                                                        <p class="mt-1">{{ $comment->komentar }}</p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                        
                        <!-- Kirim Semua Button -->
                        @if($targets->count() > 0)
                            <div class="flex justify-end mt-6">
                                <button onclick="konfirmasiKirimSemua()" 
                                        class="bg-blue-600 text-white px-6 py-3 rounded-md text-sm font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Kirim Semua
                                </button>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada target</h3>
                        <p class="mt-1 text-sm text-gray-500">Belum ada target dari Kasi untuk Triwulan ini.</p>
                    </div>
                @endif
            </div>
        </div>

<!-- Modal Konfirmasi -->
<div id="modalKonfirmasi" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Konfirmasi Kirim</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">Apakah Anda yakin ingin mengirim semua data realisasi?</p>
            </div>
            <div class="items-center px-4 py-3">
                <button onclick="tutupModal()" 
                        class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Batal
                </button>
                <form method="POST" action="{{ route('staff.kirim-realisasi') }}" class="inline">
                    @csrf
                    <input type="hidden" name="tahun" value="{{ $tahun }}">
                    <input type="hidden" name="triwulan" value="{{ $triwulan }}">
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white text-base font-medium rounded-md w-24 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Kirim
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 