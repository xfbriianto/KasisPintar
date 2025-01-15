@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Detail Transaksi</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Kode Transaksi</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            value="{{ $transaksi->kode_transaksi }}" 
                            readonly
                        >
                    </div>

                    <div class="form-group">
                        <label>Tanggal Transaksi</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            value="{{ $transaksi->tanggal_transaksi }}" 
                            readonly
                        >
                    </div>

                    <div class="form-group">
                        <label>Kode Pembeli</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            value="{{ $transaksi->pembeli->kode_pembeli ?? 'Tidak Diketahui' }}"
                            readonly
                        >
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Barang</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            value="{{ $transaksi->barang->nama_barang ?? 'Tidak Diketahui' }}" 
                            readonly
                        >
                    </div>

                    <div class="form-group">
                        <label>Jumlah Barang</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            value="{{ $transaksi->jumlah_barang }}" 
                            readonly
                        >
                    </div>

                    <div class="form-group">
                        <label>Total Harga</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            value="Rp. {{ number_format($transaksi->total_harga, 0) }}" 
                            readonly
                        >
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Status</label>
                <input 
                    type="text" 
                    class="form-control" 
                    value="{{ ucfirst($transaksi->status) }}" 
                    readonly
                >
            </div>

            <div class="row">
                <div class="col-12">
                    <a href="{{ route('transaksi.edit', $transaksi->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('transaksi.destroy', $transaksi->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin hapus data?')">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
