<header class="app-header border-bottom shadow-sm">
    <div class="container-fluid px-3 px-lg-4">
        <div class="d-flex justify-content-between align-items-center py-2">
            <div class="d-flex align-items-center gap-2">
                <img src="{{ asset('storage/images/logo-sman-1-grabagan.png') }}" style="height: 45px;">
                <div class="lh-sm">
                    <h5 class="mb-0 gradient-text-secondary fw-bold">WARTA SMAGRA</h5>
                    <small class="text-muted">Platform Resmi Berita dan Kegiatan SMAN 1 Grabagan</small>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <form action="{{ route('dashboard') }}" class="d-none d-lg-block">
                    <div class="input-group input-group-sm">
                        <input type="text" name="search" class="form-control" placeholder="Cari..." value="{{ request('search') }}">
                        <button class="btn btn-primary"><i class="bi bi-search"></i></button>
                    </div>
                </form>

                @auth
                    <div class="dropdown">
                        <button class="btn p-0 border-0" data-bs-toggle="dropdown">
                            @if (auth()->user()->foto_profile)
                                <img src="{{ asset('storage/' . auth()->user()->foto_profile) }}"
                                class="rounded-circle shadow-sm"
                                width="40"
                                height="40"
                                style="object-fit: cover;">
                            @else
                                <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                    style="width:40px; height:40px; background:#667eea; color:white; font-weight:600;">
                                        {{ strtoupper(substr(auth()->user()->username, 0, 1)) }}
                                </div>
                            @endif
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li><a class="dropdown-item" href="{{ route('profile.index') }}">Profil Saya</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">@csrf
                                    <button class="dropdown-item text-danger">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-sm btn-primary px-3">Login</a>
                @endauth
            </div>
        </div>

        <div class="d-flex d-lg-none py-2 border-top gap-2 align-items-center">
            <button class="btn btn-light border btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
                <i class="bi bi-list fs-4"></i>
            </button>
            <form action="{{ route('dashboard') }}" class="flex-grow-1">
                <div class="input-group input-group-sm">
                    <input type="text" name="search" class="form-control" placeholder="Cari berita..." value="{{ request('search') }}">
                    <button class="btn btn-primary"><i class="bi bi-search"></i></button>
                </div>
            </form>
        </div>
    </div>
</header>