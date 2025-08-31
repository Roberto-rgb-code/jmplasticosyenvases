<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>@yield('title','JM Plásticos y Envases')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Fabricación y venta de envases y botellas PET. Atención rápida y personalizada.">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  {{-- Bootstrap & Icons --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  {{-- Google Fonts --}}
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  {{-- Estilos mejorados UX/UI --}}
  <style>
    :root{
      --brand: #6366f1;           /* índigo moderno */
      --brand-light: #818cf8;     /* índigo claro */
      --brand-dark: #4f46e5;      /* índigo oscuro */
      --accent: #06b6d4;          /* cyan vibrante */
      --success: #10b981;         /* verde éxito */
      --warning: #f59e0b;         /* ámbar */
      --danger: #ef4444;          /* rojo */
      --ink: #0f172a;            /* texto principal */
      --ink-light: #334155;      /* texto secundario */
      --muted: #64748b;          /* texto terciario */
      --soft: #f8fafc;           /* fondos suaves */
      --border: #e2e8f0;         /* bordes */
      --shadow: rgba(15, 23, 42, 0.1);
      --shadow-lg: rgba(15, 23, 42, 0.15);
    }

    * {
      box-sizing: border-box;
    }

    html, body { 
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
      color: var(--ink); 
      background: #fff; 
      scroll-behavior: smooth; 
      line-height: 1.6;
    }

    /* Announcement Bar Mejorado */
    .announcement{
      background: linear-gradient(135deg, #0f766e 0%, #0891b2 100%);
      color: #fff; 
      font-size: 0.875rem; 
      font-weight: 500;
      position: relative;
      overflow: hidden;
    }
    .announcement::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
      animation: shimmer 3s infinite;
    }
    @keyframes shimmer {
      0% { left: -100%; }
      100% { left: 100%; }
    }
    .announcement a.btn{ 
      background: rgba(255,255,255,0.2); 
      border: 1px solid rgba(255,255,255,0.3);
      color: #fff;
      backdrop-filter: blur(10px);
      transition: all 0.3s ease;
    }
    .announcement a.btn:hover{ 
      background: rgba(255,255,255,0.3);
      color: #fff;
      transform: translateY(-1px);
    }

    /* Navbar Mejorado */
    .navbar{ 
      backdrop-filter: saturate(180%) blur(20px); 
      background: rgba(255, 255, 255, 0.95);
      border-bottom: 1px solid rgba(226, 232, 240, 0.6);
      box-shadow: 0 1px 3px var(--shadow);
      transition: all 0.3s ease;
    }

    .navbar-logo {
      height: 72px;
      width: auto;
      border-radius: 16px;
      box-shadow: 0 6px 20px rgba(15, 23, 42, 0.2);
      transition: all 0.3s ease;
    }

    .navbar-brand:hover .navbar-logo {
      transform: scale(1.1);
      box-shadow: 0 8px 25px rgba(15, 23, 42, 0.25);
    }

    .brand-text{ 
      font-weight: 800; 
      letter-spacing: -0.5px; 
      font-size: 1.5rem;
      background: linear-gradient(135deg, var(--brand) 0%, var(--accent) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    .nav-link{ 
      font-weight: 500; 
      transition: all 0.3s ease;
      position: relative;
      color: var(--ink-light) !important;
    }
    .nav-link:hover {
      color: var(--brand) !important;
      transform: translateY(-1px);
    }
    .nav-link.active{ 
      color: var(--brand) !important; 
      font-weight: 600; 
    }
    .nav-link.active::after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 6px;
      height: 6px;
      background: var(--brand);
      border-radius: 50%;
    }

    /* Botones Mejorados */
    .btn-brand{ 
      background: linear-gradient(135deg, var(--brand) 0%, var(--brand-light) 100%);
      border: none; 
      color: #fff;
      font-weight: 600;
      padding: 0.75rem 2rem;
      border-radius: 12px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
      position: relative;
      overflow: hidden;
    }
    .btn-brand::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
      transition: left 0.6s ease;
    }
    .btn-brand:hover::before {
      left: 100%;
    }
    .btn-brand:hover{ 
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
      color: #fff;
    }
    .btn-brand:active {
      transform: translateY(0);
    }

    .btn-outline-secondary {
      border: 2px solid var(--border);
      color: var(--ink-light);
      font-weight: 600;
      padding: 0.75rem 2rem;
      border-radius: 12px;
      transition: all 0.3s ease;
      background: #fff;
    }
    .btn-outline-secondary:hover {
      border-color: var(--brand);
      color: var(--brand);
      transform: translateY(-2px);
      box-shadow: 0 8px 25px var(--shadow);
    }

    /* Hero Gradient Mejorado */
    .hero-gradient{
      background: 
        radial-gradient(circle at 20% 50%, rgba(99, 102, 241, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(6, 182, 212, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 40% 80%, rgba(16, 185, 129, 0.05) 0%, transparent 50%),
        linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
      position: relative;
      overflow: hidden;
    }
    .hero-gradient::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: 
        radial-gradient(circle at 50% 0%, rgba(99, 102, 241, 0.05) 0%, transparent 70%);
      pointer-events: none;
    }

    /* Cards Mejoradas */
    .feature-card {
      background: #fff;
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 2rem;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      overflow: hidden;
    }
    .feature-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(135deg, var(--brand) 0%, var(--accent) 100%);
      transform: scaleX(0);
      transition: transform 0.3s ease;
    }
    .feature-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 20px 40px var(--shadow-lg);
      border-color: var(--brand);
    }
    .feature-card:hover::before {
      transform: scaleX(1);
    }
    .feature-card .icon {
      width: 64px;
      height: 64px;
      background: linear-gradient(135deg, var(--brand) 0%, var(--accent) 100%);
      border-radius: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      margin: 0 auto 1.5rem;
      font-size: 1.5rem;
    }

    /* Badge mejorado */
    .badge-modern {
      background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(6, 182, 212, 0.1) 100%);
      color: var(--brand-dark);
      border: 1px solid rgba(99, 102, 241, 0.2);
      padding: 0.5rem 1rem;
      border-radius: 50px;
      font-weight: 600;
      font-size: 0.875rem;
    }

    /* Floating WhatsApp mejorado */
    .floating-wa{ 
      position: fixed; 
      right: 24px; 
      bottom: 24px; 
      z-index: 9999; 
    }
    .floating-wa a{
      width: 64px; 
      height: 64px; 
      display: inline-flex; 
      align-items: center; 
      justify-content: center;
      border-radius: 50%; 
      background: linear-gradient(135deg, #25D366 0%, #20ba5a 100%);
      color: #fff; 
      box-shadow: 0 8px 30px rgba(37, 211, 102, 0.4);
      text-decoration: none;
      transition: all 0.3s ease;
      font-size: 1.5rem;
    }
    .floating-wa a:hover {
      transform: translateY(-3px) scale(1.05);
      box-shadow: 0 12px 40px rgba(37, 211, 102, 0.5);
      color: #fff;
    }
    .floating-wa a:active {
      transform: translateY(-1px) scale(1.02);
    }

    /* Secciones mejoradas */
    .section-divider {
      height: 1px;
      background: linear-gradient(90deg, transparent, var(--border), transparent);
    }

    /* Contenedor narrow mejorado */
    .container-narrow{ 
      max-width: 1200px; 
    }

    /* Animaciones */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .animate-fade-in-up {
      animation: fadeInUp 0.8s ease-out forwards;
    }

    /* Responsive improvements */
    @media (max-width: 768px) {
      .hero-gradient {
        padding: 3rem 0 !important;
      }
      .btn-brand, .btn-outline-secondary {
        padding: 0.625rem 1.5rem;
        font-size: 0.9rem;
      }
      .brand-text {
        font-size: 1.1rem;
      }
      .navbar-logo {
        height: 56px;
      }
    }

    /* Contact section improvements */
    .contact-item {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      padding: 1rem;
      background: #fff;
      border: 1px solid var(--border);
      border-radius: 12px;
      transition: all 0.3s ease;
      text-decoration: none;
      color: var(--ink);
    }
    .contact-item:hover {
      border-color: var(--brand);
      transform: translateY(-2px);
      box-shadow: 0 8px 25px var(--shadow);
      color: var(--brand);
    }
    .contact-item i {
      font-size: 1.25rem;
    }
  </style>
  @stack('head')
</head>
<body>
  {{-- Announcement bar mejorado --}}
  <div class="announcement py-2">
    <div class="container container-narrow d-flex justify-content-between align-items-center gap-2 flex-wrap">
      <div class="d-flex gap-4 align-items-center">
        <span class="d-flex align-items-center gap-2">
          <i class="bi bi-envelope"></i> 
          <span class="d-none d-sm-inline">{{ config('contact.email') }}</span>
        </span>
        <span class="d-flex align-items-center gap-2">
          <i class="bi bi-telephone"></i> 
          <span class="d-none d-sm-inline">{{ config('contact.phone') }}</span>
        </span>
      </div>
      <a href="{{ route('cotizacion.cart') }}" class="btn btn-sm fw-semibold">
        <i class="bi bi-bag me-1"></i> 
        <span class="d-none d-sm-inline">Ir al </span>cotizador
      </a>
    </div>
  </div>

  {{-- Navbar principal mejorado --}}
  <nav class="navbar navbar-expand-lg sticky-top">
    <div class="container container-narrow">
      <a class="navbar-brand d-flex align-items-center" href="{{ route('inicio') }}">
        <img src="{{ asset('images/logojm.png') }}" alt="JM Plásticos" class="navbar-logo me-3">
        <span class="brand-text">JM Plásticos <span>& Envases</span></span>
      </a>
      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMain" aria-controls="navMain" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navMain">
        <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
          <li class="nav-item">
            <a class="nav-link px-3 {{ request()->routeIs('inicio') ? 'active' : '' }}" href="{{ route('inicio') }}">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link px-3 {{ request()->routeIs('productos.*') ? 'active' : '' }}" href="{{ route('productos.index') }}">Productos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link px-3 {{ request()->routeIs('cotizacion.*') ? 'active' : '' }}" href="{{ route('cotizacion.cart') }}">Cotizador</a>
          </li>
          <li class="nav-item">
            <a class="nav-link px-3" href="#contacto">Contáctanos</a>
          </li>
          <li class="nav-item ms-lg-3">
            <a class="btn btn-brand btn-sm" href="{{ route('productos.index') }}">
              <i class="bi bi-grid me-2"></i>Ver catálogo
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  {{-- Contenido de cada vista --}}
  <main>
    @yield('content')
  </main>

  {{-- Botón flotante de WhatsApp mejorado --}}
  @if(config('contact.phone'))
    <div class="floating-wa">
      <a href="https://wa.me/{{ config('contact.phone') }}" target="_blank" aria-label="WhatsApp" title="Chatea con nosotros">
        <i class="bi bi-whatsapp"></i>
      </a>
    </div>
  @endif

  {{-- JS --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
</body>
</html>