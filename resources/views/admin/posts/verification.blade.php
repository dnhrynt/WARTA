@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">

    {{-- HEADER --}}
    <div class="mb-4">
        <h4 class="gradient-text-secondary mb-1">
            <i class="bi bi-shield-check me-1"></i>
            Verifikasi Postingan
        </h4>
        <small class="text-muted">
            Daftar postingan user yang menunggu persetujuan admin
        </small>
    </div>

    {{-- FLASH MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- EMPTY STATE --}}
    @if($posts->isEmpty())
        <div class="alert alert-info">
            <i class="bi bi-info-circle me-1"></i>
            Tidak ada postingan yang menunggu verifikasi
        </div>
    @else
        <div class="row g-4">
            @foreach($posts as $post)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0">

                        {{-- THUMBNAIL --}}
                        <a href="{{ route('admin.posts.show', $post) }}">
                            @if($post->gambar)
                                <img src="{{ asset('storage/'.$post->gambar) }}"
                                    class="card-img-top"
                                    style="height:180px; object-fit:cover;">
                            @else
                                <div class="d-flex align-items-center justify-content-center bg-light"
                                    style="height:180px;">
                                    <i class="bi bi-image text-muted fs-1"></i>
                                </div>
                            @endif
                        </a>

                        <div class="card-body d-flex flex-column">

                            {{-- JUDUL --}}
                            <h6 class="fw-bold mb-1">
                                <a href="{{ route('admin.posts.show', $post) }}"
                                class="text-decoration-none text-dark">
                                    {{ $post->judul }}
                                </a>
                            </h6>

                            {{-- AUTHOR --}}
                            <small class="text-muted mb-2">
                                <i class="bi bi-person me-1"></i>
                                {{ $post->author->nama_lengkap ?? $post->author->username }}
                                • {{ $post->created_at->format('d M Y') }}
                            </small>

                        </div>
                    </div>
                </div>

                {{-- MODAL REJECT --}}
                <div class="modal fade" id="rejectModal{{ $post->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <form
                            class="modal-content"
                            method="POST"
                            action="{{ route('admin.posts.reject', $post) }}">
                            @csrf
                            @method('PUT')

                            <div class="modal-header">
                                <h5 class="modal-title">
                                    Tolak Postingan
                                </h5>
                                <button class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <p class="mb-2">
                                    <strong>{{ $post->judul }}</strong>
                                </p>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        Alasan Penolakan
                                    </label>
                                    <textarea
                                        name="rejection_reason"
                                        class="form-control"
                                        rows="4"
                                        required
                                        placeholder="Tuliskan alasan penolakan..."></textarea>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button
                                    type="button"
                                    class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">
                                    Batal
                                </button>
                                <button type="submit" class="btn btn-danger">
                                    Tolak Postingan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
