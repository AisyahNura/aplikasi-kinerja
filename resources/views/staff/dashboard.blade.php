@extends('layouts.staff')

@section('content')
<style>
/* Rating styles untuk 3 level */
.rating-3 {
    display: inline-flex;
    align-items: center;
    gap: 2px;
}

.rating-star {
    font-size: 1.25rem;
    color: #3B82F6;
}

.rating-star.empty {
    color: #D1D5DB;
}

.rating-text {
    font-size: 0.875rem;
    color: #6B7280;
    margin-left: 8px;
}

/* Rating colors berdasarkan nilai */
.rating-star.rating-1 {
    color: #EF4444;
}

.rating-star.rating-2 {
    color: #F59E0B;
}

.rating-star.rating-3 {
    color: #10B981;
}

.rating-label {
    font-size: 0.75rem;
    font-weight: 600;
    padding: 2px 6px;
    border-radius: 4px;
    margin-left: 8px;
}

.rating-label-1 {
    background-color: #FEE2E2;
    color: #EF4444;
}

.rating-label-2 {
    background-color: #FEF3C7;
    color: #F59E0B;
}

.rating-label-3 {
    background-color: #D1FAE5;
    color: #10B981;
}
</style>

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
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Dashboard STAFF</h1>
            <p class="text-gray-600">Ringkasan kinerja dan aktivitas terbaru</p>
        </div>

        <!-- Profil Staff dan Atasan -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Profil Staff -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    PEGAWAI
                </h3>
                <div class="space-y-3">
                    <div>
                        <label class="text-xs font-medium text-gray-500 uppercase">NAMA</label>
                        <p class="text-sm font-medium text-gray-900">{{ $staffName }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-500 uppercase">NIP</label>
                        <p class="text-sm text-gray-900">{{ $staffNip }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-500 uppercase">PANGKAT / GOL RUANG</label>
                        <p class="text-sm text-gray-900">{{ $staffPangkat }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-500 uppercase">JABATAN</label>
                        <p class="text-sm text-gray-900">{{ $staffJabatan }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-500 uppercase">UNIT KERJA</label>
                        <p class="text-sm text-gray-900">{{ $staffUnitKerja }}</p>
                    </div>
                </div>
            </div>

            <!-- Profil Atasan -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                    ATASAN
                </h3>
                <div class="space-y-3">
                    <div>
                        <label class="text-xs font-medium text-gray-500 uppercase">NAMA</label>
                        <p class="text-sm font-medium text-gray-900">{{ $atasanName }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-500 uppercase">NIP</label>
                        <p class="text-sm text-gray-900">{{ $atasanNip }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-500 uppercase">PANGKAT / GOL RUANG</label>
                        <p class="text-sm text-gray-900">{{ $atasanPangkat }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-500 uppercase">JABATAN</label>
                        <p class="text-sm text-gray-900">{{ $atasanJabatan }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-500 uppercase">UNIT KERJA</label>
                        <p class="text-sm text-gray-900">{{ $atasanUnitKerja }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Tugas -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Tugas</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalTarget }}</p>
                    </div>
                </div>
            </div>

            <!-- Draft -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Draft</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $draftCount }}</p>
                    </div>
                </div>
            </div>

            <!-- Menunggu -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Menunggu</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $menungguCount }}</p>
                    </div>
                </div>
            </div>

            <!-- Sudah Dinilai -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Sudah Dinilai</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $sudahDinilaiCount }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Triwulan Aktif -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Triwulan Aktif</h3>
                        <p class="text-sm text-gray-600">Periode penilaian saat ini</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-green-600">{{ $currentQuarter }}</p>
                    <p class="text-sm text-gray-500">Tahun {{ $currentYear }}</p>
                </div>
            </div>
        </div>



        <!-- Status Kinerja -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Kinerja</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700">Progress Keseluruhan</span>
                    <span class="text-sm font-medium text-gray-900">
                        @if($totalTarget > 0)
                            {{ round((($sudahDinilaiCount / $totalTarget) * 100), 1) }}%
                        @else
                            0%
                        @endif
                    </span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-600 h-2 rounded-full" style="width: {{ $totalTarget > 0 ? ($sudahDinilaiCount / $totalTarget) * 100 : 0 }}%"></div>
                </div>
                <div class="grid grid-cols-3 gap-4 text-center">
                    <div>
                        <p class="text-sm text-gray-500">Draft</p>
                        <p class="text-lg font-semibold text-yellow-600">{{ $draftCount }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Menunggu</p>
                        <p class="text-lg font-semibold text-orange-600">{{ $menungguCount }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Sudah Dinilai</p>
                        <p class="text-lg font-semibold text-green-600">{{ $sudahDinilaiCount }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Komentar dari Atasan -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Komentar dari Atasan</h3>
                <a href="{{ route('staff.komentar') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    Lihat Semua →
                </a>
            </div>

            <!-- Filter Tahun & Triwulan -->
            <div class="mb-6">
                <form method="GET" action="{{ route('staff.dashboard') }}" class="flex flex-wrap gap-4 items-end">
                    <div>
                        <label for="tahun" class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                        <select name="tahun" id="tahun" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @for($year = date('Y'); $year >= date('Y') - 2; $year--)
                                <option value="{{ $year }}" {{ request('tahun', date('Y')) == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label for="triwulan" class="block text-sm font-medium text-gray-700 mb-1">Triwulan</label>
                        <select name="triwulan" id="triwulan" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="I" {{ request('triwulan', $currentQuarter) == 'I' ? 'selected' : '' }}>I</option>
                            <option value="II" {{ request('triwulan', $currentQuarter) == 'II' ? 'selected' : '' }}>II</option>
                            <option value="III" {{ request('triwulan', $currentQuarter) == 'III' ? 'selected' : '' }}>III</option>
                            <option value="IV" {{ request('triwulan', $currentQuarter) == 'IV' ? 'selected' : '' }}>IV</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Daftar Komentar -->
            @if($filteredComments->count() > 0)
                <div class="space-y-4">
                    @foreach($filteredComments->take(3) as $comment)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200">
                            <!-- Rating Bintang -->
                            <div class="flex items-center mb-3">
                                <div class="rating-3">
                                    @for($i = 1; $i <= 3; $i++)
                                        @if($i <= $comment->rating)
                                            <span class="rating-star rating-{{ $comment->rating }}">⭐</span>
                                        @else
                                            <span class="rating-star empty">☆</span>
                                        @endif
                                    @endfor
                                </div>
                                @php
                                    $ratingLabel = '';
                                    $ratingClass = '';
                                    switch($comment->rating) {
                                        case 1:
                                            $ratingLabel = 'Di Bawah Ekspektasi';
                                            $ratingClass = 'rating-label-1';
                                            break;
                                        case 2:
                                            $ratingLabel = 'Sesuai Ekspektasi';
                                            $ratingClass = 'rating-label-2';
                                            break;
                                        case 3:
                                            $ratingLabel = 'Melebihi Ekspektasi';
                                            $ratingClass = 'rating-label-3';
                                            break;
                                    }
                                @endphp
                                <span class="rating-label {{ $ratingClass }}">{{ $ratingLabel }}</span>
                            </div>

                            <!-- Teks Komentar -->
                            <div class="mb-3">
                                <p class="text-sm text-gray-700 leading-relaxed">{{ $comment->komentar }}</p>
                            </div>

                            <!-- Info Kasi dan Tanggal -->
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <span>{{ $comment->createdBy->name }} ({{ ucfirst($comment->createdBy->role) }})</span>
                                <span>{{ $comment->created_at->format('d M Y H:i') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($filteredComments->count() > 3)
                    <div class="mt-4 text-center">
                        <a href="{{ route('staff.komentar') }}?tahun={{ request('tahun', date('Y')) }}&triwulan={{ request('triwulan', $currentQuarter) }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 transition-colors duration-200">
                            Lihat {{ $filteredComments->count() - 3 }} komentar lainnya
                        </a>
                    </div>
                @endif
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada komentar</h3>
                    <p class="mt-1 text-sm text-gray-500">Belum ada komentar dari atasan untuk periode yang dipilih.</p>
                </div>
            @endif
        </div>
        </div>
    </div>
</div>
@endsection 