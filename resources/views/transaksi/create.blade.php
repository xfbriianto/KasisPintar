@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Tambah Transaksi Baru</h3>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('transaksi.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <!-- Kolom Kiri -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="kode_transaksi" class="form-label">Kode Transaksi</label>
                            <input 
                                type="text" 
                                name="kode_transaksi"
                                id="kode_transaksi"
                                class="form-control @error('kode_transaksi') is-invalid @enderror"
                                value="{{ $newKodeTransaksi }}"
                                readonly
                            >
                            @error('kode_transaksi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_transaksi" class="form-label">Tanggal Transaksi</label>
                            <input 
                                type="date" 
                                name="tanggal_transaksi" 
                                id="tanggal_transaksi"
                                class="form-control @error('tanggal_transaksi') is-invalid @enderror"
                                value="{{ old('tanggal_transaksi', now()->format('Y-m-d')) }}"
                                required
                            >
                            @error('tanggal_transaksi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="pembeli_id" class="form-label">Pembeli</label>
                            <div class="input-group">
                                <select 
                                    name="pembeli_id" 
                                    id="pembeli_id"
                                    class="form-select @error('pembeli_id') is-invalid @enderror"
                                    required
                                >
                                    <option value="">Pilih Pembeli</option>
                                    @foreach($pembelis as $pembeli)
                                        <option 
                                            value="{{ $pembeli->id }}"
                                            {{ old('pembeli_id') == $pembeli->id ? 'selected' : '' }}
                                        >
                                            {{ $pembeli->kode_pembeli }}
                                        </option>
                                    @endforeach
                                </select>
                                <a href="{{ route('transaksi.pembeli.create') }}" class="btn btn-success">
                                    <i class="fa fa-plus"></i> Tambah Pembeli
                                </a>
                            </div>
                            @error('pembeli_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="kode_barang" class="form-label">Barang</label>
                            <select 
                                name="kode_barang" 
                                id="barang-select"
                                class="form-select @error('kode_barang') is-invalid @enderror"
                                required
                            >
                                <option value="">Pilih Barang</option>
                                @foreach($barangs as $barang)
                                    <option 
                                        value="{{ $barang->kode_barang }}"
                                        data-harga="{{ $barang->harga_jual }}"
                                        data-stok="{{ $barang->stok }}"
                                        {{ old('kode_barang') == $barang->kode_barang ? 'selected' : '' }}
                                    >
                                        {{ $barang->nama_barang }} - Rp. {{ number_format($barang->harga_jual, 0) }} (Stok: {{ $barang->stok }})
                                    </option>
                                @endforeach
                            </select>
                            @error('kode_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jumlah_barang" class="form-label">Jumlah Barang</label>
                            <input 
                                type="number" 
                                name="jumlah_barang" 
                                id="jumlah-barang"
                                class="form-control @error('jumlah_barang') is-invalid @enderror"
                                value="{{ old('jumlah_barang', 1) }}"
                                min="1"
                                required
                            >
                            <div id="stok-warning" class="form-text text-danger"></div>
                            @error('jumlah_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="harga_satuan" class="form-label">Harga Satuan</label>
                            <input 
                                type="text" 
                                id="harga-satuan"
                                class="form-control"
                                readonly
                            >
                        </div>

                        <div class="mb-3">
                            <label for="total_harga" class="form-label">Total Harga</label>
                            <input 
                                type="number" 
                                name="total_harga" 
                                id="total-harga"
                                class="form-control @error('total_harga') is-invalid @enderror"
                                readonly
                            >
                            @error('total_harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select 
                        name="status" 
                        id="status"
                        class="form-select @error('status') is-invalid @enderror"
                        required
                    >
                        <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="batal" {{ old('status') == 'batal' ? 'selected' : '' }}>Batal</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100">Simpan Transaksi</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const barangSelect = document.getElementById('barang-select');
    const jumlahBarangInput = document.getElementById('jumlah-barang');
    const hargaSatuanInput = document.getElementById('harga-satuan');
    const totalHargaInput = document.getElementById('total-harga');
    const stokWarning = document.getElementById('stok-warning');
    const submitBtn = document.getElementById('submit-btn');
    const jamTransaksiInput = document.getElementById('jam-transaksi');

    // Fungsi format mata uang
    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(angka);
    }

    // Fungsi update total harga
    function updateTotalHarga() {
        const selectedOption = barangSelect.options[barangSelect.selectedIndex];
        const hargaSatuan = selectedOption ? parseFloat(selectedOption.getAttribute('data-harga')) : 0;
        const jumlahBarang = parseInt(jumlahBarangInput.value) || 1;
        const stok = selectedOption ? parseInt(selectedOption.getAttribute('data-stok')) : 0;

        hargaSatuanInput.value = formatRupiah(hargaSatuan);
        totalHargaInput.value = (hargaSatuan * jumlahBarang).toFixed(2);

        // Cek stok
        if (jumlahBarang > stok) {
            stokWarning.textContent = 'Stok tidak mencukupi!';
            submitBtn.disabled = true;
        } else {
            stokWarning.textContent = '';
            submitBtn.disabled = false;
        }
    }

    // Event listener untuk perubahan pada select barang
    barangSelect.addEventListener('change', updateTotalHarga);
    // Event listener untuk perubahan pada input jumlah barang
    jumlahBarangInput.addEventListener('input', updateTotalHarga);

    // Fungsi untuk update jam transaksi secara otomatis
    function updateJamTransaksi() {
        const now = new Date();
        const formattedTime = now.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
        jamTransaksiInput.value = formattedTime;
    }

    // Update jam transaksi saat halaman dimuat
    updateJamTransaksi();

    // Perbarui jam setiap detik
    setInterval(updateJamTransaksi, 1000);
});
</script>
@endpush

@endsection