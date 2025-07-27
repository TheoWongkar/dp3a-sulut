<x-app-layout>

    {{-- Script Tambahan --}}
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush

    {{-- Judul Halaman --}}
    <x-slot name="title">Dashboard</x-slot>

    {{-- Tahun --}}
    <form action="{{ route('dashboard') }}" method="GET" x-data>
        <x-forms.select name="year" :label="'Tahun'" :options="array_combine($years, $years)" :selected="$year"
            x-on:change="$root.submit()" class="mb-4" />
    </form>

    {{-- Bagian Statistik Laporan --}}
    <section class="mb-5 space-y-4">
        {{-- Judul --}}
        <x-shared.section-title>Statistik Laporan</x-shared.section-title>

        {{-- Status Card --}}
        <div class="grid grid-cols-3 lg:grid-cols-6 gap-4">
            <x-cards.status-card :count="$totalReports" title="Total Laporan" subtitle="Total laporan yang masuk"
                color="purple" />
            <x-cards.status-card :count="$receivedReports" title="Diterima" subtitle="Laporan diterima sistem" color="blue" />
            <x-cards.status-card :count="$unverifiedReports" title="Menunggu Verifikasi" subtitle="Menunggu verifikasi kepala UPT"
                color="yellow" />
            <x-cards.status-card :count="$processedReports" title="Diproses" subtitle="Dalam penanganan petugas"
                color="amber" />
            <x-cards.status-card :count="$completedReports" title="Selesai" subtitle="Selesai tuntas" color="green" />
            <x-cards.status-card :count="$canceledReports" title="Dibatalkan" subtitle="Dibatalkan karena suatu hal"
                color="red" />
        </div>

        {{-- Chart Utama + Jenis Kelamin --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            {{-- Statistik Laporan --}}
            <div class="lg:col-span-2 bg-white rounded-xl shadow p-4 flex flex-col">
                <h2 class="font-semibold text-gray-700">Statistik Laporan ({{ $year }})</h2>
                <div class="h-52">
                    <canvas id="reportChart"></canvas>
                </div>
            </div>

            {{-- Jenis Kelamin Korban & Pelaku --}}
            <div class="bg-white rounded-xl shadow p-4 flex flex-col">
                <h2 class="font-semibold text-gray-700">Jenis Kelamin ({{ $year }})</h2>
                <div class="grid grid-cols-2 gap-2 mt-4">
                    <div class="flex items-center justify-center h-52">
                        <canvas id="victimGenderChart"></canvas>
                    </div>
                    <div class="flex items-center justify-center h-52">
                        <canvas id="suspectGenderChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Wilayah Chart --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Kabupaten/Kota --}}
            <div class="bg-white rounded-xl shadow p-4 flex flex-col">
                <h2 class="font-semibold text-gray-700">Kabupaten/Kota ({{ $year }})</h2>
                <div class="h-52">
                    <canvas id="regencyChart"></canvas>
                </div>
            </div>

            {{-- Kecamatan --}}
            <div class="bg-white rounded-xl shadow p-4 flex flex-col">
                <h2 class="font-semibold text-gray-700">Kecamatan ({{ $year }})</h2>
                <div class="h-52">
                    <canvas id="districtChart"></canvas>
                </div>
            </div>
        </div>
    </section>

    {{-- Bagian Statistik Pegawai --}}
    <section class="mb-5 space-y-4">
        {{-- Judul --}}
        <x-shared.section-title>Statistik Pegawai</x-shared.section-title>

        <div class="flex flex-col lg:flex-row gap-4">
            {{-- Status Card --}}
            <div class="w-full lg:w-1/5 grid grid-cols-2 md:grid-cols-1 gap-4">
                <x-cards.status-card :count="$totalEmployees" title="Total Pegawai" subtitle="Total pegawai" color="purple" />
                <x-cards.status-card :count="$activeEmployees" title="Aktif" subtitle="Pegawai aktif" color="green" />
                <x-cards.status-card :count="$retiredEmployees" title="Pensiun" subtitle="Pegawai pensiun" color="blue" />
                <x-cards.status-card :count="$deceasedEmployees" title="Meninggal Dunia" subtitle="Pegawai meninggal dunia"
                    color="yellow" />
                <x-cards.status-card :count="$dismissedEmployees" title="Diberhentikan" subtitle="Pegawai diberhentikan"
                    color="red" />
            </div>

            {{-- Chart Utama --}}
            <div class="w-full bg-white rounded-xl shadow p-4 flex flex-col gap-4">
                <div>
                    <h2 class="font-semibold text-gray-700">Statistik Pegawai ({{ $year }})</h2>
                    <div class="h-52">
                        <canvas id="employeeChart"></canvas>
                    </div>
                </div>

                <div>
                    <h2 class="font-semibold text-gray-700">Penulis Terbanyak ({{ $year }})</h2>
                    <div class="h-52">
                        <canvas id="authorChart"></canvas>
                    </div>
                </div>

                <div>
                    <h2 class="font-semibold text-gray-700">Laporan ditangani Terbanyak ({{ $year }})</h2>
                    <div class="h-52">
                        <canvas id="handlerChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Bagian Statistik Berita --}}
    <section class="space-y-4">
        {{-- Judul --}}
        <x-shared.section-title>Statistik Berita</x-shared.section-title>

        <div class="flex flex-col lg:flex-row gap-4">
            {{-- Status Card --}}
            <div class="w-full lg:w-1/2 grid grid-cols-2 gap-4">
                <x-cards.status-card :count="$totalPosts" title="Total Berita" subtitle="Total berita" color="purple" />
                <x-cards.status-card :count="$publishedPosts" title="Terbit" subtitle="Postingan yang terbit"
                    color="green" />
                <x-cards.status-card :count="$draftPosts" title="Draf" subtitle="Postingan dalam draf" color="yellow" />
                <x-cards.status-card :count="$archivedPosts" title="Arsip" subtitle="Postingan diarsipkan" color="blue" />
            </div>

            {{-- Chart Utama --}}
            <div class="w-full bg-white rounded-xl shadow p-4 flex flex-col">
                <h2 class="font-semibold text-gray-700">Statistik Berita ({{ $year }})</h2>
                <div class="h-52">
                    <canvas id="postChart"></canvas>
                </div>
            </div>
        </div>
    </section>

    <script>
        const monthlyReportsData = @json($monthlyReportCounts);
        const victimGenders = @json($victimGenders);
        const suspectGenders = @json($suspectGenders);
        const regencies = @json($regencies);
        const districts = @json($districts);

        const reportMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        const reportStatusColors = {
            'Diterima': '#3B82F6',
            'Menunggu Verifikasi': '#FACC15',
            'Diproses': '#F59E0B',
            'Selesai': '#10B981',
            'Dibatalkan': '#EF4444'
        };

        // Line Chart per bulan per status
        new Chart(document.getElementById('reportChart'), {
            type: 'line',
            data: {
                labels: reportMonths,
                datasets: Object.entries(reportStatusColors).map(([status, color]) => ({
                    label: status,
                    data: reportMonths.map((_, i) => monthlyReportsData[i + 1]?.[status] ?? 0),
                    borderColor: color,
                    backgroundColor: color + '33',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: color
                })).concat([{
                    label: 'Total',
                    data: reportMonths.map((_, i) => monthlyReportsData[i + 1]?.Total ?? 0),
                    borderColor: '#111827',
                    backgroundColor: '#11182733',
                    borderWidth: 2,
                    fill: false,
                    tension: 0.4,
                    pointBackgroundColor: '#111827',
                    borderDash: [5, 5]
                }])
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        // Pie Chart Gender Korban
        const victimTotal = Object.values(victimGenders).reduce((a, b) => a + b, 0);
        const victimData = victimTotal > 0 ?
            victimGenders : {
                'Tidak Ada Data': 1
            };

        const victimColors = victimTotal > 0 ? ['#3B82F6', '#F472B6'] : ['#D1D5DB'];

        new Chart(document.getElementById('victimGenderChart'), {
            type: 'doughnut',
            data: {
                labels: Object.keys(victimData),
                datasets: [{
                    data: Object.values(victimData),
                    backgroundColor: victimColors
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Korban',
                        font: {
                            size: 12,
                            weight: 'bold'
                        }
                    },
                    legend: {
                        display: true,
                        position: 'bottom'
                    }
                }
            }
        });

        // Pie Chart Gender Pelaku
        const suspectTotal = Object.values(suspectGenders).reduce((a, b) => a + b, 0);
        const suspectData = suspectTotal > 0 ?
            suspectGenders : {
                'Tidak Ada Data': 1
            };

        const suspectColors = suspectTotal > 0 ? ['#3B82F6', '#F472B6'] : ['#D1D5DB'];

        new Chart(document.getElementById('suspectGenderChart'), {
            type: 'doughnut',
            data: {
                labels: Object.keys(suspectData),
                datasets: [{
                    data: Object.values(suspectData),
                    backgroundColor: suspectColors
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Pelaku / Terduga',
                        font: {
                            size: 12,
                            weight: 'bold'
                        }
                    },
                    legend: {
                        display: true,
                        position: 'bottom'
                    }
                }
            }
        });

        // Bar Chart Kabupaten/Kota
        new Chart(document.getElementById('regencyChart'), {
            type: 'bar',
            data: {
                labels: Object.keys(regencies),
                datasets: [{
                    label: 'Jumlah Laporan',
                    data: Object.values(regencies),
                    backgroundColor: '#6366F1'
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        ticks: {
                            autoSkip: false
                        }
                    }
                }
            }
        });

        // Bar Chart Kecamatan
        new Chart(document.getElementById('districtChart'), {
            type: 'bar',
            data: {
                labels: Object.keys(districts),
                datasets: [{
                    label: 'Jumlah Laporan',
                    data: Object.values(districts),
                    backgroundColor: '#10B981'
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        ticks: {
                            autoSkip: false
                        }
                    }
                }
            }
        });
    </script>

    <script>
        // EMPLOYEE CHART
        const monthlyEmployeesData = @json($monthlyEmployeeCounts);
        const employeeMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        const employeeStatusColors = {
            'Aktif': '#4ADE80',
            'Pensiun': '#3B82F6',
            'Meninggal Dunia': '#FACC15',
            'Diberhentikan': '#EF4444'
        };

        new Chart(document.getElementById('employeeChart'), {
            type: 'line',
            data: {
                labels: employeeMonths,
                datasets: Object.entries(employeeStatusColors).map(([status, color]) => ({
                    label: status,
                    data: employeeMonths.map((_, i) => monthlyEmployeesData[i + 1]?.[status] ?? 0),
                    borderColor: color,
                    backgroundColor: color + '33',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: color
                })).concat([{
                    label: 'Total',
                    data: employeeMonths.map((_, i) => monthlyEmployeesData[i + 1]?.Total ?? 0),
                    borderColor: '#111827',
                    backgroundColor: '#11182733',
                    borderWidth: 2,
                    fill: false,
                    tension: 0.4,
                    pointBackgroundColor: '#111827',
                    borderDash: [5, 5]
                }])
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        // AUTHOR CHART
        const monthlyAuthorCounts = @json($monthlyAuthorCounts);
        const topAuthorNames = @json($topAuthorsNames);
        const authorMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        new Chart(document.getElementById('authorChart'), {
            type: 'bar',
            data: {
                labels: authorMonths,
                datasets: Object.entries(monthlyAuthorCounts).map(([name, data], idx) => ({
                    label: name,
                    data: data,
                    backgroundColor: ['#60a5fa', '#34d399', '#fbbf24', '#a78bfa', '#f87171', '#9ca3af'][
                        idx % 6
                    ],
                    borderWidth: 1
                }))
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    },
                    legend: {
                        position: 'bottom'
                    }
                },
                scales: {
                    x: {
                        stacked: true
                    },
                    y: {
                        beginAtZero: true,
                        stacked: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        // HANDLER CHART
        const monthlyHandlerCounts = @json($monthlyHandlerCounts);
        const topHandlerNames = @json($topHandlerNames);
        const handlerMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        new Chart(document.getElementById('handlerChart'), {
            type: 'bar',
            data: {
                labels: handlerMonths,
                datasets: Object.entries(monthlyHandlerCounts).map(([name, data], idx) => ({
                    label: name,
                    data: data,
                    backgroundColor: ['#60a5fa', '#34d399', '#fbbf24', '#a78bfa', '#f87171'][idx % 5],
                    stack: 'Stack 0'
                }))
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    },
                    title: {
                        display: true,
                        text: 'Laporan Ditangani per Bulan (Stacked)'
                    },
                    legend: {
                        position: 'bottom'
                    }
                },
                scales: {
                    x: {
                        stacked: true
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>

    <script>
        const monthlyPostsData = @json($monthlyPostCounts);
        const postMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        const postStatusColors = {
            'Terbit': '#4ADE80',
            'Arsip': '#FACC15',
            'Draf': '#3B82F6'
        };

        // Line Chart per bulan per status
        new Chart(document.getElementById('postChart'), {
            type: 'line',
            data: {
                labels: postMonths,
                datasets: Object.entries(postStatusColors).map(([status, color]) => ({
                    label: status,
                    data: postMonths.map((_, i) => monthlyPostsData[i + 1]?.[status] ?? 0),
                    borderColor: color,
                    backgroundColor: color + '33',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: color
                })).concat([{
                    label: 'Total',
                    data: postMonths.map((_, i) => monthlyPostsData[i + 1]?.Total ?? 0),
                    borderColor: '#111827',
                    backgroundColor: '#11182733',
                    borderWidth: 2,
                    fill: false,
                    tension: 0.4,
                    pointBackgroundColor: '#111827',
                    borderDash: [5, 5]
                }])
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>

</x-app-layout>
