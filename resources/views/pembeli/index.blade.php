@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Daftar Pembeli</h3>
        </div>
        <div class="card-body">
            {{-- Tampilkan pesan sukses jika ada --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Pembeli</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th>Tanggal Pembelian</th> <!-- Kolom baru -->
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pembelis as $key => $pembeli)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $pembeli->kode_pembeli }}</td>
                        <td>{{ $pembeli->alamat }}</td>
                        <td>{{ $pembeli->telepon }}</td>
                        <td>{{ $pembeli->updated_at ? $pembeli->updated_at->format('d/m/Y H:i:s') : '-' }}</td> <!-- Tanggal diedit -->
                        <td>
                            <a href="{{ route('pembeli.show', $pembeli->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('pembeli.edit', $pembeli->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('pembeli.destroy', $pembeli->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Tombol Tambah Pembeli --}}
            <a href="{{ route('pembeli.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Pembeli
            </a>
        </div>
    </div>
</div>
@endsection
