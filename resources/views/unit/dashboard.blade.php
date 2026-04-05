@extends('layouts.unit')

@section('content')
<style>
    .unit-dashboard-page {
        background: #2b2f67;
        min-height: calc(100vh - 72px);
        padding: 0;
        color: #ffffff;
    }

    .unit-dashboard-wrap {
        width: 100%;
        margin: 0 auto;
    }

    .unit-mini-welcome {
        font-size: 12px;
        font-weight: 700;
        color: rgba(255,255,255,0.88);
        padding: 10px 28px 6px;
    }

    .summary-strip {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0;
        margin: 0 0 10px;
    }

    .summary-card {
        min-height: 72px;
        padding: 12px 18px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #fff;
        position: relative;
    }

    .summary-blue   { background: #2aa8c8; }
    .summary-green  { background: #32b33e; }
    .summary-orange { background: #ff881f; }
    .summary-yellow { background: #f4c21f; }

    .summary-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .summary-icon {
        width: 34px;
        height: 34px;
        border: 2px solid rgba(255,255,255,0.95);
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .summary-number {
        font-size: 22px;
        font-weight: 900;
        line-height: 1;
        margin-bottom: 2px;
    }

    .summary-label {
        font-size: 12px;
        font-weight: 600;
        color: rgba(255,255,255,0.96);
        line-height: 1.2;
    }

    .summary-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 4px 10px;
        border-radius: 3px;
        background: #1b4ea8;
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        text-decoration: none;
        border: none;
    }

    .summary-btn:hover {
        color: #fff;
        background: #153f88;
    }

    .dashboard-main-panel {
        background: #24295d;
        margin: 10px 28px 0;
        padding: 22px;
        min-height: 430px;
    }

    .chart-grid {
        display: grid;
        grid-template-columns: 1fr 1.1fr;
        gap: 18px;
    }

    .chart-box {
        background: rgba(18, 24, 68, 0.28);
        border-radius: 6px;
        padding: 18px 20px;
        min-height: 265px;
    }

    .chart-box-left {
        display: grid;
        grid-template-columns: 220px 1fr;
        gap: 12px;
        align-items: center;
    }

    .chart-title {
        font-size: 15px;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 2px;
    }

    .chart-subtitle {
        font-size: 11px;
        color: rgba(255,255,255,0.58);
        margin-bottom: 14px;
    }

    .rekap-total-title {
        font-size: 15px;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 8px;
    }

    .rekap-total-value {
        font-size: 28px;
        font-weight: 900;
        color: #ffffff;
        margin-bottom: 10px;
    }

    .rekap-status-title {
        font-size: 13px;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 10px;
    }

    .status-list {
        display: grid;
        gap: 8px;
    }

    .status-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        padding-bottom: 6px;
        border-bottom: 1px solid rgba(255,255,255,0.10);
    }

    .status-row:last-child {
        border-bottom: none;
    }

    .status-name {
        font-size: 12px;
        font-weight: 700;
        color: rgba(255,255,255,0.92);
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 54px;
        padding: 3px 8px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 800;
        color: #111827;
    }

    .badge-draft {
        background: #f3e8a4;
    }

    .badge-proses {
        background: #ff9f9f;
    }

    .badge-arsip {
        background: #a8e3cc;
    }

    .chart-canvas-wrap {
        position: relative;
        min-height: 250px;
    }

    .donut-wrap {
        min-height: 250px;
    }

    .detail-link-wrap {
        margin-top: 10px;
        text-align: right;
    }

    .detail-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #1c5fc0;
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        border-radius: 3px;
        padding: 5px 10px;
        text-decoration: none;
    }

    .detail-link:hover {
        color: #fff;
        background: #174fa0;
    }

    .bar-title-center {
        text-align: center;
        font-size: 11px;
        color: rgba(255,255,255,0.62);
        margin-bottom: 6px;
    }

    .notif-panel {
        margin: 18px 28px 0;
        background: #24295d;
        border-radius: 0;
        padding: 18px 22px 22px;
    }

    .notif-title {
        font-size: 16px;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 14px;
    }

    .notif-list {
        display: grid;
        gap: 10px;
    }

    .notif-item {
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 10px;
        padding: 14px;
    }

    .notif-item-title {
        font-size: 14px;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 5px;
    }

    .notif-item-meta {
        font-size: 11px;
        color: rgba(255,255,255,0.68);
        margin-bottom: 8px;
    }

    .notif-item-note {
        font-size: 13px;
        color: rgba(255,255,255,0.88);
        line-height: 1.6;
        margin-bottom: 8px;
    }

    .notif-item-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #7fc3ff;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
    }

    .notif-item-link:hover {
        color: #b5dbff;
    }

    .empty-text {
        font-size: 13px;
        color: rgba(255,255,255,0.72);
        margin: 0;
    }

    @media (max-width: 1200px) {
        .summary-strip {
            grid-template-columns: repeat(2, 1fr);
        }

        .chart-grid {
            grid-template-columns: 1fr;
        }

        .chart-box-left {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .unit-mini-welcome {
            padding: 10px 16px 6px;
        }

        .summary-strip {
            grid-template-columns: 1fr;
        }

        .dashboard-main-panel,
        .notif-panel {
            margin-left: 16px;
            margin-right: 16px;
            padding: 16px;
        }

        .summary-card {
            min-height: auto;
            gap: 12px;
            flex-wrap: wrap;
        }

        .chart-canvas-wrap,
        .donut-wrap {
            min-height: 220px;
        }
    }
</style>

@php
    $draft = (int) ($jumlahDraft ?? 0);
    $proses = (int) ($jumlahProses ?? 0);
    $arsip = (int) ($jumlahArsip ?? 0);
    $total = max((int) ($totalSop ?? 0), 1);

    $draftPersen = round(($draft / $total) * 100);
    $prosesPersen = round(($proses / $total) * 100);
    $arsipPersen = round(($arsip / $total) * 100);
@endphp

<div class="unit-dashboard-page">
    <div class="unit-dashboard-wrap">

        <div class="unit-mini-welcome">
            Welcome, {{ session('nama_unit') ?? session('name') ?? 'Unit Kerja' }}
        </div>

        <div class="summary-strip">
            <div class="summary-card summary-blue">
                <div class="summary-left">
                    <div class="summary-icon">
                        <i class="bi bi-journal-text"></i>
                    </div>
                    <div>
                        <div class="summary-number">{{ $totalSop ?? 0 }}</div>
                        <div class="summary-label">Total SOP</div>
                    </div>
                </div>
                <a href="{{ route('unit.sop') }}" class="summary-btn">More</a>
            </div>

            <div class="summary-card summary-green">
                <div class="summary-left">
                    <div class="summary-icon">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                    <div>
                        <div class="summary-number">{{ $jumlahDraft ?? 0 }}</div>
                        <div class="summary-label">SOP Draft</div>
                    </div>
                </div>
                <a href="{{ route('unit.sop') }}" class="summary-btn">More</a>
            </div>

            <div class="summary-card summary-orange">
                <div class="summary-left">
                    <div class="summary-icon">
                        <i class="bi bi-arrow-repeat"></i>
                    </div>
                    <div>
                        <div class="summary-number">{{ $jumlahProses ?? 0 }}</div>
                        <div class="summary-label">SOP Dalam Proses</div>
                    </div>
                </div>
                <a href="{{ route('unit.sop') }}" class="summary-btn">More</a>
            </div>

            <div class="summary-card summary-yellow">
                <div class="summary-left">
                    <div class="summary-icon">
                        <i class="bi bi-archive"></i>
                    </div>
                    <div>
                        <div class="summary-number">{{ $jumlahArsip ?? 0 }}</div>
                        <div class="summary-label">SOP Arsip</div>
                    </div>
                </div>
                <a href="{{ route('unit.arsip') }}" class="summary-btn">More</a>
            </div>
        </div>

        <div class="dashboard-main-panel">
            <div class="chart-grid">
                <div class="chart-box">
                    <div class="chart-box-left">
                        <div>
                            <div class="chart-title">Rekap SOP Unit</div>
                            <div class="chart-subtitle">Tahun {{ now()->year }}</div>

                            <div class="rekap-total-title">Total SOP Yang Dibuat</div>
                            <div class="rekap-total-value">{{ $totalSop ?? 0 }} SOP</div>

                            <div class="rekap-status-title">Berdasarkan Status</div>

                            <div class="status-list">
                                <div class="status-row">
                                    <div class="status-name">Belum diajukan</div>
                                    <div class="status-badge badge-draft">{{ $draft }} ({{ $draftPersen }}%)</div>
                                </div>
                                <div class="status-row">
                                    <div class="status-name">Diproses</div>
                                    <div class="status-badge badge-proses">{{ $proses }} ({{ $prosesPersen }}%)</div>
                                </div>
                                <div class="status-row">
                                    <div class="status-name">Selesai / Arsip</div>
                                    <div class="status-badge badge-arsip">{{ $arsip }} ({{ $arsipPersen }}%)</div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="chart-canvas-wrap donut-wrap">
                                <canvas id="statusDonutChart"></canvas>
                            </div>
                            <div class="detail-link-wrap">
                                <a href="{{ route('unit.sop') }}" class="detail-link">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="chart-box">
                    <div class="bar-title-center">
                        Data grafik berdasarkan ringkasan SOP unit per status pada tahun {{ now()->year }}
                    </div>
                    <div class="chart-canvas-wrap">
                        <canvas id="statusBarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="notif-panel">
            <div class="notif-title">Notifikasi Revisi SOP</div>

            @if(isset($notifikasi) && count($notifikasi) > 0)
                <div class="notif-list">
                    @foreach($notifikasi as $item)
                        <div class="notif-item">
                            <div class="notif-item-title">{{ $item->nama_sop }}</div>
                            <div class="notif-item-meta">
                                Status: {{ ucwords(str_replace('_', ' ', $item->status)) }}
                                @if(!empty($item->tanggal_catatan))
                                    • {{ \Carbon\Carbon::parse($item->tanggal_catatan)->translatedFormat('d F Y H:i') }}
                                @endif
                            </div>
                            <div class="notif-item-note">
                                {{ $item->isi_catatan ?? 'Ada revisi pada SOP ini.' }}
                            </div>
                            <a href="{{ route('unit.sop.detail', $item->id) }}" class="notif-item-link">
                                <i class="bi bi-arrow-right-circle"></i> Lihat detail
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="empty-text">Belum ada notifikasi revisi SOP.</p>
            @endif
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const draft = {{ $draft }};
        const proses = {{ $proses }};
        const arsip = {{ $arsip }};

        const donutCanvas = document.getElementById('statusDonutChart');
        if (donutCanvas) {
            new Chart(donutCanvas, {
                type: 'doughnut',
                data: {
                    labels: ['Belum diajukan', 'Diproses', 'Selesai / Arsip'],
                    datasets: [{
                        data: [draft, proses, arsip],
                        backgroundColor: ['#f3e8a4', '#ff9f9f', '#a8e3cc'],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '82%',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + context.raw;
                                }
                            }
                        }
                    }
                }
            });
        }

        const barCanvas = document.getElementById('statusBarChart');
        if (barCanvas) {
            new Chart(barCanvas, {
                type: 'bar',
                data: {
                    labels: ['Draft', 'Proses', 'Arsip'],
                    datasets: [{
                        data: [draft, proses, arsip],
                        backgroundColor: ['#2aa8c8', '#32b33e', '#f4c21f'],
                        borderRadius: 4,
                        borderSkipped: false,
                        barThickness: 28
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
                            ticks: {
                                color: 'rgba(255,255,255,0.52)',
                                font: {
                                    size: 11
                                }
                            },
                            grid: {
                                display: false
                            },
                            border: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                color: 'rgba(255,255,255,0.28)',
                                font: {
                                    size: 11
                                }
                            },
                            grid: {
                                color: 'rgba(255,255,255,0.04)'
                            },
                            border: {
                                display: false
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endsection