@extends('layouts.kepala')

@section('content')
<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Komentar Umum</h1>
            <p class="text-gray-600">Beri komentar umum terkait kinerja keseluruhan</p>
        </div>

        <!-- Filter Periode -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <form method="GET" action="{{ route('kepala.komentar-umum') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="tahun" class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                    <select id="tahun" 
                            name="tahun" 
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                        @for($year = date('Y'); $year >= date('Y') - 5; $year--)
                            <option value="{{ $year }}" {{ $tahun == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endfor
                    </select>
                </div>
                
                <div>
                    <label for="triwulan" class="block text-sm font-medium text-gray-700 mb-1">Triwulan</label>
                    <select id="triwulan" 
                            name="triwulan" 
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                        <option value="I" {{ $triwulan == 'I' ? 'selected' : '' }}>Triwulan I</option>
                        <option value="II" {{ $triwulan == 'II' ? 'selected' : '' }}>Triwulan II</option>
                        <option value="III" {{ $triwulan == 'III' ? 'selected' : '' }}>Triwulan III</option>
                        <option value="IV" {{ $triwulan == 'IV' ? 'selected' : '' }}>Triwulan IV</option>
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button type="submit" 
                            class="w-full px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-200">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Pilih Periode
                    </button>
                </div>
            </form>
        </div>

        <!-- Form Komentar -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Komentar Umum Periode {{ $triwulan }} Tahun {{ $tahun }}</h3>
                <p class="text-sm text-gray-600">Komentar ini akan dapat dilihat oleh Kasi dan Staff di dashboard masing-masing.</p>
            </div>

            <form method="POST" action="{{ route('kepala.komentar-umum.simpan') }}">
                @csrf
                <input type="hidden" name="tahun" value="{{ $tahun }}">
                <input type="hidden" name="triwulan" value="{{ $triwulan }}">
                
                <div class="mb-6">
                    <label for="komentar" class="block text-sm font-medium text-gray-700 mb-2">Komentar Umum</label>
                    <textarea id="komentar" 
                              name="komentar" 
                              rows="8"
                              placeholder="Tulis komentar umum terkait kinerja keseluruhan untuk periode ini..."
                              class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500"
                              required>{{ $komentar ? $komentar->komentar : '' }}</textarea>
                    <p class="mt-2 text-sm text-gray-500">Maksimal 1000 karakter</p>
                </div>

                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        <span class="font-medium">Periode:</span> Triwulan {{ $triwulan }} Tahun {{ $tahun }}
                    </div>
                    <button type="submit" 
                            class="px-6 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-200">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ $komentar ? 'Update Komentar' : 'Simpan Komentar' }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Preview Komentar -->
        @if($komentar)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Preview Komentar</h3>
                    <div class="text-sm text-gray-500">
                        Terakhir diperbarui: {{ $komentar->updated_at->format('d M Y H:i') }}
                    </div>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-purple-500">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <div class="flex items-center mb-2">
                                <h4 class="text-sm font-medium text-gray-900">Kepala Kantor</h4>
                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    Komentar Umum
                                </span>
                            </div>
                            <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $komentar->komentar }}</p>
                            <div class="mt-3 text-xs text-gray-500">
                                Periode: Triwulan {{ $komentar->triwulan }} Tahun {{ $komentar->tahun }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Informasi -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Informasi</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <ul class="list-disc list-inside space-y-1">
                            <li>Komentar umum akan ditampilkan di dashboard Kasi dan Staff</li>
                            <li>Hanya satu komentar umum per periode (tahun + triwulan)</li>
                            <li>Komentar dapat diperbarui kapan saja</li>
                            <li>Komentar akan disertakan dalam laporan export</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 