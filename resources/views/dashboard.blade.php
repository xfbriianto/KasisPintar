@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">Dashboard</h1>
    
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center bg-primary text-white">
                <div class="card-header">
                    Total Users
                </div>
                <div class="card-body">
                    <h2 class="card-title">{{ $totalUsers }}</h2>
                    <p class="card-text">Jumlah pengguna terdaftar di sistem.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card text-center bg-success text-white">
                <div class="card-header">
                    Total Pembeli
                </div>
                <div class="card-body">
                    <h2 class="card-title">{{ $totalPembeli }}</h2>
                    <p class="card-text">Jumlah pembeli terdaftar di sistem.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center bg-warning text-dark">
                <div class="card-header">
                    Recent Transactions
                </div>
                <div class="card-body">
                    <h2 class="card-title">{{ $recentTransactions->count() }}</h2>
                    <p class="card-text">Jumlah transaksi terbaru.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-info text-white">Recent Transactions</div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode Transaksi</th>
                        <th>Nama Pembeli</th>
                        <th>Jumlah Barang</th>
                        <th>Total Harga</th>
                        <th>Tanggal Transaksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentTransactions as $transaction)
                        <tr>
                            <td>{{ $transaction->id }}</td>
                            <td>{{ $transaction->kode_transaksi }}</td>
                            <td>{{ $transaction->pembeli->nama_pembeli ?? 'N/A' }}</td> <!-- Menampilkan nama pembeli -->
                            <td>{{ $transaction->jumlah_barang }}</td>
                            <td>{{ number_format($transaction->total_harga, 2, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($transaction->tanggal_transaksi)->format('d-m-Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection