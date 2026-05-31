<nav class="navbar-main-desktop navbar-main-mobile navbar navbar-expand-lg border-bottom shadow-sm">
    <div class="container-fluid px-lg-5">
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav gap-lg-3 py-2 py-lg-0">
                @foreach($navbarMenus as $menu)
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs($menu['route']) ? 'active fw-bold gradient-text-primary' : 'gradient-text-secondary' }}" 
                           href="{{ route($menu['route']) }}">
                            {{ $menu['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>