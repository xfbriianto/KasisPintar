@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Statistik Ringkas -->
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <h5>Total Barang</h5>
                    <h2>{{ $statistik['total_barang'] }}</h2>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <h5>Total Pembeli</h5>
                    <h2>{{ $statistik['total_pembeli'] }}</h2>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <h5>Total Transaksi</h5>
                    <h2>{{ $statistik['total_transaksi'] }}</h2>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">
                    <h5>Total Pendapatan</h5>
                    <h2>Rp. {{ number_format($statistik['total_pendapatan'], 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Penjualan -->
    <div class="row">
        <div class="col-xl-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-area mr-1"></i>
                    Grafik Penjualan Bulanan
                </div>
                <div class="card-body">
                    <canvas id="penjualanChart" width="100%" height="40"></canvas>
                </div>
            </div>
        </div>

        <!-- Stok Barang Rendah -->
        <div class="col-xl-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-boxes mr-1"></i>
                    Stok Barang Rendah
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Stok</th>
                            </tr </thead>
                            <tbody>
                                @foreach($stokRendah as $barang)
                                    <tr>
                                        <td>{{ $barang->nama_barang }}</td>
                                        <td>{{ $barang->stok }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaksi Terbaru -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-shopping-cart mr-1"></i>
                    Transaksi Terbaru
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID Transaksi</th>
                                <th>Pembeli</th>
                                <th>Tanggal</th>
                                <th>Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksiTerbaru as $transaksi)
                                <tr>
                                    <td>{{ $transaksi->id }}</td>
                                    <td>{{ $transaksi->pembeli->nama }}</td>
                                    <td>{{ $transaksi->tanggal_transaksi->format('d-m-Y') }}</td>
                                    <td>Rp. {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    var ctx = document.getElementById('penjualanChart').getContext('2d');
    var penjualanChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($grafikPenjualan['labels']),
            datasets: [{
                label: 'Total Penjualan',
                data: @json($grafikPenjualan['data']),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection