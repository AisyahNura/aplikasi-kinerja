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
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Penilaian Kinerja Staf</h1>
            <p class="text-gray-600">Kelola dan evaluasi kinerja staf berdasarkan periode yang dipilih</p>
        </div>

        <!-- Tab Navigation -->
        <div class="mb-6">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <button id="tab-penilaian" onclick="switchTab('penilaian')" class="tab-button active py-2 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600">
                        Penilaian Aktif
                    </button>
                    <button id="tab-riwayat" onclick="switchTab('riwayat')" class="tab-button py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Riwayat Penilaian
                    </button>
                </nav>
            </div>
        </div>

        <!-- Tab Content: Penilaian Aktif -->
        <div id="content-penilaian" class="tab-content">
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
                            <select id="tahun-select" onchange="loadData()" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025" selected>2025</option>
                            </select>
                        </div>
                        
                        <!-- Triwulan -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Triwulan</label>
                            <select id="triwulan-select" onchange="loadData()" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="I" selected>Triwulan I</option>
                                <option value="II">Triwulan II</option>
                                <option value="III">Triwulan III</option>
                                <option value="IV">Triwulan IV</option>
                            </select>
                        </div>
                        
                        <!-- Tombol Refresh -->
                        <div>
                            <button onclick="loadData()" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Refresh Data
                            </button>
                        </div>
                    </div>
                    
                    <!-- Info Periode -->
                    <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-md">
                        <p class="text-sm text-blue-800">
                            <strong>Periode Aktif:</strong> Tahun <span id="tahun-display">2025</span> | Triwulan <span id="triwulan-display">I</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Loading State -->
            <div id="loading-state" class="hidden">
                <div class="flex items-center justify-center py-12">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
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

            <!-- Tabel Penilaian -->
            <div id="table-container" class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Daftar Staf untuk Penilaian</h2>
                    <p class="text-sm text-gray-600 mt-1">Pilih penilaian untuk setiap staf sesuai kinerjanya pada periode yang dipilih</p>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Staff</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penilaian</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Komentar</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody id="staff-table-body" class="bg-white divide-y divide-gray-200">
                            <!-- Data dari JavaScript -->
                        </tbody>
                    </table>
                </div>
                
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div class="text-sm text-gray-600">
                            Total: <span id="total-staff" class="font-semibold">0</span> staf | 
                            Sudah dinilai: <span id="sudah-dinilai" class="font-semibold">0</span> staf
                        </div>
                        <button id="simpan-btn" onclick="simpanSemuaPenilaian()" disabled class="px-6 py-2 bg-gray-300 text-white rounded-md font-medium disabled:opacity-50 disabled:cursor-not-allowed hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Semua Penilaian
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Content: Riwayat Penilaian -->
        <div id="content-riwayat" class="tab-content hidden">
            <!-- Filter Riwayat -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Filter Riwayat</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <!-- Tahun Riwayat -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                            <select id="tahun-riwayat-select" onchange="loadRiwayat()" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="2023">2023</option>
                                <option value="2024" selected>2024</option>
                                <option value="2025">2025</option>
                            </select>
                        </div>
                        
                        <!-- Triwulan Riwayat -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Triwulan</label>
                            <select id="triwulan-riwayat-select" onchange="loadRiwayat()" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="I">Triwulan I</option>
                                <option value="II">Triwulan II</option>
                                <option value="III">Triwulan III</option>
                                <option value="IV" selected>Triwulan IV</option>
                            </select>
                        </div>
                        
                        <!-- Tombol Refresh Riwayat -->
                        <div>
                            <button onclick="loadRiwayat()" class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Lihat Riwayat
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loading State Riwayat -->
            <div id="loading-riwayat" class="hidden">
                <div class="flex items-center justify-center py-12">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-green-600"></div>
                    <span class="ml-3 text-gray-600">Memuat riwayat...</span>
                </div>
            </div>

            <!-- Tabel Riwayat -->
            <div id="riwayat-container" class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Riwayat Penilaian</h2>
                    <p class="text-sm text-gray-600 mt-1">Daftar penilaian yang telah dilakukan pada periode sebelumnya</p>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Staff</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penilaian</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Komentar</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody id="riwayat-table-body" class="bg-white divide-y divide-gray-200">
                            <!-- Data riwayat dari JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes spin {
    to { transform: rotate(360deg); }
}

.tab-button {
    transition: all 0.2s;
}

.tab-button.active {
    border-color: #3b82f6;
    color: #2563eb;
}

.tab-content {
    transition: all 0.3s ease;
}

.penilaian-btn {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 0.75rem;
    border-radius: 0.375rem;
    font-size: 0.75rem;
    border: 2px solid #d1d5db;
    background-color: white;
    color: #374151;
    cursor: pointer;
    transition: all 0.2s;
    margin: 0.25rem;
}

.penilaian-btn:hover {
    border-color: #9ca3af;
    background-color: #f9fafb;
}

.penilaian-btn.selected-1 {
    border-color: #dc2626;
    background-color: #fef2f2;
    color: #991b1b;
}

.penilaian-btn.selected-2 {
    border-color: #6b7280;
    background-color: #f3f4f6;
    color: #374151;
}

.penilaian-btn.selected-3 {
    border-color: #059669;
    background-color: #f0fdf4;
    color: #065f46;
}

.status-badge {
    display: inline-block;
    padding: 0.25rem 0.5rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
    transition: all 0.2s;
}

.status-badge.gray {
    background-color: #f3f4f6;
    color: #374151;
}

.status-badge.green {
    background-color: #d1fae5;
    color: #065f46;
}

.status-badge.red {
    background-color: #fee2e2;
    color: #991b1b;
}

.comment-input {
    width: 100%;
    min-height: 60px;
    padding: 0.5rem;
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    resize: vertical;
    transition: border-color 0.2s;
}

.comment-input:focus {
    outline: none;
    border-color: #3b82f6;
    ring: 2px;
    ring-color: #3b82f6;
}

@media (min-width: 640px) {
    .penilaian-btn {
        margin: 0.125rem;
    }
}
</style>

<script>
// Data berdasarkan periode
let dataPerPeriode = {
    '2025-I': [
        { id: 1, nama: "Staff 1", penilaian: null, komentar: "" },
        { id: 2, nama: "Staff 2", penilaian: null, komentar: "" },
        { id: 3, nama: "Staff 3", penilaian: null, komentar: "" },
        { id: 4, nama: "Staff 4", penilaian: null, komentar: "" },
        { id: 5, nama: "Staff 5", penilaian: null, komentar: "" }
    ],
    '2024-IV': [
        { id: 1, nama: "Staff 1", penilaian: 3, komentar: "Sangat baik dalam leadership dan teamwork", tanggal: "2024-12-31" },
        { id: 2, nama: "Staff 2", penilaian: 3, komentar: "Konsisten dalam memberikan hasil terbaik", tanggal: "2024-12-31" },
        { id: 3, nama: "Staff 3", penilaian: 2, komentar: "Peningkatan signifikan dari periode sebelumnya", tanggal: "2024-12-31" },
        { id: 4, nama: "Staff 4", penilaian: 1, komentar: "Perlu evaluasi lebih lanjut", tanggal: "2024-12-31" }
    ]
};

let dummyPenilaian = [];
let currentTab = 'penilaian';

// Tab switching function
function switchTab(tabName) {
    currentTab = tabName;
    
    // Update tab buttons
    document.querySelectorAll('.tab-button').forEach(btn => {
        btn.classList.remove('active');
    });
    
    if (tabName === 'penilaian') {
        document.getElementById('tab-penilaian').classList.add('active');
        document.getElementById('content-penilaian').classList.remove('hidden');
        document.getElementById('content-riwayat').classList.add('hidden');
    } else {
        document.getElementById('tab-riwayat').classList.add('active');
        document.getElementById('content-penilaian').classList.add('hidden');
        document.getElementById('content-riwayat').classList.remove('hidden');
        loadRiwayat();
    }
}

// Get current periode
function getCurrentPeriode() {
    const tahun = document.getElementById('tahun-select').value;
    const triwulan = document.getElementById('triwulan-select').value;
    return `${tahun}-${triwulan}`;
}

// Get current periode for history
function getCurrentPeriodeRiwayat() {
    const tahun = document.getElementById('tahun-riwayat-select').value;
    const triwulan = document.getElementById('triwulan-riwayat-select').value;
    return `${tahun}-${triwulan}`;
}

// Update periode display
function updatePeriodeDisplay() {
    const tahun = document.getElementById('tahun-select').value;
    const triwulan = document.getElementById('triwulan-select').value;
    
    document.getElementById('tahun-display').textContent = tahun;
    document.getElementById('triwulan-display').textContent = triwulan;
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

// Load data function
function loadData() {
    showLoading();
    updatePeriodeDisplay();
    
    // Simulate API call
    setTimeout(() => {
        try {
            const periode = getCurrentPeriode();
            dummyPenilaian = dataPerPeriode[periode] || [];
            
            if (dummyPenilaian.length === 0) {
                // Jika tidak ada data untuk periode ini, buat dummy data
                dummyPenilaian = [
                    { id: 1, nama: "Staff 1", penilaian: null, komentar: "" },
                    { id: 2, nama: "Staff 2", penilaian: null, komentar: "" },
                    { id: 3, nama: "Staff 3", penilaian: null, komentar: "" }
                ];
            }
            
            renderTable();
            hideLoading();
        } catch (error) {
            console.error('Error loading data:', error);
            showError();
        }
    }, 1000);
}

// Load riwayat function
function loadRiwayat() {
    document.getElementById('loading-riwayat').classList.remove('hidden');
    document.getElementById('riwayat-container').classList.add('hidden');
    
    setTimeout(() => {
        try {
            const periode = getCurrentPeriodeRiwayat();
            const riwayatData = dataPerPeriode[periode] || [];
            
            renderRiwayatTable(riwayatData);
            document.getElementById('loading-riwayat').classList.add('hidden');
            document.getElementById('riwayat-container').classList.remove('hidden');
        } catch (error) {
            console.error('Error loading riwayat:', error);
            document.getElementById('loading-riwayat').classList.add('hidden');
        }
    }, 800);
}

// Render Tabel
function renderTable() {
    const tbody = document.getElementById('staff-table-body');
    if (!tbody) {
        console.error('Table body not found');
        throw new Error('Table body not found');
    }
    
    tbody.innerHTML = '';

    dummyPenilaian.forEach((staff, index) => {
        tbody.innerHTML += `
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${index + 1}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-8 w-8">
                            <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                <span class="text-sm font-medium text-blue-600">${staff.nama.charAt(0)}</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">${staff.nama}</div>
                            <div class="text-sm text-gray-500">Staff ID: ${staff.id}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex flex-wrap gap-2">
                        ${renderButtons(staff.id)}
                    </div>
                </td>
                <td class="px-6 py-4">
                    <textarea 
                        id="komentar-${staff.id}" 
                        class="comment-input" 
                        placeholder="Tulis komentar penilaian..."
                        onchange="updateKomentar(${staff.id})"
                    >${staff.komentar || ''}</textarea>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span id="status-${staff.id}" class="status-badge gray">
                        Belum Dinilai
                    </span>
                </td>
            </tr>
        `;
    });

    updateCounters();
    updateButtonStyles();
}

// Render Riwayat Table
function renderRiwayatTable(riwayatData) {
    const tbody = document.getElementById('riwayat-table-body');
    if (!tbody) return;
    
    tbody.innerHTML = '';

    if (riwayatData.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="mt-2">Tidak ada data riwayat untuk periode ini</p>
                </td>
            </tr>
        `;
        return;
    }

    riwayatData.forEach((staff, index) => {
        const penilaianText = getPenilaianText(staff.penilaian);
        const penilaianClass = getStatusBadgeClass(staff.penilaian);
        
        tbody.innerHTML += `
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${index + 1}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-8 w-8">
                            <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                <span class="text-sm font-medium text-green-600">${staff.nama.charAt(0)}</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">${staff.nama}</div>
                            <div class="text-sm text-gray-500">Staff ID: ${staff.id}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="status-badge ${penilaianClass}">${penilaianText}</span>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm text-gray-900 max-w-xs">
                        ${staff.komentar || '-'}
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    ${staff.tanggal || '-'}
                </td>
            </tr>
        `;
    });
}

// Render Tombol Penilaian
function renderButtons(staffId) {
    return `
        <button onclick="setPenilaian(${staffId}, 3)" data-staff="${staffId}" data-nilai="3" class="penilaian-btn">
            <span style="font-size: 1.125rem; margin-right: 0.25rem;">🌟</span>
            <span style="display: none;">Melebihi</span>
        </button>
        <button onclick="setPenilaian(${staffId}, 2)" data-staff="${staffId}" data-nilai="2" class="penilaian-btn">
            <span style="font-size: 1.125rem; margin-right: 0.25rem;">👍</span>
            <span style="display: none;">Sesuai</span>
        </button>
        <button onclick="setPenilaian(${staffId}, 1)" data-staff="${staffId}" data-nilai="1" class="penilaian-btn">
            <span style="font-size: 1.125rem; margin-right: 0.25rem;">👎</span>
            <span style="display: none;">Di Bawah</span>
        </button>
    `;
}

// Update Komentar
function updateKomentar(staffId) {
    const staff = dummyPenilaian.find(s => s.id === staffId);
    if (staff) {
        const komentarInput = document.getElementById(`komentar-${staffId}`);
        staff.komentar = komentarInput.value;
    }
}

// Set Penilaian
function setPenilaian(staffId, nilai) {
    const staff = dummyPenilaian.find(s => s.id === staffId);
    if (staff) {
        staff.penilaian = nilai;
        updateStatusBadge(staffId, nilai);
        updateButtonStyles();
        updateCounters();
        
        // Add visual feedback
        const statusElement = document.getElementById(`status-${staffId}`);
        if (statusElement) {
            statusElement.style.animation = 'pulse 1s';
            setTimeout(() => {
                statusElement.style.animation = '';
            }, 1000);
        }
    }
}

// Update Badge Status
function updateStatusBadge(staffId, nilai) {
    const statusElement = document.getElementById(`status-${staffId}`);
    if (!statusElement) return;
    
    const text = getPenilaianText(nilai);
    const className = getStatusBadgeClass(nilai);
    statusElement.textContent = text;
    statusElement.className = `status-badge ${className}`;
}

// Text Penilaian
function getPenilaianText(nilai) {
    switch (nilai) {
        case 1: return '👎 Di Bawah Ekspektasi';
        case 2: return '👍 Sesuai Ekspektasi';
        case 3: return '🌟 Melebihi Ekspektasi';
        default: return 'Belum Dinilai';
    }
}

// Badge Class
function getStatusBadgeClass(nilai) {
    switch (nilai) {
        case 1: return 'red';
        case 2: return 'gray';
        case 3: return 'green';
        default: return 'gray';
    }
}

// Update Counters
function updateCounters() {
    const totalStaff = dummyPenilaian.length;
    const sudahDinilai = dummyPenilaian.filter(s => s.penilaian !== null).length;
    
    const totalElement = document.getElementById('total-staff');
    const sudahDinilaiElement = document.getElementById('sudah-dinilai');
    const simpanBtn = document.getElementById('simpan-btn');
    
    if (totalElement) totalElement.textContent = totalStaff;
    if (sudahDinilaiElement) sudahDinilaiElement.textContent = sudahDinilai;
    if (simpanBtn) {
        simpanBtn.disabled = sudahDinilai === 0;
        if (sudahDinilai > 0) {
            simpanBtn.classList.remove('bg-gray-300');
            simpanBtn.classList.add('bg-blue-600');
        } else {
            simpanBtn.classList.remove('bg-blue-600');
            simpanBtn.classList.add('bg-gray-300');
        }
    }
}

// Update Style Tombol
function updateButtonStyles() {
    dummyPenilaian.forEach(staff => {
        const buttons = document.querySelectorAll(`[data-staff="${staff.id}"]`);
        buttons.forEach(btn => {
            const nilai = parseInt(btn.getAttribute('data-nilai'));
            btn.className = 'penilaian-btn';
            if (staff.penilaian === nilai) {
                btn.classList.add(`selected-${nilai}`);
            }
        });
    });
}

// Simpan Semua Penilaian
function simpanSemuaPenilaian() {
    const hasil = dummyPenilaian.filter(s => s.penilaian !== null);
    const periode = getCurrentPeriode();
    
    if (hasil.length === 0) {
        alert('Belum ada penilaian yang dipilih!');
        return;
    }
    
    // Show loading state
    const simpanBtn = document.getElementById('simpan-btn');
    const originalText = simpanBtn.innerHTML;
    simpanBtn.innerHTML = `
        <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white mr-2"></div>
        Menyimpan...
    `;
    simpanBtn.disabled = true;
    
    // Simulate API call
    setTimeout(() => {
        console.log('=== HASIL PENILAIAN ===', {
            periode: periode,
            data: hasil
        });
        
        // Update data in memory
        dataPerPeriode[periode] = dummyPenilaian;
        
        // Reset button
        simpanBtn.innerHTML = originalText;
        simpanBtn.disabled = false;
        
        // Show success message
        alert(`Berhasil menyimpan ${hasil.length} penilaian untuk periode ${periode}! (Lihat console untuk detail)`);
        
        // Optional: Add success animation
        simpanBtn.classList.remove('bg-blue-600');
        simpanBtn.classList.add('bg-green-600');
        setTimeout(() => {
            simpanBtn.classList.remove('bg-green-600');
            simpanBtn.classList.add('bg-blue-600');
        }, 2000);
    }, 1500);
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('Penilaian page loaded');
    updatePeriodeDisplay();
    loadData();
});

// Add responsive handling
window.addEventListener('resize', function() {
    // Re-render buttons for responsive text
    updateButtonStyles();
});
</script>
@endsection 