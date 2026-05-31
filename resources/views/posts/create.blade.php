@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="mb-4">
        <h4 class="gradient-text-secondary mb-1">
            <i class="bi bi-pencil-square me-1"></i>
            Buat Postingan Baru
        </h4>
        <small class="text-muted">
            Postingan akan berstatus <strong>draft</strong> dan menunggu verifikasi admin
        </small>
    </div>

    {{-- ALERT ERROR --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">

            {{-- KONTEN --}}
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body">

                        {{-- JUDUL --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Judul Postingan
                            </label>
                            <input type="text"
                                   name="judul"
                                   value="{{ old('judul') }}"
                                   class="form-control"
                                   placeholder="Masukkan judul berita"
                                   required>
                        </div>

                        {{-- KONTEN --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Konten
                            </label>
                            <textarea name="konten"
                                      rows="10"
                                      class="form-control"
                                      placeholder="Tulis konten lengkap berita..."
                                      required>{{ old('konten') }}</textarea>
                        </div>

                    </div>
                </div>
            </div>

            {{-- SIDEBAR --}}
            <div class="col-lg-4">

                {{-- GAMBAR --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <label class="form-label fw-semibold">
                            Gambar Thumbnail
                        </label>
                        <input type="file"
                               name="gambar"
                               class="form-control"
                               accept="image/*">

                        <small class="text-muted">
                            JPG / PNG • Max 2MB
                        </small>
                    </div>
                </div>

                {{-- KATEGORI --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <label class="form-label fw-semibold mb-2">
                            Kategori
                        </label>

                        @foreach($kategori as $item)
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="kategori[]"
                                       value="{{ $item->id }}"
                                       id="kat{{ $item->id }}"
                                       {{ in_array($item->id, old('kategori', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="kat{{ $item->id }}">
                                    {{ $item->nama_kategori }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- AKSI --}}
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-gradient-primary">
                        <i class="bi bi-send me-1"></i>
                        Simpan & Kirim Verifikasi
                    </button>

                    <a href="{{ route('posts.mine') }}" class="btn btn-outline-secondary">
                        Batal
                    </a>
                </div>

            </div>
        </div>
    </form>

</div>
@endsection
