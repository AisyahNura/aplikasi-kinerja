@extends('layouts.staff')

@section('content')
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.comment-card {
    transition: all 0.2s ease-in-out;
}

.comment-card:hover {
    transform: translateY(-1px);
}

.notification {
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

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
</style>

<div class="p-6">
    <div class="max-w-6xl mx-auto">
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

        <!-- Navigation Back -->
        <div class="mb-6">
            <a href="{{ route('staff.dashboard') }}" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 mb-4">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Dashboard
            </a>
            
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">Penilaian & Komentar</h1>
                    <p class="text-gray-600">Feedback dan penilaian dari atasan untuk kinerja Anda</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $comments->count() }}</div>
                        <div class="text-sm text-gray-500">Total Ulasan</div>
                    </div>
                    @if($comments->where('is_read', false)->count() > 0)
                        <button id="markAllReadBtn" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                            Tandai Semua Dibaca
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Statistik Ringkasan -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Komentar -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Komentar</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $comments->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Rata-rata Rating -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Rata-rata Rating</p>
                        @php
                            $avgRating = $comments->count() > 0 ? $comments->avg('rating') : 0;
                        @endphp
                        <div class="flex items-center mt-1">
                            <div class="rating-3">
                                @for($i = 1; $i <= 3; $i++)
                                    @if($i <= $avgRating)
                                        <span class="rating-star">⭐</span>
                                    @elseif($i - $avgRating < 1 && $avgRating > $i - 1)
                                        <span class="rating-star">⭐</span>
                                    @else
                                        <span class="rating-star empty">☆</span>
                                    @endif
                                @endfor
                            </div>
                            <span class="rating-text">({{ number_format($avgRating, 1) }}/3)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Kinerja -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Status Kinerja</p>
                        @php
                            if ($avgRating >= 2.6) {
                                $status = 'Melebihi Target';
                                $statusColor = 'text-green-600';
                            } elseif ($avgRating >= 1.6) {
                                $status = 'Sesuai Target';
                                $statusColor = 'text-blue-600';
                            } else {
                                $status = 'Perlu Perbaikan';
                                $statusColor = 'text-red-600';
                            }
                        @endphp
                        <p class="text-lg font-bold {{ $statusColor }}">{{ $status }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Komentar -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Daftar Penilaian & Komentar</h2>
            </div>
            
            <div class="p-6">
                @if($comments->count() > 0)
                    <div class="space-y-6">
                        @foreach($comments as $comment)
                            <div class="comment-card border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow duration-200 {{ !$comment->is_read ? 'border-l-4 border-l-blue-500 bg-blue-50' : '' }}">
                                <!-- Header Komentar -->
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 {{ $comment->createdBy->role === 'kasi' ? 'bg-yellow-600' : 'bg-purple-600' }} rounded-full flex items-center justify-center mr-4">
                                            <span class="text-white font-semibold text-lg">{{ strtoupper(substr($comment->createdBy->name, 0, 1)) }}</span>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $comment->createdBy->name }}</h3>
                                            <p class="text-sm text-gray-600">{{ ucfirst($comment->createdBy->role) }} • {{ $comment->created_at->format('l, d M Y') }}</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Rating Bintang (3 level) -->
                                    <div class="flex items-center">
                                        <div class="rating-3">
                                            @for($i = 1; $i <= 3; $i++)
                                                @if($i <= $comment->rating)
                                                    <span class="rating-star">⭐</span>
                                                @elseif($i - $comment->rating < 1 && $comment->rating > $i - 1)
                                                    <span class="rating-star">⭐</span>
                                                @else
                                                    <span class="rating-star empty">☆</span>
                                                @endif
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Informasi Tugas -->
                                @if($comment->realisasiKinerja && $comment->realisasiKinerja->task)
                                    <div class="mb-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
                                        <p class="text-xs font-medium text-blue-700 mb-1">TUGAS YANG DINILAI:</p>
                                        <p class="text-sm font-semibold text-blue-900">{{ $comment->realisasiKinerja->task->nama_tugas }}</p>
                                        <p class="text-xs text-blue-600 mt-1">Triwulan {{ $comment->realisasiKinerja->triwulan }} Tahun {{ $comment->realisasiKinerja->tahun }}</p>
                                    </div>
                                @endif
                                
                                <!-- Isi Komentar -->
                                <div class="bg-white rounded-lg p-4 border-l-4 border-blue-500 shadow-sm">
                                    <p class="text-sm text-gray-700 leading-relaxed">{{ $comment->komentar }}</p>
                                </div>
                                
                                <!-- Footer Komentar -->
                                <div class="mt-4 flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <span class="text-xs text-gray-500">Rating: {{ $comment->rating }}/3</span>
                                        @if($comment->createdBy->role === 'kepala')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                Kepala Kantor
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Kasi
                                            </span>
                                        @endif
                                        @if(!$comment->is_read)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Baru
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        {{ $comment->created_at->format('H:i') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Tombol Load More -->
                    <div class="mt-8 text-center">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200">
                            Ulasan lainnya...
                        </button>
                    </div>
                @else
                    <div class="text-center py-16">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada penilaian</h3>
                        <p class="text-gray-500 mb-6">Belum ada komentar atau penilaian dari atasan untuk Anda.</p>
                        <div class="text-sm text-gray-400">
                            <p>Penilaian akan muncul setelah atasan memberikan feedback</p>
                            <p>pada realisasi kinerja yang telah Anda kirim.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mark all comments as read
    const markAllReadBtn = document.getElementById('markAllReadBtn');
    if (markAllReadBtn) {
        markAllReadBtn.addEventListener('click', function() {
            fetch('{{ route("staff.komentar.mark-all-read") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove "Baru" badges and blue border
                    document.querySelectorAll('.border-l-blue-500').forEach(element => {
                        element.classList.remove('border-l-blue-500', 'bg-blue-50');
                        element.classList.add('border-l-gray-200');
                    });
                    
                    // Remove "Baru" badges
                    document.querySelectorAll('.bg-red-100').forEach(element => {
                        element.remove();
                    });
                    
                    // Hide the button
                    markAllReadBtn.style.display = 'none';
                    
                    // Show success message
                    showNotification('Semua komentar telah ditandai sebagai dibaca', 'success');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan saat menandai komentar', 'error');
            });
        });
    }
    
    // Function to show notification
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg notification ${
            type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
});
</script>
@endsection
