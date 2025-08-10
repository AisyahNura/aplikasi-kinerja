@extends('layouts.kasi')

@section('content')
@php
    $ratingText = [
        1 => 'Di Bawah Ekspektasi',
        2 => 'Sesuai Ekspektasi',
        3 => 'Melebihi Ekspektasi'
    ];
@endphp
<div class="p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Penilaian Staff</h1>
            <p class="text-gray-600">Berikan penilaian kinerja kepada Staff berdasarkan periode tertentu</p>
        </div>

            <!-- Filter Periode -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Filter Periode</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <!-- Tahun -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                        <select id="tahun-select" onchange="loadData()" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            @php
                                $currentYear = date('Y');
                                $startYear = $currentYear - 2;
                            @endphp
                            @for($year = $startYear; $year <= $currentYear; $year++)
                                <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>{{ $year }}</option>
                            @endfor
                            </select>
                        </div>
                        
                        <!-- Triwulan -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Triwulan</label>
                        <select id="triwulan-select" onchange="loadData()" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            @php
                                $currentQuarter = ceil(date('n') / 3);
                                $quarters = [
                                    1 => ['I', 'Triwulan I'],
                                    2 => ['II', 'Triwulan II'],
                                    3 => ['III', 'Triwulan III'],
                                    4 => ['IV', 'Triwulan IV']
                                ];
                            @endphp
                            @foreach($quarters as $num => $quarter)
                                <option value="{{ $quarter[0] }}" {{ $num == $currentQuarter ? 'selected' : '' }}>{{ $quarter[1] }}</option>
                            @endforeach
                            </select>
                        </div>
                        
                    <!-- Tombol Filter -->
                        <div>
                        <button onclick="loadData()" class="w-full px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            Filter
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loading State -->
            <div id="loading-state" class="hidden">
                <div class="flex items-center justify-center py-12">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-purple-600"></div>
                    <span class="ml-3 text-gray-600">Memuat data...</span>
                </div>
            </div>

            <!-- Error State -->
            <div id="error-state" class="hidden">
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-red-800">Terjadi kesalahan saat memuat data</span>
                    </div>
                    <button onclick="loadData()" class="mt-2 text-sm text-red-600 underline hover:text-red-800">Coba lagi</button>
                </div>
            </div>

        <!-- Daftar Staff -->
        <div id="table-container">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Daftar Staff - Periode <span id="periode-display">Aktif</span></h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Staff</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIP</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jabatan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Komentar</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($staffList as $staff)
                                <tr id="staff-row-{{ $staff->id }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-purple-500 flex items-center justify-center">
                                                    <span class="text-lg font-medium text-white">{{ substr($staff->name, 0, 1) }}</span>
                    </div>
                </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $staff->name }}</div>
            </div>
        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $staff->nip }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $staff->jabatan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $staff->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <select name="rating" class="rating-select w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200" data-staff-id="{{ $staff->id }}">
                                            <option value="">Pilih Rating</option>
                                            @foreach($ratingText as $value => $text)
                                                <option value="{{ $value }}" {{ isset($penilaian[$staff->id]) && $penilaian[$staff->id]->rating == $value ? 'selected' : '' }}>
                                                    {{ $text }}
                                                </option>
                                            @endforeach
                            </select>
                                    </td>
                                    <td class="px-6 py-4">
                                        <textarea name="komentar" rows="2" class="komentar-input w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200" data-staff-id="{{ $staff->id }}" placeholder="Berikan komentar penilaian...">{{ isset($penilaian[$staff->id]) ? $penilaian[$staff->id]->komentar : '' }}</textarea>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button onclick="simpanPenilaian({{ $staff->id }})" class="simpan-btn text-purple-600 hover:text-purple-900 focus:outline-none">
                                            Simpan
                            </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                        Tidak ada staff yang ditugaskan
                                    </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Load data function
function loadData() {
    showLoading();
    updatePeriodeDisplay();
    
    // Get the selected period
    const tahun = document.getElementById('tahun-select').value;
    const triwulan = document.getElementById('triwulan-select').value;
    
    // Reload page with new parameters
    window.location.href = `/kasi/penilaian?tahun=${tahun}&triwulan=${triwulan}`;
}

// Update periode display
function updatePeriodeDisplay() {
    const tahun = document.getElementById('tahun-select').value;
    const triwulan = document.getElementById('triwulan-select').value;
    
    // Update periode display
    const periodeDisplay = document.getElementById('periode-display');
    if (periodeDisplay) {
        periodeDisplay.textContent = `${triwulan} ${tahun}`;
    }
}

// Show/Hide loading and error states
function showLoading() {
    document.getElementById('loading-state').classList.remove('hidden');
    document.getElementById('error-state').classList.add('hidden');
    document.getElementById('table-container').classList.add('hidden');
}

function hideLoading() {
    document.getElementById('loading-state').classList.add('hidden');
    document.getElementById('error-state').classList.add('hidden');
    document.getElementById('table-container').classList.remove('hidden');
}

function showError() {
    document.getElementById('loading-state').classList.add('hidden');
    document.getElementById('error-state').classList.remove('hidden');
    document.getElementById('table-container').classList.add('hidden');
}

// Save penilaian function
function simpanPenilaian(staffId) {
    const row = document.getElementById(`staff-row-${staffId}`);
    const ratingSelect = row.querySelector('.rating-select');
    const komentarInput = row.querySelector('.komentar-input');
    const simpanBtn = row.querySelector('.simpan-btn');
    
    // Validate input
    if (!ratingSelect.value) {
        alert('Silakan pilih rating terlebih dahulu');
        return;
    }

    if (!komentarInput.value.trim()) {
        alert('Silakan berikan komentar terlebih dahulu');
        return;
    }
    
    // Show loading state
    const originalText = simpanBtn.textContent;
    simpanBtn.textContent = 'Menyimpan...';
    simpanBtn.disabled = true;
    
    // Get the current period
    const tahun = document.getElementById('tahun-select').value;
    const triwulan = document.getElementById('triwulan-select').value;
    
    // Save data
    fetch('/kasi/penilaian/simpan', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            staff_id: staffId,
            rating: ratingSelect.value,
            komentar: komentarInput.value,
            tahun: tahun,
            triwulan: triwulan
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            alert('Penilaian berhasil disimpan');
            
            // Reload data
            loadData();
        } else {
            throw new Error(data.message || 'Terjadi kesalahan saat menyimpan penilaian');
        }
    })
    .catch(error => {
        console.error('Error saving penilaian:', error);
        alert(error.message || 'Terjadi kesalahan saat menyimpan penilaian. Silakan coba lagi.');
        
        // Reset button
        simpanBtn.textContent = originalText;
        simpanBtn.disabled = false;
    });
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('Penilaian page loaded');
    updatePeriodeDisplay();
});
</script>
@endsection 