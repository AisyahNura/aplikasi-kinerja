@extends('layouts.kepala')

@section('content')
<div class="p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header E-Kinerja Style -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center mr-4">
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
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Review Penilaian Kasi</h1>
            <p class="text-gray-600">Tinjau dan evaluasi laporan penilaian dari Kasi</p>
        </div>

        <!-- Tab Navigation -->
        <div class="mb-6">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <button id="tab-review" onclick="switchTab('review')" class="tab-button active py-2 px-1 border-b-2 border-purple-500 font-medium text-sm text-purple-600">
                        Review Laporan
                    </button>
                    <button id="tab-riwayat" onclick="switchTab('riwayat')" class="tab-button py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Riwayat Review
                    </button>
                </nav>
            </div>
        </div>

        <!-- Tab Content: Review Laporan -->
        <div id="content-review" class="tab-content">
            <!-- Loading State -->
            <div id="loading-review" class="hidden">
                <div class="flex items-center justify-center py-12">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-purple-600"></div>
                    <span class="ml-3 text-gray-600">Memuat laporan...</span>
                </div>
            </div>

            <!-- Tabel Laporan Menunggu Review -->
            <div id="review-container" class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Laporan Menunggu Review</h2>
                    <p class="text-sm text-gray-600 mt-1">Daftar laporan penilaian dari Kasi yang perlu ditinjau</p>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kasi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Staff</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Submit</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="review-table-body" class="bg-white divide-y divide-gray-200">
                            <!-- Data dari JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tab Content: Riwayat Review -->
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
                            <select id="tahun-riwayat-select" onchange="loadRiwayat()" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                <option value="2023">2023</option>
                                <option value="2024" selected>2024</option>
                                <option value="2025">2025</option>
                            </select>
                        </div>
                        
                        <!-- Triwulan Riwayat -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Triwulan</label>
                            <select id="triwulan-riwayat-select" onchange="loadRiwayat()" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                <option value="I">Triwulan I</option>
                                <option value="II">Triwulan II</option>
                                <option value="III">Triwulan III</option>
                                <option value="IV" selected>Triwulan IV</option>
                            </select>
                        </div>
                        
                        <!-- Tombol Refresh Riwayat -->
                        <div>
                            <button onclick="loadRiwayat()" class="w-full px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 flex items-center justify-center gap-2">
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
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-purple-600"></div>
                    <span class="ml-3 text-gray-600">Memuat riwayat...</span>
                </div>
            </div>

            <!-- Tabel Riwayat -->
            <div id="riwayat-container" class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Riwayat Review</h2>
                    <p class="text-sm text-gray-600 mt-1">Daftar laporan yang telah direview</p>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kasi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Staff</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Review</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Komentar</th>
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

<!-- Modal Review -->
<div id="review-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Review Laporan Penilaian</h3>
                <button onclick="closeReviewModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div id="modal-content">
                <!-- Content will be loaded here -->
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
    border-color: #9333ea;
    color: #7c3aed;
}

.tab-content {
    transition: all 0.3s ease;
}

.status-badge {
    display: inline-block;
    padding: 0.25rem 0.5rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
    transition: all 0.2s;
}

.status-badge.yellow {
    background-color: #fef3c7;
    color: #92400e;
}

.status-badge.green {
    background-color: #d1fae5;
    color: #065f46;
}

.status-badge.red {
    background-color: #fee2e2;
    color: #991b1b;
}

.status-badge.purple {
    background-color: #f3e8ff;
    color: #7c3aed;
}

.comment-input {
    width: 100%;
    min-height: 100px;
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    resize: vertical;
    transition: border-color 0.2s;
}

.comment-input:focus {
    outline: none;
    border-color: #9333ea;
    ring: 2px;
    ring-color: #9333ea;
}

@media (min-width: 640px) {
    .btn {
        margin: 0.125rem;
    }
}
</style>

<script>
let currentTab = 'review';
let currentLaporanId = null;

// Tab switching function
function switchTab(tabName) {
    currentTab = tabName;
    
    // Update tab buttons
    document.querySelectorAll('.tab-button').forEach(btn => {
        btn.classList.remove('active');
    });
    
    if (tabName === 'review') {
        document.getElementById('tab-review').classList.add('active');
        document.getElementById('content-review').classList.remove('hidden');
        document.getElementById('content-riwayat').classList.add('hidden');
        loadLaporanMenunggu();
    } else {
        document.getElementById('tab-riwayat').classList.add('active');
        document.getElementById('content-review').classList.add('hidden');
        document.getElementById('content-riwayat').classList.remove('hidden');
        loadRiwayat();
    }
}

// Load laporan menunggu review
function loadLaporanMenunggu() {
    document.getElementById('loading-review').classList.remove('hidden');
    document.getElementById('review-container').classList.add('hidden');
    
    // Simulate API call
    setTimeout(() => {
        const laporanMenunggu = [
            {
                id: 1,
                kasi_name: 'Kasi Bimas Islam',
                periode: '2025 - Triwulan I',
                jumlah_staff: 8,
                tanggal_submit: '2025-01-15',
                status: 'Menunggu Review'
            },
            {
                id: 2,
                kasi_name: 'Kasi Pendidikan Madrasah',
                periode: '2025 - Triwulan I',
                jumlah_staff: 12,
                tanggal_submit: '2025-01-14',
                status: 'Menunggu Review'
            },
            {
                id: 3,
                kasi_name: 'Kasi Penyelenggara Haji',
                periode: '2025 - Triwulan I',
                jumlah_staff: 6,
                tanggal_submit: '2025-01-13',
                status: 'Menunggu Review'
            }
        ];
        
        renderReviewTable(laporanMenunggu);
        document.getElementById('loading-review').classList.add('hidden');
        document.getElementById('review-container').classList.remove('hidden');
    }, 800);
}

// Render Review Table
function renderReviewTable(laporanData) {
    const tbody = document.getElementById('review-table-body');
    if (!tbody) return;
    
    tbody.innerHTML = '';

    if (laporanData.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="mt-2">Tidak ada laporan yang menunggu review</p>
                </td>
            </tr>
        `;
        return;
    }

    laporanData.forEach((laporan, index) => {
        tbody.innerHTML += `
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${index + 1}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-8 w-8">
                            <div class="h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center">
                                <span class="text-sm font-medium text-purple-600">${laporan.kasi_name.charAt(0)}</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">${laporan.kasi_name}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${laporan.periode}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${laporan.jumlah_staff} staff</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${laporan.tanggal_submit}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="status-badge yellow">${laporan.status}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <button onclick="openReviewModal(${laporan.id})" class="text-purple-600 hover:text-purple-900 bg-purple-100 hover:bg-purple-200 px-3 py-1 rounded-md transition-colors duration-200">
                        Review
                    </button>
                </td>
            </tr>
        `;
    });
}

// Load riwayat function
function loadRiwayat() {
    document.getElementById('loading-riwayat').classList.remove('hidden');
    document.getElementById('riwayat-container').classList.add('hidden');
    
    setTimeout(() => {
        const riwayatData = [
            {
                id: 1,
                kasi_name: 'Kasi Bimas Islam',
                periode: '2024 - Triwulan IV',
                jumlah_staff: 8,
                tanggal_review: '2024-12-20',
                status: 'Disetujui',
                komentar_kepala: 'Laporan penilaian sudah sesuai dengan standar yang ditetapkan.'
            },
            {
                id: 2,
                kasi_name: 'Kasi Pendidikan Madrasah',
                periode: '2024 - Triwulan IV',
                jumlah_staff: 12,
                tanggal_review: '2024-12-18',
                status: 'Disetujui',
                komentar_kepala: 'Penilaian dilakukan dengan objektif dan transparan.'
            },
            {
                id: 3,
                kasi_name: 'Kasi Penyelenggara Haji',
                periode: '2024 - Triwulan IV',
                jumlah_staff: 6,
                tanggal_review: '2024-12-15',
                status: 'Dikembalikan',
                komentar_kepala: 'Perlu perbaikan pada penilaian beberapa staff yang kurang objektif.'
            }
        ];
        
        renderRiwayatTable(riwayatData);
        document.getElementById('loading-riwayat').classList.add('hidden');
        document.getElementById('riwayat-container').classList.remove('hidden');
    }, 800);
}

// Render Riwayat Table
function renderRiwayatTable(riwayatData) {
    const tbody = document.getElementById('riwayat-table-body');
    if (!tbody) return;
    
    tbody.innerHTML = '';

    if (riwayatData.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="mt-2">Tidak ada data riwayat untuk periode ini</p>
                </td>
            </tr>
        `;
        return;
    }

    riwayatData.forEach((laporan, index) => {
        const statusClass = laporan.status === 'Disetujui' ? 'green' : 'red';
        
        tbody.innerHTML += `
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${index + 1}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-8 w-8">
                            <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                <span class="text-sm font-medium text-green-600">${laporan.kasi_name.charAt(0)}</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">${laporan.kasi_name}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${laporan.periode}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${laporan.jumlah_staff} staff</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${laporan.tanggal_review}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="status-badge ${statusClass}">${laporan.status}</span>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm text-gray-900 max-w-xs">
                        ${laporan.komentar_kepala || '-'}
                    </div>
                </td>
            </tr>
        `;
    });
}

// Open Review Modal
function openReviewModal(laporanId) {
    currentLaporanId = laporanId;
    
    // Load laporan detail (simulated)
    const laporanDetail = {
        id: laporanId,
        kasi_name: 'Kasi Bimas Islam',
        periode: '2025 - Triwulan I',
        jumlah_staff: 8,
        tanggal_submit: '2025-01-15',
        staff_list: [
            { id: 1, nama: 'Staff 1', penilaian: 3, komentar: 'Sangat baik dalam teamwork' },
            { id: 2, nama: 'Staff 2', penilaian: 2, komentar: 'Kinerja sesuai target' },
            { id: 3, nama: 'Staff 3', penilaian: 3, komentar: 'Melebihi ekspektasi' }
        ]
    };
    
    const modalContent = document.getElementById('modal-content');
    modalContent.innerHTML = `
        <div class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Kasi</label>
                    <p class="text-sm text-gray-900">${laporanDetail.kasi_name}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Periode</label>
                    <p class="text-sm text-gray-900">${laporanDetail.periode}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Jumlah Staff</label>
                    <p class="text-sm text-gray-900">${laporanDetail.jumlah_staff} staff</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Submit</label>
                    <p class="text-sm text-gray-900">${laporanDetail.tanggal_submit}</p>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Detail Penilaian Staff</label>
                <div class="bg-gray-50 rounded-lg p-4 max-h-60 overflow-y-auto">
                    ${laporanDetail.staff_list.map(staff => `
                        <div class="flex justify-between items-center py-2 border-b border-gray-200 last:border-b-0">
                            <div>
                                <p class="text-sm font-medium text-gray-900">${staff.nama}</p>
                                <p class="text-xs text-gray-500">${staff.komentar}</p>
                            </div>
                            <span class="status-badge ${staff.penilaian === 3 ? 'green' : staff.penilaian === 2 ? 'purple' : 'red'}">
                                ${staff.penilaian === 3 ? '🌟 Melebihi' : staff.penilaian === 2 ? '👍 Sesuai' : '👎 Di Bawah'}
                            </span>
                        </div>
                    `).join('')}
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Komentar Kepala</label>
                <textarea id="komentar-kepala" class="comment-input" placeholder="Tulis komentar review..."></textarea>
            </div>
            
            <div class="flex justify-end space-x-3 pt-4">
                <button onclick="closeReviewModal()" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    Batal
                </button>
                <button onclick="approveLaporan('dikembalikan')" class="px-4 py-2 bg-red-600 text-white rounded-md text-sm font-medium hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Kembalikan
                </button>
                <button onclick="approveLaporan('disetujui')" class="px-4 py-2 bg-green-600 text-white rounded-md text-sm font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Setujui
                </button>
            </div>
        </div>
    `;
    
    document.getElementById('review-modal').classList.remove('hidden');
}

// Close Review Modal
function closeReviewModal() {
    document.getElementById('review-modal').classList.add('hidden');
    currentLaporanId = null;
}

// Approve Laporan
function approveLaporan(status) {
    const komentar = document.getElementById('komentar-kepala').value;
    
    if (!komentar.trim()) {
        alert('Harap isi komentar review');
        return;
    }
    
    // Show loading state
    const buttons = document.querySelectorAll('#modal-content button');
    buttons.forEach(btn => btn.disabled = true);
    
    // Simulate API call
    setTimeout(() => {
        console.log('=== REVIEW LAPORAN ===', {
            laporan_id: currentLaporanId,
            status: status,
            komentar: komentar
        });
        
        // Close modal
        closeReviewModal();
        
        // Show success message
        const message = status === 'disetujui' ? 'Laporan berhasil disetujui' : 'Laporan dikembalikan untuk perbaikan';
        alert(message);
        
        // Reload data
        if (currentTab === 'review') {
            loadLaporanMenunggu();
        } else {
            loadRiwayat();
        }
    }, 1000);
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('Kepala Penilaian page loaded');
    loadLaporanMenunggu();
});

// Close modal when clicking outside
document.getElementById('review-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeReviewModal();
    }
});
</script>
@endsection 