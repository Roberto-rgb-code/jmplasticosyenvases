@extends('layouts.app')
@section('title','Productos | JM Plásticos y Envases')

@push('head')
<style>
  /* Estilos específicos para la página de productos */
  .hero-products {
    background: 
      radial-gradient(circle at 30% 20%, rgba(99, 102, 241, 0.08) 0%, transparent 50%),
      radial-gradient(circle at 70% 80%, rgba(6, 182, 212, 0.06) 0%, transparent 50%),
      linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    border-bottom: 1px solid rgba(226, 232, 240, 0.6);
  }

  .filter-card {
    background: #fff;
    border: 1px solid var(--border);
    box-shadow: 0 4px 12px rgba(15, 23, 42, 0.08);
    transition: all 0.3s ease;
    position: sticky;
    top: 100px;
  }

  .filter-card:hover {
    box-shadow: 0 8px 25px rgba(15, 23, 42, 0.12);
  }

  .form-control, .form-select {
    border: 1.5px solid var(--border);
    border-radius: 10px;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
    font-size: 0.9rem;
  }

  .form-control:focus, .form-select:focus {
    border-color: var(--brand);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
  }

  .form-label {
    font-weight: 600;
    color: var(--ink);
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
  }

  .card-product {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.06);
  }

  .card-product::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(135deg, var(--brand) 0%, var(--accent) 100%);
    transform: scaleX(0);
    transition: transform 0.3s ease;
  }

  .card-product:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(15, 23, 42, 0.15);
    border-color: var(--brand);
  }

  .card-product:hover::before {
    transform: scaleX(1);
  }

  .card-product .card-img-top {
    height: 200px;
    object-fit: contain;
    padding: 1rem;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    transition: all 0.3s ease;
  }

  .card-product:hover .card-img-top {
    transform: scale(1.05);
  }

  .badge-product {
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(6, 182, 212, 0.1) 100%);
    color: var(--brand-dark);
    border: 1px solid rgba(99, 102, 241, 0.2);
    padding: 0.375rem 0.75rem;
    border-radius: 8px;
    font-weight: 500;
    font-size: 0.8rem;
  }

  .stats-card {
    background: linear-gradient(135deg, var(--brand) 0%, var(--brand-light) 100%);
    color: #fff;
    border-radius: 16px;
    padding: 1.5rem;
    text-align: center;
    position: relative;
    overflow: hidden;
  }

  .stats-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
  }

  .section-title {
    font-weight: 700;
    color: var(--ink);
    position: relative;
    display: inline-block;
  }

  .section-title::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 0;
    width: 60px;
    height: 3px;
    background: linear-gradient(135deg, var(--brand) 0%, var(--accent) 100%);
    border-radius: 2px;
  }

  .filter-reset {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: none;
    border: none;
    color: var(--muted);
    font-size: 1.2rem;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .filter-reset:hover {
    color: var(--brand);
    transform: rotate(90deg);
  }

  .products-count {
    background: rgba(99, 102, 241, 0.1);
    color: var(--brand);
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: 600;
    display: inline-block;
  }

  .search-highlight {
    background: linear-gradient(135deg, rgba(251, 191, 36, 0.2) 0%, rgba(245, 158, 11, 0.2) 100%);
    padding: 0.125rem 0.25rem;
    border-radius: 4px;
    font-weight: 600;
  }

  .loading-skeleton {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: loading 1.5s infinite;
  }

  @keyframes loading {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
  }

  .no-products {
    text-align: center;
    padding: 4rem 2rem;
  }

  .no-products-icon {
    width: 120px;
    height: 120px;
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(6, 182, 212, 0.1) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 2rem;
    font-size: 3rem;
    color: var(--brand);
  }

  /* Responsive improvements */
  @media (max-width: 992px) {
    .filter-card {
      position: static;
      margin-bottom: 2rem;
    }
  }

  @media (max-width: 768px) {
    .card-product .card-img-top {
      height: 160px;
    }
    
    .hero-products {
      padding: 2rem 0 !important;
    }
  }
</style>
@endpush

@section('content')
  {{-- HERO MEJORADO --}}
  <header class="hero-products py-5">
    <div class="container container-narrow">
      <div class="row align-items-center">
        <div class="col-lg-8">
          <div class="mb-3">
            <span class="badge badge-modern">
              <i class="bi bi-grid-3x3-gap me-2"></i>Catálogo completo
            </span>
          </div>
          <h1 class="fw-bold display-6 mb-3">
            Envases <span class="text-primary">PET</span> de alta calidad
          </h1>
          <p class="text-muted lead mb-4">
            Más de 50 modelos disponibles. Calidad certificada, entrega rápida y atención personalizada.
          </p>
          <div class="d-flex gap-3 flex-wrap">
            <a href="{{ route('cotizacion.cart') }}" class="btn btn-brand">
              <i class="bi bi-calculator me-2"></i>Ir al cotizador
            </a>
            <a href="#productos" class="btn btn-outline-secondary">
              <i class="bi bi-arrow-down me-2"></i>Ver productos
            </a>
          </div>
        </div>
        <div class="col-lg-4 text-center">
          <div class="stats-card">
            <div class="fs-2 fw-bold mb-2">{{ $productos->count() }}+</div>
            <div class="opacity-90">Modelos disponibles</div>
          </div>
        </div>
      </div>
    </div>
  </header>

  <div class="container container-narrow py-5">
    <div class="row g-4">
      {{-- SIDEBAR FILTROS MEJORADO --}}
      <aside class="col-lg-3">
        <div class="filter-card rounded-4 p-4 position-relative">
          <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="fw-bold mb-0 d-flex align-items-center">
              <i class="bi bi-funnel me-2 text-primary"></i>Filtros
            </h6>
            @if(request()->hasAny(['q', 'rosca', 'cap_min', 'cap_max', 'sort']))
              <button type="button" class="filter-reset" onclick="window.location.href='{{ route('productos.index') }}'" title="Limpiar filtros">
                <i class="bi bi-x-circle"></i>
              </button>
            @endif
          </div>

          <form method="get" class="vstack gap-4" id="filterForm">
            {{-- Búsqueda --}}
            <div class="filter-group">
              <label class="form-label d-flex align-items-center">
                <i class="bi bi-search me-2 text-muted"></i>Buscar producto
              </label>
              <input 
                type="text" 
                name="q" 
                value="{{ $q }}" 
                class="form-control" 
                placeholder="Nombre o palabra clave..."
                autocomplete="off"
              >
            </div>

            {{-- Rosca --}}
            <div class="filter-group">
              <label class="form-label d-flex align-items-center">
                <i class="bi bi-nut me-2 text-muted"></i>Tipo de rosca
              </label>
              <select name="rosca" class="form-select">
                <option value="">Todas las roscas</option>
                @foreach($roscas as $r)
                  <option value="{{ $r }}" @selected($rosca==$r)>{{ $r }}</option>
                @endforeach
              </select>
            </div>

            {{-- Capacidad --}}
            <div class="filter-group">
              <label class="form-label d-flex align-items-center">
                <i class="bi bi-cup me-2 text-muted"></i>Capacidad (ml)
              </label>
              <div class="row g-2">
                <div class="col-6">
                  <input 
                    type="number" 
                    name="cap_min" 
                    value="{{ $min }}" 
                    class="form-control" 
                    placeholder="Mínimo"
                    min="0"
                  >
                </div>
                <div class="col-6">
                  <input 
                    type="number" 
                    name="cap_max" 
                    value="{{ $max }}" 
                    class="form-control" 
                    placeholder="Máximo"
                    min="0"
                  >
                </div>
              </div>
            </div>

            {{-- Ordenamiento --}}
            <div class="filter-group">
              <label class="form-label d-flex align-items-center">
                <i class="bi bi-sort-down me-2 text-muted"></i>Ordenar por
              </label>
              <select name="sort" class="form-select">
                <option value="">Relevancia</option>
                <option value="alpha" @selected($sort==='alpha')>Alfabético A-Z</option>
                <option value="cap_asc" @selected($sort==='cap_asc')>Capacidad menor a mayor</option>
                <option value="cap_desc" @selected($sort==='cap_desc')>Capacidad mayor a menor</option>
              </select>
            </div>

            <button type="submit" class="btn btn-brand w-100">
              <i class="bi bi-check2 me-2"></i>Aplicar filtros
            </button>
          </form>
        </div>

        {{-- Card de atención --}}
        <div class="mt-4 p-4 rounded-4 bg-gradient text-white" style="background: linear-gradient(135deg, var(--success) 0%, #059669 100%);">
          <div class="d-flex align-items-center mb-3">
            <i class="bi bi-headset fs-4 me-3"></i>
            <h6 class="fw-bold mb-0">Atención inmediata</h6>
          </div>
          <div class="mb-3">
            <div class="small opacity-90">Tiempo promedio de respuesta</div>
            <div class="fs-4 fw-bold">&lt; 2 horas</div>
          </div>
          <a href="https://wa.me/{{ config('contact.phone') }}" target="_blank" class="btn btn-light btn-sm">
            <i class="bi bi-whatsapp me-2"></i>Contactar ahora
          </a>
        </div>
      </aside>

      {{-- GRID DE PRODUCTOS MEJORADO --}}
      <section class="col-lg-9" id="productos">
        <div class="d-flex align-items-center justify-content-between mb-4">
          <div>
            <h3 class="section-title mb-2">Nuestros productos</h3>
            @if($productos->count() > 0)
              <div class="products-count">
                {{ $productos->count() }} producto{{ $productos->count() != 1 ? 's' : '' }} 
                @if(request()->hasAny(['q', 'rosca', 'cap_min', 'cap_max']))
                  encontrado{{ $productos->count() != 1 ? 's' : '' }}
                @endif
              </div>
            @endif
          </div>
          
          @if(request()->hasAny(['q', 'rosca', 'cap_min', 'cap_max', 'sort']))
            <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary btn-sm">
              <i class="bi bi-arrow-counterclockwise me-2"></i>Limpiar filtros
            </a>
          @endif
        </div>

        @if($productos->isEmpty())
          <div class="no-products">
            <div class="no-products-icon">
              <i class="bi bi-search"></i>
            </div>
            <h4 class="fw-bold mb-3">No encontramos productos</h4>
            <p class="text-muted mb-4">
              Intenta ajustar tus filtros de búsqueda o 
              <a href="{{ route('productos.index') }}" class="text-decoration-none">ver todos los productos</a>
            </p>
            <div class="d-flex gap-3 justify-content-center">
              <a href="{{ route('productos.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-grid me-2"></i>Ver todo el catálogo
              </a>
              <a href="https://wa.me/{{ config('contact.phone') }}" target="_blank" class="btn btn-success">
                <i class="bi bi-whatsapp me-2"></i>Consultar por WhatsApp
              </a>
            </div>
          </div>
        @else
          <div class="row g-4" id="productsGrid">
            @foreach($productos as $p)
              <div class="col-sm-6 col-xl-4">
                <article class="card card-product h-100">
                  <div class="position-relative">
                    <img 
                      src="{{ asset('images/'.$p->imagen) }}" 
                      class="card-img-top" 
                      alt="{{ $p->nombre }}"
                      loading="lazy"
                    >
                    @if($p->destacado ?? false)
                      <span class="position-absolute top-0 end-0 m-3 badge bg-warning text-dark">
                        <i class="bi bi-star-fill me-1"></i>Destacado
                      </span>
                    @endif
                  </div>
                  
                  <div class="card-body d-flex flex-column p-4">
                    <h6 class="fw-bold mb-3 lh-base">
                      @if($q && str_contains(strtolower($p->nombre), strtolower($q)))
                        {!! str_ireplace($q, '<span class="search-highlight">'.$q.'</span>', $p->nombre) !!}
                      @else
                        {{ $p->nombre }}
                      @endif
                    </h6>
                    
                    <div class="d-flex flex-wrap gap-2 mb-3">
                      <span class="badge-product">
                        <i class="bi bi-cup me-1"></i>{{ $p->capacidad_ml }} ml
                      </span>
                      <span class="badge-product">
                        <i class="bi bi-nut me-1"></i>{{ $p->rosca }}
                      </span>
                      <span class="badge-product">
                        <i class="bi bi-box me-1"></i>{{ $p->piezas_empaque }} pzas
                      </span>
                    </div>
                    
                    @if($p->descripcion_corta ?? false)
                      <p class="text-muted small mb-3">{{ Str::limit($p->descripcion_corta, 80) }}</p>
                    @endif
                    
                    <div class="mt-auto">
                      <div class="d-grid gap-2">
                        <a 
                          href="{{ route('producto.show', $p) }}" 
                          class="btn btn-brand"
                        >
                          <i class="bi bi-eye me-2"></i>Ver detalles
                        </a>
                        <a 
                          href="{{ route('cotizacion.cart') }}?add={{ $p->id }}" 
                          class="btn btn-outline-secondary btn-sm"
                        >
                          <i class="bi bi-plus-circle me-2"></i>Agregar a cotización
                        </a>
                      </div>
                    </div>
                  </div>
                </article>
              </div>
            @endforeach
          </div>

          {{-- Paginación mejorada --}}
          @if(method_exists($productos, 'hasPages') && $productos->hasPages())
            <div class="d-flex justify-content-center mt-5">
              <nav aria-label="Navegación de productos">
                {{ $productos->appends(request()->query())->links('pagination::bootstrap-4') }}
              </nav>
            </div>
          @endif
        @endif
      </section>
    </div>
  </div>

  {{-- CTA Section --}}
  @if($productos->isNotEmpty())
    <section class="py-5 bg-light bg-opacity-50">
      <div class="container container-narrow text-center">
        <h3 class="fw-bold mb-3">¿No encuentras lo que buscas?</h3>
        <p class="text-muted mb-4">
          Contáctanos directamente y te ayudamos a encontrar el envase perfecto para tu proyecto
        </p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
          <a href="https://wa.me/{{ config('contact.phone') }}" target="_blank" class="btn btn-success">
            <i class="bi bi-whatsapp me-2"></i>Consultar por WhatsApp
          </a>
          <a href="mailto:{{ config('contact.email') }}" class="btn btn-outline-primary">
            <i class="bi bi-envelope me-2"></i>Enviar email
          </a>
        </div>
      </div>
    </section>
  @endif
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Auto-submit form en cambios de select
  const selects = document.querySelectorAll('#filterForm select');
  selects.forEach(select => {
    select.addEventListener('change', function() {
      // Pequeño delay para mejor UX
      setTimeout(() => {
        document.getElementById('filterForm').submit();
      }, 300);
    });
  });

  // Debounce para el input de búsqueda
  let searchTimeout;
  const searchInput = document.querySelector('input[name="q"]');
  if (searchInput) {
    searchInput.addEventListener('input', function() {
      clearTimeout(searchTimeout);
      searchTimeout = setTimeout(() => {
        // Auto-submit después de 1 segundo de inactividad
        if (this.value.length >= 3 || this.value.length === 0) {
          document.getElementById('filterForm').submit();
        }
      }, 1000);
    });
  }

  // Animación de aparición para las tarjetas
  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = '0';
        entry.target.style.transform = 'translateY(30px)';
        entry.target.style.transition = 'all 0.6s ease';
        
        setTimeout(() => {
          entry.target.style.opacity = '1';
          entry.target.style.transform = 'translateY(0)';
        }, 100);
        
        observer.unobserve(entry.target);
      }
    });
  }, observerOptions);

  // Observar las tarjetas de productos
  document.querySelectorAll('.card-product').forEach((card, index) => {
    // Staggered animation delay
    setTimeout(() => {
      observer.observe(card);
    }, index * 100);
  });

  // Smooth scroll para anclas
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
});
</script>
@endpush