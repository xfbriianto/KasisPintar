@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Supplier</h1>
    <p><strong>Kode Supplier:</strong> {{ $supplier->kode_supplier }}</p>
    <p><strong>Nama Supplier:</strong> {{ $supplier->nama_supplier }}</p>
    <p><strong>Alamat:</strong> {{ $supplier->alamat }}</p>
    <p><strong>Telepon:</strong> {{ $supplier->telepon }}</p>
    <a href="{{ route('supplier.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection