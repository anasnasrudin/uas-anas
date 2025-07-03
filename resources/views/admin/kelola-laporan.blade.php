@extends('layout-admin')

@section('judul-halaman')
    Halaman - Laporan Penjualan
@endsection

@section('konten-utama')
    <div class="container-fluid bg-white pb-4">
        <h1 class="text-center fw-bold">Laporan Penjualan</h1>
        <form action="" method="get">
            <div class="row justify-content-center mt-4">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Tanggal Awal</label>
                    <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-info fw-semibold w-100">
                        <i class="fa fa-filter me-1"></i> Filter
                    </button>
                </div>
            </div>
        </form>
        <div class="table-responsive mt-4">
            <table class="table table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th>ID Transaksi</th>
                        <th>Tanggal Transaksi</th>
                        <th>Total Pembayaran</th>
                        <th>Nama Kasir</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data_transaksi as $t)
                        <tr>
                            <td>{{ $t->id_transaksi }}</td>
                            <td>{{ \Carbon\Carbon::parse($t->created_at)->translatedFormat('l, d F Y') }}</td>
                            <td>Rp. {{ number_format($t->total_bayar, 0, ',', '.') }}</td>
                            <td>{{ $t->user->nama ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-end mt-3 pe-2">
            {{ $data_transaksi->withQueryString()->links('pagination::bootstrap-4') }}
        </div>
        <div id="chartSection" class="d-flex align-items-start mt-5" style="gap: 20px;">
            <div style="flex: 0 0 85%;">
                <canvas id="chartOmset" style="display: none; width: 100%; height: 300px;"></canvas>
            </div>
            <div style="flex: 0 0 15%;" class="d-flex flex-column">
                <label class="fw-semibold mb-2 d-flex align-items-center gap-2">
                    <i class="fa fa-money-bill-wave text-success"></i> Omset
                </label>
                <button id="toggleChartBtn" class="btn btn-info fw-semibold">
                    <i class="fa fa-chart-bar me-1"></i> Generate
                </button>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
<style>
    #chartOmset {
        opacity: 0;
        transform: translateY(10px);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }
    #chartOmset.show {
        opacity: 1;
        transform: translateY(0);
    }
</style>

<script>
    let chartInstance = null;

    function generateChart() {
        const ctx = document.getElementById('chartOmset').getContext('2d');
        const labels = {!! json_encode($data_transaksi->pluck('id_transaksi')) !!};
        const values = {!! json_encode($data_transaksi->pluck('total_bayar')) !!};

        if (chartInstance) chartInstance.destroy();

        chartInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Omset',
                    data: values,
                    backgroundColor: '#0d6efd'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp. ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        const canvas = document.getElementById('chartOmset');
        const btn = document.getElementById('toggleChartBtn');
        let visible = false;

        btn.addEventListener('click', () => {
            visible = !visible;

            if (visible) {
                canvas.style.display = 'block';

                // Nunggu 50ms supaya transition jalan
                setTimeout(() => {
                    canvas.classList.add('show');
                }, 50);

                generateChart();
                btn.innerHTML = '<i class="fa fa-eye-slash me-1"></i> Hide Chart';
            } else {
                canvas.classList.remove('show');

                // Tunggu animasi selesai sebelum hide canvas
                setTimeout(() => {
                    canvas.style.display = 'none';
                }, 500);

                btn.innerHTML = '<i class="fa fa-chart-bar me-1"></i> Generate';
            }
        });
    });
</script>
@endsection
