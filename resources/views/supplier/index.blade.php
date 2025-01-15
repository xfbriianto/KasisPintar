@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Supplier</h1>
    <a href="{{ route('supplier.create') }}" class="btn btn-primary">Tambah Supplier</a>
    <table class="table">
        <thead>
            <tr>
                <th>Kode Supplier</th>
                <th>Nama Supplier</th>
                <th>Alamat</th>
                <th>Telepon</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($suppliers as $supplier)
            <tr>
                <td>{{ $supplier->kode_supplier }}</td>
                <td>{{ $supplier->nama_supplier }}</td>
                <td>{{ $supplier->alamat }}</td>
                <td>{{ $supplier->telepon }}</td>
                <td>
                    <a href="{{ route('supplier.edit', $supplier) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('supplier.destroy', $supplier) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection