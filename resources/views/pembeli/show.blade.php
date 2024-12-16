@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">
                        <i class="fas fa-user"></i> Detail Pembeli
                    </h3>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-3">
                            <div class="avatar-container">
                                <img 
                                    src="{{ asset('images/default-avatar.png') }}" 
                                    alt="Avatar Pembeli" 
                                    class="img-fluid rounded-circle shadow"
                                    style="max-width: 200px;"
                                >
                            </div>
                        </div>
                        
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th width="30%">Kode Pembeli</th>
                                        <td>
                                            <span class="badge bg-info">
                                                {{ $pembeli->kode_pembeli ?? 'Tidak Ada' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Nama Pembeli</th>
                                        <td>{{ $pembeli->nama_pembeli ?? 'Tidak Diketahui' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td>{{ $pembeli->alamat ?? 'Tidak Ada' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Telepon</th>
                                        <td>
                                            <i class="fas fa-phone"></i> 
                                            {{ $pembeli->telepon ?? 'Tidak Ada' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Terdaftar Sejak</th>
                                        <td>
                                            <i class="fas fa-calendar"></i>
                                            {{ 
                                                $pembeli->created_at 
                                                ? $pembeli->created_at->translatedFormat('d F Y H:i') 
                                                : 'Tanggal Tidak Tersedia' 
                                            }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Terakhir Diupdate</th>
                                        <td>
                                            <i class="fas fa-sync"></i>
                                            {{ 
                                                $pembeli->updated_at 
                                                ? $pembeli->updated_at->translatedFormat('d F Y H:i') 
                                                : 'Belum Pernah Diupdate' 
                                            }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <div>
                            <a 
                                href="{{ route('pembeli.edit', $pembeli->id) }}" 
                                class="btn btn-warning"
                            >
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a 
                                href="{{ route('pembeli.index') }}" 
                                class="btn btn-secondary"
                            >
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                        
                        <div>
                            <form 
                                action="{{ route('pembeli.destroy', $pembeli->id) }}" 
                                method="POST" 
                                class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus data pembeli?');"
                            >
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Riwayat Transaksi (Opsional) --}}
            <div class="card mt-4">
                <div class="card-header bg-secondary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-history"></i> Riwayat Transaksi
                    </h4>
                </div>
                <div class="card-body">
                    @if($pembeli->transaksis && $pembeli->transaksis->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No. Transaksi</th>
                                        <th>Tanggal</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                
    @foreach($pembeli->transaksis as $transaksi)
    <tr>
        <td>{{ $transaksi->kode_transaksi ?? 'Tidak Ada' }}</td>
        <td>
            {{ 
                $transaksi->tanggal_transaksi
                ? \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d/m/Y') 
                : 'Tanggal Tidak Tersedia' 
            }}
        </td>
        <td>Rp. {{ number_format($transaksi->total_harga ?? 0, 0, ',', '.') }}</td>
        <td>
            <span class="badge 
                @if($transaksi->status == 'Lunas') bg-success 
                @elseif($transaksi->status == 'Proses') bg-warning 
                @else bg-danger 
                @endif
            ">
                {{ $transaksi->status ?? 'Tidak Diketahui' }}
            </span>
        </td>
    </tr>
    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info text-center">
                            Belum ada riwayat transaksi
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection