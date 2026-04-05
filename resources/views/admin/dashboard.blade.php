@extends('layouts.admin')

@section('content')
<style>
    .sop-dashboard {
        background: linear-gradient(180deg, #252a63 0%, #2d3272 100%);
        border-radius: 18px;
        padding: 22px;
        color: #fff;
        box-shadow: 0 14px 30px rgba(15, 23, 42, 0.18);
    }

    .sop-dashboard .top-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .sop-dashboard .top-title h3 {
        margin: 0;
        font-size: 28px;
        font-weight: 800;
        color: #fff;
    }

    .sop-dashboard .top-title .subtitle {
        color: rgba(255,255,255,0.8);
        font-size: 14px;
        margin-top: 4px;
    }

    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 18px;
    }

    .stat-card {
        border-radius: 14px;
        padding: 20px 18px;
        color: #fff;
        position: relative;
        overflow: hidden;
        min-height: 112px;
    }

    .stat-card::after {
        content: "";
        position: absolute;
        right: -18px;
        bottom: -18px;
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: rgba(255,255,255,0.10);
    }

    .stat-card .icon {
        font-size: 34px;
        margin-bottom: 10px;
        opacity: 0.95;
    }

    .stat-card .number {
        font-size: 30px;
        font-weight: 800;
        line-height: 1;
        margin-bottom: 5px;
    }

    .stat-card .label {
        font-size: 14px;
        font-weight: 600;
        opacity: 0.95;
    }

    .stat-card .mini-link {
        position: absolute;
        right: 14px;
        top: 14px;
        background: rgba(255,255,255,0.18);
        color: #fff;
        border-radius: 999px;
        padding: 4px 10px;
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
    }

    .stat-link {
        display: block;
        text-decoration: none;
        color: #fff;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .stat-link:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 20px rgba(0,0,0,0.2);
        color: #fff;
    }

    .bg-blue { background: #2ea7bf; }
    .bg-green { background: #38b34a; }
    .bg-orange { background: #f68121; }
    .bg-yellow { background: #f3c126; }

    .dashboard-panels {
        display: grid;
        grid-template-columns: 1.1fr 1fr;
        gap: 18px;
    }

    .panel-box {
        background: rgba(20, 25, 76, 0.72);
        border-radius: 16px;
        padding: 18px;
        min-height: 470px;
        box-shadow: inset 0 0 0 1px rgba(255,255,255,0.04);
    }

    .panel-title {
        font-size: 15px;
        font-weight: 700;
        margin-bottom: 16px;
        color: #fff;
    }

    .panel-subtitle {
        font-size: 13px;
        color: rgba(255,255,255,0.72);
        margin-bottom: 16px;
    }

    .summary-box h4 {
        font-size: 34px;
        font-weight: 800;
        margin-bottom: 2px;
    }

    .summary-box p {
        color: rgba(255,255,255,0.74);
        margin-bottom: 14px;
    }

    .status-list {
        margin-top: 18px;
    }

    .status-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        padding: 10px 0;
        border-bottom: 1px solid rgba(255,255,255,0.08);
        color: #fff;
    }

    .status-item:last-child {
        border-bottom: none;
    }

    .status-item .name {
        font-size: 14px;
        font-weight: 600;
    }

    .status-item .badge-count {
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 800;
        color: #1f2937;
        background: #d1fae5;
    }

    .badge-yellow { background: #fef3c7 !important; }
    .badge-blue { background: #dbeafe !important; }
    .badge-green { background: #d1fae5 !important; }
    .badge-orange { background: #fde68a !important; }
    .badge-red { background: #fecaca !important; }

    .chart-wrap {
        position: relative;
        height: 390px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
        margin-top: 18px;
    }

    .info-card {
        background: rgba(255,255,255,0.08);
        border-radius: 12px;
        padding: 16px;
    }

    .info-card h6 {
        margin: 0 0 8px 0;
        font-size: 15px;
        font-weight: 700;
        color: #fff;
    }

    .info-card .status-chip {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        background: #dbeafe;
        color: #1d4ed8;
        margin-bottom: 10px;
    }

    .info-card p {
        margin: 0;
        font-size: 13px;
        line-height: 1.7;
        color: rgba(255,255,255,0.78);
    }

    @media (max-width: 1200px) {
        .stats-row {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .dashboard-panels {
            grid-template-columns: 1fr;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .stats-row {
            grid-template-columns: 1fr;
        }

        .sop-dashboard {
            padding: 16px;
        }

        .panel-box {
            min-height: auto;
        }
    }
</style>

<div class="sop-dashboard">
    <div class="top-title">
        <div>
            <h3>Dashboard Admin SOP</h3>
            <div class="subtitle">Monitoring verifikasi, penomoran, proses selesai, dan arsip SOP</div>
        </div>
        <div class="subtitle">
            Update: {{ now()->translatedFormat('d F Y H:i') }}
        </div>
    </div>

    <div class="stats-row">
        <a href="{{ route('admin.penomoran') }}" class="stat-card stat-link bg-blue">
            <span class="mini-link">More</span>
            <div class="icon"><i class="bi bi-file-earmark-text"></i></div>
            <div class="number">{{ $totalSop ?? 0 }}</div>
            <div class="label">Total SOP</div>
        </a>

        <a href="{{ route('admin.verifikasi') }}" class="stat-card stat-link bg-green">
            <span class="mini-link">More</span>
            <div class="icon"><i class="bi bi-patch-check"></i></div>
            <div class="number">{{ $jumlahVerifikasi ?? 0 }}</div>
            <div class="label">SOP Menunggu Verifikasi</div>
        </a>

        <a href="{{ route('admin.penomoran', ['status' => 'diverifikasi_admin']) }}" class="stat-card stat-link bg-orange">
            <span class="mini-link">More</span>
            <div class="icon"><i class="bi bi-hash"></i></div>
            <div class="number">{{ $jumlahBelumDiberiNomor ?? 0 }}</div>
            <div class="label">SOP Belum Diberi Nomor</div>
        </a>

        <a href="{{ route('admin.arsip') }}" class="stat-card stat-link bg-yellow">
            <span class="mini-link">More</span>
            <div class="icon"><i class="bi bi-archive"></i></div>
            <div class="number">{{ $jumlahArsip ?? 0 }}</div>
            <div class="label">SOP Diarsipkan</div>
        </a>
    </div>

    <div class="dashboard-panels">
        <div class="panel-box">
            <div class="panel-title">Rekap SOP Admin</div>
            <div class="panel-subtitle">Tahun {{ $tahunSekarang }}</div>

            <div class="summary-box">
                <div style="font-size:15px;font-weight:600;">Total SOP Dalam Sistem</div>
                <h4>{{ $totalSop ?? 0 }}</h4>
                <p>{{ $jumlahSelesai ?? 0 }} SOP sudah masuk tahap selesai / akhir proses</p>
            </div>

            <div class="status-list">
                <div class="status-item">
                    <div class="name">Diajukan</div>
                    <div class="badge-count badge-yellow">{{ $statusCounts['diajukan'] ?? 0 }}</div>
                </div>
                <div class="status-item">
                    <div class="name">Diverifikasi Admin</div>
                    <div class="badge-count badge-blue">{{ $statusCounts['diverifikasi_admin'] ?? 0 }}</div>
                </div>
                <div class="status-item">
                    <div class="name">Nomor Booking</div>
                    <div class="badge-count badge-orange">{{ $statusCounts['nomor_booking'] ?? 0 }}</div>
                </div>
                <div class="status-item">
                    <div class="name">Disetujui Kepala</div>
                    <div class="badge-count badge-blue">{{ $statusCounts['disetujui_kepala'] ?? 0 }}</div>
                </div>
                <div class="status-item">
                    <div class="name">Nomor Final</div>
                    <div class="badge-count badge-green">{{ $statusCounts['nomor_final'] ?? 0 }}</div>
                </div>
                <div class="status-item">
                    <div class="name">Dikirim ke Umum</div>
                    <div class="badge-count badge-blue">{{ $statusCounts['dikirim_ke_umum'] ?? 0 }}</div>
                </div>
                <div class="status-item">
                    <div class="name">Ditandatangani</div>
                    <div class="badge-count badge-red">{{ $statusCounts['ditandatangani'] ?? 0 }}</div>
                </div>
                <div class="status-item">
                    <div class="name">Diarsipkan</div>
                    <div class="badge-count badge-green">{{ $statusCounts['diarsipkan'] ?? 0 }}</div>
                </div>
            </div>
        </div>

        <div class="panel-box">
            <div class="panel-title">Grafik SOP per Bulan</div>
            <div class="panel-subtitle">Data berdasarkan jumlah SOP yang dibuat per bulan di tahun {{ $tahunSekarang }}</div>
            <div class="chart-wrap">
                <canvas id="sopMonthlyChart"></canvas>
            </div>
        </div>
    </div>

    <div class="info-grid">
        @foreach(($informasiAdmin ?? []) as $info)
            <div class="info-card">
                <h6>{{ $info['judul'] }}</h6>
                <div class="status-chip">{{ $info['status'] }}</div>
                <p>{{ $info['keterangan'] }}</p>
            </div>
        @endforeach
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('sopMonthlyChart');

        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($months),
                    datasets: [{
                        label: 'Jumlah SOP',
                        data: @json($monthlyData),
                        backgroundColor: '#14b8a6',
                        borderColor: '#14b8a6',
                        borderWidth: 1,
                        borderRadius: 8,
                        barThickness: 28
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                color: '#ffffff'
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: 'rgba(255,255,255,0.70)'
                            },
                            grid: {
                                color: 'rgba(255,255,255,0.05)'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: 'rgba(255,255,255,0.70)',
                                precision: 0
                            },
                            grid: {
                                color: 'rgba(255,255,255,0.06)'
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endsection