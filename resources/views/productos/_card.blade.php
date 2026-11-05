<article class="card-soft product-card h-100 d-flex flex-column">
  <a href="{{ route('producto.show', $producto) }}" class="product-media text-decoration-none">
    <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" loading="lazy">
  </a>
  <div class="p-4 d-flex flex-column flex-grow-1">
    <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
      <h3 class="h5 fw-bold mb-0 min-w-0">{{ $producto->nombre }}</h3>
      <span class="spec-pill flex-shrink-0">{{ number_format($producto->capacidad_ml / 1000, 0) }} L</span>
    </div>
    <div class="d-flex flex-wrap gap-1 mb-4">
      <span class="spec-pill"><x-icon name="water" size="1em" />{{ $producto->capacidad_ml }} ml</span>
      <span class="spec-pill"><x-icon name="cog" size="1em" />{{ $producto->rosca }}</span>
      <span class="spec-pill"><x-icon name="folder" size="1em" />{{ $producto->piezas_empaque }} pzas/pack</span>
    </div>
    <div class="mt-auto d-grid gap-2">
      <a href="{{ route('producto.show', $producto) }}" class="btn btn-brand"><x-icon name="file-document" color="ffffff" />Ver ficha</a>
      <form action="{{ route('cotizacion.add', $producto) }}" method="POST">
        @csrf
        <input type="hidden" name="cantidad" value="1">
        <button class="btn btn-ghost w-100" type="submit">
          <x-icon name="plus" />Agregar a cotización
        </button>
      </form>
    </div>
  </div>
</article>
