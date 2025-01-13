@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Data Pembeli</h3>
            <a href="{{ route('pembeli.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Pembeli
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Pembeli</th>
                        <th>Alamat</th>
                        <th>telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembelis as $index => $pembeli)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $pembeli->kode_pembeli }}</td>
                            <td>{{ $pembeli->alamat }}</td>
                            <td>{{ $pembeli->telepon }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('pembeli.show', $pembeli->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('pembeli.edit', $pembeli->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('pembeli.destroy', $pembeli->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger delete-btn">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data pembeli</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $pembelis->links() }}
        </div>
    </div>
</div>

@include('components.delete-modal')
@endsection