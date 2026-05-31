@extends('layouts.app')

@section('content')
<div class="container px-4">

    <div class="mb-4">
        <h4 class="mb-1 gradient-text-secondary">
            <i class="bi bi-pencil-square me-1"></i>
            Edit Kategori
        </h4>
        <small class="text-muted">Ubah informasi kategori</small>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Kategori</label>
                    <input type="text"
                           name="nama_kategori"
                           class="form-control @error('nama_kategori') is-invalid @enderror"
                           value="{{ old('nama_kategori', $kategori->nama_kategori) }}">

                    @error('nama_kategori')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('kategori.index') }}" class="btn btn-gradient-secondary">
                        Batal
                    </a>
                    <button class="btn btn-gradient-primary">
                        <i class="bi bi-arrow-up-circle"></i> Update
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
