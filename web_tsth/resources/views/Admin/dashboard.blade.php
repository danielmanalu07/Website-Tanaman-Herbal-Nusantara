@extends('component.main')
@section('menu')
    Home
@endsection
@section('title')
    Dashboard
@endsection
@section('icon')
    <i class="ph-house"></i>
@endsection
@push('resource')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Pulse animation for icons */
        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.2);
                opacity: 0.7;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .icon-pulse {
            animation: pulse 1.5s infinite;
        }

        /* Icon styling */
        .healthy-icon {
            color: #10b981;
            font-size: 3.8rem;
        }

        .unhealthy-icon {
            color: #ef4444;
            font-size: 3.8rem;
        }

        .needs-attention-icon {
            color: #f59e0b;
            font-size: 3.8rem;
        }
    </style>
    @php
        $labels = [];
        $total = [];
        $persentase = [];
        $predefinedColors = [
            '#3b82f6', // biru
            '#10b981', // hijau
            '#f59e0b', // kuning
            '#ef4444', // merah
            '#8b5cf6', // ungu
            '#ec4899', // pink
            '#14b8a6', // teal
            '#a855f7', // violet
            '#6366f1', // indigo
            '#22c55e', // emerald
        ];
        $colors = [];
        foreach ($visitor as $index => $item) {
            $colors[] = $predefinedColors[$index % count($predefinedColors)];
        }

        $totalVisitor = 0;
        foreach ($visitor as $item) {
            $totalVisitor += $item->visitor_total;
        }

        foreach ($visitor as $item) {
            $labels[] = $item->visitor_category['name'];
            $total[] = $item->visitor_total;

            $percent = $totalVisitor > 0 ? ($item->visitor_total / $totalVisitor) * 100 : 0;
            $persentase[] = round($percent, 2);
        }

        // Aggregate validation conditions
        $healthyCount = $validations->where('condition', 'Healthy')->count();
        $unhealthyCount = $validations->where('condition', 'Unhealthy')->count();
        $needsAttentionCount = $validations->where('condition', 'Needs Attention')->count();
        $totalValidations = $healthyCount + $unhealthyCount + $needsAttentionCount;
        $healthyPercent = $totalValidations > 0 ? round(($healthyCount / $totalValidations) * 100, 2) : 0;
        $unhealthyPercent = $totalValidations > 0 ? round(($unhealthyCount / $totalValidations) * 100, 2) : 0;
        $needsAttentionPercent = $totalValidations > 0 ? round(($needsAttentionCount / $totalValidations) * 100, 2) : 0;
    @endphp

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let barChart;

            // Ambil data langsung dari PHP
            const plantData = @json(
                $plant->map(function ($item) {
                    return [
                        'created_at' => $item->created_at ?? ($item->date_created ?? $item->createdBy),
                    ];
                }));
            console.log(plantData);

            // Fungsi untuk memfilter data berdasarkan tanggal
            function filterDataByDate(data, startDate, endDate) {
                if (!startDate || !endDate) return data; // Return all data if no date filter
                return data.filter(item => {
                    if (!item.created_at) return false;
                    const itemDate = new Date(item.created_at);
                    const start = new Date(startDate);
                    const end = new Date(endDate);
                    return itemDate >= start && itemDate <= end;
                });
            }

            // Fungsi untuk memuat chart
            function loadChart(startDate, endDate) {
                const chartCanvas = document.getElementById('barChart');
                chartCanvas.style.opacity = '0.5';

                // Filter data berdasarkan tanggal
                const filteredData = filterDataByDate(plantData, startDate, endDate);

                // Proses data untuk chart
                processChartData(filteredData, startDate, endDate);
                chartCanvas.style.opacity = '1';
            }

            // Fungsi untuk memproses data dan menampilkan chart
            function processChartData(data, startDate, endDate) {
                const monthCounts = {};
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

                // Tentukan rentang tahun untuk inisialisasi label
                let startYear, endYear;
                if (startDate && endDate) {
                    startYear = new Date(startDate).getFullYear();
                    endYear = new Date(endDate).getFullYear();
                } else {
                    const years = data
                        .filter(item => item.created_at)
                        .map(item => new Date(item.created_at).getFullYear());
                    startYear = years.length ? Math.min(...years) : new Date().getFullYear();
                    endYear = years.length ? Math.max(...years) : new Date().getFullYear();
                }

                // Inisialisasi semua kombinasi bulan-tahun dengan nilai 0
                const labels = [];
                for (let year = startYear; year <= endYear; year++) {
                    months.forEach(month => {
                        const key = `${month}-${year}`;
                        monthCounts[key] = 0;
                        labels.push(key);
                    });
                }

                // Hitung jumlah tanaman per bulan dan tahun
                data.forEach(item => {
                    if (item && item.created_at) {
                        const date = new Date(item.created_at);
                        const month = months[date.getMonth()];
                        const year = date.getFullYear();
                        const key = `${month}-${year}`;
                        monthCounts[key] = (monthCounts[key] || 0) + 1;
                    }
                });

                const counts = labels.map(key => monthCounts[key]);

                if (barChart) {
                    barChart.destroy();
                }
                const maxData = Math.min(100, Math.ceil(Math.max(...counts, 0) / 10) * 10);

                const ctx = document.getElementById('barChart').getContext('2d');
                barChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Tanaman',
                            data: counts,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1,
                            barPercentage: 0.8
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return `Jumlah Tanaman: ${tooltipItem.raw}`;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                min: 0,
                                max: maxData,
                                title: {
                                    display: true,
                                    text: 'Jumlah'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Bulan-Tahun'
                                }
                            }
                        }
                    }
                });
            }

            function initProgressCharts() {
                const healthyData = [{
                    value: {{ $healthyPercent }},
                    label: 'Healthy'
                }];
                if (healthyChart) healthyChart.destroy();
                const healthyCtx = document.getElementById('healthy-progress').getContext('2d');
                healthyChart = new Chart(healthyCtx, {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: healthyData.map(d => d.value),
                            backgroundColor: ['#10b981', '#ebedef'],
                            borderWidth: 0
                        }],
                        labels: ['']
                    },
                    options: {
                        circumference: 180,
                        rotation: 270,
                        cutout: '80%',
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                enabled: false
                            },
                            beforeDraw: function(chart) {
                                const ctx = chart.ctx;
                                const width = chart.width;
                                const height = chart.height;
                                const fontSize = (height / 114).toFixed(2);
                                ctx.font = fontSize + "em sans-serif";
                                ctx.textBaseline = "middle";
                                const text = {{ $healthyPercent }} + '%';
                                const textX = Math.round((width - ctx.measureText(text).width) / 2);
                                const textY = height / 2;
                                ctx.fillStyle = '#000';
                                ctx.fillText(text, textX, textY);
                            }
                        }
                    }
                });

                const unhealthyData = [{
                    value: {{ $unhealthyPercent }},
                    label: 'Unhealthy'
                }];
                if (unhealthyChart) unhealthyChart.destroy();
                const unhealthyCtx = document.getElementById('unhealthy-progress').getContext('2d');
                unhealthyChart = new Chart(unhealthyCtx, {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: unhealthyData.map(d => d.value),
                            backgroundColor: ['#ef4444', '#ebedef'],
                            borderWidth: 0
                        }],
                        labels: ['']
                    },
                    options: {
                        circumference: 180,
                        rotation: 270,
                        cutout: '80%',
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                enabled: false
                            },
                            beforeDraw: function(chart) {
                                const ctx = chart.ctx;
                                const width = chart.width;
                                const height = chart.height;
                                const fontSize = (height / 114).toFixed(2);
                                ctx.font = fontSize + "em sans-serif";
                                ctx.textBaseline = "middle";
                                const text = {{ $unhealthyPercent }} + '%';
                                const textX = Math.round((width - ctx.measureText(text).width) / 2);
                                const textY = height / 2;
                                ctx.fillStyle = '#000';
                                ctx.fillText(text, textX, textY);
                            }
                        }
                    }
                });

                const needsAttentionData = [{
                    value: {{ $needsAttentionPercent }},
                    label: 'Needs Attention'
                }];
                if (needsAttentionChart) needsAttentionChart.destroy();
                const needsAttentionCtx = document.getElementById('needs-attention-progress').getContext('2d');
                needsAttentionChart = new Chart(needsAttentionCtx, {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: needsAttentionData.map(d => d.value),
                            backgroundColor: ['#f59e0b', '#ebedef'],
                            borderWidth: 0
                        }],
                        labels: ['']
                    },
                    options: {
                        circumference: 180,
                        rotation: 270,
                        cutout: '80%',
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                enabled: false
                            },
                            beforeDraw: function(chart) {
                                const ctx = chart.ctx;
                                const width = chart.width;
                                const height = chart.height;
                                const fontSize = (height / 114).toFixed(2);
                                ctx.font = fontSize + "em sans-serif";
                                ctx.textBaseline = "middle";
                                const text = {{ $needsAttentionPercent }} + '%';
                                const textX = Math.round((width - ctx.measureText(text).width) / 2);
                                const textY = height / 2;
                                ctx.fillStyle = '#000';
                                ctx.fillText(text, textX, textY);
                            }
                        }
                    }
                });
            }

            // Event listener untuk perubahan tanggal
            document.querySelectorAll('.date-filter').forEach(input => {
                input.addEventListener('change', function() {
                    const startDate = document.getElementById('start').value;
                    const endDate = document.getElementById('end').value;
                    loadChart(startDate, endDate);
                });
            });

            // Load chart dengan semua data sebagai default
            loadChart(null, null);
            initProgressCharts();
        });
        $(document).ready(function() {
            const habitatCtx = document.getElementById('habitat-chart').getContext('2d');
            const visitorData = @json($total);
            const visitorCategory = @json($labels);
            const colors = @json($colors);
            new Chart(habitatCtx, {
                type: 'doughnut',
                data: {
                    labels: visitorCategory,
                    datasets: [{
                        data: visitorData,
                        backgroundColor: colors,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right'
                        }
                    }
                }
            });
        });
    </script>
@endpush
@section('content')
    @php
        $avgHabitus = round($habituses / (now()->hour ?: 1));
        $countLanguage = $languages->count();
        $avgLanguage = round($countLanguage / (now()->hour ?: 1));
        $avgStaff = round($staff / (now()->hour ?: 1));
        $avgPlants = round($plants / (now()->hour ?: 1));
        $avgLands = round($lands / (now()->hour ?: 1));
        $avgVisitorCategories = round($visitor_categories / (now()->hour ?: 1));
        $avgVisitors = round($visitors / (now()->hour ?: 1));
        $avgNews = round($news / (now()->hour ?: 1));
        $avgPlantValidations = round($plant_validations / (now()->hour ?: 1));

        $validation = collect($validations)
            ->sortByDesc(fn($item) => \Carbon\Carbon::parse($item->date_validation))
            ->take(5);
        $berita = collect($berita)->sortByDesc(fn($item) => \Carbon\Carbon::parse($item->published))->take(4);
    @endphp
    <!-- Quick stats boxes -->
    <div class="row">
        <div class="col-lg-4">

            <!-- Members online -->
            <div class="card bg-teal text-white">
                <div class="card-body">
                    <div class="d-flex">
                        <h3 class="mb-0">{{ $habituses }}</h3>
                    </div>

                    <div>
                        {{ __('messages.Total Habitus') }}
                        <div class="fs-sm opacity-75">{{ $avgHabitus }}% avg</div>
                    </div>
                </div>

                {{-- <div class="rounded-bottom overflow-hidden mx-3" id="members-online"></div> --}}
            </div>
            <!-- /members online -->

        </div>

        <div class="col-lg-4">

            <!-- Current server load -->
            <div class="card bg-pink text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h3 class="mb-0">{{ $staff }}</h3>
                    </div>

                    <div>
                        {{ __('messages.Total Staf') }}
                        <div class="fs-sm opacity-75">{{ $avgStaff }}% avg</div>
                    </div>
                </div>

                {{-- <div class="rounded-bottom overflow-hidden" id="server-load"></div> --}}
            </div>
            <!-- /current server load -->

        </div>

        <div class="col-lg-4">

            <!-- Today's revenue -->
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h3 class="mb-0">{{ $plants }}</h3>
                    </div>

                    <div>
                        Plant Total
                        <div class="fs-sm opacity-75">{{ $avgPlants }}% avg</div>
                    </div>
                </div>

                {{-- <div class="rounded-bottom overflow-hidden" id="today-revenue"></div> --}}
            </div>
            <!-- /today's revenue -->

        </div>

        <div class="col-lg-4">

            <!-- Today's revenue -->
            <div class="card bg-secondary text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h3 class="mb-0">{{ $lands }}</h3>
                    </div>

                    <div>
                        Land Total
                        <div class="fs-sm opacity-75">{{ $avgLands }}% avg</div>
                    </div>
                </div>

                {{-- <div class="rounded-bottom overflow-hidden" id="today-revenue"></div> --}}
            </div>
            <!-- /today's revenue -->

        </div>

        <div class="col-lg-4">

            <!-- Today's revenue -->
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h3 class="mb-0">{{ $visitor_categories }}</h3>
                    </div>

                    <div>
                        Visitor Category Total
                        <div class="fs-sm opacity-75">{{ $visitor_categories }}% avg</div>
                    </div>
                </div>

            </div>
            <!-- /today's revenue -->

        </div>

        <div class="col-lg-4">

            <!-- Today's revenue -->
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h3 class="mb-0">{{ $visitors }}</h3>
                    </div>

                    <div>
                        Visitor Total
                        <div class="fs-sm opacity-75">{{ $visitors }}% avg</div>
                    </div>
                </div>

            </div>
            <!-- /today's revenue -->

        </div>

        <div class="col-lg-4">

            <!-- Today's revenue -->
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h3 class="mb-0">{{ $news }}</h3>
                    </div>

                    <div>
                        News Total
                        <div class="fs-sm opacity-75">{{ $avgNews }}% avg</div>
                    </div>
                </div>

                {{-- <div class="rounded-bottom overflow-hidden" id="today-revenue"></div> --}}
            </div>
            <!-- /today's revenue -->

        </div>

        <div class="col-lg-4">

            <!-- Today's revenue -->
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h3 class="mb-0">{{ $plant_validations }}</h3>
                    </div>

                    <div>
                        Plant Validation Total
                        <div class="fs-sm opacity-75">{{ $avgPlantValidations }}% avg</div>
                    </div>
                </div>
            </div>
            <!-- /today's revenue -->

        </div>

        <div class="col-lg-4">

            <!-- Today's revenue -->
            <div class="card bg-dark text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h3 class="mb-0">{{ $countLanguage }}</h3>
                    </div>

                    <div>
                        Language Total
                        <div class="fs-sm opacity-75">{{ $avgLanguage }}% avg</div>
                    </div>
                </div>
            </div>
            <!-- /today's revenue -->

        </div>
    </div>
    <!-- /quick stats boxes -->
    <!-- Main charts -->
    <div class="row">
        <div class="col-xl-7">

            <!-- Ganti bagian Marketing campaigns dengan ini -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Visitor Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="chart-container" style="height: 350px;">
                                <canvas id="habitat-chart"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Visitor</th>
                                            <th>Visitor Total</th>
                                            <th>Persentase</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($visitor as $index => $item)
                                            <tr>
                                                <td>{{ $labels[$index] }}</td>
                                                <td>{{ $total[$index] }}</td>
                                                <td>
                                                    <div class="progress progress-xs" style="height: 10px;">
                                                        <div class="progress-bar"
                                                            style="width: {{ $persentase[$index] }}%; background-color: {{ $colors[$index] }};">
                                                        </div>
                                                    </div>
                                                    <span>{{ $persentase[$index] }}%</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="mb-0">Latest Plant Validations</h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date Validation</th>
                                    <th>Plant</th>
                                    <th>Description Validation</th>
                                    <th>Condition</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($validation as $item)
                                    <tr>
                                        <td>{{ $item->date_validation }}</td>
                                        <td>{{ $item->plant['name'] }}</td>
                                        <td>{{ $item->description }}</td>
                                        @if ($item->condition == 'Healthy')
                                            <td><span class="badge bg-success">{{ $item->condition }}</span></td>
                                        @elseif ($item->condition == 'Unhealthy')
                                            <td><span class="badge bg-danger">{{ $item->condition }}</span></td>
                                        @else
                                            <td><span class="badge bg-warning">{{ $item->condition }}</span></td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>

        <div class="col-xl-5">

            <!-- Sales stats -->
            <div class="card">
                <div class="card-header d-sm-flex align-items-sm-center py-sm-0">
                    <h5 class="py-sm-2 my-sm-1">Plant statistics</h5>
                    <div class="mt-2 mt-sm-0 ms-sm-auto">
                        <input type="date" id="start" class="date-filter">
                        <span>to</span>
                        <input type="date" id="end" class="date-filter">
                    </div>
                </div>

                <div class="card-body pb-0">
                    <div class="row text-center">
                        <canvas id="barChart" height="100"></canvas>
                    </div>
                </div>
            </div>
            <!-- /sales stats -->

            <!-- Progress counters -->
            <div class="row">
                <div class="col-sm-6">
                    <!-- Healthy Progress -->
                    <div class="card text-center">
                        <div class="card-body">
                            <div>
                                <i class="bi bi-check-circle-fill healthy-icon icon-pulse"></i>
                            </div>
                            <h3 class="mt-2">{{ $healthyPercent }}%</h3>
                            <p>Healthy Plants<br><small>{{ $healthyCount }} total</small></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <!-- Unhealthy Progress -->
                    <div class="card text-center">
                        <div class="card-body">
                            <div>
                                <i class="bi bi-x-circle-fill unhealthy-icon icon-pulse"></i>
                            </div>
                            <h3 class="mt-2">{{ $unhealthyPercent }}%</h3>
                            <p>Unhealthy Plants<br><small>{{ $unhealthyCount }} total</small></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <!-- Needs Attention Progress -->
                    <div class="card text-center">
                        <div class="card-body">
                            <div>
                                <i class="bi bi-exclamation-circle-fill needs-attention-icon icon-pulse"></i>
                            </div>
                            <h3 class="mt-2">{{ $needsAttentionPercent }}%</h3>
                            <p>Needs Attention<br><small>{{ $needsAttentionCount }} total</small></p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /progress counters -->

        </div>
    </div>
    <!-- /main charts -->


    <!-- Dashboard content -->
    <div class="row">
        <div class="col-xl">

            <!-- Latest posts -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Latest News</h5>
                </div>

                <div class="card-body pb-0">
                    <div class="row">
                        @foreach ($berita as $item)
                            <div class="col-xl-6">
                                <div class="d-sm-flex align-items-sm-start mb-3">
                                    <a href="{{ route('news.index') }}"
                                        class="d-inline-block position-relative me-sm-3 mb-3 mb-sm-0">
                                        <img src="{{ $item->images[0]['image_path'] }}" width="100"
                                            class="flex-shrink-0 rounded" height="100" alt="">
                                    </a>

                                    <div class="flex-fill">
                                        <h6 class="mb-1"><a href="{{ route('news.index') }}">{{ $item->title }}</a>
                                        </h6>
                                        <ul class="list-inline list-inline-bullet text-muted mb-2">
                                            <li class="list-inline-item"><a href="#"
                                                    class="text-body">{{ \Carbon\Carbon::parse($item->published)->format('d F Y') }}</a>
                                            </li>
                                        </ul>
                                        {!! Str::limit($item->title, 70) !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- /latest posts -->

        </div>
    </div>
    <!-- /dashboard content -->
@endsection
