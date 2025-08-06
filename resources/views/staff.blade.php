@php
    $years = [2023, 2024, 2025];
    $quarters = ['I', 'II', 'III', 'IV'];
    $staffs = ['Andi', 'Budi', 'Citra', 'Dewi'];
    $tasks = [
        ['id' => 1, 'name' => 'Menyusun laporan bulanan', 'target_kuantitas' => 1, 'target_waktu' => 30],
        ['id' => 2, 'name' => 'Membuat presentasi kinerja', 'target_kuantitas' => 2, 'target_waktu' => 10],
        ['id' => 3, 'name' => 'Mengelola dokumen proyek', 'target_kuantitas' => 5, 'target_waktu' => 20],
    ];
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realisasi Kinerja Staf (Collab)</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        body { font-family: theme('fontFamily.sans'); }
        .badge { @apply inline-block px-2 py-0.5 rounded-full text-xs font-semibold align-middle; }
        .badge-draft { @apply bg-yellow-100 text-yellow-800; }
        .badge-dikirim { @apply bg-blue-100 text-blue-800; }
        .badge-verif { @apply bg-green-100 text-green-800; }
        .badge-revisi { @apply bg-red-100 text-red-700; }
        .badge-belum { @apply bg-gray-100 text-gray-500; }
        .badge-tercapai { @apply bg-green-100 text-green-800; }
        .badge-tidak { @apply bg-red-100 text-red-700; }
        .sticky-header th { position: sticky; top: 0; background: #fafaff; z-index: 1; }
        .modal-bg { @apply fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50; }
        .modal-card { @apply bg-white rounded-xl shadow-xl p-6 w-full max-w-md relative; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <div id="app" class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="hidden md:flex flex-col w-56 bg-white border-r border-gray-100 shadow-lg py-8 px-4 space-y-2">
            <div class="mb-8 flex items-center gap-2">
                <span class="inline-block bg-indigo-600 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold text-lg">S</span>
                <span class="font-bold text-lg text-indigo-700">Staf Panel</span>
            </div>
            <nav class="flex-1 space-y-1">
                <button @click="menu = 'dashboard'" :class="menu==='dashboard' ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-700'" class="w-full flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-indigo-50 transition">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24"><path d="M3 13h2v-2H3v2zm4 0h2v-6H7v6zm4 0h2V7h-2v6zm4 0h2v-4h-2v4zm4 0h2v-8h-2v8z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    Dashboard
                </button>
                <button @click="menu = 'kinerja'" :class="menu==='kinerja' ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-700'" class="w-full flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-indigo-50 transition">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24"><path d="M4 4h16v16H4V4zm4 4v8m4-8v8m4-8v8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    Kinerja Saya
                </button>
                <button @click="menu = 'komentar'" :class="menu==='komentar' ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-700'" class="w-full flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-indigo-50 transition">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24"><path d="M8 10h8M8 14h5M21 12c0 4.418-4.03 8-9 8a9.77 9.77 0 0 1-4-.8L3 20l.8-3.2A7.5 7.5 0 0 1 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Komentar
                </button>
                <button @click="menu = 'profil'" :class="menu==='profil' ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-700'" class="w-full flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-indigo-50 transition">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="2"/><path d="M4 20v-2a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4v2" stroke="currentColor" stroke-width="2"/></svg>
                    Profil
                </button>
            </nav>
        </aside>
        <!-- Sidebar mobile (optional, simple) -->
        <aside class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 shadow-lg flex justify-around py-2 z-40">
            <button @click="menu = 'dashboard'" :class="menu==='dashboard' ? 'text-indigo-700' : 'text-gray-500'" class="flex flex-col items-center text-xs">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24"><path d="M3 13h2v-2H3v2zm4 0h2v-6H7v6zm4 0h2V7h-2v6zm4 0h2v-4h-2v4zm4 0h2v-8h-2v8z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                Dashboard
            </button>
            <button @click="menu = 'kinerja'" :class="menu==='kinerja' ? 'text-indigo-700' : 'text-gray-500'" class="flex flex-col items-center text-xs">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24"><path d="M4 4h16v16H4V4zm4 4v8m4-8v8m4-8v8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                Kinerja
            </button>
            <button @click="menu = 'komentar'" :class="menu==='komentar' ? 'text-indigo-700' : 'text-gray-500'" class="flex flex-col items-center text-xs">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24"><path d="M8 10h8M8 14h5M21 12c0 4.418-4.03 8-9 8a9.77 9.77 0 0 1-4-.8L3 20l.8-3.2A7.5 7.5 0 0 1 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Komentar
            </button>
            <button @click="menu = 'profil'" :class="menu==='profil' ? 'text-indigo-700' : 'text-gray-500'" class="flex flex-col items-center text-xs">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="2"/><path d="M4 20v-2a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4v2" stroke="currentColor" stroke-width="2"/></svg>
                Profil
            </button>
        </aside>
        <!-- Main Content -->
        <main class="flex-1 min-h-screen bg-gray-50 py-8 px-2 md:px-8">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div v-if="menu==='dashboard'" class="max-w-3xl mx-auto">
                <h2 class="text-xl font-bold text-indigo-700 mb-4">Dashboard</h2>
                <div class="bg-white rounded-xl shadow p-6 text-gray-600">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Selamat Datang!</h3>
                            <p class="text-sm text-gray-500">{{ session('staff_name', 'Staff') }}</p>
                        </div>
                    </div>
                    <p>Selamat datang di dashboard staf. Pilih menu di samping untuk mulai mengisi kinerja.</p>
                </div>
            </div>
            <div v-if="menu==='kinerja'" class="max-w-3xl mx-auto">
                <h2 class="text-xl font-bold text-indigo-700 mb-4">Kinerja Saya</h2>
                <!-- Dropdown Tahun & Triwulan -->
                <div class="flex flex-col md:flex-row gap-4 mb-6 justify-center">
                    <div class="w-full md:w-1/2">
                        <label class="block mb-1 font-semibold text-gray-700">Tahun</label>
                        <select v-model="selectedYear" class="border border-gray-200 rounded px-3 py-2 w-full focus:ring-2 focus:ring-indigo-200 focus:outline-none bg-white text-gray-800">
                            <option value="" disabled>Pilih Tahun</option>
                            <option v-for="year in years" :key="year" :value="year">@{{ year }}</option>
                        </select>
                    </div>
                    <div class="w-full md:w-1/2">
                        <label class="block mb-1 font-semibold text-gray-700">Triwulan</label>
                        <select v-model="selectedQuarter" class="border border-gray-200 rounded px-3 py-2 w-full focus:ring-2 focus:ring-indigo-200 focus:outline-none bg-white text-gray-800">
                            <option value="" disabled>Pilih Triwulan</option>
                            <option v-for="q in quarters" :key="q" :value="q">Triwulan @{{ q }}</option>
                        </select>
                    </div>
                </div>
                <!-- Checklist & Tabel Realisasi Kinerja (Hybrid) -->
                <div v-if="menu==='kinerja' && selectedYear && selectedQuarter" class="mb-8">
                    <!-- Checklist Daftar Tugas -->
                    <div v-if="!getHybrid().lanjutChecklist" class="mb-8">
                        <h2 class="text-xl font-bold mb-6" style="color:#5B21B6">Pilih Tugas yang Akan Diisi (Tabel)</h2>
                        <form @submit.prevent="getHybrid().lanjutChecklist = true">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <label v-for="task in tasks" :key="task.id" class="flex items-center gap-3 bg-gray-50 rounded-xl px-5 py-4 shadow border border-gray-100 cursor-pointer transition-all hover:shadow-lg">
                                    <input type="checkbox" v-model="getHybrid().tugasDipilih" :value="task.id" class="accent-[#5B21B6] w-5 h-5 transition-all">
                                    <span class="font-medium text-gray-700 text-base">@{{ task.name }}</span>
                                </label>
                            </div>
                            <button type="submit" :disabled="getHybrid().tugasDipilih.length === 0" class="flex items-center gap-2 px-7 py-2.5 rounded-lg font-semibold text-white bg-[#5B21B6] hover:bg-[#5B21B6]/90 transition-all disabled:bg-gray-300 disabled:cursor-not-allowed text-base">
                                <!-- Heroicon: ArrowRight -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                                Lanjut
                            </button>
                        </form>
                    </div>
                    <!-- Tabel Realisasi Kinerja -->
                    <div v-else class="mt-4">
                        <h2 class="text-xl font-bold mb-6" style="color:#5B21B6">Tabel Realisasi Kinerja</h2>
                        <div class="overflow-x-auto rounded-2xl border border-gray-100 shadow-lg">
                            <table class="min-w-full bg-white rounded-xl text-sm overflow-hidden">
                                <thead class="sticky-header">
                                    <tr class="bg-[#f3f0fa] text-[#5B21B6] text-base">
                                        <th class="px-4 py-3 border-b font-semibold">No</th>
                                        <th class="px-4 py-3 border-b font-semibold">Nama Tugas</th>
                                        <th class="px-4 py-3 border-b font-semibold">Target Kuantitas</th>
                                        <th class="px-4 py-3 border-b font-semibold">Realisasi Kuantitas</th>
                                        <th class="px-4 py-3 border-b font-semibold">Target Waktu (hari)</th>
                                        <th class="px-4 py-3 border-b font-semibold">Realisasi Waktu</th>
                                        <th class="px-4 py-3 border-b font-semibold">Kualitas (%)</th>
                                        <th class="px-4 py-3 border-b font-semibold">Link Bukti</th>
                                        <th class="px-4 py-3 border-b font-semibold">Status</th>
                                        <th class="px-4 py-3 border-b font-semibold">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(id, idx) in getHybrid().tugasDipilih" :key="id" class="even:bg-gray-50 hover:bg-indigo-50/30 transition-all">
                                        <td class="px-4 py-3 border-b text-center font-semibold">@{{ idx+1 }}</td>
                                        <td class="px-4 py-3 border-b">@{{ getTask(id).name }}</td>
                                        <td class="px-4 py-3 border-b text-center">@{{ getTask(id).target_kuantitas }}</td>
                                        <td class="px-4 py-3 border-b text-center">
                                            <input type="number" min="0" v-model.number="getHybrid().formTabel[id].realisasi_kuantitas" :disabled="getHybrid().formTabel[id].kirim" class="border border-gray-200 rounded-lg px-3 py-2 w-24 text-center focus:ring-2 focus:ring-[#5B21B6] focus:outline-none transition-all hover:shadow disabled:bg-gray-100">
                                        </td>
                                        <td class="px-4 py-3 border-b text-center">@{{ getTask(id).target_waktu }}</td>
                                        <td class="px-4 py-3 border-b text-center">
                                            <input type="number" min="0" v-model.number="getHybrid().formTabel[id].realisasi_waktu" :disabled="getHybrid().formTabel[id].kirim" class="border border-gray-200 rounded-lg px-3 py-2 w-24 text-center focus:ring-2 focus:ring-[#5B21B6] focus:outline-none transition-all hover:shadow disabled:bg-gray-100">
                                        </td>
                                        <td class="px-4 py-3 border-b text-center">
                                            <input type="number" min="0" max="100" v-model.number="getHybrid().formTabel[id].kualitas" :disabled="getHybrid().formTabel[id].kirim" class="border border-gray-200 rounded-lg px-3 py-2 w-20 text-center focus:ring-2 focus:ring-[#5B21B6] focus:outline-none transition-all hover:shadow disabled:bg-gray-100">
                                        </td>
                                        <td class="px-4 py-3 border-b text-center">
                                            <input type="url" v-model="getHybrid().formTabel[id].bukti" :disabled="getHybrid().formTabel[id].kirim" class="border border-gray-200 rounded-lg px-3 py-2 w-40 focus:ring-2 focus:ring-[#5B21B6] focus:outline-none transition-all hover:shadow disabled:bg-gray-100" placeholder="https://...">
                                        </td>
                                        <td class="px-4 py-3 border-b text-center">
                                            <span v-if="getHybrid().formTabel[id].kirim && isTercapaiTabel(id)" class="badge badge-tercapai">Tercapai</span>
                                            <span v-else-if="getHybrid().formTabel[id].kirim && !isTercapaiTabel(id)" class="badge badge-revisi">Tidak</span>
                                            <span v-else-if="getHybrid().formTabel[id].draft" class="badge badge-draft">Draft</span>
                                            <span v-else-if="getHybrid().formTabel[id].kirim" class="badge badge-dikirim">Terkirim</span>
                                            <span v-else class="badge badge-belum">Belum</span>
                                        </td>
                                        <td class="px-4 py-3 border-b text-center flex flex-col gap-2 min-w-[110px]">
                                            <button @click="simpanDraftTabel(id)" :disabled="getHybrid().formTabel[id].kirim" class="flex items-center gap-1 px-3 py-1.5 rounded-lg bg-yellow-100 text-yellow-800 font-semibold text-xs hover:bg-yellow-200 transition-all disabled:bg-gray-100 disabled:text-gray-400 disabled:cursor-not-allowed">
                                                <!-- Heroicon: PencilSquare -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 3.487a2.25 2.25 0 113.182 3.182L7.5 19.213l-4 1 1-4 12.362-12.726z" /></svg>
                                                Draft
                                            </button>
                                            <button @click="kirimTabel(id)" :disabled="getHybrid().formTabel[id].kirim || !isBarisValidTabel(id)" class="flex items-center gap-1 px-3 py-1.5 rounded-lg font-semibold text-xs text-white bg-[#5B21B6] hover:bg-[#5B21B6]/90 transition-all disabled:bg-gray-300 disabled:text-gray-100 disabled:cursor-not-allowed">
                                                <!-- Heroicon: PaperAirplane -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-7-7 7-7-9 2-2 9z" /></svg>
                                                Kirim
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="flex flex-col md:flex-row md:justify-between items-center gap-4 mt-8">
                            <button @click="kirimSemuaTabel" :disabled="!bisaKirimSemuaTabel" class="flex items-center gap-2 px-7 py-2.5 rounded-lg font-semibold text-white bg-[#5B21B6] hover:bg-[#5B21B6]/90 transition-all disabled:bg-gray-300 disabled:cursor-not-allowed text-base">
                                <!-- Heroicon: PaperAirplane -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-7-7 7-7-9 2-2 9z" /></svg>
                                Kirim Semua
                            </button>
                            <button @click="getHybrid().lanjutChecklist = false" class="flex items-center gap-2 px-5 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold text-xs transition-all">
                                <!-- Heroicon: ArrowLeft -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                                Kembali
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="menu==='komentar'" class="max-w-3xl mx-auto">
                <h2 class="text-xl font-bold text-indigo-700 mb-4">Komentar</h2>
                <div class="bg-white rounded-xl shadow p-6 text-gray-600">Komentar dan diskusi tugas akan tampil di sini.</div>
            </div>
            <div v-if="menu==='profil'" class="max-w-3xl mx-auto">
                <h2 class="text-xl font-bold text-indigo-700 mb-4">Profil</h2>
                <div class="bg-white rounded-xl shadow p-6 text-gray-600">Data profil staf akan tampil di sini.</div>
            </div>
            <!-- Modal Komentar -->
            <div v-if="showKomentar" class="modal-bg">
                <div class="modal-card">
                    <button @click="closeKomentar" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 text-xl">&times;</button>
                    <h3 class="text-lg font-bold mb-4">Komentar Tugas: @{{ tasks[komentarIdx].name }}</h3>
                    <div class="mb-4 max-h-40 overflow-y-auto">
                        <div v-if="getForm(komentarIdx).komentar.length === 0" class="text-gray-400 text-sm">Belum ada komentar.</div>
                        <div v-for="(k, i) in getForm(komentarIdx).komentar" :key="i" class="mb-2">
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-indigo-700">@{{ k.user }}</span>
                                <span class="text-xs text-gray-400">@{{ k.time }}</span>
                            </div>
                            <div class="ml-2 text-gray-700">@{{ k.text }}</div>
                        </div>
                    </div>
                    <form @submit.prevent="addKomentar">
                        <div class="flex gap-2">
                            <input v-model="newKomentar" class="border border-gray-200 rounded px-2 py-1 w-full text-sm" placeholder="Tulis komentar...">
                            <button type="submit" class="px-3 py-1 rounded bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
    <script>
        const { createApp, reactive, ref, computed, watch } = Vue;
        createApp({
            setup() {
                // Data utama
                const years = @json($years);
                const quarters = @json($quarters);
                const tasks = @json($tasks);
                const staffs = @json($staffs);
                const selectedYear = ref('');
                const selectedQuarter = ref('');
                const menu = ref('dashboard');
                // Komentar modal
                const showKomentar = ref(false);
                const komentarIdx = ref(0);
                const newKomentar = ref('');
                // Card per tugas (fitur lama)
                const forms = reactive({});
                // Hybrid: data per tahun+triwulan
                const hybrid = reactive({});
                function getKey() {
                    return selectedYear.value + '-' + selectedQuarter.value;
                }
                // Checklist & tabel per tahun+triwulan
                function getHybrid() {
                    const key = getKey();
                    if (!hybrid[key]) {
                        hybrid[key] = {
                            lanjutChecklist: false,
                            tugasDipilih: [],
                            formTabel: {},
                        };
                    }
                    return hybrid[key];
                }
                // Card per tugas (fitur lama)
                function getForm(idx) {
                    if (!forms[selectedYear.value]) forms[selectedYear.value] = {};
                    if (!forms[selectedYear.value][selectedQuarter.value]) forms[selectedYear.value][selectedQuarter.value] = [];
                    if (!forms[selectedYear.value][selectedQuarter.value][idx]) {
                        forms[selectedYear.value][selectedQuarter.value][idx] = {
                            anggota: [],
                            realisasi_kuantitas: '',
                            realisasi_waktu: '',
                            kualitas: 100,
                            status: '', // draft, dikirim, verif, revisi
                            komentar: [],
                            file_bukti: null,
                        };
                    }
                    return forms[selectedYear.value][selectedQuarter.value][idx];
                }
                function handleFileUpload(e, idx) {
                    getForm(idx).file_bukti = e.target.files[0] || null;
                }
                function isFormValid(idx) {
                    const f = getForm(idx);
                    return f.realisasi_kuantitas && f.realisasi_waktu && (f.kualitas !== '' && f.kualitas !== null) && (f.status !== 'dikirim' && f.status !== 'verif');
                }
                function submitForm(idx) {
                    const f = getForm(idx);
                    if (!isFormValid(idx)) return;
                    if (confirm('Yakin ingin mengirim data kinerja tugas ini?')) {
                        f.status = 'dikirim';
                    }
                }
                function saveDraft(idx) {
                    const f = getForm(idx);
                    if (f.status !== 'dikirim' && f.status !== 'verif') {
                        f.status = 'draft';
                    }
                }
                // Komentar
                function openKomentar(idx) {
                    komentarIdx.value = idx;
                    showKomentar.value = true;
                }
                function closeKomentar() {
                    showKomentar.value = false;
                    newKomentar.value = '';
                }
                function addKomentar() {
                    if (!newKomentar.value.trim()) return;
                    getForm(komentarIdx.value).komentar.push({
                        user: 'Andi', // Dummy user
                        text: newKomentar.value,
                        time: new Date().toLocaleString('id-ID', { hour: '2-digit', minute: '2-digit', day: '2-digit', month: '2-digit', year: '2-digit' })
                    });
                    newKomentar.value = '';
                }
                // HYBRID: Checklist & Tabel Realisasi per tahun+triwulan
                function getTask(id) {
                    return tasks.find(t => t.id === id) || {};
                }
                function simpanDraftTabel(id) {
                    const h = getHybrid();
                    if (!h.formTabel[id]) h.formTabel[id] = { realisasi_kuantitas: '', realisasi_waktu: '', kualitas: 100, bukti: '', draft: false, kirim: false };
                    h.formTabel[id].draft = true;
                }
                function kirimTabel(id) {
                    const h = getHybrid();
                    if (isBarisValidTabel(id)) {
                        if (!h.formTabel[id]) h.formTabel[id] = { realisasi_kuantitas: '', realisasi_waktu: '', kualitas: 100, bukti: '', draft: false, kirim: false };
                        h.formTabel[id].kirim = true;
                        h.formTabel[id].draft = false;
                    }
                }
                function isBarisValidTabel(id) {
                    const h = getHybrid();
                    const f = h.formTabel[id] || {};
                    return f.realisasi_kuantitas && f.realisasi_waktu && f.kualitas !== '' && f.bukti;
                }
                function isTercapaiTabel(id) {
                    const t = getTask(id);
                    const h = getHybrid();
                    const f = h.formTabel[id] || {};
                    return f.realisasi_kuantitas >= t.target_kuantitas && f.realisasi_waktu <= t.target_waktu;
                }
                function kirimSemuaTabel() {
                    const h = getHybrid();
                    h.tugasDipilih.forEach(id => {
                        if (isBarisValidTabel(id)) kirimTabel(id);
                    });
                }
                const bisaKirimSemuaTabel = computed(() => {
                    const h = getHybrid();
                    return h.tugasDipilih.length > 0 && h.tugasDipilih.every(id => isBarisValidTabel(id) && !(h.formTabel[id] && h.formTabel[id].kirim));
                });
                // Reset formTabel jika checklist berubah
                function resetFormTabel() {
                    const h = getHybrid();
                    const newForm = {};
                    h.tugasDipilih.forEach(id => {
                        if (!h.formTabel[id]) {
                            newForm[id] = { realisasi_kuantitas: '', realisasi_waktu: '', kualitas: 100, bukti: '', draft: false, kirim: false };
                        } else {
                            newForm[id] = h.formTabel[id];
                        }
                    });
                    Object.keys(h.formTabel).forEach(id => { delete h.formTabel[id]; });
                    Object.assign(h.formTabel, newForm);
                }
                watch(() => getHybrid().tugasDipilih, resetFormTabel);
                // Reset checklist/tabel jika tahun/triwulan diganti
                watch([selectedYear, selectedQuarter], () => {
                    // force reactivity
                    getHybrid();
                });
                return {
                    years,
                    quarters,
                    tasks,
                    staffs,
                    selectedYear,
                    selectedQuarter,
                    menu,
                    // Card per tugas
                    getForm,
                    handleFileUpload,
                    isFormValid,
                    submitForm,
                    saveDraft,
                    showKomentar,
                    komentarIdx,
                    openKomentar,
                    closeKomentar,
                    newKomentar,
                    addKomentar,
                    // Hybrid checklist/tabel per tahun+triwulan
                    getHybrid,
                    getTask,
                    simpanDraftTabel,
                    kirimTabel,
                    isBarisValidTabel,
                    isTercapaiTabel,
                    kirimSemuaTabel,
                    bisaKirimSemuaTabel,
                };
            }
        }).mount('#app');
    </script>
</body>
</html> 