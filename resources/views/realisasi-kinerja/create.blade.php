@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Realisasi Kinerja</h1>
            <p class="text-gray-600">Tahun: {{ $tahun }} | Triwulan: {{ $triwulan }}</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('realisasi-kinerja.store') }}" method="POST" class="bg-white rounded-lg shadow-lg p-6">
            @csrf
            <input type="hidden" name="tahun" value="{{ $tahun }}">
            <input type="hidden" name="triwulan" value="{{ $triwulan }}">

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-4 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Tugas</th>
                            <th class="px-4 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Target Kuantitas</th>
                            <th class="px-4 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Realisasi Kuantitas</th>
                            <th class="px-4 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Target Waktu (hari)</th>
                            <th class="px-4 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Realisasi Waktu (hari)</th>
                            <th class="px-4 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kualitas (%)</th>
                            <th class="px-4 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Link Bukti</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($selectedTasks as $index => $task)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $task['name'] }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <input type="number" 
                                           name="realisasi[{{ $index }}][target_kuantitas]" 
                                           value="{{ $task['target_kuantitas'] }}" 
                                           class="w-20 px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           readonly>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <input type="number" 
                                           name="realisasi[{{ $index }}][realisasi_kuantitas]" 
                                           value="{{ old("realisasi.{$index}.realisasi_kuantitas") }}"
                                           min="0"
                                           class="w-20 px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error("realisasi.{$index}.realisasi_kuantitas") border-red-500 @enderror"
                                           placeholder="0">
                                    @error("realisasi.{$index}.realisasi_kuantitas")
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <input type="number" 
                                           name="realisasi[{{ $index }}][target_waktu]" 
                                           value="{{ $task['target_waktu'] }}" 
                                           class="w-20 px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           readonly>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <input type="number" 
                                           name="realisasi[{{ $index }}][realisasi_waktu]" 
                                           value="{{ old("realisasi.{$index}.realisasi_waktu") }}"
                                           min="0"
                                           class="w-20 px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error("realisasi.{$index}.realisasi_waktu") border-red-500 @enderror"
                                           placeholder="0">
                                    @error("realisasi.{$index}.realisasi_waktu")
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <input type="number" 
                                           name="realisasi[{{ $index }}][kualitas]" 
                                           value="{{ old("realisasi.{$index}.kualitas", 100) }}"
                                           min="0" 
                                           max="100"
                                           class="w-20 px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error("realisasi.{$index}.kualitas") border-red-500 @enderror"
                                           placeholder="100">
                                    @error("realisasi.{$index}.kualitas")
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <input type="url" 
                                           name="realisasi[{{ $index }}][link_bukti]" 
                                           value="{{ old("realisasi.{$index}.link_bukti") }}"
                                           class="w-48 px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error("realisasi.{$index}.link_bukti") border-red-500 @enderror"
                                           placeholder="https://...">
                                    @error("realisasi.{$index}.link_bukti")
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </td>
                                <input type="hidden" name="realisasi[{{ $index }}][tugas_id]" value="{{ $task['id'] }}">
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-between items-center">
                <button type="submit" 
                        formaction="{{ route('realisasi-kinerja.store-draft') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Simpan Draft
                </button>
                
                <div class="flex space-x-4">
                    <a href="{{ route('realisasi-kinerja.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Kembali
                    </a>
                    <button type="submit" 
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Kirim Semua
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection 