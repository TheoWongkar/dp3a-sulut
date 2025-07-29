<x-app-layout>

    {{-- Judul Halaman --}}
    <x-slot name="title">Update Status Laporan</x-slot>

    {{-- Bagian Update Status Halaman --}}
    <section class="space-y-2">

        {{-- Card laporan --}}
        <x-cards.report-card :report="$report" />

        {{-- Card Status --}}
        <x-cards.report-status-card :statuses="$report->statuses" />

        {{-- Flash Message --}}
        <x-alerts.flash-message></x-alerts.flash-message>

        {{-- Form Update Status --}}
        <div id="status-update" class="p-4 bg-white rounded-lg border border-gray-300 shadow">
            <div>
                <form action="{{ route('dashboard.report.processed.update', ['diproses', $report->ticket_number]) }}"
                    method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <x-forms.select name="status" label="Status" :options="['Diproses', 'Selesai', 'Dibatalkan']"></x-forms.select>
                            <p class="mt-1 text-xs text-gray-600">Mohon isi dengan seksama. Status yang sudah diterapkan
                                tidak dapat diubah.</p>
                        </div>
                        <x-forms.textarea name="description" label="Deskripsi"></x-forms.textarea>
                    </div>

                    <div class="flex items-center justify-end gap-2">
                        <x-buttons.primary-button href="{{ route('dashboard.report.index', 'diproses') }}"
                            class="bg-gray-600 hover:bg-gray-700">Kembali</x-buttons.primary-button>
                        <x-buttons.primary-button type="submit" class="bg-green-600 hover:bg-green-700">Update
                            Status</x-buttons.primary-button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    @if (session('success') || $errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const target = document.getElementById('status-update');
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        </script>
    @endif

</x-app-layout>
