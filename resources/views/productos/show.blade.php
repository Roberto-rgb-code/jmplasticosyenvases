@extends('layouts.app')
@section('title', $producto->nombre.' | JM Plásticos')

@section('content')
<div class="hero">
  <div class="container container-narrow">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="{{ route('productos.index') }}">Catálogo</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $producto->nombre }}</li>
      </ol>
    </nav>
    <span class="chip mb-3"><x-icon name="file-document" /> Ficha técnica</span>
    <h1 class="font-display display-5 display-tight mb-0">{{ $producto->nombre }}</h1>
  </div>
</div>

<div class="container container-narrow py-5">
  <div class="row g-5 align-items-start">
    <div class="col-lg-6">
      <div class="card-soft p-4 p-lg-5 text-center product-media" style="height: auto;">
        <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" class="img-fluid" style="max-height: 420px;">
      </div>
    </div>
    <div class="col-lg-6">
      <div class="row g-2 g-md-3 mb-4 spec-compact">
        <div class="col-4">
          <div class="card-soft p-2 p-md-3 text-center h-100">
            <div class="icon-tile mx-auto mb-2" style="width:2.2rem;height:2.2rem;"><x-icon name="water" size="18" /></div>
            <div class="small text-secondary">Capacidad</div>
            <div class="fw-bold">{{ $producto->capacidad_ml }} ml</div>
          </div>
        </div>
        <div class="col-4">
          <div class="card-soft p-2 p-md-3 text-center h-100">
            <div class="icon-tile mx-auto mb-2" style="width:2.2rem;height:2.2rem;"><x-icon name="cog" size="18" /></div>
            <div class="small text-secondary">Rosca</div>
            <div class="fw-bold">{{ $producto->rosca }}</div>
          </div>
        </div>
        <div class="col-4">
          <div class="card-soft p-2 p-md-3 text-center h-100">
            <div class="icon-tile mx-auto mb-2" style="width:2.2rem;height:2.2rem;"><x-icon name="folder-multiple" size="18" /></div>
            <div class="small text-secondary">Por pack</div>
            <div class="fw-bold">{{ $producto->piezas_empaque }}</div>
          </div>
        </div>
      </div>

      <div class="card-soft p-4 p-lg-4">
        <form action="{{ route('cotizacion.add', $producto) }}" method="POST" id="quoteForm">
          @csrf
          <h2 class="h5 fw-bold mb-2">Agregar a cotización</h2>
          <p class="text-secondary small">Indica cuántos paquetes necesitas. El precio se confirma por WhatsApp o correo.</p>
          <label class="form-label fw-semibold">Paquetes</label>
          <div class="stepper mb-2">
            <button type="button" onclick="step(-1)" aria-label="Menos"><x-icon name="minus" size="1em" /></button>
            <input type="number" id="cant" name="cantidad" value="1" min="1" inputmode="numeric">
            <button type="button" onclick="step(1)" aria-label="Más"><x-icon name="plus" size="1em" /></button>
          </div>
          <div class="small text-secondary mb-3">Total estimado: <strong id="totalPzas">{{ $producto->piezas_empaque }}</strong> piezas</div>
          <div class="d-grid gap-2">
            <button class="btn btn-brand" type="submit"><x-icon name="plus-circle" color="ffffff" />Agregar al cotizador</button>
            <a href="{{ route('cotizacion.cart') }}" class="btn btn-ghost"><x-icon name="clipboard-list" />Ver cotizador</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  @if(($relacionados ?? collect())->isNotEmpty())
    <div class="mt-5">
      <h2 class="font-display h3 display-tight mb-4">También disponible</h2>
      <div class="row g-4">
        @foreach($relacionados as $rel)
          <div class="col-md-6 col-lg-5">
            @include('productos._card', ['producto' => $rel])
          </div>
        @endforeach
      </div>
    </div>
  @endif
</div>
@endsection

@push('scripts')
<script>
  const ppack = {{ (int) $producto->piezas_empaque }};
  function step(delta) {
    const el = document.getElementById('cant');
    el.value = Math.max(1, parseInt(el.value || 1, 10) + delta);
    document.getElementById('totalPzas').textContent = (el.value * ppack).toLocaleString();
  }
  document.getElementById('cant').addEventListener('input', () => step(0));
</script>
@endpush
