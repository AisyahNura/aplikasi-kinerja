{{-- Halaman index realisasi kinerja - menampilkan daftar realisasi --}}
{{-- Template dengan filter periode dan tabel data realisasi --}}
@extends('layouts.app')

{{-- Section content untuk konten utama --}}
@section('content')

{{-- Container utama dengan padding dan max width --}}
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        
        {{-- Header halaman dengan judul dan tombol tambah --}}
        <div class="mb-6 flex justify-between items-center">
            <div>
                {{-- Judul halaman --}}
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Daftar Realisasi Kinerja</h1>
                {{-- Info periode dari controller --}}
                <p class="text-gray-600">Tahun: {{ $tahun }} | Triwulan: {{ $triwulan }}</p>
            </div>
            {{-- Tombol tambah realisasi dengan parameter periode --}}
            <a href="{{ route('realisasi-kinerja.create', ['tahun' => $tahun, 'triwulan' => $triwulan, 'tugas_ids' => [1,2,3]]) }}" 
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Tambah Realisasi
            </a>
        </div>

        {{-- Flash message success dari session --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        {{-- Flash message error dari session --}}
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        {{-- Filter periode dengan form GET --}}
        <div class="bg-white rounded-lg shadow p-4 mb-6">
            {{-- Form filter dengan method GET untuk update URL --}}
            <form method="GET" class="flex flex-wrap gap-4 items-end">
                
                {{-- Filter tahun dengan dropdown 2020-2030 --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                    {{-- Select tahun dengan loop dari 2020-2030 --}}
                    <select name="tahun" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        {{-- Generate option tahun dengan selected state --}}
                        @for($year = 2020; $year <= 2030; $year++)
                            <option value="{{ $year }}" {{ $tahun == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endfor
                    </select>
                </div>
                
                {{-- Filter triwulan dengan dropdown I-IV --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Triwulan</label>
                    {{-- Select triwulan dengan array values --}}
                    <select name="triwulan" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        {{-- Loop array triwulan dengan selected state --}}
                        @foreach(['I', 'II', 'III', 'IV'] as $q)
                            <option value="{{ $q }}" {{ $triwulan == $q ? 'selected' : '' }}>Triwulan {{ $q }}</option>
                        @endforeach
                    </select>
                </div>
                
                {{-- Button submit filter --}}
                <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Filter
                </button>
            </form>
        </div>

        {{-- Tabel realisasi kinerja dengan data dari controller --}}
        <div class="bg-white rounded-lg shadow overflow-hidden">
            {{-- Cek apakah ada data realisasi --}}
            @if($realisasiKinerja->count() > 0)
                {{-- Container dengan scroll horizontal --}}
                <div class="overflow-x-auto">
                    {{-- Tabel dengan responsive design --}}
                    <table class="min-w-full divide-y divide-gray-200">
                        
                        {{-- Header tabel dengan background abu-abu --}}
                        <thead class="bg-gray-50">
                            <tr>
                                {{-- Kolom nomor urut --}}
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                {{-- Kolom ID tugas --}}
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tugas ID</th>
                                {{-- Kolom target kuantitas --}}
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Target Kuantitas</th>
                                {{-- Kolom realisasi kuantitas --}}
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Realisasi Kuantitas</th>
                                {{-- Kolom target waktu --}}
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Target Waktu</th>
                                {{-- Kolom realisasi waktu --}}
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Realisasi Waktu</th>
                                {{-- Kolom kualitas --}}
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kualitas</th>
                                {{-- Kolom link bukti --}}
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Link Bukti</th>
                                {{-- Kolom status --}}
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                {{-- Kolom tanggal --}}
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            </tr>
                        </thead>
                        
                        {{-- Body tabel dengan data realisasi --}}
                        <tbody class="bg-white divide-y divide-gray-200">
                            {{-- Loop untuk setiap data realisasi --}}
                            @foreach($realisasiKinerja as $index => $realisasi)
                                {{-- Row dengan hover effect --}}
                                <tr class="hover:bg-gray-50">
                                    
                                    {{-- Kolom nomor urut --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $index + 1 }}
                                    </td>
                                    
                                    {{-- Kolom ID tugas --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $realisasi->tugas_id }}
                                    </td>
                                    
                                    {{-- Kolom target kuantitas --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $realisasi->target_kuantitas }}
                                    </td>
                                    
                                    {{-- Kolom realisasi kuantitas --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $realisasi->realisasi_kuantitas }}
                                    </td>
                                    
                                    {{-- Kolom target waktu dengan suffix hari --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $realisasi->target_waktu }} hari
                                    </td>
                                    
                                    {{-- Kolom realisasi waktu dengan suffix hari --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $realisasi->realisasi_waktu }} hari
                                    </td>
                                    
                                    {{-- Kolom kualitas dengan suffix % --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $realisasi->kualitas }}%
                                    </td>
                                    
                                    {{-- Kolom link bukti dengan conditional rendering --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{-- Cek apakah ada link bukti --}}
                                        @if($realisasi->link_bukti)
                                            {{-- Link bukti dengan target blank --}}
                                            <a href="{{ $realisasi->link_bukti }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                                Lihat Bukti
                                            </a>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    
                                    {{-- Kolom status dengan badge --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($realisasi->status === 'draft')
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Draft
                                            </span>
                                        @elseif($realisasi->status === 'dikirim')
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Dikirim
                                            </span>
                                        @elseif($realisasi->status === 'verif')
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                Terverifikasi
                                            </span>
                                        @elseif($realisasi->status === 'revisi')
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                Revisi
                                            </span>
                                        @endif
                                    </td>
                                    
                                    {{-- Kolom tanggal dengan format --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $realisasi->created_at->format('d/m/Y H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada data</h3>
                    <p class="mt-1 text-sm text-gray-500">Belum ada realisasi kinerja untuk periode ini.</p>
                    <div class="mt-6">
                        <a href="{{ route('realisasi-kinerja.create', ['tahun' => $tahun, 'triwulan' => $triwulan, 'tugas_ids' => [1,2,3]]) }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Tambah Realisasi
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 