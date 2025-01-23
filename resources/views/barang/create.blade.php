@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Tambah Barang Baru</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('barang.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kode Barang</label>
                        <input type="text" name="kode_barang" 
                               class="form-control @error('kode_barang') is-invalid @enderror" 
                               value="{{ $newKodeBarang }}" 
                               readonly>
                        @error('kode_barang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori_id" 
                                class="form-select @error('kategori_id') is-invalid @enderror" 
                                required>
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" 
                                    {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
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
                               value="{{ old('nama_barang') }}" 
                               required>
                        @error('nama_barang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Harga Jual (Rp)</label>
                        <input type="text" name="harga_jual" 
                               id="harga_jual_input"
                               class="form-control rupiah-input @error('harga_jual') is-invalid @enderror" 
                               value="{{ old('harga_jual') }}" 
                               required>
                        <input type="hidden" name="harga_jual_raw" 
                               id="harga_jual_raw"
                               value="{{ old('harga_jual') }}">
                        @error('harga_jual')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Harga Dasar (Rp)</label>
                        <input type="text" name="harga_dasar" 
                               id="harga_dasar_input"
                               class="form-control rupiah-input @error('harga_dasar') is-invalid @enderror" 
                               value="{{ old('harga_dasar') }}" 
                               required>
                        <input type="hidden" name="harga_dasar_raw" 
                               id="harga_dasar_raw"
                               value="{{ old('harga_dasar') }}">
                        @error('harga_dasar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" 
                               class="form-control @error('stok') is-invalid @enderror" 
                               value="{{ old('stok', 0) }}" 
                               min="0" required>
                        @error('stok')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tipe Barang</label>
                        <input type="text" name="tipe_barang" 
                               class="form-control @error('tipe_barang') is-invalid @enderror" 
                               value="{{ old('tipe_barang') }}">
                        @error('tipe_barang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Barang
                        </button>
                        <a href="{{ route('barang.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fungsi untuk memformat angka ke Rupiah
    function formatRupiah(angka) {
        let number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return 'Rp ' + rupiah;
    }

    // Fungsi untuk menghilangkan format Rupiah
    function unformatRupiah(rupiah) {
        return rupiah.replace(/[^,\d]/g, '').replace(',', '.');
    }

    // Input Harga Jual
    const hargaJualInput = document.getElementById('harga_jual_input');
    const hargaJualRaw = document.getElementById('harga_jual_raw');

    hargaJualInput.addEventListener('input', function() {
        this.value = formatRupiah(this.value);
        hargaJualRaw.value = unformatRupiah(this.value);
    });

    // Input Harga Dasar
    const hargaDasarInput = document.getElementById('harga_dasar_input');
    const hargaDasarRaw = document.getElementById('harga_dasar_raw');

    hargaDasarInput.addEventListener('input', function() {
        this.value = formatRupiah(this.value);
        hargaDasarRaw.value = unformatRupiah(this.value);
    });

    // Set initial formatting if old values exist
    if (hargaJualInput.value) {
        hargaJualInput.value = formatRupiah(hargaJualInput.value);
        hargaJualRaw.value = unformatRupiah(hargaJualInput.value);
    }

    if (hargaDasarInput.value) {
        hargaDasarInput.value = formatRupiah(hargaDasarInput.value);
        hargaDasarRaw.value = unformatRupiah(h argaDasarInput.value);
    }
});
</script>
@endpush