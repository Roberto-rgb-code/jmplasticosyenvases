<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>@yield('title', 'JM Plásticos y Envases')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <meta name="description" content="Fabricación y venta de envases PET. Catálogo, cotización rápida y atención personalizada.">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preconnect" href="https://api.iconify.design" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    :root {
      --brand: #0d9488;
      --brand-2: #0f766e;
      --brand-ink: #042f2e;
      --accent: #f4b942;
      --ink: #0f172a;
      --muted: #64748b;
      --line: #d9e2ec;
      --soft: #f4f7f6;
      --radius: 1.5rem;
      --shadow: 0 18px 50px rgba(15, 23, 42, .08);
    }
    * { box-sizing: border-box; }
    html {
      scroll-behavior: smooth;
      overflow-x: clip;
      -webkit-text-size-adjust: 100%;
      text-size-adjust: 100%;
    }
    body {
      font-family: "Plus Jakarta Sans", system-ui, sans-serif;
      color: var(--ink);
      background:
        radial-gradient(1200px 500px at 100% -10%, #ccfbf1 0%, transparent 55%),
        radial-gradient(900px 400px at -10% 20%, #fef3c7 0%, transparent 50%),
        #fbfdfc;
      line-height: 1.65;
      min-height: 100vh;
      overflow-x: clip;
      padding-top: calc(5.75rem + env(safe-area-inset-top));
      touch-action: manipulation;
    }
    img, svg, video { max-width: 100%; height: auto; }
    main { padding-bottom: .5rem; }
    .min-w-0 { min-width: 0; }
    body::before {
      content: "";
      position: fixed; inset: 0; pointer-events: none; z-index: 0;
      opacity: .28;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='140' height='140'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.85' numOctaves='2' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='140' height='140' filter='url(%23n)' opacity='.35'/%3E%3C/svg%3E");
    }
    main, .site-footer, .wa-fab { position: relative; z-index: 1; }
    a { color: var(--brand-2); }
    .font-display { font-family: Fraunces, Georgia, serif; letter-spacing: -.03em; }
    .container-narrow { max-width: 1140px; }
    .display-4 { font-size: clamp(1.85rem, 7vw, 3.25rem) !important; }
    .display-5 { font-size: clamp(1.55rem, 5.6vw, 2.6rem) !important; }
    .lead { font-size: clamp(1rem, 2.4vw, 1.2rem); }
    .jm-icon { display: inline-block; vertical-align: -0.2em; flex-shrink: 0; max-width: none; height: auto; width: auto; }

    .nav-float-wrap {
      position: fixed; z-index: 1080;
      top: max(.65rem, env(safe-area-inset-top));
      left: 0; right: 0;
      padding: 0 max(.75rem, env(safe-area-inset-right)) 0 max(.75rem, env(safe-area-inset-left));
      pointer-events: none;
    }
    .nav-float {
      pointer-events: auto;
      max-width: 1140px;
      margin: 0 auto;
      display: flex;
      align-items: center;
      gap: .65rem;
      background: rgba(255,255,255,.94);
      backdrop-filter: blur(22px) saturate(1.4);
      border-radius: 1.75rem;
      padding: .55rem .6rem .55rem .9rem;
      box-shadow: 0 18px 44px rgba(15, 23, 42, .14);
      border: 1px solid rgba(255,255,255,.95);
      flex-wrap: nowrap;
    }
    .nav-brand {
      display: flex; align-items: center; gap: .65rem;
      text-decoration: none; min-width: 0;
    }
    .navbar-logo {
      height: 46px; width: auto; border-radius: 12px;
      box-shadow: 0 8px 18px rgba(13, 148, 136, .16);
    }
    .brand-text { font-weight: 800; letter-spacing: -.03em; color: var(--brand-ink); }
    .nav-chips {
      display: none; align-items: center; gap: .5rem; flex: 1; min-width: 0;
    }
    .nav-chip {
      display: inline-flex; align-items: center; gap: .4rem;
      background: #fff; border: 1px solid #e8eef3; border-radius: 999px;
      padding: .42rem .85rem; font-size: .8rem; font-weight: 700; color: #334155;
      white-space: nowrap; box-shadow: 0 4px 12px rgba(15,23,42,.04);
    }
    .nav-links { display: none; align-items: center; gap: .15rem; margin-left: auto; }
    .nav-links a {
      color: #334155; text-decoration: none; font-weight: 700; font-size: .9rem;
      padding: .45rem .7rem; border-radius: 999px;
    }
    .nav-links a:hover, .nav-links a.active { background: #f0fdfa; color: var(--brand-2); }
    .nav-actions { display: flex; align-items: center; gap: .45rem; margin-left: auto; }
    .nav-icon-btn {
      width: 2.65rem; height: 2.65rem; border-radius: 1rem;
      border: 1px solid #e8eef3; background: #fff; color: var(--ink);
      display: grid; place-items: center; position: relative; text-decoration: none;
    }
    .nav-icon-btn:hover { border-color: var(--brand); background: #f0fdfa; }
    .nav-burger {
      width: 1.05rem; height: .72rem; display: grid; align-content: space-between;
    }
    .nav-burger span {
      display: block; height: 2px; border-radius: 999px; background: #0f766e;
    }
    .nav-icon-btn .badge {
      font-size: .65rem; min-width: 1.15rem; padding: .2em .35em;
    }
    .btn-nav-cta {
      display: none; align-items: center; gap: .4rem;
      background: #12324a; color: #fff !important; text-decoration: none;
      font-weight: 800; font-size: .82rem; letter-spacing: .01em;
      border-radius: 1rem; padding: .72rem 1rem; white-space: nowrap;
    }
    .btn-nav-cta:hover { background: #0b2233; color: #fff; }
    @media (min-width: 992px) {
      .nav-links { display: flex; }
      .btn-nav-cta { display: inline-flex; }
      .nav-actions { margin-left: 0; }
      .nav-menu-btn { display: none !important; }
    }
    @media (min-width: 1200px) {
      .nav-chips { display: flex; }
    }

    .btn-brand, .btn-ghost {
      display: inline-flex; align-items: center; justify-content: center; gap: .35rem;
      min-height: 48px;
    }
    .btn-brand {
      background: linear-gradient(135deg, #14b8a6, #0f766e);
      border: 0; color: #fff; font-weight: 700; border-radius: 999px;
      padding: .78rem 1.35rem; box-shadow: 0 10px 24px rgba(13, 148, 136, .28);
    }
    .btn-brand:hover { color: #fff; filter: brightness(1.05); transform: translateY(-1px); }
    .btn-ghost {
      border: 1px solid var(--line); background: #fff; color: var(--ink);
      font-weight: 700; border-radius: 999px; padding: .78rem 1.35rem;
    }
    .btn-ghost:hover { border-color: var(--brand); color: var(--brand-2); background: #f0fdfa; }
    .btn-ghost.btn-sm { min-height: 44px; padding: .4rem .95rem; }
    .chip {
      display: inline-flex; align-items: center; gap: .45rem;
      background: #ecfdf5; color: #115e59; border: 1px solid #99f6e4;
      border-radius: 999px; padding: .4rem .9rem; font-weight: 700; font-size: .82rem;
      box-shadow: inset 0 1px 0 #fff;
    }
    .hero {
      background:
        radial-gradient(800px 280px at 80% 0%, rgba(20, 184, 166, .16), transparent 60%),
        radial-gradient(600px 240px at 10% 40%, rgba(244, 185, 66, .18), transparent 55%);
      padding-block: 2.5rem 3.5rem;
    }
    .display-tight { letter-spacing: -.045em; font-weight: 800; }
    .card-soft {
      background: color-mix(in srgb, #fff 92%, transparent);
      border: 1px solid color-mix(in srgb, #fff 60%, var(--line));
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      backdrop-filter: blur(10px);
    }
    .product-card { overflow: hidden; transition: transform .28s ease, box-shadow .28s ease; }
    .product-card:hover { transform: translateY(-8px); box-shadow: 0 28px 60px rgba(15, 118, 110, .16); }
    .product-media {
      background:
        radial-gradient(circle at 70% 20%, rgba(20, 184, 166, .18), transparent 45%),
        linear-gradient(180deg, #eef8f6, #fff);
      height: 250px; display: grid; place-items: center; padding: 1.4rem; position: relative;
    }
    .product-media::after {
      content: ""; position: absolute; inset: auto 12% 12px 12%; height: 18px;
      background: radial-gradient(ellipse, rgba(15,23,42,.12), transparent 70%);
    }
    .product-media img {
      max-height: 200px; width: auto; max-width: 100%; object-fit: contain;
      filter: drop-shadow(0 18px 18px rgba(15,23,42,.12));
      transition: transform .35s ease;
    }
    .product-card:hover .product-media img { transform: scale(1.07) translateY(-6px); }
    .spec-pill {
      background: #f0fdfa; border: 1px solid #99f6e4; border-radius: 999px;
      padding: .28rem .7rem; font-size: .78rem; font-weight: 700; color: #115e59;
    }
    .icon-tile {
      width: 3.1rem; height: 3.1rem; border-radius: 1rem;
      display: grid; place-items: center; color: #0f766e;
      background: linear-gradient(180deg, #ccfbf1, #fff);
      border: 1px solid #99f6e4;
    }
    .process-num {
      width: 2.6rem; height: 2.6rem; border-radius: 999px; display: grid; place-items: center;
      background: var(--brand-ink); margin-bottom: .8rem;
    }
    .stat-card {
      background: #fff; border: 1px solid var(--line); border-radius: 1.1rem; padding: 1rem 1.1rem;
    }
    .stat-card strong { font-size: 1.55rem; display: block; color: var(--brand-ink); }
    .cta-banner {
      background: linear-gradient(135deg, #042f2e 0%, #0f766e 55%, #14b8a6 100%);
      color: #fff; border-radius: 2rem; overflow: hidden; position: relative;
    }
    .cta-banner::after {
      content: ""; position: absolute; right: -40px; top: -40px; width: 220px; height: 220px;
      background: radial-gradient(circle, rgba(244,185,66,.4), transparent 65%);
    }
    .site-footer {
      background:
        radial-gradient(600px 200px at 90% 0%, rgba(20,184,166,.25), transparent 50%),
        #042f2e;
      color: #cbd5e1;
    }
    .site-footer a { color: #e2e8f0; text-decoration: none; }
    .site-footer a:hover { color: #99f6e4; }
    .wa-fab {
      position: fixed; z-index: 1040;
      right: max(.85rem, env(safe-area-inset-right));
      bottom: max(.85rem, env(safe-area-inset-bottom));
      width: 3.4rem; height: 3.4rem; border-radius: 999px;
      background: linear-gradient(180deg, #4ade80, #16a34a); color: #fff;
      display: grid; place-items: center;
      box-shadow: 0 14px 30px rgba(22, 163, 74, .4);
    }
    .wa-fab:hover { color: #fff; transform: translateY(-3px) scale(1.04); }
    .stepper {
      display: inline-flex; border: 1px solid var(--line); border-radius: 999px;
      overflow: hidden; background: #fff;
    }
    .stepper button {
      width: 2.75rem; height: 2.75rem; border: 0; background: #f0fdfa;
      font-weight: 800; color: var(--brand-2); display: grid; place-items: center;
    }
    .stepper input {
      width: 3.1rem; border: 0; text-align: center; font-weight: 800;
      font-size: 16px; min-width: 0;
    }
    .form-control, .form-select { border-radius: .9rem; border-color: var(--line); padding: .8rem 1rem; font-size: 16px; }
    .form-control:focus, .form-select:focus {
      border-color: #14b8a6; box-shadow: 0 0 0 .25rem rgba(20, 184, 166, .15);
    }
    .form-floating > .form-control { border-radius: .9rem; }
    .hero-frame {
      border-radius: 2rem; overflow: hidden; box-shadow: var(--shadow);
      border: 8px solid #fff; position: relative;
    }
    .hero-frame img { height: 420px; object-fit: cover; width: 100%; }
    .carousel-control-prev, .carousel-control-next {
      width: 3rem; height: 3rem; top: 50%; transform: translateY(-50%);
      background: rgba(255,255,255,.9); border-radius: 999px; opacity: 1; margin: 0 .7rem;
    }
    .carousel-control-prev-icon, .carousel-control-next-icon { filter: invert(1); }
    .empty-state { text-align: center; padding: 4rem 1.5rem; }
    .empty-orb {
      width: 5.5rem; height: 5.5rem; margin: 0 auto 1rem; border-radius: 2rem;
      display: grid; place-items: center;
      background: linear-gradient(180deg, #ccfbf1, #fff); border: 1px solid #99f6e4;
    }
    .btn .jm-icon, .chip .jm-icon, .spec-pill .jm-icon, .nav-chip .jm-icon { margin-right: .15rem; }
    .cart-line {
      display: grid;
      grid-template-columns: 72px minmax(0, 1fr) auto;
      gap: .85rem .9rem;
      align-items: start;
    }
    .cart-thumb { width: 72px; height: 72px; }
    .offcanvas { width: min(100%, 22rem); z-index: 1090; }
    .offcanvas-backdrop { z-index: 1085; }
    .alert { position: relative; z-index: 1; }
    .alert .btn-close { flex-shrink: 0; }
    .offcanvas-body { align-content: start; }
    .offcanvas-body .btn {
      min-height: 48px;
      justify-content: flex-start;
      width: 100%;
    }
    .offcanvas-header, .offcanvas-body {
      padding-left: max(1rem, env(safe-area-inset-left));
      padding-right: max(1rem, env(safe-area-inset-right));
    }
    .offcanvas-body { padding-bottom: max(1rem, env(safe-area-inset-bottom)); }
    .site-footer a { word-break: break-word; }
    .product-card h3 { overflow-wrap: anywhere; }
    .breadcrumb { font-size: .9rem; }
    .contact-card { min-height: 100%; }
    @media (hover: none) {
      .product-card:hover { transform: none; box-shadow: var(--shadow); }
      .btn-brand:hover { transform: none; }
    }
    @media (max-width: 991.98px) {
      .nav-float { padding: .4rem .45rem .4rem .7rem; border-radius: 1.35rem; }
      .navbar-logo { height: 38px; border-radius: 10px; }
      .brand-text { font-size: .95rem; }
      .nav-icon-btn { width: 2.5rem; height: 2.5rem; border-radius: .9rem; }
    }
    @media (max-width: 767.98px) {
      body { padding-top: calc(5.1rem + env(safe-area-inset-top)); }
      main { padding-bottom: 1rem; }
      .brand-text { display: none; }
      .nav-float { gap: .4rem; }
      .hero { padding-block: 1.15rem 1.75rem; }
      .hero-actions, .hero .d-flex.flex-wrap.gap-2.mb-4 { display: grid !important; width: 100%; }
      .hero .btn-brand, .hero .btn-ghost, .cta-banner .btn { width: 100%; }
      .stat-card { padding: .7rem .45rem; text-align: center; }
      .stat-card strong { font-size: 1.15rem; }
      .stat-card .small { font-size: .68rem; line-height: 1.25; }
      .stat-card .jm-icon { display: none; }
      .product-media { height: 190px; padding: 1rem; }
      .product-media img { max-height: 150px; }
      .product-card .p-4 { padding: 1rem !important; }
      .product-card h3 { font-size: 1.05rem; }
      .hero-frame { border-width: 4px; border-radius: 1.25rem; }
      .hero-frame img { height: 220px; }
      .carousel-control-prev, .carousel-control-next { display: none; }
      .cta-banner { border-radius: 1.35rem; padding: 1.25rem !important; text-align: center; }
      .py-5 { padding-top: 2rem !important; padding-bottom: 2rem !important; }
      .g-5 { --bs-gutter-x: 1.25rem; --bs-gutter-y: 1.5rem; }
      .empty-state { padding: 2.25rem 1.1rem; }
      .wa-fab { width: 3.15rem; height: 3.15rem; }
      .spec-compact .fw-bold { font-size: .92rem !important; }
      .spec-compact .small { font-size: .68rem; }
      .spec-compact .icon-tile { width: 1.9rem !important; height: 1.9rem !important; }
      .cart-line { grid-template-columns: 64px minmax(0, 1fr); }
      .cart-line .cart-meta {
        grid-column: 1 / -1;
        display: flex; justify-content: space-between; align-items: center;
        gap: .75rem; text-align: left !important;
      }
      .sticky-lg-top { position: static !important; }
      .breadcrumb { font-size: .82rem; }
      .site-footer { margin-top: 0 !important; padding-bottom: calc(5.5rem + env(safe-area-inset-bottom)) !important; }
      .site-footer a { min-height: 44px; display: inline-flex; align-items: center; gap: .35rem; }
    }
    @media (max-width: 575.98px) {
      .chip { font-size: .75rem; padding: .32rem .7rem; }
      .process-num { margin-inline: auto; }
      .process-step { text-align: center; }
      .process-step .h6 { font-size: .95rem; }
      .container { padding-left: 1rem; padding-right: 1rem; }
    }
  </style>
  @stack('head')
</head>
<body>
  <div class="nav-float-wrap">
    <nav class="nav-float" aria-label="Principal">
      <a class="nav-brand" href="{{ route('inicio') }}">
        <img src="{{ asset('images/logojm.png') }}" alt="JM Plásticos" class="navbar-logo">
        <span class="brand-text">JM Plásticos</span>
      </a>

      <div class="nav-chips">
        <span class="nav-chip"><x-icon name="security" size="18" /> PET grado alimentario</span>
        <span class="nav-chip"><x-icon name="watch-loop" size="18" /> Respuesta en 24h</span>
      </div>

      <div class="nav-links">
        <a class="{{ request()->routeIs('inicio') ? 'active' : '' }}" href="{{ route('inicio') }}">Inicio</a>
        <a class="{{ request()->routeIs('productos.*') || request()->routeIs('producto.*') ? 'active' : '' }}" href="{{ route('productos.index') }}">Catálogo</a>
        <a class="{{ request()->routeIs('cotizacion.*') ? 'active' : '' }}" href="{{ route('cotizacion.cart') }}">Cotizador</a>
        <a class="{{ request()->routeIs('contacto') ? 'active' : '' }}" href="{{ route('contacto') }}">Contacto</a>
      </div>

      <div class="nav-actions">
        <a href="{{ route('cotizacion.cart') }}" class="nav-icon-btn" aria-label="Cotización">
          <x-icon name="clipboard-list" size="20" />
          @if(($cartCount ?? 0) > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $cartCount }}</span>
          @endif
        </a>
        <a class="btn-nav-cta" href="{{ route('productos.index') }}">
          <x-icon name="folder" size="18" color="ffffff" /> Ver catálogo
        </a>
        <button class="nav-icon-btn nav-menu-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#navOffcanvas" aria-controls="navOffcanvas" aria-label="Abrir menú">
          <span class="nav-burger" aria-hidden="true"><span></span><span></span><span></span></span>
        </button>
      </div>
    </nav>
  </div>

  <div class="offcanvas offcanvas-end" tabindex="-1" id="navOffcanvas">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title fw-bold">Menú</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
    </div>
    <div class="offcanvas-body d-grid gap-2">
      <a class="btn btn-ghost text-start" data-bs-dismiss="offcanvas" href="{{ route('inicio') }}"><x-icon name="home" /> Inicio</a>
      <a class="btn btn-ghost text-start" data-bs-dismiss="offcanvas" href="{{ route('productos.index') }}"><x-icon name="grid-3" /> Catálogo</a>
      <a class="btn btn-ghost text-start" data-bs-dismiss="offcanvas" href="{{ route('cotizacion.cart') }}"><x-icon name="clipboard-list" /> Cotizador</a>
      <a class="btn btn-ghost text-start" data-bs-dismiss="offcanvas" href="{{ route('contacto') }}"><x-icon name="chat-round-dots" /> Contacto</a>
      <a class="btn btn-brand" data-bs-dismiss="offcanvas" href="{{ route('productos.index') }}"><x-icon name="folder" color="ffffff" /> Ver productos</a>
    </div>
  </div>

  <main>
    @yield('content')
  </main>

  <footer class="site-footer py-5 mt-5">
    <div class="container container-narrow">
      <div class="row g-4">
        <div class="col-12 col-md-5">
          <div class="d-flex align-items-center gap-2 mb-3">
            <img src="{{ asset('images/logojm.png') }}" alt="" width="44" height="44" class="rounded-3">
            <strong class="text-white">JM Plásticos y Envases</strong>
          </div>
          <p class="mb-0 small opacity-75">Envases PET de 5 litros para alimentos e industria. Cotiza en minutos y recibe respuesta personalizada.</p>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
          <div class="text-white fw-bold mb-2">Navegar</div>
          <div class="d-grid gap-1 small">
            <a href="{{ route('inicio') }}"><x-icon name="home" size="16" color="e2e8f0" /> Inicio</a>
            <a href="{{ route('productos.index') }}"><x-icon name="grid-3" size="16" color="e2e8f0" /> Catálogo</a>
            <a href="{{ route('cotizacion.cart') }}"><x-icon name="clipboard-list" size="16" color="e2e8f0" /> Cotizador</a>
            <a href="{{ route('contacto') }}"><x-icon name="chat-round-dots" size="16" color="e2e8f0" /> Contacto</a>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
          <div class="text-white fw-bold mb-2">Contacto</div>
          <div class="d-grid gap-1 small">
            @if(config('contact.email'))
              <a href="mailto:{{ config('contact.email') }}"><x-icon name="email" size="16" color="e2e8f0" /> {{ config('contact.email') }}</a>
            @endif
            @if(config('contact.phone'))
              <a href="tel:{{ config('contact.phone') }}"><x-icon name="phone-call" size="16" color="e2e8f0" /> {{ config('contact.phone') }}</a>
              <a href="https://wa.me/{{ preg_replace('/\D+/', '', config('contact.phone')) }}" target="_blank" rel="noopener"><x-icon name="chat-round-dots" size="16" color="e2e8f0" /> WhatsApp</a>
            @endif
          </div>
        </div>
      </div>
      <div class="border-top border-secondary border-opacity-25 mt-4 pt-3 small opacity-50">
        © {{ date('Y') }} JM Plásticos y Envases.
      </div>
    </div>
  </footer>

  @if(config('contact.phone'))
    <a class="wa-fab" href="https://wa.me/{{ preg_replace('/\D+/', '', config('contact.phone')) }}" target="_blank" rel="noopener" aria-label="WhatsApp">
      <x-icon name="phone-call-loop" size="28" color="ffffff" />
    </a>
  @endif

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
</body>
</html>
