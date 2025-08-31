@extends('layouts.app')
@section('title','JM Plásticos y Envases - Líderes en Envases PET')

@push('head')
<style>
  /* Estilos específicos para el carrusel */
  .carousel-slide {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(15, 23, 42, 0.15);
    background: #fff;
  }

  .carousel-image {
    width: 100%;
    height: 400px;
    object-fit: cover;
    transition: transform 0.6s ease;
  }

  .carousel-item.active .carousel-image {
    transform: scale(1.02);
  }

  .carousel-caption {
    background: linear-gradient(135deg, rgba(15, 23, 42, 0.8) 0%, rgba(15, 23, 42, 0.6) 100%);
    backdrop-filter: blur(10px);
    border-radius: 12px;
    padding: 1.5rem;
    bottom: 2rem;
    left: 2rem;
    right: 2rem;
    text-align: left;
  }

  .carousel-caption h5 {
    font-weight: 700;
    font-size: 1.3rem;
    margin-bottom: 0.5rem;
    color: #fff;
  }

  .carousel-caption p {
    margin-bottom: 0;
    opacity: 0.9;
    font-size: 0.95rem;
    color: #fff;
  }

  .carousel-indicators {
    bottom: -50px;
  }

  .carousel-indicators button {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: var(--border);
    border: none;
    margin: 0 6px;
    transition: all 0.3s ease;
  }

  .carousel-indicators button.active {
    background: var(--brand);
    transform: scale(1.2);
  }

  .carousel-control-prev,
  .carousel-control-next {
    width: 8%;
    top: 50%;
    transform: translateY(-50%);
    height: 60px;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 50%;
    border: 1px solid var(--border);
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
  }

  .carousel-control-prev:hover,
  .carousel-control-next:hover {
    background: rgba(255, 255, 255, 0.95);
    border-color: var(--brand);
    transform: translateY(-50%) scale(1.1);
  }

  .carousel-control-prev-icon,
  .carousel-control-next-icon {
    filter: invert(1);
    width: 24px;
    height: 24px;
  }

  /* Responsive carrusel */
  @media (max-width: 992px) {
    .carousel-image {
      height: 300px;
    }
    
    .carousel-caption {
      padding: 1rem;
      bottom: 1rem;
      left: 1rem;
      right: 1rem;
    }
    
    .carousel-caption h5 {
      font-size: 1.1rem;
    }
    
    .carousel-caption p {
      font-size: 0.85rem;
    }
  }

  @media (max-width: 768px) {
    .carousel-image {
      height: 250px;
    }
    
    .carousel-control-prev,
    .carousel-control-next {
      display: none;
    }
  }

  /* Estilos para productos destacados */
  .product-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 12px rgba(15, 23, 42, 0.06);
  }

  .product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(15, 23, 42, 0.12);
    border-color: var(--brand);
  }

  .product-image-container {
    position: relative;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    padding: 1.5rem;
    height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .product-image {
    width: 100%;
    height: 100%;
    object-fit: contain;
    transition: transform 0.3s ease;
  }

  .product-card:hover .product-image {
    transform: scale(1.1);
  }

  .product-badge {
    position: absolute;
    top: 0.75rem;
    right: 0.75rem;
    background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
    color: #fff;
    padding: 0.375rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
  }

  .product-badge.badge-new {
    background: linear-gradient(135deg, var(--warning) 0%, #d97706 100%);
  }

  .product-info {
    padding: 1.5rem;
  }

  .product-title {
    font-weight: 700;
    color: var(--ink);
    margin-bottom: 0.75rem;
    font-size: 0.95rem;
    line-height: 1.3;
    min-height: 2.5rem;
    display: flex;
    align-items: center;
  }

  .product-specs {
    display: flex;
    gap: 0.25rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
  }

  .spec {
    background: rgba(99, 102, 241, 0.1);
    color: var(--brand-dark);
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-size: 0.7rem;
    font-weight: 500;
    white-space: nowrap;
  }

  /* Responsive productos */
  @media (max-width: 768px) {
    .product-image-container {
      height: 160px;
      padding: 1rem;
    }
    
    .product-info {
      padding: 1rem;
    }

    .product-title {
      font-size: 0.9rem;
      min-height: 2rem;
    }

    .spec {
      font-size: 0.65rem;
      padding: 0.2rem 0.4rem;
    }
  }
</style>
@endpush

@section('content')
  {{-- HERO SECTION CON CARRUSEL --}}
  <section class="hero-gradient py-5">
    <div class="container container-narrow">
      <div class="row align-items-center min-vh-75">
        <div class="col-lg-6 order-lg-1">
          <div class="animate-fade-in-up">
            <span class="badge badge-modern mb-4">
              <i class="bi bi-award me-2"></i>+25 años aportando soluciones
            </span>
            
            <h1 class="fw-bold display-4 mb-4 lh-1">
              Envases <span class="text-primary">PET</span><br>
              para todas las <span style="background: linear-gradient(135deg, #6366f1 0%, #06b6d4 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">industrias</span>
            </h1>
            
            <p class="text-muted lead mb-5">
              Fabricación especializada, calidad garantizada y entregas puntuales. 
              Solicita tu cotización personalizada en minutos y descubre por qué somos líderes del mercado.
            </p>
            
            <div class="d-flex gap-3 flex-wrap mb-4">
              <a href="{{ route('productos.index') }}" class="btn btn-brand">
                <i class="bi bi-grid me-2"></i>Explorar productos
              </a>
              <a href="{{ route('cotizacion.cart') }}" class="btn btn-outline-secondary">
                <i class="bi bi-calculator me-2"></i>Cotizar ahora
              </a>
            </div>

            {{-- Stats mejorados --}}
            <div class="row g-3 mt-4">
              <div class="col-6 col-md-3">
                <div class="text-center">
                  <div class="fs-2 fw-bold text-primary">25+</div>
                  <small class="text-muted">Años de experiencia</small>
                </div>
              </div>
              <div class="col-6 col-md-3">
                <div class="text-center">
                  <div class="fs-2 fw-bold text-primary">1000+</div>
                  <small class="text-muted">Clientes satisfechos</small>
                </div>
              </div>
              <div class="col-6 col-md-3">
                <div class="text-center">
                  <div class="fs-2 fw-bold text-primary">50+</div>
                  <small class="text-muted">Tipos de envases</small>
                </div>
              </div>
              <div class="col-6 col-md-3">
                <div class="text-center">
                  <div class="fs-2 fw-bold text-primary">24h</div>
                  <small class="text-muted">Tiempo de respuesta</small>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        {{-- CARRUSEL --}}
        <div class="col-lg-6 order-lg-2">
          <div id="productCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="4000">
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="0" class="active"></button>
              <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="1"></button>
              <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="2"></button>
              <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="3"></button>
            </div>
            
            <div class="carousel-inner">
              <div class="carousel-item active">
                <div class="carousel-slide">
                  <img src="{{ asset('images/carousel-1.jpg') }}" 
                       alt="Tecnología de vanguardia en producción PET" class="carousel-image">
                  <div class="carousel-caption">
                    <h5>Tecnología de vanguardia</h5>
                    <p>Procesos automatizados para máxima calidad</p>
                  </div>
                </div>
              </div>
              
              <div class="carousel-item">
                <div class="carousel-slide">
                  <img src="{{ asset('images/carousel-2.jpg') }}" 
                       alt="Línea de producción de botellas PET" class="carousel-image">
                  <div class="carousel-caption">
                    <h5>Producción a gran escala</h5>
                    <p>Capacidad para proyectos de cualquier tamaño</p>
                  </div>
                </div>
              </div>
              
              <div class="carousel-item">
                <div class="carousel-slide">
                  <img src="{{ asset('images/carousel-3.jpg') }}" 
                       alt="Botellas PET transparentes de alta calidad" class="carousel-image">
                  <div class="carousel-caption">
                    <h5>Transparencia cristalina</h5>
                    <p>Material PET de grado alimentario certificado</p>
                  </div>
                </div>
              </div>
              
              <div class="carousel-item">
                <div class="carousel-slide">
                  <img src="{{ asset('images/carousel-4.jpg') }}" 
                       alt="Control de calidad en envases PET" class="carousel-image">
                  <div class="carousel-caption">
                    <h5>Control de calidad riguroso</h5>
                    <p>Cada lote cumple estándares internacionales</p>
                  </div>
                </div>
              </div>
            </div>
            
            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon"></span>
              <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon"></span>
              <span class="visually-hidden">Siguiente</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- PRODUCTOS DESTACADOS --}}
  <section class="py-5 bg-light bg-opacity-30">
    <div class="container container-narrow">
      <div class="text-center mb-5">
        <h2 class="fw-bold mb-3">Productos destacados</h2>
        <p class="text-muted">Nuestra selección de envases PET más populares</p>
      </div>
      
      <div class="row g-4">
        @php
          // Obtener productos específicos: las dos piñas, el salsero y uno más
          $productosDestacados = \App\Models\Producto::whereIn('nombre', [
            'Piña 960 ml Cristal',
            'Piña 5000 ml Asa Blanca',
            'Salsero Alto 5000 ml',
            'Botella Cilíndrica Lisa 500 ml'
          ])->get();
          
          // Reorganizar para que la primera piña tenga el badge "Más vendido"
          $productosOrdenados = $productosDestacados->sortBy(function($producto) {
            if($producto->nombre === 'Piña 960 ml Cristal') return 1;
            if($producto->nombre === 'Piña 5000 ml Asa Blanca') return 2;  
            if($producto->nombre === 'Salsero Alto 5000 ml') return 3;
            return 4;
          });
        @endphp
        
        @foreach($productosOrdenados as $index => $producto)
          <div class="col-lg-3 col-md-6">
            <div class="product-card h-100">
              <div class="product-image-container">
                <img src="{{ asset('images/'.$producto->imagen) }}" alt="{{ $producto->nombre }}" class="product-image">
                @if($index === 1)
                  <div class="product-badge badge-new">Nuevo</div>
                @else
                  <div class="product-badge">Más vendido</div>
                @endif
              </div>
              <div class="product-info">
                <h6 class="product-title">{{ $producto->nombre }}</h6>
                <div class="product-specs">
                  <span class="spec">{{ $producto->capacidad_ml }} ml</span>
                  <span class="spec">{{ $producto->rosca }}</span>
                  <span class="spec">{{ $producto->piezas_empaque }} pzas/pack</span>
                </div>
                <div class="d-grid gap-2">
                  <a href="{{ route('producto.show', $producto) }}" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-eye me-1"></i>Ver detalles
                  </a>
                  <a href="{{ route('cotizacion.cart') }}" class="btn btn-brand btn-sm">
                    <i class="bi bi-plus-circle me-1"></i>Agregar a cotización
                  </a>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
      
      <div class="text-center mt-5">
        <a href="{{ route('productos.index') }}" class="btn btn-brand btn-lg">
          <i class="bi bi-grid me-2"></i>Ver todos los productos
        </a>
      </div>
    </div>
  </section>

  {{-- BENEFICIOS MEJORADOS --}}
  <section class="py-5">
    <div class="container container-narrow">
      <div class="text-center mb-5">
        <h2 class="fw-bold mb-3">¿Por qué elegir JM Plásticos?</h2>
        <p class="text-muted lead">Más que un proveedor, somos tu socio estratégico en soluciones de envase</p>
      </div>
      
      <div class="row g-4">
        <div class="col-lg-4 col-md-6">
          <div class="feature-card h-100 text-center">
            <div class="icon">
              <i class="bi bi-shield-check"></i>
            </div>
            <h5 class="fw-bold mb-3">Calidad certificada</h5>
            <p class="text-muted mb-4">
              Procesos estandarizados ISO y control de calidad riguroso en cada lote de producción.
            </p>
            <div class="d-flex justify-content-center gap-2">
              <span class="badge bg-light text-dark">ISO 9001</span>
              <span class="badge bg-light text-dark">FDA</span>
            </div>
          </div>
        </div>
        
        <div class="col-lg-4 col-md-6">
          <div class="feature-card h-100 text-center">
            <div class="icon">
              <i class="bi bi-truck"></i>
            </div>
            <h5 class="fw-bold mb-3">Entrega garantizada</h5>
            <p class="text-muted mb-4">
              Cobertura nacional y logística optimizada. Cumplimos fechas de entrega al 98%.
            </p>
            <div class="d-flex justify-content-center gap-2">
              <span class="badge bg-light text-dark">Nacional</span>
              <span class="badge bg-light text-dark">Express</span>
            </div>
          </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mx-auto">
          <div class="feature-card h-100 text-center">
            <div class="icon">
              <i class="bi bi-headset"></i>
            </div>
            <h5 class="fw-bold mb-3">Soporte 24/7</h5>
            <p class="text-muted mb-4">
              Atención personalizada por WhatsApp, correo o teléfono. Respuesta garantizada en menos de 2 horas.
            </p>
            <div class="d-flex justify-content-center gap-2">
              <span class="badge bg-light text-dark">WhatsApp</span>
              <span class="badge bg-light text-dark">Inmediato</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- DIVIDER --}}
  <div class="section-divider"></div>

  {{-- PROCESO MEJORADO --}}
  <section class="py-5 bg-light bg-opacity-50">
    <div class="container container-narrow">
      <div class="text-center mb-5">
        <h2 class="fw-bold mb-3">Proceso simple y rápido</h2>
        <p class="text-muted">De la cotización a tu almacén en 4 pasos</p>
      </div>
      
      <div class="row g-4">
        <div class="col-lg-3 col-md-6">
          <div class="text-center">
            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
              <span class="fw-bold fs-4 text-primary">1</span>
            </div>
            <h6 class="fw-bold">Explora y cotiza</h6>
            <p class="text-muted small">Navega nuestro catálogo y agrega productos a tu cotización</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="text-center">
            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
              <span class="fw-bold fs-4 text-primary">2</span>
            </div>
            <h6 class="fw-bold">Recibe propuesta</h6>
            <p class="text-muted small">Te enviamos cotización detallada en menos de 24 horas</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="text-center">
            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
              <span class="fw-bold fs-4 text-primary">3</span>
            </div>
            <h6 class="fw-bold">Confirma pedido</h6>
            <p class="text-muted small">Aprueba la cotización y coordinamos la producción</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="text-center">
            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
              <span class="fw-bold fs-4 text-primary">4</span>
            </div>
            <h6 class="fw-bold">Recibe productos</h6>
            <p class="text-muted small">Entregamos en tiempo y forma en tu ubicación</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- CTA INTERMEDIA MEJORADA --}}
  <section class="py-5">
    <div class="container container-narrow">
      <div class="row align-items-center">
        <div class="col-lg-8">
          <h3 class="fw-bold mb-2">¿Listo para comenzar tu cotización?</h3>
          <p class="text-muted mb-4 mb-lg-0">
            Más de 50 tipos de envases PET disponibles. Agrega productos al cotizador y recibe tu propuesta personalizada.
          </p>
        </div>
        <div class="col-lg-4 text-lg-end">
          <a href="{{ route('productos.index') }}" class="btn btn-brand btn-lg">
            <i class="bi bi-plus-square me-2"></i>Explorar catálogo
          </a>
        </div>
      </div>
    </div>
  </section>

  {{-- DIVIDER --}}
  <div class="section-divider"></div>

  {{-- CONTACTO MEJORADO --}}
  <section class="py-5 bg-light bg-opacity-50" id="contacto">
    <div class="container container-narrow">
      <div class="row">
        <div class="col-lg-6 mx-auto">
          <div class="text-center mb-5">
            <h4 class="fw-bold mb-3">Contáctanos directamente</h4>
            <p class="text-muted">Elige tu canal preferido y te respondemos inmediatamente</p>
          </div>
          
          <div class="row g-3">
            <div class="col-md-6">
              <a href="mailto:{{ config('contact.email') }}" class="contact-item">
                <div class="bg-primary bg-opacity-10 rounded-2 p-2">
                  <i class="bi bi-envelope text-primary"></i>
                </div>
                <div>
                  <div class="fw-semibold">Email</div>
                  <small class="text-muted">{{ config('contact.email') }}</small>
                </div>
              </a>
            </div>
            
            <div class="col-md-6">
              <a href="tel:{{ config('contact.phone') }}" class="contact-item">
                <div class="bg-primary bg-opacity-10 rounded-2 p-2">
                  <i class="bi bi-telephone text-primary"></i>
                </div>
                <div>
                  <div class="fw-semibold">Teléfono</div>
                  <small class="text-muted">{{ config('contact.phone') }}</small>
                </div>
              </a>
            </div>
            
            @if(config('contact.phone'))
            <div class="col-12">
              <a href="https://wa.me/{{ config('contact.phone') }}" target="_blank" class="contact-item">
                <div class="bg-success bg-opacity-10 rounded-2 p-2">
                  <i class="bi bi-whatsapp text-success"></i>
                </div>
                <div class="flex-grow-1">
                  <div class="fw-semibold">WhatsApp directo</div>
                  <small class="text-muted">Respuesta inmediata - Chat en vivo</small>
                </div>
                <div class="ms-auto">
                  <i class="bi bi-arrow-right text-muted"></i>
                </div>
              </a>
            </div>
            @endif
          </div>
          
          {{-- CTA adicional --}}
          <div class="text-center mt-4">
            <p class="small text-muted mb-3">¿Prefieres que te llamemos?</p>
            <a href="{{ route('cotizacion.cart') }}" class="btn btn-outline-primary">
              <i class="bi bi-telephone me-2"></i>Solicitar llamada
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- TESTIMONIAL/TRUST SECTION --}}
  <section class="py-5">
    <div class="container container-narrow">
      <div class="text-center mb-5">
        <h4 class="fw-bold mb-3">Confían en nosotros</h4>
        <p class="text-muted">Empresas de todos los tamaños eligen JM Plásticos</p>
      </div>
      
      <div class="row g-4 align-items-center justify-content-center">
        <div class="col-6 col-md-3 text-center">
          <div class="p-3 bg-light bg-opacity-50 rounded-3">
            <div class="text-primary fs-4 fw-bold">PYMES</div>
            <small class="text-muted">Startups y pequeñas empresas</small>
          </div>
        </div>
        <div class="col-6 col-md-3 text-center">
          <div class="p-3 bg-light bg-opacity-50 rounded-3">
            <div class="text-primary fs-4 fw-bold">Retail</div>
            <small class="text-muted">Cadenas de supermercados</small>
          </div>
        </div>
        <div class="col-6 col-md-3 text-center">
          <div class="p-3 bg-light bg-opacity-50 rounded-3">
            <div class="text-primary fs-4 fw-bold">Industria</div>
            <small class="text-muted">Manufactura y distribución</small>
          </div>
        </div>
        <div class="col-6 col-md-3 text-center">
          <div class="p-3 bg-light bg-opacity-50 rounded-3">
            <div class="text-primary fs-4 fw-bold">F&B</div>
            <small class="text-muted">Alimentos y bebidas</small>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@push('scripts')
<script>
  // Animación para elementos cuando aparecen en viewport
  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('animate-fade-in-up');
      }
    });
  }, observerOptions);

  // Observar elementos que queremos animar
  document.addEventListener('DOMContentLoaded', () => {
    const elementsToAnimate = document.querySelectorAll('.feature-card, .contact-item');
    elementsToAnimate.forEach(el => observer.observe(el));

    // Pausa el carrusel al hover
    const carousel = document.getElementById('productCarousel');
    if (carousel) {
      carousel.addEventListener('mouseenter', () => {
        bootstrap.Carousel.getInstance(carousel)?.pause();
      });
      
      carousel.addEventListener('mouseleave', () => {
        bootstrap.Carousel.getInstance(carousel)?.cycle();
      });
    }
  });

  // Smooth scroll para enlaces internos
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        target.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    });
  });
</script>
@endpush