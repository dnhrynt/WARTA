@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold gradient-text-primary mb-1">
                <i class="bi bi-pencil-square me-1"></i>
                Edit Postingan
            </h4>
            <small class="text-muted">
                Perbarui konten berita sebelum dipublikasikan
            </small>
        </div>

        <a href="{{ route('posts.show', $post) }}" class="btn btn-gradient-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- JUDUL --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Judul Postingan
                    </label>
                    <input
                        type="text"
                        name="judul"
                        class="form-control @error('judul') is-invalid @enderror"
                        value="{{ old('judul', $post->judul) }}"
                        placeholder="Masukkan judul berita"
                    >
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- KONTEN --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Konten
                    </label>
                    <textarea
                        name="konten"
                        rows="7"
                        class="form-control @error('konten') is-invalid @enderror"
                        placeholder="Tulis isi berita..."
                    >{{ old('konten', $post->konten) }}</textarea>

                    @error('konten')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- KATEGORI --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Kategori
                    </label>

                    <div class="row">
                        @foreach($categories as $kategori)
                            <div class="col-md-4 col-sm-6">
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="kategori[]"
                                        value="{{ $kategori->id }}"
                                        id="kategori{{ $kategori->id }}"
                                        {{ in_array($kategori->id, old('kategori', $selectedCategories)) ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="kategori{{ $kategori->id }}">
                                        {{ $kategori->nama_kategori }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @error('kategori')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- GAMBAR --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Gambar Postingan
                    </label>

                    @if($post->gambar)
                        <div class="mb-2">
                            <img
                                src="{{ asset('storage/' . $post->gambar) }}"
                                class="img-thumbnail"
                                style="max-height: 200px"
                            >
                        </div>
                    @endif

                    <input
                        type="file"
                        name="gambar"
                        class="form-control @error('gambar') is-invalid @enderror"
                    >

                    <small class="text-muted">
                        Kosongkan jika tidak ingin mengganti gambar
                    </small>

                    @error('gambar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- AKSI --}}
                <div class="d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-gradient-danger">
                        <i class="bi bi-arrow-clockwise"></i>
                        Reset
                    </button>

                    <button type="submit" class="btn btn-gradient-primary">
                        <i class="bi bi-save me-1"></i>
                        Simpan Perubahan
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
