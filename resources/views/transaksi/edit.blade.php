@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>Edit Transaksi</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Kode Transaksi -->
                        <div class="mb-3">
                            <label for="kode_transaksi" class="form-label">Kode Transaksi</label>
                            <input type="text" name="kode_transaksi" id="kode_transaksi" 
                                   class="form-control @error('kode_transaksi') is-invalid @enderror" 
                                   value="{{ old('kode_transaksi', $transaksi->kode_transaksi) }}" readonly>
                            @error('kode_transaksi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Pembeli -->
                        <div class="mb-3">
                            <label for="pembeli_id" class="form-label">Pembeli</label>
                            <select name="pembeli_id" id="pembeli_id" 
                                    class="form-select @error('pembeli_id') is-invalid @enderror">
                                <option value="">Pilih Pembeli</option>
                                @foreach($pembelis as $pembeli)
                                    <option value="{{ $pembeli->id }}" 
                                            {{ $transaksi->pembeli_id == $pembeli->id ? 'selected' : '' }}>
                                        {{ $pembeli->kode_pembeli }} - {{ $pembeli->telepon }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pembeli_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Barang -->
                        <div class="mb-3">
                            <label for="kode_barang" class="form-label">Barang</label>
                            <select name="kode_barang" id="kode_barang" 
                                    class="form-select @error('kode_barang') is-invalid @enderror">
                                <option value="">Pilih Barang</option>
                                @foreach($barangs as $barang)
                                    <option value="{{ $barang->kode_barang }}" 
                                            data-harga="{{ $barang->harga_jual }}" 
                                            {{ $transaksi->kode_barang == $barang->kode_barang ? 'selected' : '' }}>
                                        {{ $barang->nama_barang }} (Stok: {{ $barang->stok }}) - Rp{{ number_format($barang->harga_jual, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kode_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jumlah Barang -->
                        <div class="mb-3">
                            <label for="jumlah_barang" class="form-label">Jumlah Barang</label>
                            <input type="number" name="jumlah_barang" id="jumlah_barang" 
                                   class="form-control @error('jumlah_barang') is-invalid @enderror" 
                                   value="{{ old('jumlah_barang', $transaksi->jumlah_barang) }}">
                            @error('jumlah_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Total Harga -->
                        <div class="mb-3">
                            <label for="total_harga" class="form-label">Total Harga</label>
                            <input type="number" name="total_harga" id="total_harga" 
                                   class="form-control @error('total_harga') is-invalid @enderror" 
                                   value="{{ old('total_harga', $transaksi->total_harga) }}" readonly>
                            @error('total_harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tanggal Transaksi -->
                        <div class="mb-3">
                            <label for="tanggal_transaksi" class="form-label">Tanggal Transaksi</label>
                            <input type="date" name="tanggal_transaksi" id="tanggal_transaksi" 
                                   class="form-control @error('tanggal_transaksi') is-invalid @enderror" 
                                   value="{{ old('tanggal_transaksi', $transaksi->tanggal_transaksi) }}">
                            @error('tanggal_transaksi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" 
                                    class="form-select @error('status') is-invalid @enderror">
                                <option value="">Pilih Status</option>
                                <option value="selesai" {{ $transaksi->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="pending" {{ $transaksi->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="batal" {{ $transaksi->status == 'batal' ? 'selected' : '' }}>Batal</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tombol -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const barangSelect = document.getElementById('kode_barang'); // Dropdown barang
        const jumlahInput = document.getElementById('jumlah_barang'); // Input jumlah barang
        const totalHargaInput = document.getElementById('total_harga'); // Input total harga

        function updateTotalHarga() {
            const selectedOption = barangSelect.options[barangSelect.selectedIndex];
            const hargaBarang = parseFloat(selectedOption.getAttribute('data-harga')) || 0;
            const jumlahBarang = parseInt(jumlahInput.value) || 0;

            // Hitung total harga
            const totalHarga = hargaBarang * jumlahBarang;
            totalHargaInput.value = totalHarga; // Update nilai total harga
        }

        // Event listener untuk perubahan pada dropdown barang
        barangSelect.addEventListener('change', function () {
            jumlahInput.value = 1; // Reset jumlah barang ke 1 saat barang dipilih
            updateTotalHarga(); // Perbarui total harga
        });

        // Event listener untuk perubahan jumlah barang
        jumlahInput.addEventListener('input', function () {
            updateTotalHarga(); // Perbarui total harga saat jumlah barang berubah
        });
    });
</script>
@endsection

