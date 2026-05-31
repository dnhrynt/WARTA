@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="mb-4 d-flex justify-content-between align-items-start">
        <div>
            <h2 class="fw-bold gradient-text-primary mb-2">
                {{ $post->judul }}
            </h2>

            {{-- META --}}
            <div class="text-muted small mb-2 d-inline-flex flex-wrap align-items-center gap-3">
                <span class="d-inline-flex align-items-center gap-2">
                    <a href="{{ route('author.profile', $post->author) }}">
                        {{-- FOTO PROFIL AUTHOR --}}
                        @if($post->author->foto_profile)
                            <img
                                src="{{ asset('storage/' . $post->author->foto_profile) }}"
                                alt="Foto {{ $post->author->username }}"
                                class="rounded-circle"
                                style="width: 32px; height: 32px; object-fit: cover;"
                            >
                        @else
                            <div
                                class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
                                style="width: 32px; height: 32px; background:#667eea; font-size: 0.85rem;"
                            >
                                {{ strtoupper(substr($post->author->username, 0, 1)) }}
                            </div>
                        @endif
                    </a>
                    <span>
                        {{ $post->author->nama_lengkap ?? $post->author->username }}
                    </span>
                </span>
                <span>
                    <i class="bi bi-calendar-event me-1"></i>
                    {{ $post->published_at 
                        ? $post->published_at->format('d M Y') 
                        : $post->created_at->format('d M Y') }}
                </span>

                @if($post->status === 'published')
                    <span>
                        <i class="bi bi-eye me-1"></i>
                        {{ $post->views ?? 0 }} views
                    </span>
                    <span>
                        <i class="bi bi-share me-1"></i>
                        {{ $post->shared ?? 0 }} shared
                    </span>
                    <span>
                        <i class="bi bi-heart me-1"></i>
                        {{ $post->likes->count() }} likes
                    </span>
                @endif
            </div>
            <div class="text-secondary mb-3">
                <small>{{ $post->author->info ?? '' }}</small>
            </div>

            <div class="d-inline-flex align-items-center flex-wrap gap-3">
                {{-- KATEGORI --}}
                <div class="mb-3">
                    @foreach($post->categories as $kat)
                        <span class="badge bg-secondary me-1">
                            {{ $kat->nama_kategori }}
                        </span>
                    @endforeach
                </div>

                @if(Auth::id() === $post->author_id)

                    {{-- STATUS --}}
                    <div class="mb-3">
                        @if($post->status === 'draft')
                            <span class="badge bg-warning text-dark">Draft</span>
                        @elseif($post->status === 'published')
                            <span class="badge bg-success">Published</span>
                        @else
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </div>

                    {{-- REJECTION --}}
                    @if($post->status === 'rejected')
                        <div class="alert alert-danger">
                            <strong>Postingan Ditolak</strong><br>
                            {{ $post->rejection_reason }}
                        </div>
                    @endif

                @endif
            </div>


        </div>

        @php
            $backUrl = url()->previous() !== url()->current()
                ? url()->previous()
                : route('dashboard');
        @endphp

        <a href="{{ $backUrl }}" class="btn btn-sm btn-gradient-secondary mb-3">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>


    </div>

    {{-- GAMBAR --}}
    @if($post->gambar)
        <div class="mb-4">
            <img
                src="{{ asset('storage/' . $post->gambar) }}"
                class="img-fluid rounded shadow-sm"
                style="max-height: 420px; width: 100%; object-fit: cover;"
                alt="{{ $post->judul }}"
            >
        </div>
    @endif

    {{-- KONTEN --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body fs-6 lh-lg">
            {!! nl2br(e($post->konten)) !!}
        </div>
    </div>

    {{-- ACTIONS --}}
    @php
        $shareUrl = urlencode(url()->current());
        $shareText = urlencode($post->judul);
    @endphp

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

        {{-- LEFT: SHARE + LIKE --}}
        <div class="d-flex align-items-center gap-2">

            {{-- LIKE --}}
            @auth
                <button
                    type="button"
                    class="btn d-flex align-items-center gap-1 like-btn
                        {{ $post->isLikedBy(auth()->user()) ? 'text-danger' : 'text-muted' }}"
                    data-post-id="{{ $post->id }}"
                >
                    <i class="bi {{ $post->isLikedBy(auth()->user()) ? 'bi-heart-fill' : 'bi-heart' }} fs-4"></i>
                    <span class="like-count">{{ $post->likes->count() }}</span>
                </button>

            @else
                <a href="{{ route('login') }}"
                class="btn text-muted d-flex align-items-center gap-1"
                title="Login untuk menyukai">
                    <i class="bi bi-heart fs-4"></i>
                    <span>{{ $post->likes->count() }}</span>
                </a>
            @endauth

            {{-- SHARE --}}
            <a href="https://wa.me/?text={{ $shareText }}%20{{ $shareUrl }}"
            target="_blank"
            class="btn text-success">
                <i class="bi bi-whatsapp fs-4"></i>
            </a>

            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}"
            target="_blank"
            class="btn text-primary">
                <i class="bi bi-facebook fs-4"></i>
            </a>

            <a href="https://t.me/share/url?url={{ $shareUrl }}&text={{ $shareText }}"
            target="_blank"
            class="btn text-info">
                <i class="bi bi-telegram fs-4"></i>
            </a>
        </div>

        {{-- RIGHT: AUTHOR ACTION --}}
        @if(Auth::id() === $post->author_id)
            <div class="d-flex gap-2">
                <a href="{{ route('posts.edit', $post) }}" class="btn btn-gradient-primary">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <form action="{{ route('posts.destroy', $post) }}"
                    method="POST"
                    onsubmit="return confirm('Yakin hapus postingan ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-gradient-danger">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </form>
            </div>
        @endif
    </div>

</div>
@endsection

@auth
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.like-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const postId = btn.dataset.postId;

            fetch(`/posts/${postId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                const icon = btn.querySelector('i');
                const count = btn.querySelector('.like-count');

                count.textContent = data.total_likes;

                if (data.status === 'liked') {
                    icon.classList.remove('bi-heart');
                    icon.classList.add('bi-heart-fill');
                    btn.classList.add('text-danger');
                    btn.classList.remove('text-muted');
                } else {
                    icon.classList.remove('bi-heart-fill');
                    icon.classList.add('bi-heart');
                    btn.classList.remove('text-danger');
                    btn.classList.add('text-muted');
                }
            });
        });
    });
});
</script>
@endauth

