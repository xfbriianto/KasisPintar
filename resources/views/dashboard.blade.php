<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6200ea;
            --success-color: #00c853;
            --warning-color: #ffd600;
            --info-color: #00b8d4;
        }

        body {
            background-color: #f5f5f5;
        }

        .navbar-material {
            background: #424242;
            padding: 0.5rem 1rem;
        }

        .dashboard-container {
            padding: 20px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .stats-card {
            border-radius: 8px;
            border: none;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            height: 100%;
            transition: all 0.3s;
            position: relative;
            padding: 20px;
        }

        .stats-card:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .stats-purple {
            background: #6200ea;
        }

        .stats-orange {
            background: #ff6d00;
        }

        .stats-violet {
            background: #aa00ff;
        }

        .stats-teal {
            background: #00bfa5;
        }

        .stats-icon {
            position: absolute;
            right: 20px;
            top: 20px;
            font-size: 2rem;
            opacity: 0.7;
        }

        .stats-number {
            font-size: 2.5rem;
            font-weight: 500;
            margin-bottom: 0;
        }

        .stats-label {
            font-size: 1rem;
            opacity: 0.8;
            margin-bottom: 0;
        }

        .stats-trend {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .chart-card {
            background: white;
            border-radius: 8px;
            border: none;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-top: 20px;
        }

        .dropdown-filter {
            background: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px 10px;
        }

        .table th, .table td {
            vertical-align: middle;
        }
    </style>
</head>
<body>

@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <!-- Header with Filters -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Dashboard</h4>
        <div class="d-flex gap-3">
            <select class="dropdown-filter">
                <option>Order type</option>
                <option>Last month</option>
                <option>Last year</option>
            </select>
            <select class="dropdown-filter">
                <option>Last year</option>
                <option>This year</option>
                <option>Last month</option>
            </select>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3">
        <!-- Users Card -->
        <div class="col-md-3">
            <div class="stats-card stats-purple text-white">
                <p class="stats-number">{{ $totalUsers }}</p>
                <p class="stats-label">Total Users</p>
                <p class="stats-trend">+3% from last month</p>
                <i class="fas fa-users stats-icon"></i>
            </div>
        </div>

        <!-- Downloads Card -->
        <div class="col-md-3">
            <div class="stats-card stats-orange text-white">
                <p class="stats-number">{{ $totalPembeli }}</p>
                <p class="stats-label">Total Pembeli</p>
                <p class="stats-trend">+2% from last month</p>
                <i class="fas fa-shopping-cart stats-icon"></i>
            </div>
        </div>

        <!-- Customers Card -->
        <div class="col-md-3">
            <div class="stats-card stats-violet text-white">
                <p class="stats-number">{{ $recentTransactions->count() }}</p>
                <p class="stats-label">Recent Transactions</p>
                <p class="stats-trend">+8% from last month</p>
                <i class="fas fa-chart-bar stats-icon"></i>
            </div>
        </div>

        <!-- Renewals Card -->
        <div class="col-md-3">
            <div class="stats-card stats-teal text-white">
                <p class="stats-number">7</p>
                <p class="stats-label">Renewals</p>
                <p class="stats-trend">+2% from last month</p>
                <i class="fas fa-sync stats-icon"></i>
            </div>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="chart-card mt-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0">Recent Transactions</h5>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kode Transaksi</th>
                            <th>Jumlah Barang</th>
                            <th>Total Harga</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentTransactions as $transaction)
                        <tr>
                            <td>{{ $transaction->id }}</td>
                            <td>{{ $transaction->kode_transaksi }}</td>
                            <td>{{ $transaction->jumlah_barang }}</td>
                            <td>Rp {{ number_format($transaction->total_harga, 2, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($transaction->tanggal_transaksi)->format('d-m-Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
@endsection
</body>
</html>