@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">

    {{-- NAVBAR KATEGORI --}}
    <div class="mb-3">
        <ul class="nav border-bottom nav-scroll category-nav-fixed {{ auth()->check() ? 'top-auth' : 'top-guest' }}">
            <li class="nav-item">
                <a class="nav-link {{ !$kategoriAktif ? 'active fw-bold gradient-text-info' : 'text-primary' }}" href="{{ route('dashboard') }}">Semua</a>
            </li>
            @foreach($categories as $cat)
                <li class="nav-item">
                    <a class="nav-link {{ $kategoriAktif == $cat->id ? 'active fw-bold gradient-text-info' : 'text-primary' }}" 
                    href="{{ route('dashboard', ['kategori' => $cat->id]) }}">
                        {{ $cat->nama_kategori }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="row g-4 g-lg-5 dashboard-scroll">

        {{-- 1. BAGIAN POPULER (Sekarang jadi yang pertama di Mobile) --}}
        <div class="col-lg-3 dashboard-right order-1 order-lg-2">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light">
                    <h4 class="gradient-text-primary mb-0" style="font-size: 1.2rem;">
                        <i class="bi bi-fire text-orange"></i>
                        Populer
                    </h4>
                </div>

                <div class="card-body">
                    {{-- Di Mobile, kita buat sedikit lebih ringkas agar tidak terlalu panjang ke bawah --}}
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-1">
                        @foreach($popularPosts as $pop)
                            <div class="col mb-3">
                                <div class="d-flex d-lg-block gap-3">
                                    <a href="{{ route('posts.show', $pop) }}" class="flex-shrink-0">
                                        <img src="{{ $pop->gambar ? asset('storage/' . $pop->gambar) : asset('storage/images/default-post.jpg') }}"
                                            class="rounded"
                                            style="width: 100px; height: 70px; object-fit: cover; @media (min-width: 992px) { width: 100%; height: 150px; }"
                                            alt="{{ $pop->judul }}">
                                    </a>
                                    <div class="mt-lg-2">
                                        <a href="{{ route('posts.show', $pop) }}" class="fw-semibold text-decoration-none text-dark d-block small mb-1">
                                            {{ Str::limit($pop->judul, 50) }}
                                        </a>
                                        <small class="text-muted" style="font-size: 0.7rem;">
                                            <i class="bi bi-eye"></i> {{ $pop->views }} • <i class="bi bi-share"></i> {{ $pop->shared }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. BAGIAN UTAMA (Paling Disukai & Postingan Lain) --}}
        <div class="col-lg-9 dashboard-left order-2 order-lg-1">

            {{-- PALING BANYAK DISUKAI --}}
            <div class="mb-5">
                <h5 class="fw-bold gradient-text-primary mb-3">
                    <i class="bi bi-heart-fill text-danger me-1"></i>
                    Paling Banyak Disukai
                </h5>

                <div class="d-flex gap-3 overflow-x-auto pb-3 most-liked-scroll">
                    @foreach($mostLikedPosts as $liked)
                        <div class="card shadow-sm border-0 flex-shrink-0" style="width:260px">
                            <a href="{{ route('posts.show', $liked) }}">
                                <img src="{{ $liked->gambar ? asset('storage/' . $liked->gambar) : asset('storage/images/default-post.jpg') }}"
                                     class="card-img-top" style="height:140px;object-fit:cover">
                            </a>
                            <div class="card-body p-3">
                                <h6 class="fw-bold mb-2 text-truncate">
                                    <a href="{{ route('posts.show', $liked) }}" class="text-decoration-none text-dark">
                                        {{ $liked->judul }}
                                    </a>
                                </h6>
                                <div class="d-flex justify-content-between small text-muted">
                                    <span><i class="bi bi-heart-fill text-danger"></i> {{ $liked->likes_count }} Suka</span>
                                    <span><i class="bi bi-person"></i> {{ Str::limit($liked->author->username, 10) }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- GRID POSTINGAN LAINNYA --}}
            <h5 class="fw-bold gradient-text-secondary mb-4">
                <i class="bi bi-newspaper me-1"></i>
                Postingan Terbaru
            </h5>
            
            <div class="row g-4">
                @forelse($posts as $post)
                    <div class="col-md-6">
                        <div class="card h-100 shadow-sm border-0 overflow-hidden">
                            <div class="card-body p-0">
                                <div class="p-3 d-flex align-items-center gap-2">
                                    @if($post->author->foto_profile)
                                        <img src="{{ asset('storage/' . $post->author->foto_profile) }}" class="rounded-circle" style="width: 30px; height: 30px; object-fit: cover;">
                                    @else
                                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold bg-primary" style="width: 30px; height: 30px; font-size: 0.7rem;">
                                            {{ strtoupper(substr($post->author->username, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div class="small">
                                        <span class="fw-bold text-dark">{{ $post->author->nama_lengkap ?? $post->author->username }}</span>
                                        <span class="text-muted ms-1">• {{ $post->published_at->diffForHumans() }}</span>
                                    </div>
                                </div>

                                <a href="{{ route('posts.show', $post) }}">
                                    <img src="{{ $post->gambar ? asset('storage/' . $post->gambar) : asset('storage/images/default-post.jpg') }}"
                                         class="card-img-top rounded-0" style="height: 200px; object-fit: cover;">
                                </a>

                                <div class="p-3">
                                    <h5 class="fw-bold mb-2">
                                        <a href="{{ route('posts.show', $post) }}" class="text-decoration-none text-dark">
                                            {{ $post->judul }}
                                        </a>
                                    </h5>
                                    
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div class="d-flex gap-1">
                                            @foreach($post->categories->take(2) as $cat)
                                                <span class="badge bg-light text-primary border">{{ $cat->nama_kategori }}</span>
                                            @endforeach
                                        </div>
                                        <div class="small text-muted d-flex gap-2">
                                            <span><i class="bi bi-eye"></i> {{ $post->views }}</span>
                                            <span><i class="bi bi-heart"></i> {{ $post->likes_count }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <img src="{{ asset('storage/images/empty.png') }}" style="width: 150px; opacity: 0.5;">
                        <p class="text-muted mt-3">Belum ada postingan untuk kategori ini.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-5 d-flex justify-content-center">
                {{ $posts->withQueryString()->links() }}
            </div>

        </div>
    </div>
</div>
@endsection