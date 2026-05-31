<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Warta - SMAN 1 Grabagan</title>
        <link rel="icon" type="image/png"
            href="{{ asset('storage/images/logo-sman-1-grabagan.png') }}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <style>
            /* --- GAYA GLOBAL (Warna, Gradient, Button) --- */
            .gradient-text-primary {
                background: linear-gradient(135deg, #f40f67ff, #3413f0ff);
                background-clip: text;
                -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            }
            .gradient-text-secondary {
                background: linear-gradient(135deg, #667eea, #764ba2);
                background-clip: text;
                -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            }
            .gradient-text-info {
                background: linear-gradient(135deg, #f013aaff, #3dd8f3ff);
                background-clip: text;
                -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            }
            .btn-gradient-primary {
                padding: 12px 24px; border: none; border-radius: 8px; font-weight: 600; color: #fff;
                background: linear-gradient(90deg, #f40f67ff, #3413f0ff); transition: .2s;
            }
            .btn-gradient-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(0,0,0,.2); }
            .btn-gradient-secondary {
                padding: 12px 24px; border: none; border-radius: 8px; font-weight: 600; color: #fff;
                background: linear-gradient(90deg, #6677ea, #764ba2); transition: .2s;
            }
            .btn-gradient-secondary:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(0,0,0,.2); }
            .btn-gradient-danger {
                padding: 12px 24px; border: none; border-radius: 8px; font-weight: 600; color: #fff;
                background: linear-gradient(90deg, #e42626, #980505); transition: .2s;
            }
            .btn-gradient-danger:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(0,0,0,.2); }

            /* KATEGORI X-SCROLLING (Global) */
            .nav-scroll {
                display: flex; flex-wrap: nowrap; overflow-x: auto; 
                -webkit-overflow-scrolling: touch; scrollbar-width: none;
            }
            .nav-scroll::-webkit-scrollbar { display: none; }
            .nav-scroll .nav-link { white-space: nowrap; }

            .table thead th {
                background: linear-gradient(135deg, #667aaecb, #764ba2c7) !important;
                color: #fff;
                padding: 10px;
            }    

            /* =============================================
            GAYA KHUSUS DESKTOP (Min-width 992px)
            ============================================= */
            @media (min-width: 992px) {
                .app-header {
                    position: fixed; top: 0; left: 0; right: 0;
                    padding-top: 7px;
                    height: 80px; z-index: 1050; background: #fff;
                }
                /* Navbar Utama (Home, dll) */
                .navbar-main-desktop {
                    position: fixed; top: 80px; left: 0; right: 0;
                    z-index: 1040; background: #f8f9fa;
                }
                .app-content {
                    padding: 35px 80px;
                    margin-top: 190px; /* Jarak untuk Header + Navbar + Kategori */
                }
                .category-nav-fixed {
                    position: fixed; top: 140px; left: 100px; right: 100px;
                    z-index: 1030; background: #fff;
                }

                .top-guest { top: 90px; }
                .top-auth { top: 145px; }
                
                /* Layout Scrollable Desktop */
                .dashboard-scroll { height: calc(100vh - 220px); }
                .dashboard-left, .dashboard-right { height: 100%; overflow-y: auto; padding-right: 6px; }

            }

            /* =============================================
            GAYA KHUSUS MOBILE (Max-width 991px)
            ============================================= */
            @media (max-width: 991px) {
                .app-header {
                    position: fixed; top: 0; left: 0; right: 0;
                    z-index: 1100; background: #fff; padding-bottom: 10px;
                }
                /* Navbar Utama Mobile (Disediakan untuk Collapse) */
                .navbar-main-mobile {
                    position: fixed; top: 115px; left: 0; right: 0;
                    z-index: 1090; background: #fff;
                }
                .app-content {
                    padding: 15px;
                    margin-top: 175px; /* Sesuaikan agar tidak tertutup header 2 baris */
                }
                .category-nav-fixed {
                    position: fixed; top: 118px; left: 0 !important; right: 0 !important;
                    z-index: 1080; background: #fff; padding: 0 10px;
                }
                /* Reset scroll desktop */
                .dashboard-scroll, .dashboard-left, .dashboard-right {
                    height: auto !important; overflow: visible !important;
                }
                /* Kategori tepat di bawah header mobile */
                .top-guest, .top-auth { top: 125px !important; }
                .category-nav-fixed { left: 0 !important; right: 0 !important; padding: 0 10px !important; }
                
                .hero-section > div { position: static; }
                .hero-grid { grid-template-columns: 1fr; }
            }
        </style>
    </head>
    <body>

        {{-- HEADER --}}
        @include('layouts.header')

        {{-- NAVBAR UTAMA (HANYA LOGIN) --}}
        @auth
            @include('layouts.navbar')
        @endauth

        {{-- CONTENT --}}
        <main class="app-content">
            @yield('content')
        </main>

        @stack('scripts')
    </body>

</html>