@extends('layouts.app')
@section('title', 'JM Plásticos y Envases | Envases PET')

@section('content')
<section class="hero">
  <div class="container container-narrow">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <div class="d-flex flex-wrap gap-2 mb-3">
          <span class="chip"><x-icon name="star-pulsating-loop" /> Confianza industrial</span>
          <span class="chip"><x-icon name="security" /> PET grado alimentario</span>
        </div>
        <h1 class="font-display display-4 display-tight mb-3">Envases PET de gran formato, listos para cotizar</h1>
        <p class="lead text-secondary mb-4">Salsero alto y garrafón tipo piña de 5 litros. Arma tu pedido por paquetes y te respondemos con disponibilidad, tiempos y precio.</p>
        <div class="hero-actions d-flex flex-wrap gap-2 mb-4">
          <a href="{{ route('productos.index') }}" class="btn btn-brand"><x-icon name="grid-3" color="ffffff" />Ver catálogo</a>
          <a href="{{ route('cotizacion.cart') }}" class="btn btn-ghost"><x-icon name="clipboard-list" />Ir al cotizador</a>
        </div>
        <div class="row g-3">
          <div class="col-4"><div class="stat-card"><x-icon name="grid-3" size="1.2em" /><strong>{{ $destacados->count() }}</strong><span class="small text-secondary">Modelos activos</span></div></div>
          <div class="col-4"><div class="stat-card"><x-icon name="water" size="1.2em" /><strong>5 L</strong><span class="small text-secondary">Capacidad</span></div></div>
          <div class="col-4"><div class="stat-card"><x-icon name="watch-loop" size="1.2em" /><strong>24h</strong><span class="small text-secondary">Respuesta</span></div></div>
        </div>
      </div>
      <div class="col-lg-6">
        <div id="heroCarousel" class="carousel slide hero-frame" data-bs-ride="carousel">
          <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="3"></button>
          </div>
          <div class="carousel-inner">
            @foreach(['carousel-1.jpg','carousel-2.jpg','carousel-3.jpg','carousel-4.jpg'] as $i => $img)
              <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                <img src="{{ asset('images/'.$img) }}" alt="Producción JM Plásticos">
              </div>
            @endforeach
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
          </button>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-5">
  <div class="container container-narrow">
    <div class="text-center mb-5">
      <span class="chip mb-3"><x-icon name="folder-check" /> Catálogo vigente</span>
      <h2 class="font-display display-5 display-tight">Dos formatos, una cotización rápida</h2>
      <p class="text-secondary mb-0">Ambos de 5 litros con rosca R-48. Elige el que encaja con tu línea.</p>
    </div>
    <div class="row g-4 justify-content-center">
      @forelse($destacados as $producto)
        <div class="col-md-6 col-lg-5">
          @include('productos._card', ['producto' => $producto])
        </div>
      @empty
        <div class="col-12"><div class="alert alert-light border">Aún no hay productos publicados.</div></div>
      @endforelse
    </div>
  </div>
</section>

<section class="py-5">
  <div class="container container-narrow">
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card-soft p-4 h-100">
          <div class="icon-tile mb-3"><x-icon name="security" size="1.55em" /></div>
          <h3 class="h5 fw-bold">PET de calidad</h3>
          <p class="text-secondary mb-0">Material para contacto con alimentos, con capacidad y rosca claras en cada ficha.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card-soft p-4 h-100">
          <div class="icon-tile mb-3"><x-icon name="speed-loop" size="1.55em" /></div>
          <h3 class="h5 fw-bold">Pedido en minutos</h3>
          <p class="text-secondary mb-0">Agrega paquetes al cotizador y envíalo por WhatsApp o correo. Sin precios públicos.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card-soft p-4 h-100">
          <div class="icon-tile mb-3"><x-icon name="navigation-right-up" size="1.55em" /></div>
          <h3 class="h5 fw-bold">Entrega coordinada</h3>
          <p class="text-secondary mb-0">Ajustamos cantidades, empaque y logística según tu operación.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-5">
  <div class="container container-narrow">
    <h2 class="font-display h1 display-tight text-center mb-5">Así cotizas</h2>
    <div class="row g-4">
      <div class="col-6 col-md-3 process-step">
        <div class="process-num"><x-icon name="search" size="18" color="ffffff" /></div>
        <h3 class="h6 fw-bold">Elige el envase</h3>
        <p class="small text-secondary mb-0">Salsero alto o piña 5 L con asa blanca.</p>
      </div>
      <div class="col-6 col-md-3 process-step">
        <div class="process-num"><x-icon name="plus-circle" size="18" color="ffffff" /></div>
        <h3 class="h6 fw-bold">Indica paquetes</h3>
        <p class="small text-secondary mb-0">Cada pack trae 50 piezas. Calculamos el total al instante.</p>
      </div>
      <div class="col-6 col-md-3 process-step">
        <div class="process-num"><x-icon name="email-arrow-up" size="18" color="ffffff" /></div>
        <h3 class="h6 fw-bold">Envía la solicitud</h3>
        <p class="small text-secondary mb-0">WhatsApp o correo, con tus datos de contacto.</p>
      </div>
      <div class="col-6 col-md-3 process-step">
        <div class="process-num"><x-icon name="confirm-circle" size="18" color="ffffff" /></div>
        <h3 class="h6 fw-bold">Recibe propuesta</h3>
        <p class="small text-secondary mb-0">Precio, tiempos y disponibilidad en menos de 24 h.</p>
      </div>
    </div>
  </div>
</section>

<section class="pb-5">
  <div class="container container-narrow">
    <div class="cta-banner p-4 p-lg-5 d-flex flex-column flex-lg-row align-items-stretch align-items-lg-center justify-content-between gap-3 text-lg-start">
      <div class="position-relative" style="z-index:1">
        <h2 class="font-display h2 mb-2">¿Listo para pedir una cotización?</h2>
        <p class="mb-0 opacity-75">Elige un formato de 5 litros, indica paquetes y te contactamos.</p>
      </div>
      <a href="{{ route('productos.index') }}" class="btn btn-light rounded-pill fw-bold px-4 position-relative" style="z-index:1"><x-icon name="arrow-right" color="042f2e" /> Empezar ahora</a>
    </div>
  </div>
</section>
@endsection
