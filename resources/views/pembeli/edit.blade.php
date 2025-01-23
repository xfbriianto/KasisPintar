@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Edit Pembeli</h3>
        </div>
        <div class="card-body">
            {{-- Tampilkan pesan error jika ada --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form edit pembeli --}}
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

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
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
</div>
@endsection
