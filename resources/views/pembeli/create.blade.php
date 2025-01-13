@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Tambah Pembeli Baru</h3>
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

            <form action="{{ route('pembeli.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="kode_pembeli" class="form-label">Kode Pembeli</label>
                    <input 
                        type="text" 
                        class="form-control @error('kode_pembeli') is-invalid @enderror" 
                        id="kode_pembeli" 
                        name="kode_pembeli" 
                        value="{{ $newKodePembeli ?? old('kode_pembeli') }}"
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
                    >{{ old('alamat') }}</textarea>
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
                        value="{{ old('telepon') }}"
                        required
                    >
                    @error('telepon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('pembeli.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection