@extends('layouts.app')
@section('title', 'Contacto | JM Plásticos y Envases')

@section('content')
<header class="hero">
  <div class="container container-narrow text-center">
    <span class="chip mb-3"><x-icon name="chat-round-dots" /> Atención directa</span>
    <h1 class="font-display display-4 display-tight mb-3">Hablemos de tu pedido</h1>
    <p class="lead text-secondary mb-0 mx-auto" style="max-width: 36rem;">Elige el canal que te acomode. Respondemos con disponibilidad, tiempos y precio.</p>
  </div>
</header>

<div class="container container-narrow py-5">
  <div class="row g-4">
    <div class="col-12 col-md-4">
      <a class="card-soft contact-card p-4 h-100 text-decoration-none text-dark d-block" href="mailto:{{ config('contact.email') }}">
        <div class="icon-tile mb-3"><x-icon name="email" size="1.6em" /></div>
        <h2 class="h5 fw-bold">Correo</h2>
        <p class="text-secondary mb-0">{{ config('contact.email') ?: 'Escríbenos desde el cotizador' }}</p>
      </a>
    </div>
    <div class="col-12 col-md-4">
      <a class="card-soft contact-card p-4 h-100 text-decoration-none text-dark d-block" href="tel:{{ config('contact.phone') }}">
        <div class="icon-tile mb-3"><x-icon name="phone-call-loop" size="1.6em" /></div>
        <h2 class="h5 fw-bold">Teléfono</h2>
        <p class="text-secondary mb-0">{{ config('contact.phone') ?: 'Disponible en tu cotización' }}</p>
      </a>
    </div>
    <div class="col-12 col-md-4">
      <a class="card-soft contact-card p-4 h-100 text-decoration-none text-dark d-block" href="https://wa.me/{{ preg_replace('/\D+/', '', (string) config('contact.phone')) }}" target="_blank" rel="noopener">
        <div class="icon-tile mb-3"><x-icon name="chat-round-dots" size="1.6em" /></div>
        <h2 class="h5 fw-bold">WhatsApp</h2>
        <p class="text-secondary mb-0">La vía más rápida para confirmar un pedido.</p>
      </a>
    </div>
  </div>
  <div class="cta-banner p-4 p-lg-5 mt-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
    <div class="position-relative" style="z-index:1">
      <h2 class="h4 fw-bold mb-1">¿Ya sabes qué envase necesitas?</h2>
      <p class="mb-0 opacity-75">Arma la cotización con cantidades y envíala en un paso.</p>
    </div>
    <a href="{{ route('productos.index') }}" class="btn btn-light rounded-pill fw-bold px-4 position-relative" style="z-index:1"><x-icon name="grid-3" color="042f2e" /> Ir al catálogo</a>
  </div>
</div>
@endsection
