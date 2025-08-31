@extends('layouts.app')
@section('title', $producto->nombre.' | JM Plásticos')

@push('head')
<style>
  /* Estilos específicos para página de producto */
  .product-header {
    background: 
      radial-gradient(circle at 25% 25%, rgba(99, 102, 241, 0.06) 0%, transparent 50%),
      radial-gradient(circle at 75% 75%, rgba(6, 182, 212, 0.04) 0%, transparent 50%),
      linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    border-bottom: 1px solid rgba(226, 232, 240, 0.6);
    position: relative;
    overflow: hidden;
  }

  .product-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
      radial-gradient(circle at 50% 0%, rgba(99, 102, 241, 0.03) 0%, transparent 50%);
    pointer-events: none;
  }

  .breadcrumb-link {
    color: var(--muted);
    text-decoration: none;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border: 1px solid var(--border);
    border-radius: 50px;
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
  }

  .breadcrumb-link:hover {
    color: var(--brand);
    border-color: var(--brand);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.15);
  }

  .product-title {
    font-weight: 800;
    background: linear-gradient(135deg, var(--ink) 0%, var(--brand) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    line-height: 1.2;
  }

  .product-image-container {
    background: 
      radial-gradient(circle at 50% 50%, #f8fafc 0%, #ffffff 100%);
    border: 2px solid var(--border);
    border-radius: 20px;
    padding: 2rem;
    position: relative;
    overflow: hidden;
    transition: all 0.4s ease;
  }

  .product-image-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
      radial-gradient(circle at 30% 30%, rgba(99, 102, 241, 0.05) 0%, transparent 60%),
      radial-gradient(circle at 70% 70%, rgba(6, 182, 212, 0.03) 0%, transparent 60%);
    pointer-events: none;
    opacity: 0;
    transition: opacity 0.3s ease;
  }

  .product-image-container:hover::before {
    opacity: 1;
  }

  .product-image-container:hover {
    border-color: var(--brand);
    box-shadow: 0 20px 40px rgba(99, 102, 241, 0.15);
    transform: translateY(-5px);
  }

  .product-image {
    width: 100%;
    height: auto;
    max-height: 400px;
    object-fit: contain;
    transition: transform 0.4s ease;
  }

  .product-image-container:hover .product-image {
    transform: scale(1.05);
  }

  .spec-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
  }

  .spec-card::before {
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

  .spec-card:hover {
    border-color: var(--brand);
    box-shadow: 0 8px 25px rgba(99, 102, 241, 0.12);
    transform: translateY(-3px);
  }

  .spec-card:hover::before {
    transform: scaleX(1);
  }

  .spec-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, var(--brand) 0%, var(--accent) 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    margin: 0 auto 1rem;
    font-size: 1.25rem;
  }

  .spec-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--ink);
    margin-bottom: 0.5rem;
  }

  .spec-label {
    color: var(--muted);
    font-size: 0.9rem;
    font-weight: 500;
  }

  .quote-form {
    background: 
      linear-gradient(135deg, #fff 0%, #fefeff 100%);
    border: 2px solid var(--border);
    border-radius: 20px;
    padding: 2rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 8px 30px rgba(15, 23, 42, 0.08);
  }

  .quote-form::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
      radial-gradient(circle at 20% 20%, rgba(99, 102, 241, 0.02) 0%, transparent 50%);
    pointer-events: none;
  }

  .quantity-stepper {
    border: 2px solid var(--border);
    border-radius: 12px;
    overflow: hidden;
    background: #fff;
    display: flex;
    align-items: center;
    max-width: 180px;
  }

  .stepper-btn {
    background: none;
    border: none;
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--brand);
    font-size: 1.2rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .stepper-btn:hover {
    background: var(--brand);
    color: #fff;
  }

  .stepper-btn:active {
    transform: scale(0.95);
  }

  .stepper-input {
    border: none;
    text-align: center;
    font-weight: 600;
    font-size: 1.1rem;
    color: var(--ink);
    width: 60px;
    background: transparent;
  }

  .stepper-input:focus {
    outline: none;
    box-shadow: none;
  }

  .total-pieces {
    background: rgba(99, 102, 241, 0.1);
    color: var(--brand);
    padding: 0.75rem 1rem;
    border-radius: 12px;
    font-weight: 600;
    display: inline-block;
    margin-top: 1rem;
  }

  .quote-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
  }

  .btn-quote {
    background: linear-gradient(135deg, var(--brand) 0%, var(--brand-light) 100%);
    border: none;
    color: #fff;
    padding: 1rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
    flex: 1;
  }

  .btn-quote:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
    color: #fff;
  }

  .btn-quote:active {
    transform: translateY(0);
  }

  .btn-secondary-quote {
    background: #fff;
    border: 2px solid var(--border);
    color: var(--ink);
    padding: 1rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
  }

  .btn-secondary-quote:hover {
    border-color: var(--brand);
    color: var(--brand);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(15, 23, 42, 0.1);
  }

  .disclaimer {
    background: rgba(6, 182, 212, 0.05);
    border: 1px solid rgba(6, 182, 212, 0.2);
    border-radius: 12px;
    padding: 1rem;
    margin-top: 1.5rem;
  }

  .disclaimer-icon {
    color: var(--accent);
    margin-right: 0.5rem;
  }

  .features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-top: 3rem;
  }

  .feature-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 12px;
    transition: all 0.3s ease;
  }

  .feature-item:hover {
    border-color: var(--brand);
    box-shadow: 0 4px 15px rgba(99, 102, 241, 0.1);
  }

  .feature-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(6, 182, 212, 0.1) 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--brand);
    font-size: 1.2rem;
  }

  /* Responsive improvements */
  @media (max-width: 992px) {
    .quote-actions {
      flex-direction: column;
    }
    
    .product-header {
      padding: 2rem 0 !important;
    }
    
    .product-image-container {
      margin-bottom: 2rem;
    }
  }

  @media (max-width: 768px) {
    .spec-card {
      padding: 1rem;
    }
    
    .quote-form {
      padding: 1.5rem;
    }
    
    .btn-quote, .btn-secondary-quote {
      padding: 0.875rem 1.5rem;
      font-size: 1rem;
    }
  }
</style>
@endpush

@section('content')
  {{-- HEADER MEJORADO --}}
  <header class="product-header py-5">
    <div class="container container-narrow">
      <div class="mb-4">
        <a href="{{ url()->previous() }}" class="breadcrumb-link">
          <i class="bi bi-arrow-left"></i>
          <span>Regresar al catálogo</span>
        </a>
      </div>
      
      <div class="row align-items-center">
        <div class="col-lg-8">
          <div class="mb-3">
            <span class="badge badge-modern">
              <i class="bi bi-box-seam me-2"></i>Ficha técnica
            </span>
          </div>
          <h1 class="product-title display-5 mb-0">
            {{ $producto->nombre }}
          </h1>
        </div>
        <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
          <div class="d-flex gap-2 justify-content-lg-end">
            <a href="{{ route('cotizacion.cart') }}" class="btn btn-outline-secondary btn-sm">
              <i class="bi bi-bag me-2"></i>Ver cotizador
            </a>
            <a href="https://wa.me/{{ config('contact.phone') }}" target="_blank" class="btn btn-success btn-sm">
              <i class="bi bi-whatsapp me-2"></i>Consultar
            </a>
          </div>
        </div>
      </div>
    </div>
  </header>

  {{-- CONTENIDO PRINCIPAL --}}
  <div class="container container-narrow py-5">
    <div class="row g-5 align-items-start">
      {{-- IMAGEN DEL PRODUCTO --}}
      <div class="col-lg-6">
        <div class="product-image-container">
          <img 
            src="{{ asset('images/'.$producto->imagen) }}" 
            class="product-image" 
            alt="{{ $producto->nombre }}"
          >
        </div>
      </div>

      {{-- INFORMACIÓN Y COTIZACIÓN --}}
      <div class="col-lg-6">
        {{-- ESPECIFICACIONES --}}
        <div class="row g-3 mb-4">
          <div class="col-4">
            <div class="spec-card">
              <div class="spec-icon">
                <i class="bi bi-cup"></i>
              </div>
              <div class="spec-value">{{ $producto->capacidad_ml }}</div>
              <div class="spec-label">Mililitros</div>
            </div>
          </div>
          <div class="col-4">
            <div class="spec-card">
              <div class="spec-icon">
                <i class="bi bi-nut"></i>
              </div>
              <div class="spec-value">{{ $producto->rosca }}</div>
              <div class="spec-label">Rosca</div>
            </div>
          </div>
          <div class="col-4">
            <div class="spec-card">
              <div class="spec-icon">
                <i class="bi bi-boxes"></i>
              </div>
              <div class="spec-value">{{ $producto->piezas_empaque }}</div>
              <div class="spec-label">Pzas/paquete</div>
            </div>
          </div>
        </div>

        {{-- FORMULARIO DE COTIZACIÓN --}}
        <div class="quote-form">
          <form action="{{ route('cotizacion.add',$producto) }}" method="POST" id="quoteForm">
            @csrf
            <div class="mb-4">
              <h5 class="fw-bold mb-3 d-flex align-items-center">
                <i class="bi bi-calculator me-2 text-primary"></i>
                Solicitar cotización
              </h5>
              <p class="text-muted mb-0">
                Selecciona la cantidad de paquetes que necesitas y enviaremos tu cotización personalizada.
              </p>
            </div>

            <div class="mb-4">
              <label class="form-label fw-semibold mb-3">Cantidad de paquetes</label>
              <div class="quantity-stepper">
                <button class="stepper-btn" type="button" onclick="stepper('cant',-1)">
                  <i class="bi bi-dash"></i>
                </button>
                <input 
                  type="number" 
                  id="cant" 
                  name="cantidad" 
                  class="stepper-input" 
                  value="1" 
                  min="1"
                  onchange="updateTotal()"
                >
                <button class="stepper-btn" type="button" onclick="stepper('cant',1)">
                  <i class="bi bi-plus"></i>
                </button>
              </div>
              
              <div class="total-pieces">
                <i class="bi bi-box2 me-2"></i>
                Total estimado: <span id="totalPzas">{{ $producto->piezas_empaque }}</span> piezas
              </div>
            </div>

            <div class="quote-actions">
              <button type="submit" class="btn-quote">
                <i class="bi bi-send me-2"></i>
                Solicitar cotización
              </button>
              <a href="{{ route('cotizacion.cart') }}" class="btn-secondary-quote">
                <i class="bi bi-eye"></i>
                Ver cotizador
              </a>
            </div>

            <div class="disclaimer">
              <div class="d-flex align-items-start">
                <i class="bi bi-info-circle disclaimer-icon flex-shrink-0"></i>
                <div>
                  <strong>Información importante:</strong><br>
                  Los precios se envían por WhatsApp o correo una vez recibida tu solicitud. 
                  Tiempo de respuesta promedio: menos de 2 horas.
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    {{-- CARACTERÍSTICAS ADICIONALES --}}
    <div class="features-grid">
      <div class="feature-item">
        <div class="feature-icon">
          <i class="bi bi-shield-check"></i>
        </div>
        <div>
          <h6 class="fw-bold mb-1">Material PET grado alimentario</h6>
          <small class="text-muted">Certificado para contacto con alimentos</small>
        </div>
      </div>
      
      <div class="feature-item">
        <div class="feature-icon">
          <i class="bi bi-truck"></i>
        </div>
        <div>
          <h6 class="fw-bold mb-1">Entrega garantizada</h6>
          <small class="text-muted">Tiempos de entrega respetados al 98%</small>
        </div>
      </div>
      
      <div class="feature-item">
        <div class="feature-icon">
          <i class="bi bi-award"></i>
        </div>
        <div>
          <h6 class="fw-bold mb-1">Calidad certificada</h6>
          <small class="text-muted">Control de calidad en cada lote</small>
        </div>
      </div>
      
      <div class="feature-item">
        <div class="feature-icon">
          <i class="bi bi-headset"></i>
        </div>
        <div>
          <h6 class="fw-bold mb-1">Soporte personalizado</h6>
          <small class="text-muted">Atención directa por WhatsApp</small>
        </div>
      </div>
    </div>
  </div>

  {{-- CTA SECTION --}}
  <section class="py-5 bg-light bg-opacity-50">
    <div class="container container-narrow text-center">
      <h3 class="fw-bold mb-3">¿Tienes dudas sobre este producto?</h3>
      <p class="text-muted mb-4">
        Nuestro equipo está listo para ayudarte con información técnica, precios especiales y asesoría personalizada.
      </p>
      <div class="d-flex gap-3 justify-content-center flex-wrap">
        <a href="https://wa.me/{{ config('contact.phone') }}" target="_blank" class="btn btn-success btn-lg">
          <i class="bi bi-whatsapp me-2"></i>Consultar por WhatsApp
        </a>
        <a href="mailto:{{ config('contact.email') }}" class="btn btn-outline-primary btn-lg">
          <i class="bi bi-envelope me-2"></i>Enviar email
        </a>
        <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary btn-lg">
          <i class="bi bi-grid me-2"></i>Ver más productos
        </a>
      </div>
    </div>
  </section>
@endsection

@push('scripts')
<script>
  const ppack = {{ (int)$producto->piezas_empaque }};
  
  function stepper(id, delta) {
    const el = document.getElementById(id);
    let v = parseInt(el.value || 1) + delta;
    if (v < 1) v = 1;
    el.value = v;
    updateTotal();
    
    // Efecto visual en el botón
    const btn = event.target.closest('.stepper-btn');
    btn.style.transform = 'scale(0.95)';
    setTimeout(() => {
      btn.style.transform = 'scale(1)';
    }, 150);
  }
  
  function updateTotal() {
    const cantInput = document.getElementById('cant');
    const totalElement = document.getElementById('totalPzas');
    const cantidad = parseInt(cantInput.value || 1);
    totalElement.textContent = (cantidad * ppack).toLocaleString();
  }

  // Inicializar
  document.addEventListener('DOMContentLoaded', function() {
    updateTotal();
    
    // Animación de entrada para las cards
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

    // Observar elementos
    document.querySelectorAll('.spec-card, .feature-item').forEach((el, index) => {
      setTimeout(() => {
        observer.observe(el);
      }, index * 100);
    });

    // Validación del formulario
    document.getElementById('quoteForm').addEventListener('submit', function(e) {
      const cantidad = parseInt(document.getElementById('cant').value);
      if (cantidad < 1) {
        e.preventDefault();
        alert('Por favor selecciona al menos 1 paquete.');
        return false;
      }
      
      // Mostrar feedback visual
      const btn = this.querySelector('.btn-quote');
      const originalText = btn.innerHTML;
      btn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Enviando...';
      btn.disabled = true;
      
      // Si hay error, restaurar botón (esto se manejaría con la respuesta del servidor)
      setTimeout(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
      }, 3000);
    });
  });
</script>
@endpush