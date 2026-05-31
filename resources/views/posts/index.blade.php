@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="gradient-text-secondary mb-1">
                <i class="bi bi-newspaper me-1"></i>
                Postingan Saya
            </h4>
            <small class="text-muted">
                Daftar semua postingan yang Anda buat
            </small>
        </div>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- GRID POST --}}
    <div class="row g-4">
        @forelse($posts as $post)
            <div class="col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm border-0 rombel-card">

                    {{-- GAMBAR --}}
                    <a href="{{ route('posts.show', $post) }}">
                        <img
                            src="{{ $post->gambar 
                                ? asset('storage/' . $post->gambar) 
                                : asset('storage/images/default-post.jpg') }}"
                            class="card-img-top"
                            style="height: 180px; object-fit: cover;"
                            alt="{{ $post->judul }}"
                        >
                    </a>

                    <div class="card-body d-flex flex-column">

                        {{-- JUDUL --}}
                        <h6 class="fw-bold mb-2">
                            <a href="{{ route('posts.show', $post) }}" class="text-decoration-none text-dark">
                                {{ Str::limit($post->judul, 60) }}
                            </a>
                        </h6>

                        {{-- TANGGAL --}}
                        <small class="text-muted mb-2">
                            <i class="bi bi-calendar-event me-1"></i>
                            {{ $post->created_at->format('d M Y') }}
                        </small>

                        {{-- STATUS --}}
                        <div class="mb-2">
                            @if($post->status === 'draft')
                                <span class="badge bg-secondary">Draft</span>
                            @elseif($post->status === 'published')
                                <span class="badge bg-success">Published</span>
                            @else
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </div>

                        {{-- INFO TAMBAHAN --}}
                        @if($post->status === 'published')
                            <small class="text-muted mb-2">
                                <i class="bi bi-eye me-1"></i>{{ $post->views ?? 0 }}
                                &nbsp;&nbsp;
                                <i class="bi bi-share me-1"></i>{{ $post->shared ?? 0 }}
                                &nbsp;&nbsp;
                                <i class="bi bi-heart me-1"></i>{{ $post->likes->count() }}
                            </small>
                        @endif

                        {{-- PESAN PENOLAKAN --}}
                        @if($post->status === 'rejected')
                            <div class="alert alert-danger p-2 small mt-2">
                                <strong>Alasan:</strong><br>
                                {{ $post->rejection_reason }}
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted py-5">
                <i class="bi bi-file-earmark-x fs-1"></i>
                <p class="mt-2">Belum ada postingan</p>
            </div>
        @endforelse
    </div>

</div>
@endsection
