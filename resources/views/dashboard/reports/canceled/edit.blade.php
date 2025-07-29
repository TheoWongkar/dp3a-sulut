<x-app-layout>

    {{-- Judul Halaman --}}
    <x-slot name="title">Review Laporan</x-slot>

    {{-- Bagian Review Dibatalkan --}}
    <section class="space-y-2">

        {{-- Card laporan --}}
        <x-cards.report-card :report="$report" />

        {{-- Card Status --}}
        <x-cards.report-status-card :statuses="$report->statuses" />

        {{-- Tombol aksi --}}
        <div class="p-4 bg-white rounded-lg border border-gray-300 shadow">
            <div>
                <div class="flex items-center justify-end gap-2">
                    <x-buttons.primary-button href="{{ route('dashboard.report.index', 'dibatalkan') }}"
                        class="bg-gray-600 hover:bg-gray-700">Kembali</x-buttons.primary-button>
                </div>
            </div>
        </div>
    </section>

</x-app-layout>
