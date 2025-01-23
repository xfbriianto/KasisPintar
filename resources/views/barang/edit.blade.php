@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Edit Barang</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('barang.update', $barang->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kode Barang</label>
                        <input type="text" name="kode_barang" 
                               class="form-control @error('kode_barang') is-invalid @enderror" 
                               value="{{ old('kode_barang', $barang->kode_barang) }}" 
                               required>
                        @error('kode_barang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori_id" 
                                class="form-select @error('kategori_id') is-invalid @enderror" 
                                required>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" 
                                    {{ $barang->kategori_id == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" name="nama_barang" 
                               class="form-control @error('nama_barang') is-invalid @enderror" 
                               value="{{ old('nama_barang', $barang->nama_barang) }}" 
                               required>
                        @error('nama_barang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Harga Jual</label>
                        <input type="number" name="harga_jual" 
                               class="form-control @error('harga_jual') is-invalid @enderror" 
                               value="{{ old('harga_jual', $barang->harga_jual) }}" 
                               min="0" required>
                        @error('harga_jual')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Harga Dasar</label>
                        <input type="number" name="harga_dasar" 
                               class="form-control @error('harga_dasar') is-invalid @enderror" 
                               value="{{ old('harga_dasar', $barang->harga_dasar) }}" 
                               min="0" required>
                        @error('harga_dasar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" 
                               class="form-control @error('stok') is-invalid @enderror" 
                               value="{{ old('stok', $barang->stok) }}" 
                               min="0" required>
                        @error('stok')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tipe Barang</label>
                        <input type="text" name="tipe_barang" 
                               class="form-control @error('tipe_barang') is-invalid @enderror" 
                               value="{{ old('tipe_barang', $barang->tipe_barang) }}">
                        @error('tipe_barang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Update Barang</button>
                    <a href="{{ route('barang.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection