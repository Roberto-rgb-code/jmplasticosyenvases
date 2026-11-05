@extends('layouts.app')
@section('title', 'Cotizador | JM Plásticos')

@section('content')
<header class="hero">
  <div class="container container-narrow">
    <span class="chip mb-3"><x-icon name="clipboard-check" /> Solicitud de cotización</span>
    <h1 class="font-display display-5 display-tight mb-2">Cotizador</h1>
    <p class="text-secondary lead mb-0">Confirma paquetes y envía tu solicitud. Te respondemos con precio y tiempos.</p>
  </div>
</header>

<div class="container container-narrow py-5">
  @if(session('ok'))
    <div class="alert alert-success d-flex align-items-center rounded-4" role="alert">
      <x-icon name="confirm-circle" class="me-2" />{{ session('ok') }}
    </div>
  @endif
  @if(session('err'))
    <div class="alert alert-danger d-flex align-items-center rounded-4" role="alert">
      <x-icon name="alert-circle" class="me-2" />{{ session('err') }}
    </div>
  @endif

  @if(empty($cart))
    <div class="card-soft empty-state">
      <div class="empty-orb"><x-icon name="clipboard-plus" size="2em" /></div>
      <h2 class="h4 fw-bold">Tu cotizador está vacío</h2>
      <p class="text-secondary">Agrega el salsero o la piña de 5 L para armar tu pedido.</p>
      <a href="{{ route('productos.index') }}" class="btn btn-brand"><x-icon name="grid-3" color="ffffff" />Ver catálogo</a>
    </div>
  @else
    <div class="row g-4">
      <div class="col-lg-7">
        <div class="d-grid gap-3">
          @foreach($cart as $item)
            <article class="card-soft p-3 p-md-4">
              <div class="cart-line">
                <div class="cart-thumb rounded-4 bg-light p-2 d-flex align-items-center justify-content-center">
                  <img src="{{ asset('images/'.$item['imagen']) }}" alt="" width="64" height="64" class="object-fit-contain">
                </div>
                <div class="flex-grow-1 min-w-0">
                  <div class="fw-bold">{{ $item['nombre'] }}</div>
                  <div class="small text-secondary">{{ $item['capacidad_ml'] }} ml · {{ $item['rosca'] }} · {{ $item['piezas_empaque'] }} pzas/pack</div>
                  <form action="{{ route('cotizacion.update', $item['id']) }}" method="POST" class="d-flex align-items-center gap-2 mt-2 flex-wrap">
                    @csrf @method('PATCH')
                    <div class="stepper">
                      <button type="button" onclick="chg('q{{ $item['id'] }}',-1)" aria-label="Menos"><x-icon name="minus" size="1em" /></button>
                      <input type="number" id="q{{ $item['id'] }}" name="cantidad" value="{{ $item['cantidad'] }}" min="1" inputmode="numeric">
                      <button type="button" onclick="chg('q{{ $item['id'] }}',1)" aria-label="Más"><x-icon name="plus" size="1em" /></button>
                    </div>
                    <button class="btn btn-ghost btn-sm" type="submit">Actualizar</button>
                  </form>
                </div>
                <div class="cart-meta text-end">
                  <div>
                    <div class="fw-bold fs-5">{{ $item['cantidad'] * $item['piezas_empaque'] }}</div>
                    <div class="small text-secondary">piezas</div>
                  </div>
                  <form action="{{ route('cotizacion.remove', $item['id']) }}" method="POST">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger btn-sm rounded-pill" type="submit" aria-label="Quitar">
                      <x-icon name="trash" size="1.1em" />
                    </button>
                  </form>
                </div>
              </div>
            </article>
          @endforeach
        </div>
      </div>

      <div class="col-lg-5">
        <div class="card-soft p-4 sticky-lg-top" style="top: 5.5rem;">
          <h2 class="h5 fw-bold mb-3">Resumen</h2>
          <div class="d-flex justify-content-between mb-2">
            <span class="text-secondary">Paquetes</span>
            <strong>{{ $total_packs }}</strong>
          </div>
          <div class="d-flex justify-content-between mb-4 pb-3 border-bottom">
            <span class="text-secondary">Total de piezas</span>
            <strong class="fs-4">{{ $total_piezas }}</strong>
          </div>

          <form action="{{ route('cotizacion.submit') }}" method="POST" class="vstack gap-3">
            @csrf
            <div class="form-floating">
              <input name="nombre" id="nombre" class="form-control" placeholder="Nombre" required>
              <label for="nombre">Nombre *</label>
            </div>
            <div class="form-floating">
              <input name="email" id="email" type="email" class="form-control" placeholder="Email">
              <label for="email">Email</label>
            </div>
            <div class="form-floating">
              <input name="telefono" id="telefono" class="form-control" placeholder="Teléfono">
              <label for="telefono">Teléfono</label>
            </div>
            <div class="form-floating">
              <textarea name="comentarios" id="comentarios" class="form-control" placeholder="Comentarios" style="height: 100px"></textarea>
              <label for="comentarios">Comentarios</label>
            </div>
            <button class="btn btn-brand w-100" type="submit"><x-icon name="email-arrow-up" color="ffffff" />Enviar por correo</button>
            @if(config('contact.phone'))
              <a id="btnWA" href="#" class="btn btn-success rounded-pill w-100"><x-icon name="phone-call-loop" color="ffffff" />Enviar por WhatsApp</a>
            @endif
            <p class="small text-secondary mb-0">No publicamos precios. Te confirmamos costo y disponibilidad al recibir la solicitud.</p>
          </form>
        </div>
      </div>
    </div>
  @endif
</div>
@endsection

@push('scripts')
<script>
  function chg(id, delta) {
    const el = document.getElementById(id);
    el.value = Math.max(1, parseInt(el.value || 1, 10) + delta);
  }
  const btnWA = document.getElementById('btnWA');
  if (btnWA) {
    btnWA.addEventListener('click', function (e) {
      e.preventDefault();
      const nombre = document.getElementById('nombre')?.value || '';
      const email  = document.getElementById('email')?.value || '';
      const tel    = document.getElementById('telefono')?.value || '';
      const com    = document.getElementById('comentarios')?.value || '';
      const cards = document.querySelectorAll('article.card-soft');
      if (!cards.length) { alert('Tu cotizador está vacío.'); return; }
      const rows = [];
      let total = 0;
      cards.forEach(card => {
        const title = card.querySelector('.fw-bold')?.textContent?.trim() || '';
        const sub = card.querySelector('.small.text-secondary')?.textContent?.trim() || '';
        const qty = parseInt(card.querySelector('input[type="number"]')?.value || '0', 10) || 0;
        const match = sub.match(/(\d+)\s+pzas\/pack/);
        const ppack = match ? parseInt(match[1], 10) : 0;
        const subtotal = ppack * qty;
        total += subtotal;
        rows.push(`• ${title} (${sub})  ${qty} pack(s) = ${subtotal} pzas`);
      });
      const lines = [
        'Solicitud de cotización (JM Plásticos y Envases)',
        '---------------------------------------------',
        ...rows,
        '---------------------------------------------',
        `Total de piezas: ${total}`,
      ];
      if (nombre) lines.push(`Cliente: ${nombre}`);
      if (tel) lines.push(`Tel: ${tel}`);
      if (email) lines.push(`Email: ${email}`);
      if (com) lines.push(`Comentarios: ${com}`);
      const digits = "{{ preg_replace('/\\D+/', '', (string) config('contact.phone')) }}";
      const phoneIntl = digits.startsWith('52') ? digits : ('52' + digits);
      window.open(`https://wa.me/${phoneIntl}?text=${encodeURIComponent(lines.join('\n'))}`, '_blank');
    });
  }
</script>
@endpush
