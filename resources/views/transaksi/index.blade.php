@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0">
                <i class="fas fa-list"></i> Data Transaksi
            </h3>
            <a href="{{ route('transaksi.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Tambah Transaksi
            </a>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-hover" id="transaksi-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Transaksi</th>
                            <th>Tanggal</th>
                            <th>Jam</th> <!-- Kolom Jam -->
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksis as $transaksi)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $transaksi->kode_transaksi }}</td>
                                <td>
                                    {{ $transaksi->tanggal_transaksi 
                                        ? \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->setTimezone('Asia/Jakarta')->format('d/m/Y') 
                                        : '-' }}
                                </td>
                                <td>
                                    <!-- Menampilkan jam transaksi -->
                                    {{ $transaksi->jam_transaksi 
                                        ? \Carbon\Carbon::parse($transaksi->jam_transaksi)->setTimezone('Asia/Jakarta')->format('H:i:s')
                                        : '-' }}
                                </td>
                                <td>Rp. {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge 
                                        @if($transaksi->status == 'selesai') bg-success 
                                        @elseif($transaksi->status == 'pending') bg-warning 
                                        @else bg-danger 
                                        @endif">
                                        {{ ucfirst($transaksi->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('transaksi.show', $transaksi->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('transaksi.edit', $transaksi->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('transaksi.destroy', $transaksi->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus transaksi?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        // Inisialisasi DataTable
        $('#transaksi-table').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
            }
        });
    });
</script>
@endpush