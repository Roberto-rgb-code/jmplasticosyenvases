@extends('layouts.app')
@section('title', 'Cotizador - '.$producto->nombre)

@push('head')
<style>
  /* Estilos específicos para el cotizador */
  .calculator-hero {
    background: 
      radial-gradient(circle at 20% 30%, rgba(99, 102, 241, 0.08) 0%, transparent 50%),
      radial-gradient(circle at 80% 70%, rgba(6, 182, 212, 0.06) 0%, transparent 50%),
      linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    border-bottom: 1px solid rgba(226, 232, 240, 0.6);
    position: relative;
    overflow: hidden;
  }

  .calculator-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
      radial-gradient(circle at 50% 0%, rgba(99, 102, 241, 0.04) 0%, transparent 60%);
    pointer-events: none;
  }

  .product-preview {
    background: #fff;
    border: 2px solid var(--border);
    border-radius: 20px;
    padding: 2rem;
    text-align: center;
    position: relative;
    overflow: hidden;
    transition: all 0.4s ease;
    box-shadow: 0 8px 30px rgba(15, 23, 42, 0.08);
  }

  .product-preview::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
      radial-gradient(circle at 50% 50%, rgba(99, 102, 241, 0.02) 0%, transparent 70%);
    pointer-events: none;
    opacity: 0;
    transition: opacity 0.3s ease;
  }

  .product-preview:hover::before {
    opacity: 1;
  }

  .product-preview:hover {
    border-color: var(--brand);
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(99, 102, 241, 0.15);
  }

  .product-image-calc {
    width: 120px;
    height: 120px;
    object-fit: contain;
    margin: 0 auto 1.5rem;
    transition: transform 0.3s ease;
  }

  .product-preview:hover .product-image-calc {
    transform: scale(1.1);
  }

  .calculator-form {
    background: 
      linear-gradient(135deg, #fff 0%, #fefeff 100%);
    border: 2px solid var(--border);
    border-radius: 24px;
    padding: 3rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 12px 40px rgba(15, 23, 42, 0.1);
  }

  .calculator-form::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
      radial-gradient(circle at 30% 30%, rgba(99, 102, 241, 0.03) 0%, transparent 60%),
      radial-gradient(circle at 70% 70%, rgba(6, 182, 212, 0.02) 0%, transparent 60%);
    pointer-events: none;
  }

  .quantity-input-group {
    background: #fff;
    border: 3px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
    display: flex;
    align-items: center;
    transition: all 0.3s ease;
    max-width: 240px;
    margin: 0 auto;
  }

  .quantity-input-group:focus-within {
    border-color: var(--brand);
    box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
  }

  .qty-btn {
    background: none;
    border: none;
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--brand);
    font-size: 1.5rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .qty-btn:hover {
    background: var(--brand);
    color: #fff;
  }

  .qty-btn:active {
    transform: scale(0.9);
  }

  .qty-input {
    border: none;
    text-align: center;
    font-weight: 700;
    font-size: 1.8rem;
    color: var(--ink);
    width: 100px;
    background: transparent;
    padding: 1rem 0.5rem;
  }

  .qty-input:focus {
    outline: none;
    box-shadow: none;
  }

  .calculate-btn {
    background: linear-gradient(135deg, var(--brand) 0%, var(--brand-light) 100%);
    border: none;
    color: #fff;
    padding: 1.25rem 3rem;
    border-radius: 16px;
    font-weight: 700;
    font-size: 1.2rem;
    transition: all 0.3s ease;
    box-shadow: 0 8px 30px rgba(99, 102, 241, 0.4);
    position: relative;
    overflow: hidden;
    min-width: 200px;
  }

  .calculate-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.6s ease;
  }

  .calculate-btn:hover::before {
    left: 100%;
  }

  .calculate-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 40px rgba(99, 102, 241, 0.5);
    color: #fff;
  }

  .calculate-btn:active {
    transform: translateY(-1px);
  }

  .calculate-btn.loading {
    background: var(--muted);
    cursor: not-allowed;
    transform: none !important;
    box-shadow: 0 4px 15px rgba(100, 116, 139, 0.3);
  }

  .results-panel {
    background: 
      linear-gradient(135deg, var(--brand) 0%, var(--brand-light) 100%);
    border-radius: 24px;
    padding: 3rem;
    color: #fff;
    position: relative;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(99, 102, 241, 0.3);
    transform: scale(0.95);
    opacity: 0;
    transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .results-panel.show {
    transform: scale(1);
    opacity: 1;
  }

  .results-panel::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    pointer-events: none;
  }

  .results-panel::after {
    content: '';
    position: absolute;
    bottom: -20%;
    left: -20%;
    width: 60%;
    height: 60%;
    background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
    pointer-events: none;
  }

  .result-item {
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    padding: 2rem;
    text-align: center;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
  }

  .result-item:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-3px);
  }

  .result-value {
    font-size: 2.5rem;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 0.5rem;
  }

  .result-label {
    opacity: 0.9;
    font-weight: 500;
    font-size: 1.1rem;
  }

  .result-icon {
    font-size: 2rem;
    opacity: 0.8;
    margin-bottom: 1rem;
  }

  .breakdown-card {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 20px;
    padding: 2rem;
    backdrop-filter: blur(15px);
    margin-top: 2rem;
  }

  .breakdown-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  }

  .breakdown-item:last-child {
    border-bottom: none;
    font-weight: 700;
    font-size: 1.2rem;
  }

  .action-buttons {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
    flex-wrap: wrap;
  }

  .btn-action {
    background: rgba(255, 255, 255, 0.2);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: #fff;
    padding: 1rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    backdrop-filter: blur(10px);
    flex: 1;
    justify-content: center;
    min-width: 160px;
  }

  .btn-action:hover {
    background: rgba(255, 255, 255, 0.3);
    border-color: rgba(255, 255, 255, 0.5);
    color: #fff;
    transform: translateY(-2px);
  }

  .btn-action.primary {
    background: #fff;
    color: var(--brand);
    border-color: #fff;
  }

  .btn-action.primary:hover {
    background: rgba(255, 255, 255, 0.9);
    color: var(--brand);
  }

  .specs-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
  }

  .spec-item {
    background: rgba(99, 102, 241, 0.05);
    border: 1px solid rgba(99, 102, 241, 0.15);
    border-radius: 12px;
    padding: 1rem;
    text-align: center;
    transition: all 0.3s ease;
  }

  .spec-item:hover {
    border-color: var(--brand);
    transform: translateY(-2px);
  }

  .spec-icon {
    color: var(--brand);
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
  }

  .spec-value {
    font-weight: 700;
    font-size: 1.1rem;
    color: var(--ink);
  }

  .spec-label {
    font-size: 0.85rem;
    color: var(--muted);
    margin-top: 0.25rem;
  }

  /* Animaciones */
  @keyframes bounceIn {
    0% {
      transform: scale(0.3);
      opacity: 0;
    }
    50% {
      transform: scale(1.05);
    }
    70% {
      transform: scale(0.9);
    }
    100% {
      transform: scale(1);
      opacity: 1;
    }
  }

  .animate-bounce-in {
    animation: bounceIn 0.6s ease-out;
  }

  @keyframes pulse {
    0%, 100% {
      transform: scale(1);
    }
    50% {
      transform: scale(1.02);
    }
  }

  .animate-pulse {
    animation: pulse 2s infinite;
  }

  /* Responsive */
  @media (max-width: 992px) {
    .calculator-form {
      padding: 2rem;
    }
    
    .results-panel {
      padding: 2rem;
    }
    
    .action-buttons {
      flex-direction: column;
    }
    
    .btn-action {
      flex: none;
    }
  }

  @media (max-width: 768px) {
    .calculate-btn {
      width: 100%;
      margin-top: 1rem;
    }
    
    .quantity-input-group {
      max-width: 200px;
    }
    
    .qty-input {
      font-size: 1.5rem;
      width: 80px;
    }
    
    .result-value {
      font-size: 2rem;
    }
  }
</style>
@endpush

@section('content')
  {{-- HERO CALCULADORA --}}
  <header class="calculator-hero py-5">
    <div class="container container-narrow">
      <div class="text-center mb-4">
        <a href="{{ route('productos.index') }}" class="breadcrumb-link">
          <x-icon name="arrow-left" />Regresar al catálogo
        </a>
      </div>
      
      <div class="text-center">
        <span class="badge badge-modern mb-3">
          <x-icon name="hash" />Cotizador inteligente
        </span>
        <h1 class="fw-bold display-5 mb-3">
          Calcula tu pedido
        </h1>
        <p class="text-muted lead mb-0">
          Obtén al instante el total de piezas para tu proyecto
        </p>
      </div>
    </div>
  </header>

  {{-- CONTENIDO PRINCIPAL --}}
  <div class="container container-narrow py-5">
    <div class="row g-5 align-items-start">
      {{-- INFORMACIÓN DEL PRODUCTO --}}
      <div class="col-lg-5">
        <div class="product-preview">
          <img 
            src="{{ $producto->imagen_url }}" 
            alt="{{ $producto->nombre }}" 
            class="product-image-calc"
          >
          <h4 class="fw-bold mb-3">{{ $producto->nombre }}</h4>
          
          <div class="specs-grid">
            <div class="spec-item">
              <div class="spec-icon">
                <x-icon name="water" size="1.4em" />
              </div>
              <div class="spec-value">{{ $producto->capacidad_ml }}</div>
              <div class="spec-label">Mililitros</div>
            </div>
            
            <div class="spec-item">
              <div class="spec-icon">
                <x-icon name="cog" size="1.4em" />
              </div>
              <div class="spec-value">{{ $producto->rosca }}</div>
              <div class="spec-label">Rosca</div>
            </div>
            
            <div class="spec-item">
              <div class="spec-icon">
                <x-icon name="folder-multiple" size="1.4em" />
              </div>
              <div class="spec-value">{{ $producto->piezas_empaque }}</div>
              <div class="spec-label">Pzas/paquete</div>
            </div>
          </div>
          
          <div class="mt-4">
            <div class="d-flex gap-2 justify-content-center">
              <a href="{{ route('producto.show', $producto) }}" class="btn btn-outline-secondary btn-sm">
                <x-icon name="search" />Ver ficha técnica
              </a>
              <a href="https://wa.me/{{ config('contact.phone') }}" target="_blank" class="btn btn-success btn-sm">
                <x-icon name="phone-call" />Consultar
              </a>
            </div>
          </div>
        </div>
      </div>

      {{-- CALCULADORA --}}
      <div class="col-lg-7">
        <div class="calculator-form">
          <div class="text-center mb-4">
            <h3 class="fw-bold mb-3">
              <x-icon name="hash" />
              Calculadora de pedido
            </h3>
            <p class="text-muted">
              Ingresa la cantidad de paquetes que necesitas y obtén el cálculo instantáneo
            </p>
          </div>

          <form id="cotizadorForm">
            <div class="text-center mb-4">
              <label for="cantidad" class="form-label fw-bold mb-3 d-block">
                Cantidad de paquetes
              </label>
              
              <div class="quantity-input-group">
                <button type="button" class="qty-btn" onclick="adjustQuantity(-1)">
                  <x-icon name="minus" size="1em" />
                </button>
                <input 
                  type="number" 
                  id="cantidad" 
                  class="qty-input" 
                  min="1" 
                  value="1"
                  onchange="calcularAuto()"
                >
                <button type="button" class="qty-btn" onclick="adjustQuantity(1)">
                  <x-icon name="plus" size="1em" />
                </button>
              </div>
            </div>

            <div class="text-center">
              <button type="button" class="calculate-btn" onclick="calcular()">
                <x-icon name="play" />
                <span class="btn-text">Calcular total</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    {{-- PANEL DE RESULTADOS --}}
    <div class="row mt-5">
      <div class="col-12">
        <div id="resultado" class="results-panel" style="display: none;">
          <!-- Los resultados se insertan aquí dinámicamente -->
        </div>
      </div>
    </div>
  </div>

  {{-- CTA SECTION --}}
  <section class="py-5 bg-light bg-opacity-50">
    <div class="container container-narrow text-center">
      <h3 class="fw-bold mb-3">¿Listo para hacer tu pedido?</h3>
      <p class="text-muted mb-4">
        Una vez que tengas tu cálculo, nuestro equipo te ayudará con precios y disponibilidad
      </p>
      <div class="d-flex gap-3 justify-content-center flex-wrap">
        <a href="{{ route('cotizacion.cart') }}" class="btn btn-brand btn-lg">
          <x-icon name="clipboard-plus" />Ir al cotizador completo
        </a>
        <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary btn-lg">
          <x-icon name="grid-3" />Ver más productos
        </a>
      </div>
    </div>
  </section>
@endsection

@push('scripts')
<script>
  const piezasPorEmpaque = {{ $producto->piezas_empaque }};
  const nombreProducto = "{{ $producto->nombre }}";
  
  // Auto-calcular cuando cambia el input
  function calcularAuto() {
    const cantidad = parseInt(document.getElementById('cantidad').value);
    if (cantidad && cantidad > 0) {
      setTimeout(calcular, 300); // Pequeño delay para mejor UX
    }
  }
  
  // Ajustar cantidad con botones
  function adjustQuantity(delta) {
    const input = document.getElementById('cantidad');
    let cantidad = parseInt(input.value || 1) + delta;
    if (cantidad < 1) cantidad = 1;
    input.value = cantidad;
    
    // Efecto visual en botón
    const btn = event.target.closest('.qty-btn');
    btn.style.transform = 'scale(0.9)';
    setTimeout(() => {
      btn.style.transform = 'scale(1)';
    }, 150);
    
    calcularAuto();
  }
  
  // Función principal de cálculo
  function calcular() {
    const cantidadInput = document.getElementById('cantidad');
    const cantidad = parseInt(cantidadInput.value);
    const btn = document.querySelector('.calculate-btn');
    const btnText = btn.querySelector('.btn-text');
    
    // Validación
    if (!cantidad || cantidad < 1) {
      cantidadInput.focus();
      cantidadInput.style.borderColor = '#ef4444';
      setTimeout(() => {
        cantidadInput.style.borderColor = '';
      }, 2000);
      return;
    }
    
    // Estado de carga
    btn.classList.add('loading');
    btnText.innerHTML = '<iconify-icon icon="line-md:loading-loop" width="1.2em" height="1.2em"></iconify-icon> Calculando...';
    btn.disabled = true;
    
    setTimeout(() => {
      const totalPiezas = cantidad * piezasPorEmpaque;
      mostrarResultado(cantidad, totalPiezas);
      
      // Restaurar botón
      btn.classList.remove('loading');
      btnText.innerHTML = '<iconify-icon icon="line-md:backup-restore" width="1.2em" height="1.2em"></iconify-icon> Recalcular';
      btn.disabled = false;
    }, 1200); // Simular tiempo de procesamiento
  }
  
  // Mostrar resultado con animación
  function mostrarResultado(cantidad, totalPiezas) {
    const resultadoDiv = document.getElementById('resultado');
    
    const html = `
      <div class="text-center mb-4">
        <h3 class="fw-bold mb-2">
          <iconify-icon icon="line-md:confirm-circle" width="1.3em" height="1.3em"></iconify-icon>
          Cálculo completado
        </h3>
        <p class="opacity-90">Aquí está el desglose de tu pedido</p>
      </div>
      
      <div class="row g-4 mb-4">
        <div class="col-md-4">
          <div class="result-item animate-bounce-in" style="animation-delay: 0.1s">
            <div class="result-icon">
              <iconify-icon icon="line-md:heart" width="1.6em" height="1.6em"></iconify-icon>
            </div>
            <div class="result-value">${cantidad.toLocaleString()}</div>
            <div class="result-label">Paquetes</div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="result-item animate-bounce-in" style="animation-delay: 0.2s">
            <div class="result-icon">
              <iconify-icon icon="line-md:grid-3" width="1.6em" height="1.6em"></iconify-icon>
            </div>
            <div class="result-value">${piezasPorEmpaque.toLocaleString()}</div>
            <div class="result-label">Pzas por paquete</div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="result-item animate-bounce-in animate-pulse" style="animation-delay: 0.3s">
            <div class="result-icon">
              <iconify-icon icon="line-md:hash" width="1.6em" height="1.6em"></iconify-icon>
            </div>
            <div class="result-value">${totalPiezas.toLocaleString()}</div>
            <div class="result-label">Total de piezas</div>
          </div>
        </div>
      </div>
      
      <div class="breakdown-card">
        <h5 class="fw-bold mb-3">
          <iconify-icon icon="line-md:list" width="1.2em" height="1.2em"></iconify-icon> Desglose del pedido
        </h5>
        <div class="breakdown-item">
          <span>Producto</span>
          <span>${nombreProducto}</span>
        </div>
        <div class="breakdown-item">
          <span>Paquetes solicitados</span>
          <span>${cantidad.toLocaleString()}</span>
        </div>
        <div class="breakdown-item">
          <span>Piezas por paquete</span>
          <span>${piezasPorEmpaque.toLocaleString()}</span>
        </div>
        <div class="breakdown-item">
          <span><strong>Total de piezas</strong></span>
          <span><strong>${totalPiezas.toLocaleString()}</strong></span>
        </div>
      </div>
      
      <div class="action-buttons">
        <a href="{{ route('cotizacion.add', $producto) }}?cantidad=${cantidad}" class="btn-action primary">
          <iconify-icon icon="line-md:email-arrow-up" width="1.2em" height="1.2em"></iconify-icon>
          Solicitar cotización
        </a>
        <a href="https://wa.me/{{ config('contact.phone') }}?text=Hola, necesito cotización para ${cantidad} paquetes de ${nombreProducto} (${totalPiezas.toLocaleString()} piezas total)" target="_blank" class="btn-action">
          <iconify-icon icon="line-md:phone-call" width="1.2em" height="1.2em"></iconify-icon>
          Enviar por WhatsApp
        </a>
        <button onclick="compartirResultado(${cantidad}, ${totalPiezas})" class="btn-action">
          <iconify-icon icon="line-md:external-link" width="1.2em" height="1.2em"></iconify-icon>
          Compartir cálculo
        </button>
      </div>
    `;
    
    resultadoDiv.innerHTML = html;
    resultadoDiv.style.display = 'block';
    
    // Animación de entrada
    setTimeout(() => {
      resultadoDiv.classList.add('show');
      // Scroll suave hacia resultados
      resultadoDiv.scrollIntoView({ 
        behavior: 'smooth', 
        block: 'center' 
      });
    }, 100);
  }
  
  // Función para compartir resultado
  function compartirResultado(cantidad, totalPiezas) {
    if (navigator.share) {
      navigator.share({
        title: 'Cálculo de pedido - JM Plásticos',
        text: `Pedido calculado: ${cantidad.toLocaleString()} paquetes = ${totalPiezas.toLocaleString()} piezas de ${nombreProducto}`,
        url: window.location.href
      });
    } else {
      // Fallback: copiar al clipboard
      const texto = `Pedido calculado: ${cantidad.toLocaleString()} paquetes = ${totalPiezas.toLocaleString()} piezas de ${nombreProducto}`;
      navigator.clipboard.writeText(texto).then(() => {
        // Feedback visual
        const btn = event.target.closest('.btn-action');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<iconify-icon icon="line-md:confirm" width="1.2em" height="1.2em"></iconify-icon> ¡Copiado!';
        setTimeout(() => {
          btn.innerHTML = originalText;
        }, 2000);
      });
    }
  }
  
  // Inicialización
  document.addEventListener('DOMContentLoaded', function() {
    // Auto-focus en el input
    document.getElementById('cantidad').focus();
    
    // Enter para calcular
    document.getElementById('cantidad').addEventListener('keypress', function(e) {
      if (e.key === 'Enter') {
        calcular();
      }
    });
    
    // Validación en tiempo real
    document.getElementById('cantidad').addEventListener('input', function(e) {
      const value = parseInt(e.target.value);
      if (value < 1) {
        e.target.value = 1;
      }
    });
    
    // Cálculo inicial
    setTimeout(calcular, 1000);
  });
</script>
@endpush