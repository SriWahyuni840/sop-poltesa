@extends('layouts.umum')

@section('content')
<div class="umum-dashboard-full">
    <div class="summary-cards">
        <div class="summary-card cyan">
            <div class="card-left">
                <div class="mail-icon"><i class="bi bi-envelope"></i></div>
                <div class="card-text">
                    <div class="card-number">{{ $totalSopMasuk }}</div>
                    <div class="card-label">SOP Masuk</div>
                </div>
            </div>
            <a href="{{ route('umum.sop') }}" class="mini-btn">More</a>
        </div>

        <div class="summary-card green">
            <div class="card-left">
                <div class="mail-icon"><i class="bi bi-envelope"></i></div>
                <div class="card-text">
                    <div class="card-number">{{ $jumlahPerluDikirim }}</div>
                    <div class="card-label">Belum dikirim ke Direktur</div>
                </div>
            </div>
            <a href="{{ route('umum.sop') }}" class="mini-btn">More</a>
        </div>

        <div class="summary-card orange">
            <div class="card-left">
                <div class="mail-icon"><i class="bi bi-envelope"></i></div>
                <div class="card-text">
                    <div class="card-number">{{ $jumlahSudahKeDirektur }}</div>
                    <div class="card-label">Sudah dikirim ke Direktur</div>
                </div>
            </div>
            <a href="{{ route('umum.sop') }}" class="mini-btn">More</a>
        </div>

        <div class="summary-card yellow">
            <div class="card-left">
                <div class="mail-icon"><i class="bi bi-envelope"></i></div>
                <div class="card-text">
                    <div class="card-number">{{ $jumlahSudahDitandatangani }}</div>
                    <div class="card-label">Sudah ditandatangani</div>
                </div>
            </div>
            <a href="{{ route('umum.sop') }}" class="mini-btn">More</a>
        </div>
    </div>

    <div class="panel-wrapper">
        <div class="panel-grid">
            <div class="left-panel">
                <div class="info-box">
                    <h3>Rekap SOP Umum</h3>
                    <div class="year-text">Tahun {{ $tahun }}</div>

                    <div class="total-title">Total SOP yang Diproses</div>
                    <div class="total-value">{{ $totalSopMasuk }} SOP</div>

                    @php $total = array_sum($chartStatus); @endphp

                    <div class="status-list">
                        @foreach($chartStatus as $label => $jumlah)
                            @php
                                $persen = $total > 0 ? round(($jumlah / $total) * 100) : 0;
                            @endphp
                            <div class="status-row">
                                <span>{{ $label }}</span>
                                <span class="status-pill">{{ $jumlah }} ({{ $persen }}%)</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="detail-wrap">
                        <a href="{{ route('umum.sop') }}" class="detail-btn">Lihat Detail</a>
                    </div>
                </div>

                <div class="donut-box">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>

            <div class="right-panel">
                <div class="chart-title">
                    Data grafik berdasarkan jumlah SOP per bulan di tahun {{ $tahun }}
                </div>
                <div class="bar-box">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .umum-dashboard-full {
        width: 100%;
        min-height: calc(100vh - 112px);
        background: #2f356f;
        padding: 18px 24px 28px;
    }

    .summary-cards {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 0;
        margin-bottom: 18px;
    }

    .summary-card {
        min-height: 82px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 14px;
        color: #fff;
    }

    .summary-card.cyan { background: #2ea7c5; }
    .summary-card.green { background: #35b242; }
    .summary-card.orange { background: #fb8222; }
    .summary-card.yellow { background: #f3bf23; }

    .card-left {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }

    .mail-icon {
        width: 40px;
        height: 40px;
        border: 2px solid rgba(255,255,255,0.92);
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: #fff;
        flex-shrink: 0;
    }

    .card-text {
        min-width: 0;
    }

    .card-number {
        font-size: 22px;
        font-weight: 700;
        line-height: 1.1;
        margin-bottom: 3px;
    }

    .card-label {
        font-size: 12px;
        color: rgba(255,255,255,0.96);
        line-height: 1.2;
    }

    .mini-btn {
        display: inline-block;
        background: #1f58a7;
        color: #fff;
        text-decoration: none;
        font-size: 11px;
        font-weight: 600;
        padding: 4px 11px;
        border-radius: 4px;
        white-space: nowrap;
        margin-left: 10px;
    }

    .mini-btn:hover,
    .detail-btn:hover {
        color: #fff;
        text-decoration: none;
        opacity: .95;
    }

    .panel-wrapper {
        background: #23295e;
        padding: 16px;
        width: 100%;
    }

    .panel-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
        width: 100%;
    }

    .left-panel,
    .right-panel {
        background: #21275c;
        border-radius: 2px;
        min-height: 520px;
        width: 100%;
    }

    .left-panel {
        display: grid;
        grid-template-columns: 320px 1fr;
        align-items: center;
        padding: 28px 26px;
        gap: 20px;
    }

    .right-panel {
        padding: 34px 26px 26px;
    }

    .info-box h3 {
        font-size: 20px;
        font-weight: 700;
        color: #fff;
        margin: 0 0 6px;
    }

    .year-text {
        font-size: 13px;
        color: #9eabd9;
        margin-bottom: 22px;
    }

    .total-title {
        font-size: 16px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 8px;
    }

    .total-value {
        font-size: 34px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 18px;
    }

    .status-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        padding: 10px 0;
        border-bottom: 1px solid rgba(255,255,255,0.14);
        color: #fff;
        font-size: 14px;
    }

    .status-row:last-child {
        border-bottom: none;
    }

    .status-pill {
        background: #f4e28c;
        color: #111;
        border-radius: 20px;
        padding: 3px 10px;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .detail-wrap {
        text-align: right;
        margin-top: 16px;
    }

    .detail-btn {
        display: inline-block;
        background: #1f58a7;
        color: #fff;
        text-decoration: none;
        font-size: 11px;
        font-weight: 600;
        padding: 4px 11px;
        border-radius: 4px;
    }

    .donut-box {
        height: 380px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .donut-box canvas {
        width: 100% !important;
        height: 100% !important;
        max-width: 380px;
    }

    .chart-title {
        color: #98a6d7;
        font-size: 13px;
        margin-bottom: 18px;
    }

    .bar-box {
        height: 410px;
        width: 100%;
    }

    .bar-box canvas {
        width: 100% !important;
        height: 100% !important;
    }

    @media (max-width: 1200px) {
        .summary-cards {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .panel-grid {
            grid-template-columns: 1fr;
        }

        .left-panel {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .summary-cards {
            grid-template-columns: 1fr;
        }

        .umum-dashboard-full {
            padding: 14px;
        }

        .left-panel,
        .right-panel {
            min-height: auto;
            padding: 20px 16px;
        }

        .donut-box,
        .bar-box {
            height: 300px;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    if (typeof Chart !== 'undefined') {
        const statusEl = document.getElementById('statusChart');
        if (statusEl) {
            new Chart(statusEl, {
                type: 'doughnut',
                data: {
                    labels: @json(array_keys($chartStatus)),
                    datasets: [{
                        data: @json(array_values($chartStatus)),
                        backgroundColor: ['#efe6aa', '#9fd9c2', '#f1d27c'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '78%',
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }

        const monthlyEl = document.getElementById('monthlyChart');
        if (monthlyEl) {
            new Chart(monthlyEl, {
                type: 'bar',
                data: {
                    labels: @json($labelBulan),
                    datasets: [{
                        data: @json($dataBulanan),
                        backgroundColor: '#18c7d8',
                        borderRadius: 6,
                        barThickness: 18
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            ticks: { color: '#6f7bb0', font: { size: 12 } },
                            grid: { display: false },
                            border: { display: false }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: { color: '#6f7bb0', precision: 0, stepSize: 1 },
                            grid: { color: 'rgba(255,255,255,0.05)' },
                            border: { display: false }
                        }
                    }
                }
            });
        }
    }
</script>
@endsection