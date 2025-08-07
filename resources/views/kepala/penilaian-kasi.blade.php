@extends('layouts.kepala')

@section('content')
<div class="p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Penilaian Kasi</h1>
            <p class="text-gray-600">Berikan penilaian kinerja kepada Kasi berdasarkan periode tertentu</p>
        </div>

        <!-- Filter -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <form method="GET" action="{{ route('kepala.penilaian-kasi') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Daftar Kasi untuk Dinilai -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Daftar Kasi - Periode {{ $triwulan }} {{ $tahun }}</h3>
            </div>
            <div class="p-6">
                @if(count($statistikKasi) > 0)
                    <div class="space-y-6">
                        @foreach($statistikKasi as $stat)
                            <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center">
                                            <span class="text-white font-semibold">{{ strtoupper(substr($stat['kasi']->name, 0, 1)) }}</span>
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="text-lg font-medium text-gray-900">{{ $stat['kasi']->name }}</h4>
                                            <p class="text-sm text-gray-500">{{ $stat['kasi']->jabatan }}</p>
                                            <p class="text-xs text-gray-400">NIP: {{ $stat['kasi']->nip }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="text-right">
                                        @if($stat['sudah_dinilai'])
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Sudah Dinilai
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Belum Dinilai
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Statistik Kasi -->
                                <div class="grid grid-cols-3 gap-4 mb-6">
                                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                                        <p class="text-2xl font-bold text-gray-900">{{ $stat['total_staff'] }}</p>
                                        <p class="text-sm text-gray-500">Total Staff</p>
                                    </div>
                                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                                        <p class="text-2xl font-bold text-gray-900">{{ $stat['total_penilaian_staff'] }}</p>
                                        <p class="text-sm text-gray-500">Penilaian Staff</p>
                                    </div>
                                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                                        <div class="flex items-center justify-center mb-1">
                                            @for($i = 1; $i <= 3; $i++)
                                                @if($i <= round($stat['rata_rata_staff']))
                                                    <span class="text-yellow-500 text-sm">⭐</span>
                                                @else
                                                    <span class="text-gray-300 text-sm">☆</span>
                                                @endif
                                            @endfor
                                        </div>
                                        <p class="text-lg font-bold text-gray-900">{{ $stat['rata_rata_staff'] }}</p>
                                        <p class="text-sm text-gray-500">Rata-rata Staff</p>
                                    </div>
                                </div>

                                <!-- Form Penilaian atau Tampilan Penilaian -->
                                @if($stat['sudah_dinilai'])
                                    <!-- Tampilkan penilaian yang sudah ada -->
                                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                        <div class="flex items-center justify-between mb-3">
                                            <h5 class="text-sm font-medium text-green-800">Penilaian yang Sudah Diberikan</h5>
                                            <div class="flex items-center">
                                                @for($i = 1; $i <= 3; $i++)
                                                    @if($i <= $stat['penilaian']->rating)
                                                        <span class="text-yellow-500">⭐</span>
                                                    @else
                                                        <span class="text-gray-300">☆</span>
                                                    @endif
                                                @endfor
                                                <span class="ml-2 text-sm font-medium text-green-800">{{ $stat['penilaian']->rating_label }}</span>
                                            </div>
                                        </div>
                                        <p class="text-sm text-green-700">{{ $stat['penilaian']->komentar }}</p>
                                        <p class="text-xs text-green-600 mt-2">Dinilai pada: {{ $stat['penilaian']->created_at->format('d/m/Y H:i') }}</p>
                                        
                                        <!-- Tombol Edit -->
                                        <button onclick="openEditModal('{{ $stat['kasi']->id }}', '{{ $stat['kasi']->name }}', '{{ $stat['penilaian']->rating }}', '{{ $stat['penilaian']->komentar }}')" 
                                                class="mt-3 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors duration-200 text-sm">
                                            Edit Penilaian
                                        </button>
                                    </div>
                                @else
                                    <!-- Form untuk memberikan penilaian -->
                                    <form method="POST" action="{{ route('kepala.penilaian-kasi.simpan') }}" class="space-y-4">
                                        @csrf
                                        <input type="hidden" name="kasi_id" value="{{ $stat['kasi']->id }}">
                                        <input type="hidden" name="tahun" value="{{ $tahun }}">
                                        <input type="hidden" name="triwulan" value="{{ $triwulan }}">
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                                            <div class="flex items-center space-x-4">
                                                <label class="flex items-center">
                                                    <input type="radio" name="rating" value="1" class="mr-2" required>
                                                    <span class="text-sm">1 ⭐ Di Bawah Ekspektasi</span>
                                                </label>
                                                <label class="flex items-center">
                                                    <input type="radio" name="rating" value="2" class="mr-2" required>
                                                    <span class="text-sm">2 ⭐⭐ Sesuai Ekspektasi</span>
                                                </label>
                                                <label class="flex items-center">
                                                    <input type="radio" name="rating" value="3" class="mr-2" required>
                                                    <span class="text-sm">3 ⭐⭐⭐ Melebihi Ekspektasi</span>
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label for="komentar_{{ $stat['kasi']->id }}" class="block text-sm font-medium text-gray-700 mb-2">Komentar</label>
                                            <textarea id="komentar_{{ $stat['kasi']->id }}" 
                                                      name="komentar" 
                                                      rows="3" 
                                                      class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500" 
                                                      placeholder="Berikan komentar penilaian untuk {{ $stat['kasi']->name }}..." 
                                                      required></textarea>
                                        </div>
                                        
                                        <div class="flex justify-end">
                                            <button type="submit" 
                                                    class="px-6 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-200">
                                                Simpan Penilaian
                                            </button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada Kasi</h3>
                        <p class="mt-1 text-sm text-gray-500">Belum ada data Kasi yang tersedia untuk dinilai.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Penilaian -->
<div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Penilaian Kasi</h3>
            <form method="POST" action="{{ route('kepala.penilaian-kasi.simpan') }}" id="editForm">
                @csrf
                <input type="hidden" name="kasi_id" id="edit_kasi_id">
                <input type="hidden" name="tahun" value="{{ $tahun }}">
                <input type="hidden" name="triwulan" value="{{ $triwulan }}">
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="radio" name="rating" value="1" class="mr-2" required>
                            <span class="text-sm">1 ⭐ Di Bawah Ekspektasi</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="rating" value="2" class="mr-2" required>
                            <span class="text-sm">2 ⭐⭐ Sesuai Ekspektasi</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="rating" value="3" class="mr-2" required>
                            <span class="text-sm">3 ⭐⭐⭐ Melebihi Ekspektasi</span>
                        </label>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="edit_komentar" class="block text-sm font-medium text-gray-700 mb-2">Komentar</label>
                    <textarea id="edit_komentar" 
                              name="komentar" 
                              rows="3" 
                              class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500" 
                              required></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" 
                            onclick="closeEditModal()" 
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors duration-200">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition-colors duration-200">
                        Update Penilaian
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openEditModal(kasiId, kasiName, rating, komentar) {
    document.getElementById('edit_kasi_id').value = kasiId;
    document.getElementById('edit_komentar').value = komentar;
    
    // Set radio button
    document.querySelector(`input[name="rating"][value="${rating}"]`).checked = true;
    
    document.getElementById('editModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});
</script>
@endsection 