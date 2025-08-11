{{-- ALUR: Halaman ini adalah halaman penilaian staff untuk role KASI --}}
{{-- ALUR: Menggunakan layout KASI sebagai template utama --}}
@extends('layouts.kasi')

{{-- ALUR: Section content akan diisi dengan konten halaman penilaian --}}
@section('content')

{{-- ALUR: Mendefinisikan array rating text untuk dropdown rating --}}
{{-- ALUR: Rating 1-3 dengan deskripsi yang mudah dipahami --}}
@php
    $ratingText = [
        1 => 'Di Bawah Ekspektasi',    {{-- Rating terendah --}}
        2 => 'Sesuai Ekspektasi',       {{-- Rating standar --}}
        3 => 'Melebihi Ekspektasi'      {{-- Rating tertinggi --}}
    ];
@endphp

{{-- ALUR: Container utama halaman dengan padding dan max width --}}
<div class="p-6">
    <div class="max-w-7xl mx-auto">
        
        {{-- ALUR: Header halaman dengan judul dan deskripsi --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Penilaian Staff</h1>
            <p class="text-gray-600">Berikan penilaian kinerja kepada Staff berdasarkan periode tertentu</p>
        </div>

        {{-- ALUR: Filter periode untuk memilih tahun dan triwulan --}}
        {{-- ALUR: Data akan difilter berdasarkan periode yang dipilih --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Filter Periode</h3>
            </div>
            <div class="p-6">
                {{-- ALUR: Grid layout untuk filter tahun, triwulan, dan tombol --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                    
                    {{-- ALUR: Filter tahun - generate tahun dari 2 tahun lalu sampai sekarang --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                        {{-- ALUR: onchange akan trigger function loadData() untuk reload data --}}
                        <select id="tahun-select" onchange="loadData()" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            @php
                                {{-- ALUR: Generate tahun untuk dropdown --}}
                                $currentYear = date('Y');           {{-- Tahun sekarang --}}
                                $startYear = $currentYear - 2;      {{-- 2 tahun lalu --}}
                            @endphp
                            {{-- ALUR: Loop untuk generate option tahun --}}
                            @for($year = $startYear; $year <= $currentYear; $year++)
                                {{-- ALUR: Set tahun sekarang sebagai default selected --}}
                                <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                    
                    {{-- ALUR: Filter triwulan - pilihan I, II, III, IV --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Triwulan</label>
                        {{-- ALUR: onchange akan trigger function loadData() untuk reload data --}}
                        <select id="triwulan-select" onchange="loadData()" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            @php
                                {{-- ALUR: Hitung triwulan sekarang berdasarkan bulan --}}
                                $currentQuarter = ceil(date('n') / 3);
                                {{-- ALUR: Array mapping triwulan dengan label --}}
                                $quarters = [
                                    1 => ['I', 'Triwulan I'],      {{-- Jan-Mar --}}
                                    2 => ['II', 'Triwulan II'],     {{-- Apr-Jun --}}
                                    3 => ['III', 'Triwulan III'],   {{-- Jul-Sep --}}
                                    4 => ['IV', 'Triwulan IV']      {{-- Oct-Dec --}}
                                ];
                            @endphp
                            {{-- ALUR: Loop untuk generate option triwulan --}}
                            @foreach($quarters as $num => $quarter)
                                {{-- ALUR: Set triwulan sekarang sebagai default selected --}}
                                <option value="{{ $quarter[0] }}" {{ $num == $currentQuarter ? 'selected' : '' }}>{{ $quarter[1] }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    {{-- ALUR: Tombol filter untuk reload data dengan periode yang dipilih --}}
                    <div>
                        {{-- ALUR: onclick akan trigger function loadData() --}}
                        <button onclick="loadData()" class="w-full px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 flex items-center justify-center gap-2">
                            {{-- ALUR: Icon search untuk tombol filter --}}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Filter
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ALUR: Loading state - ditampilkan saat memuat data --}}
        {{-- ALUR: Awalnya hidden, akan ditampilkan saat loadData() dipanggil --}}
        <div id="loading-state" class="hidden">
            <div class="flex items-center justify-center py-12">
                {{-- ALUR: Spinner animation untuk loading --}}
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-purple-600"></div>
                <span class="ml-3 text-gray-600">Memuat data...</span>
            </div>
        </div>

        {{-- ALUR: Error state - ditampilkan jika terjadi error --}}
        {{-- ALUR: Awalnya hidden, akan ditampilkan jika ada error --}}
        <div id="error-state" class="hidden">
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-center">
                    {{-- ALUR: Icon error untuk error state --}}
                    <svg class="w-5 h-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-red-800">Terjadi kesalahan saat memuat data</span>
                </div>
                {{-- ALUR: Tombol retry untuk coba lagi --}}
                <button onclick="loadData()" class="mt-2 text-sm text-red-600 underline hover:text-red-800">Coba lagi</button>
            </div>
        </div>

        {{-- ALUR: Container untuk tabel daftar staff --}}
        {{-- ALUR: Akan ditampilkan setelah data berhasil dimuat --}}
        <div id="table-container">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    {{-- ALUR: Judul tabel dengan periode yang aktif --}}
                    <h2 class="text-lg font-semibold text-gray-900">Daftar Staff - Periode <span id="periode-display">Aktif</span></h2>
                </div>
                
                {{-- ALUR: Tabel dengan scroll horizontal untuk responsive --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        {{-- ALUR: Header tabel dengan kolom-kolom --}}
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
                        
                        {{-- ALUR: Body tabel dengan data staff --}}
                        <tbody class="bg-white divide-y divide-gray-200">
                            {{-- ALUR: Loop untuk setiap staff yang ada --}}
                            @forelse($staffList as $staff)
                                {{-- ALUR: Row untuk setiap staff dengan ID unik --}}
                                <tr id="staff-row-{{ $staff->id }}">
                                    
                                    {{-- ALUR: Kolom nama staff dengan avatar dan nama --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{-- ALUR: Avatar dengan inisial nama staff --}}
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-purple-500 flex items-center justify-center">
                                                    {{-- ALUR: Ambil huruf pertama dari nama staff --}}
                                                    <span class="text-lg font-medium text-white">{{ substr($staff->name, 0, 1) }}</span>
                                                </div>
                                            </div>
                                            {{-- ALUR: Nama lengkap staff --}}
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $staff->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    {{-- ALUR: Kolom NIP staff --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $staff->nip }}</td>
                                    
                                    {{-- ALUR: Kolom jabatan staff --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $staff->jabatan }}</td>
                                    
                                    {{-- ALUR: Kolom email staff --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $staff->email }}</td>
                                    
                                    {{-- ALUR: Kolom rating dengan dropdown --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{-- ALUR: Dropdown rating dengan data existing --}}
                                        <select name="rating" class="rating-select w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200" data-staff-id="{{ $staff->id }}">
                                            <option value="">Pilih Rating</option>
                                            {{-- ALUR: Loop untuk setiap rating option --}}
                                            @foreach($ratingText as $value => $text)
                                                {{-- ALUR: Set selected jika sudah ada rating sebelumnya --}}
                                                <option value="{{ $value }}" {{ isset($penilaian[$staff->id]) && $penilaian[$staff->id]->rating == $value ? 'selected' : '' }}>
                                                    {{ $text }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    
                                    {{-- ALUR: Kolom komentar dengan textarea --}}
                                    <td class="px-6 py-4">
                                        {{-- ALUR: Textarea untuk komentar dengan data existing --}}
                                        <textarea name="komentar" rows="2" class="komentar-input w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200" data-staff-id="{{ $staff->id }}" placeholder="Berikan komentar penilaian...">{{ isset($penilaian[$staff->id]) ? $penilaian[$staff->id]->komentar : '' }}</textarea>
                                    </td>
                                    
                                    {{-- ALUR: Kolom aksi dengan tombol simpan --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        {{-- ALUR: Tombol simpan dengan onclick ke function simpanPenilaian --}}
                                        <button onclick="simpanPenilaian({{ $staff->id }})" class="simpan-btn text-purple-600 hover:text-purple-900 focus:outline-none">
                                            Simpan
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                {{-- ALUR: Tampilkan jika tidak ada staff yang ditugaskan --}}
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

{{-- ALUR: JavaScript untuk interaktivitas halaman --}}
<script>

{{-- ALUR: Function untuk memuat data berdasarkan filter periode --}}
{{-- ALUR: Dipanggil saat filter berubah atau tombol filter diklik --}}
function loadData() {
    showLoading();           {{-- Tampilkan loading state --}}
    updatePeriodeDisplay();  {{-- Update tampilan periode --}}
    
    {{-- ALUR: Ambil nilai filter yang dipilih --}}
    const tahun = document.getElementById('tahun-select').value;
    const triwulan = document.getElementById('triwulan-select').value;
    
    {{-- ALUR: Reload halaman dengan parameter filter baru --}}
    window.location.href = `/kasi/penilaian?tahun=${tahun}&triwulan=${triwulan}`;
}

{{-- ALUR: Function untuk update tampilan periode di judul tabel --}}
{{-- ALUR: Dipanggil saat halaman load atau filter berubah --}}
function updatePeriodeDisplay() {
    const tahun = document.getElementById('tahun-select').value;
    const triwulan = document.getElementById('triwulan-select').value;
    
    {{-- ALUR: Update text periode di judul tabel --}}
    const periodeDisplay = document.getElementById('periode-display');
    if (periodeDisplay) {
        periodeDisplay.textContent = `${triwulan} ${tahun}`;
    }
}

{{-- ALUR: Function untuk menampilkan loading state --}}
{{-- ALUR: Sembunyikan tabel dan tampilkan loading --}}
function showLoading() {
    document.getElementById('loading-state').classList.remove('hidden');
    document.getElementById('error-state').classList.add('hidden');
    document.getElementById('table-container').classList.add('hidden');
}

{{-- ALUR: Function untuk menyembunyikan loading state --}}
{{-- ALUR: Tampilkan tabel dan sembunyikan loading/error --}}
function hideLoading() {
    document.getElementById('loading-state').classList.add('hidden');
    document.getElementById('error-state').classList.add('hidden');
    document.getElementById('table-container').classList.remove('hidden');
}

{{-- ALUR: Function untuk menampilkan error state --}}
{{-- ALUR: Sembunyikan loading dan tabel, tampilkan error --}}
function showError() {
    document.getElementById('loading-state').classList.add('hidden');
    document.getElementById('error-state').classList.remove('hidden');
    document.getElementById('table-container').classList.add('hidden');
}

{{-- ALUR: Function utama untuk menyimpan penilaian staff --}}
{{-- ALUR: Dipanggil saat tombol simpan diklik --}}
function simpanPenilaian(staffId) {
    {{-- ALUR: Ambil element row staff berdasarkan ID --}}
    const row = document.getElementById(`staff-row-${staffId}`);
    const ratingSelect = row.querySelector('.rating-select');
    const komentarInput = row.querySelector('.komentar-input');
    const simpanBtn = row.querySelector('.simpan-btn');
    
    {{-- ALUR: Validasi input - rating harus dipilih --}}
    if (!ratingSelect.value) {
        alert('Silakan pilih rating terlebih dahulu');
        return;
    }

    {{-- ALUR: Validasi input - komentar harus diisi --}}
    if (!komentarInput.value.trim()) {
        alert('Silakan berikan komentar terlebih dahulu');
        return;
    }
    
    {{-- ALUR: Tampilkan loading state pada tombol --}}
    const originalText = simpanBtn.textContent;
    simpanBtn.textContent = 'Menyimpan...';
    simpanBtn.disabled = true;
    
    {{-- ALUR: Ambil periode yang aktif untuk data --}}
    const tahun = document.getElementById('tahun-select').value;
    const triwulan = document.getElementById('triwulan-select').value;
    
    {{-- ALUR: Kirim data ke server menggunakan AJAX --}}
    fetch('/kasi/penilaian/simpan', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            staff_id: staffId,        {{-- ID staff yang dinilai --}}
            rating: ratingSelect.value,    {{-- Rating yang dipilih --}}
            komentar: komentarInput.value, {{-- Komentar yang ditulis --}}
            tahun: tahun,             {{-- Tahun periode --}}
            triwulan: triwulan       {{-- Triwulan periode --}}
        })
    })
    .then(response => response.json())  {{-- Parse response JSON --}}
    .then(data => {
        if (data.success) {
            {{-- ALUR: Jika berhasil, tampilkan pesan sukses --}}
            alert('Penilaian berhasil disimpan');
            
            {{-- ALUR: Reload data untuk update tampilan --}}
            loadData();
        } else {
            {{-- ALUR: Jika gagal, throw error --}}
            throw new Error(data.message || 'Terjadi kesalahan saat menyimpan penilaian');
        }
    })
    .catch(error => {
        {{-- ALUR: Handle error dan tampilkan pesan --}}
        console.error('Error saving penilaian:', error);
        alert(error.message || 'Terjadi kesalahan saat menyimpan penilaian. Silakan coba lagi.');
        
        {{-- ALUR: Reset tombol ke state awal --}}
        simpanBtn.textContent = originalText;
        simpanBtn.disabled = false;
    });
}

{{-- ALUR: Event listener saat DOM sudah siap --}}
{{-- ALUR: Dipanggil sekali saat halaman pertama kali load --}}
document.addEventListener('DOMContentLoaded', function() {
    console.log('Penilaian page loaded');  {{-- Log untuk debugging --}}
    updatePeriodeDisplay();                {{-- Update tampilan periode --}}
});

</script>

{{-- ALUR: End section content --}}
@endsection 