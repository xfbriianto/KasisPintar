@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm border-0 rounded">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0">
                <i class="fas fa-users"></i> Daftar Pembeli
            </h3>
            <a href="{{ route('pembeli.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Tambah Pembeli Baru
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-hover" id="pembeli-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Pembeli</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pembelis as $index => $pembeli)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $pembeli->kode_pembeli }}</td>
                                <td>
                                    <a href="{{ route('pembeli.edit', $pembeli->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('pembeli.destroy', $pembeli->id) }}" method="POST" class="d-inline form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-delete">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Tidak ada data pembeli</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $pembelis->links() }}
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // SweetAlert2 untuk konfirmasi penghapusan
        $('.btn-delete').on('click', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data pembeli akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
