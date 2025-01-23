@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tambah Pembeli Baru</div>

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
                    <form method="POST" action="{{ route('transaksi.pembeli.store') }}">
                        @csrf

                        <div class="form-group row mb-3">
                            <label for="kode_pembeli" class="col-md-4 col-form-label text-md-right">Kode Pembeli</label>
                            <div class="col-md-6">
                                <input id="kode_pembeli" type="text" class="form-control" 
                                       value="{{ $newKodePembeli }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Tambah Pembeli
                                </button>
                                <a href="{{ route('transaksi.create') }}" class="btn btn-secondary ml-2">
                                    Batal
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection