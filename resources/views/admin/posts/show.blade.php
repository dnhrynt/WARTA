@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="fw-bold gradient-text-primary mb-1">{{ $post->judul }}</h4>
            <small class="text-muted">
                <i class="bi bi-person me-1"></i>
                {{ $post->author->nama_lengkap ?? $post->author->username }}
                • {{ $post->created_at->format('d M Y H:i') }}
            </small>
        </div>

        <span class="badge bg-warning text-dark">
            DRAFT
        </span>
    </div>

    {{-- GAMBAR --}}
    @if($post->gambar)
        <div class="mb-4">
            <img src="{{ asset('storage/'.$post->gambar) }}"
                 class="img-fluid rounded shadow-sm">
        </div>
    @endif

    {{-- KATEGORI --}}
    <div class="mb-3">
        @foreach($post->categories as $cat)
            <span class="badge bg-secondary me-1">
                {{ $cat->nama_kategori }}
            </span>
        @endforeach
    </div>

    {{-- KONTEN --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            {!! nl2br(e($post->konten)) !!}
        </div>
    </div>

    {{-- AKSI ADMIN --}}
    <div class="d-flex gap-2">

        {{-- APPROVE --}}
        <form method="POST"
              action="{{ route('admin.posts.approve', $post) }}">
            @csrf
            @method('PUT')

            <button class="btn btn-gradient-primary">
                <i class="bi bi-check-circle me-1"></i>
                Publish
            </button>
        </form>

        {{-- REJECT --}}
        <button class="btn btn-gradient-danger"
                data-bs-toggle="modal"
                data-bs-target="#rejectModal">
            <i class="bi bi-x-circle me-1"></i>
            Tolak
        </button>

        <a href="{{ route('admin.posts.index') }}"
           class="btn btn-gradient-secondary ms-auto">
           <i class="bi bi-arrow-left"></i>
            Kembali
        </a>
    </div>
</div>

{{-- MODAL REJECT --}}
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content"
              method="POST"
              action="{{ route('admin.posts.reject', $post) }}">
            @csrf
            @method('PUT')

            <div class="modal-header">
                <h5 class="modal-title">Tolak Postingan</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <label class="form-label fw-semibold">
                    Alasan Penolakan
                </label>
                <textarea name="rejection_reason"
                          class="form-control"
                          rows="4"
                          required></textarea>
            </div>

            <div class="modal-footer">
                <button class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">
                    Batal
                </button>
                <button class="btn btn-gradient-danger">
                    Tolak
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
