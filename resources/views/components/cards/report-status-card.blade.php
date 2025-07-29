@props(['statuses' => collect()])

<div class="p-4 bg-white rounded-xl border border-gray-200 shadow-sm">
    <h2 class="mb-4 text-lg font-bold text-gray-800">Riwayat Status</h2>

    @if ($statuses->isEmpty())
        <p class="text-sm text-gray-500">Belum ada riwayat status.</p>
    @else
        <div class="relative pl-6 space-y-4">
            <!-- Garis vertikal -->
            <div class="absolute left-2 top-0 bottom-0 w-0.5 bg-gray-200"></div>

            @foreach ($statuses as $status)
                @php
                    $reportStatus = $status->status;
                    $colors = [
                        'Diterima' => 'bg-blue-100 text-blue-700 border-blue-300',
                        'Menunggu Verifikasi' => 'bg-yellow-100 text-yellow-700 border-yellow-300',
                        'Diproses' => 'bg-amber-100 text-amber-700 border-amber-300',
                        'Selesai' => 'bg-green-100 text-green-700 border-green-300',
                        'Dibatalkan' => 'bg-red-100 text-red-700 border-red-300',
                    ];
                    $color = $colors[$reportStatus] ?? 'bg-gray-100 text-gray-600 border-gray-300';

                    // Warna titik timeline
                    $dotColor = $loop->last ? 'bg-blue-500' : 'bg-gray-400';
                @endphp

                <div class="relative">
                    <!-- Titik timeline -->
                    <div class="absolute -left-5 top-5 w-3 h-3 rounded-full {{ $dotColor }} shadow">
                    </div>

                    <div class="p-3 bg-gray-50 rounded-lg border border-gray-200 shadow-sm">
                        <div class="flex items-center justify-between mb-1">
                            <span class="px-2 py-0.5 text-xs font-semibold rounded-full border {{ $color }}">
                                {{ $reportStatus }}
                            </span>
                            <span class="text-xs text-gray-500">
                                {{ $status->created_at->translatedFormat('d M Y H:i') }}
                            </span>
                        </div>

                        <p class="text-xs text-gray-600">
                            Ditangani oleh: <span
                                class="font-medium">{{ $status->changedBy->employee->name ?? '-' }}</span>
                        </p>

                        @if ($status->description)
                            <p class="mt-1 text-sm text-gray-700 leading-snug">
                                {{ $status->description }}
                            </p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
