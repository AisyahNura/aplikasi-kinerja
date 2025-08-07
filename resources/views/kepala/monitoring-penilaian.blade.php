@extends('layouts.kepala')

@section('content')
<div class="p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Monitoring Penilaian Kinerja</h1>
            <p class="text-gray-600">Pantau penilaian kinerja dari Kasi kepada Staff</p>
        </div>

        <!-- Filter -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <form method="GET" action="{{ route('kepala.monitoring-penilaian') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
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
                
                <div>
                    <label for="kasi_id" class="block text-sm font-medium text-gray-700 mb-1">Kasi</label>
                    <select id="kasi_id" 
                            name="kasi_id" 
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                        <option value="">Semua Kasi</option>
                        @foreach($kasiList as $kasi)
                            <option value="{{ $kasi->id }}" {{ $kasiId == $kasi->id ? 'selected' : '' }}>{{ $kasi->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button type="submit" 
                            class="w-full px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-200">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Statistik per Kasi -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Statistik per Kasi</h3>
            </div>
            <div class="p-6">
                @if(count($statistikKasi) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($statistikKasi as $stat)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                <div class="flex items-center mb-4">
                                    <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center">
                                        <span class="text-white font-semibold">{{ strtoupper(substr($stat['kasi']->name, 0, 1)) }}</span>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-gray-900">{{ $stat['kasi']->name }}</h4>
                                        <p class="text-xs text-gray-500">{{ $stat['kasi']->jabatan }}</p>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-3 gap-4 text-center">
                                    <div>
                                        <p class="text-lg font-semibold text-gray-900">{{ $stat['total_staff'] }}</p>
                                        <p class="text-xs text-gray-500">Staff</p>
                                    </div>
                                    <div>
                                        <p class="text-lg font-semibold text-gray-900">{{ $stat['total_penilaian'] }}</p>
                                        <p class="text-xs text-gray-500">Penilaian</p>
                                    </div>
                                    <div>
                                        <div class="flex items-center justify-center mb-1">
                                            @for($i = 1; $i <= 3; $i++)
                                                @if($i <= round($stat['rata_rata']))
                                                    <span class="text-yellow-500 text-sm">⭐</span>
                                                @else
                                                    <span class="text-gray-300 text-sm">☆</span>
                                                @endif
                                            @endfor
                                        </div>
                                        <p class="text-sm font-medium text-gray-900">{{ $stat['rata_rata'] }}</p>
                                        <p class="text-xs text-gray-500">Rata-rata</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada data</h3>
                        <p class="mt-1 text-sm text-gray-500">Belum ada statistik penilaian untuk periode ini.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Rata-rata Penilaian per Staff -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Rata-rata Penilaian per Staff</h3>
            </div>
            <div class="p-6">
                @if($rataRataStaff->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($rataRataStaff as $staff)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center">
                                            <span class="text-white font-semibold text-sm">{{ strtoupper(substr($staff->user->name, 0, 1)) }}</span>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ $staff->user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $staff->user->jabatan }}</p>
                                            @if($staff->user->kasi)
                                                <p class="text-xs text-blue-600">Atasan: {{ $staff->user->kasi->name }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 3; $i++)
                                                @if($i <= round($staff->rata_rata))
                                                    <span class="text-yellow-500">⭐</span>
                                                @else
                                                    <span class="text-gray-300">☆</span>
                                                @endif
                                            @endfor
                                        </div>
                                        <p class="text-sm font-medium text-gray-900">{{ number_format($staff->rata_rata, 1) }}</p>
                                    </div>
                                </div>
                                <div class="text-xs text-gray-500">
                                    Total penilaian: {{ $staff->total_penilaian }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada penilaian</h3>
                        <p class="mt-1 text-sm text-gray-500">Belum ada data penilaian untuk periode yang dipilih.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Daftar Penilaian -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Daftar Penilaian</h3>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('kepala.export.pdf') }}?tahun={{ $tahun }}&triwulan={{ $triwulan }}&kasi_id={{ $kasiId }}" 
                           class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Export PDF
                        </a>
                        <a href="{{ route('kepala.export.excel') }}?tahun={{ $tahun }}&triwulan={{ $triwulan }}&kasi_id={{ $kasiId }}" 
                           class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Export Excel
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Staff
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kasi
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tugas
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Rating
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Komentar
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($penilaian as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full flex items-center justify-center bg-green-600">
                                                <span class="text-white font-semibold text-sm">{{ strtoupper(substr($item->user->name, 0, 1)) }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $item->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $item->user->jabatan }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <div class="h-8 w-8 rounded-full flex items-center justify-center bg-blue-600">
                                                <span class="text-white font-semibold text-xs">{{ strtoupper(substr($item->createdBy->name, 0, 1)) }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ $item->createdBy->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        @if($item->realisasiKinerja && $item->realisasiKinerja->task)
                                            {{ $item->realisasiKinerja->task->nama_tugas }}
                                        @else
                                            -
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 3; $i++)
                                                @if($i <= $item->rating)
                                                    <span class="text-yellow-500">⭐</span>
                                                @else
                                                    <span class="text-gray-300">☆</span>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="ml-2 text-sm font-medium text-gray-900">{{ $item->rating }}/3</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 max-w-xs truncate">
                                        {{ Str::limit($item->komentar, 100) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $item->created_at->format('d/m/Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ $item->created_at->format('H:i') }}</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada penilaian</h3>
                                        <p class="mt-1 text-sm text-gray-500">Belum ada data penilaian untuk periode yang dipilih.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($penilaian->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Menampilkan {{ $penilaian->firstItem() }} sampai {{ $penilaian->lastItem() }} dari {{ $penilaian->total() }} hasil
                        </div>
                        <div class="flex items-center space-x-2">
                            {{ $penilaian->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 