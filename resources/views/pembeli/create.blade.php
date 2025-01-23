@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Tambah Pembeli Baru</h3>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
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

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('pembeli.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection