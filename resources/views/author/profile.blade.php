@extends('layouts.app')

@section('content')
<div class="container">

    {{-- HEADER PROFIL --}}
    <div class="card shadow-sm border-0 mb-4 position-relative">

        {{-- TOMBOL HOME --}}
        <a href="{{ auth()->check() ? route('dashboard') : route('welcome') }}"
        class="btn btn-sm btn-outline-primary position-absolute"
        style="top: 16px; right: 16px;">
            <i class="bi bi-house-door-fill"></i>
        </a>

        <div class="card-body d-flex align-items-center gap-4">

            {{-- FOTO PROFIL --}}
            @if($user->foto_profile)
                <img src="{{ asset('storage/' . $user->foto_profile) }}"
                    class="rounded-circle"
                    style="width:90px;height:90px;object-fit:cover">
            @else
                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
                    style="width:90px;height:90px;background:#6677ea;font-size:2rem;">
                    {{ strtoupper(substr($user->nama_lengkap ?? $user->username, 0, 1)) }}
                </div>
            @endif

            {{-- INFO --}}
            <div>
                <h4 class="fw-bold mb-1 gradient-text-secondary">
                    {{ $user->nama_lengkap ?? $user->username }}
                </h4>

                <p class="text-muted mb-0">
                    {{ $user->info ?? 'Tidak ada info' }}
                </p>
            </div>

        </div>
    </div>

    {{-- JUDUL --}}
    <h5 class="fw-bold gradient-text-secondary mb-3">
        Postingan
    </h5>

    {{-- WRAPPER SCROLL --}}
    <div class="post-scroll-wrapper">

        {{-- GRID POSTINGAN --}}
        <div class="row g-4">
            @forelse($posts as $post)
                <div class="col-md-4 col-sm-6">
                    <div class="card h-100 shadow-sm border-0">

                        <a href="{{ route('posts.show', $post) }}">
                            <img src="{{ $post->gambar
                                ? asset('storage/' . $post->gambar)
                                : asset('storage/images/default-post.jpg') }}"
                                class="card-img-top"
                                style="height:180px;object-fit:cover;">
                        </a>

                        <div class="card-body">
                            <h6 class="fw-bold mb-2">
                                <a href="{{ route('posts.show', $post) }}"
                                class="text-decoration-none gradient-text-primary">
                                    {{ $post->judul }}
                                </a>
                            </h6>

                            <div class="d-flex align-items-center gap-3">
                                <div class="d-flex align-items-center gap-2 text-muted">
                                    <i class="bi bi-calendar-event"></i>
                                    <small>
                                        {{ $post->published_at->translatedFormat('d M Y') }}
                                    </small>
                                </div>
                                <span>
                                    @foreach($post->categories as $kat)
                                        <span class="badge bg-secondary me-1">
                                            {{ $kat->nama_kategori }}
                                        </span>
                                    @endforeach
                                </span>
                            </div>

                            <div class="d-flex justify-content-end gap-3 mt-2 text-muted small">
                                <span><i class="bi bi-eye"></i> {{ $post->views ?? 0 }}</span>
                                <span><i class="bi bi-share"></i> {{ $post->shared ?? 0 }}</span>
                                <span><i class="bi bi-heart"></i> {{ $post->likes->count() }}</span>
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-5">
                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                    Author belum memiliki postingan
                </div>
            @endforelse
        </div>

        {{-- PAGINATION --}}
        <div class="mt-4">
            {{ $posts->links() }}
        </div>

    </div>

</div>
@endsection
