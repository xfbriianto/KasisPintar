@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Edit Pembeli</h3>
        </div>
        <div class="card-body">
            {{-- Tampilkan pesan error --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pembeli.update', $pembeli->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="kode_pembeli" class="form-label">Kode Pembeli</label>
                    <input 
                        type="text" 
                        class="form-control @error('kode_pembeli') is-invalid @enderror" 
                        id="kode_pembeli" 
                        name="kode_pembeli" 
                        value="{{ old('kode_pembeli', $pembeli->kode_pembeli) }}"
                        required
                    >
                    @error('kode_pembeli')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea 
                        class="form-control @error('alamat') is-invalid @enderror" 
                        id="alamat" 
                        name="alamat" 
                        required
                    >{{ old('alamat', $pembeli->alamat) }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="telepon" class="form-label">Telepon</label>
                    <input 
                        type="text" 
                        class="form-control @error('telepon') is-invalid @enderror" 
                        id="telepon" 
                        name="telepon" 
                        value="{{ old('telepon', $pembeli->telepon) }}"
                        required
                    >
                    @error('telepon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="{{ route('pembeli.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                    <div>
                        <small class="text-muted">
                            Dibuat: {{ $pembeli->created_at->format('d M Y H:i') }}
                            | Diupdate: {{ $pembeli->updated_at->format('d M Y H:i') }}
                        </small>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Tambahan: Modal Konfirmasi --}}
    @include('components.delete-modal')
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validasi real-time
        const form = document.querySelector('form');
        const inputs = form.querySelectorAll('input, textarea');

        inputs.forEach(input => {
            input.addEventListener('input', function() {
                // Hapus error jika sudah diisi
                if (this.value.trim() !== '') {
                    this.classList.remove('is-invalid');
                }
            });
        });
    });
</script>
@endpush