@extends('layouts.app')
@section('title', 'Catálogo | JM Plásticos y Envases')

@section('content')
<header class="hero">
  <div class="container container-narrow text-center">
    <span class="chip mb-3"><x-icon name="grid-3" /> {{ $productos->count() }} modelos activos</span>
    <h1 class="font-display display-4 display-tight mb-3">Catálogo PET de 5 litros</h1>
    <p class="text-secondary lead mb-0 mx-auto" style="max-width: 38rem;">Filtra por rosca o capacidad y agrégalo al cotizador. El precio se confirma al enviar tu solicitud.</p>
  </div>
</header>

<div class="container container-narrow py-5">
  <div class="row g-4">
    <aside class="col-lg-3">
      <div class="d-lg-none mb-3">
        <button class="btn btn-ghost w-100" type="button" data-bs-toggle="offcanvas" data-bs-target="#filtersOffcanvas">
          <x-icon name="filter" />Filtros
        </button>
      </div>
      <div class="offcanvas-lg offcanvas-start" tabindex="-1" id="filtersOffcanvas">
        <div class="offcanvas-header d-lg-none">
          <h5 class="offcanvas-title fw-bold">Filtros</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#filtersOffcanvas"></button>
        </div>
        <div class="offcanvas-body p-0">
          <form method="get" class="card-soft p-4" id="filterForm">
            <h2 class="h6 fw-bold mb-3">Afinar búsqueda</h2>
            <label class="form-label fw-semibold">Buscar</label>
            <input type="search" name="q" value="{{ $q }}" class="form-control mb-3" placeholder="Nombre del envase" enterkeyhint="search">

            <label class="form-label fw-semibold">Rosca</label>
            <select name="rosca" class="form-select mb-3">
              <option value="">Todas</option>
              @foreach($roscas as $r)
                <option value="{{ $r }}" @selected($rosca==$r)>{{ $r }}</option>
              @endforeach
            </select>

            <label class="form-label fw-semibold">Capacidad (ml)</label>
            <div class="row g-2 mb-3">
              <div class="col-6"><input type="number" name="cap_min" value="{{ $min }}" class="form-control" placeholder="Mín" min="0" inputmode="numeric"></div>
              <div class="col-6"><input type="number" name="cap_max" value="{{ $max }}" class="form-control" placeholder="Máx" min="0" inputmode="numeric"></div>
            </div>

            <label class="form-label fw-semibold">Orden</label>
            <select name="sort" class="form-select mb-4">
              <option value="">Relevancia</option>
              <option value="alpha" @selected($sort==='alpha')>A-Z</option>
              <option value="cap_asc" @selected($sort==='cap_asc')>Capacidad ↑</option>
              <option value="cap_desc" @selected($sort==='cap_desc')>Capacidad ↓</option>
            </select>

            <button class="btn btn-brand w-100" type="submit"><x-icon name="filter-confirm" color="ffffff" />Aplicar</button>
            @if(request()->hasAny(['q','rosca','cap_min','cap_max','sort']))
              <a href="{{ route('productos.index') }}" class="btn btn-ghost w-100 mt-2">Limpiar</a>
            @endif
          </form>
        </div>
      </div>
    </aside>

    <section class="col-lg-9">
      @if($productos->isEmpty())
        <div class="card-soft empty-state">
          <div class="empty-orb"><x-icon name="search" size="2em" /></div>
          <h2 class="h4 fw-bold">Sin coincidencias</h2>
          <p class="text-secondary">Prueba otros filtros o revisa el catálogo completo.</p>
          <a href="{{ route('productos.index') }}" class="btn btn-brand">Ver todo</a>
        </div>
      @else
        <div class="row g-4">
          @foreach($productos as $producto)
            <div class="col-md-6">
              @include('productos._card', ['producto' => $producto])
            </div>
          @endforeach
        </div>
      @endif
    </section>
  </div>
</div>
@endsection
