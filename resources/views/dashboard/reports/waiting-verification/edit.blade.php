<x-app-layout>

    {{-- Judul Halaman --}}
    <x-slot name="title">Verifikasi Laporan</x-slot>

    {{-- Bagian Verifikasi --}}
    <section class="space-y-2">

        {{-- Card laporan --}}
        <x-cards.report-card :report="$report" />

        {{-- Card Status --}}
        <x-cards.report-status-card :statuses="$report->statuses" />

        {{-- Form Verifikasi --}}
        <div class="p-4 bg-white rounded-lg border border-gray-300 shadow">
            <div>
                <form
                    action="{{ route('dashboard.report.waiting-verification.update', ['menunggu-verifikasi', $report->ticket_number]) }}"
                    method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="flex items-center justify-end gap-2">
                        <x-buttons.primary-button href="{{ route('dashboard.report.index', 'menunggu-verifikasi') }}"
                            class="bg-gray-600 hover:bg-gray-700">Kembali</x-buttons.primary-button>
                        <x-buttons.primary-button type="submit" name="action" value="cancel"
                            onclick="return confirm('Yakin ingin membatalkan?')"
                            class="bg-red-600 hover:bg-red-700">Batalkan</x-buttons.primary-button>
                        @can('update', $report)
                            <x-buttons.primary-button type="submit"
                                class="bg-green-600 hover:bg-green-700">Verifikasi</x-buttons.primary-button>
                        @else
                            <x-buttons.primary-button type="button"
                                onclick="alert('Tindakan ini hanya bisa dilakukan oleh Admin.')"
                                class="bg-gray-600 hover:bg-gray-700">Verifikasi</x-buttons.primary-button>
                        @endcan
                    </div>
                </form>
            </div>
        </div>
    </section>

</x-app-layout>
