@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Detail Barang: {{ $barang->nama_barang }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>Kode Barang:</strong>
                    <p>{{ $barang->kode_barang }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Nama Barang:</strong>
                    <p>{{ $barang->nama_barang }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Kategori:</strong>
                    <p>
                        @if($barang->kategori)
                            {{ $barang->kategori->nama_kategori }}
                        @else
                            <span class="text-muted">Tidak ada kategori</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Stok:</strong>
                    <p>{{ $barang->stok }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Harga Beli:</strong>
                    <p>Rp. {{ number_format($barang->harga_dasar, 0, ',', '.') }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Harga Jual:</strong>
                    <p>Rp. {{ number_format($barang->harga_jual, 0, ',', '.') }}</p>
                </div>
                @if($barang->tipe_barang)
                <div class="col-md-6 mb-3">
                    <strong>Tipe Barang:</strong>
                    <p>{{ $barang->tipe_barang }}</p>
                </div>
                @endif
            </div>
            <div class="row">
                <div class="col-12">
                    <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin hapus data?')">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                    <a href="{{ route('barang.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection