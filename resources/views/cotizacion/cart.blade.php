@extends('layouts.app')
@section('title','Cotizador | JM Plásticos')

@section('content')
  <header class="hero py-4">
    <div class="container">
      <h2 class="fw-bold mb-0">Cotizador</h2>
      <p class="text-muted mb-0">Confirma cantidades y envíanos tu solicitud.</p>
    </div>
  </header>

  <div class="container py-4" data-animate>
    {{-- Alertas de estado (correo enviado / error) --}}
    @if(session('ok'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill"></i> {{ session('ok') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
      </div>
    @endif
    @if(session('err'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill"></i> {{ session('err') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
      </div>
    @endif

    @if(empty($cart))
      <div class="alert alert-info">
        Aún no has agregado productos.
        <a href="{{ route('productos.index') }}">Explorar catálogo</a>
      </div>
    @else
    <div class="table-responsive panel p-2">
      <table class="table align-middle mb-0">
        <thead>
          <tr>
            <th>Producto</th>
            <th class="text-center">Pzas/pack</th>
            <th class="text-center">Paquetes</th>
            <th class="text-center">Total piezas</th>
            <th class="text-center">Quitar</th>
          </tr>
        </thead>
        <tbody>
          @foreach($cart as $item)
            <tr>
              <td>
                <div class="d-flex align-items-center gap-3">
                  <img src="{{ asset('images/'.$item['imagen']) }}" width="64" class="rounded border" alt="">
                  <div>
                    <div class="fw-bold">{{ $item['nombre'] }}</div>
                    <div class="small text-muted">{{ $item['capacidad_ml'] }} ml · Rosca {{ $item['rosca'] }}</div>
                  </div>
                </div>
              </td>
              <td class="text-center">{{ $item['piezas_empaque'] }}</td>
              <td class="text-center" style="max-width:220px;">
                <form action="{{ route('cotizacion.update',$item['id']) }}" method="POST" class="d-inline-flex">
                  @csrf @method('PATCH')
                  <div class="input-group">
                    <button class="btn btn-outline-secondary" type="button" onclick="chg('q{{ $item['id'] }}',-1)">−</button>
                    <input type="number" id="q{{ $item['id'] }}" name="cantidad" class="form-control text-center" value="{{ $item['cantidad'] }}" min="1">
                    <button class="btn btn-outline-secondary" type="button" onclick="chg('q{{ $item['id'] }}',1)">+</button>
                    <button class="btn btn-brand text-white" type="submit" title="Actualizar">
                      <i class="bi bi-arrow-repeat"></i>
                    </button>
                  </div>
                </form>
              </td>
              <td class="text-center fw-bold">{{ $item['cantidad'] * $item['piezas_empaque'] }}</td>
              <td class="text-center">
                <form action="{{ route('cotizacion.remove',$item['id']) }}" method="POST" onsubmit="return confirm('Quitar este producto?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-outline-danger"><i class="bi bi-x-lg"></i></button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th colspan="3" class="text-end">Total de piezas</th>
            <th class="text-center fs-5">{{ $total_piezas }}</th>
            <th></th>
          </tr>
        </tfoot>
      </table>
    </div>

    <div class="row g-4 mt-3">
      <div class="col-lg-8">
        <form action="{{ route('cotizacion.submit') }}" method="POST" id="formCorreo" class="vstack gap-3 panel p-3">
          @csrf
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label">Nombre <span class="text-danger">*</span></label>
              <input name="nombre" id="nombre" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Email</label>
              <input name="email" id="email" type="email" class="form-control">
            </div>
            <div class="col-md-4">
              <label class="form-label">Teléfono</label>
              <input name="telefono" id="telefono" class="form-control">
            </div>
          </div>
          <div>
            <label class="form-label">Comentarios</label>
            <textarea name="comentarios" id="comentarios" rows="3" class="form-control" placeholder="Ej. destino, color, observaciones"></textarea>
          </div>
          <div class="d-flex flex-wrap gap-2">
            <button class="btn btn-brand text-white"><i class="bi bi-send"></i> Enviar por correo</button>

            @if(config('contact.phone'))
              <a id="btnWA" href="#" class="btn btn-success">
                <i class="bi bi-whatsapp"></i> Enviar por WhatsApp
              </a>
            @endif
          </div>
          <div class="small text-muted">
            * No mostramos precios en línea. Te responderemos con disponibilidad y costo.
          </div>
        </form>
      </div>

      <div class="col-lg-4">
        <div class="p-3 rounded-3 border panel">
          <h6 class="fw-bold">¿Cómo funciona?</h6>
          <ol class="mb-0 small">
            <li>Confirma la cantidad de <b>paquetes</b> por producto.</li>
            <li>Ingresa tu nombre y contacto.</li>
            <li>Envíanos por <b>correo</b> o <b>WhatsApp</b>.</li>
            <li>Te respondemos con <b>precio y tiempos</b>.</li>
          </ol>
        </div>
      </div>
    </div>
    @endif
  </div>

  {{-- Toast de confirmación para WhatsApp --}}
  <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="toastWA" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body">
          ✔️ Tu cotización se está enviando por WhatsApp…
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button>
      </div>
    </div>
  </div>

  @push('scripts')
  <script>
    function chg(id,delta){
      const el = document.getElementById(id);
      let v = parseInt(el.value || 1) + delta;
      if (v < 1) v = 1;
      el.value = v;
    }

    // Construcción del mensaje y envío por WhatsApp (cálculo de total robusto)
    const btnWA = document.getElementById('btnWA');
    if (btnWA) {
      btnWA.addEventListener('click', function (e) {
        e.preventDefault();

        const nombre = document.getElementById('nombre')?.value || '';
        const email  = document.getElementById('email')?.value || '';
        const tel    = document.getElementById('telefono')?.value || '';
        const com    = document.getElementById('comentarios')?.value || '';

        // Recorre filas y arma líneas + total sin depender de <tfoot>
        const trs = document.querySelectorAll('tbody tr');
        if (!trs.length) {
          alert('Tu cotizador está vacío.');
          return;
        }

        const rows = [];
        let total = 0;
        trs.forEach(tr => {
          const title = tr.querySelector('td .fw-bold')?.textContent?.trim() || '';
          const sub   = tr.querySelector('td .small')?.textContent?.trim() || '';
          const ppack = parseInt((tr.children[1]?.textContent || '0').trim(), 10) || 0;
          const qty   = parseInt(tr.querySelector('input[type="number"]')?.value || '0', 10) || 0;
          const subtotal = ppack * qty;
          total += subtotal;
          rows.push(`• ${title} (${sub})  ${ppack} pzas/pack × ${qty} pack(s) = ${subtotal} pzas`);
        });

        let lines = [];
        lines.push('Solicitud de cotización (JM Plásticos y Envases)');
        lines.push('---------------------------------------------');
        lines = lines.concat(rows);
        lines.push('---------------------------------------------');
        lines.push(`Total de piezas: ${total}`);
        if (nombre) lines.push(`Cliente: ${nombre}`);
        if (tel)    lines.push(`Tel: ${tel}`);
        if (email)  lines.push(`Email: ${email}`);
        if (com)    lines.push(`Comentarios: ${com}`);

        const text = encodeURIComponent(lines.join('\n'));

        // Normalizar número (agregar LADA 52 si no viene)
        const rawPhone = "{{ config('contact.phone') }}";
        const digits = (rawPhone || '').toString().replace(/\D/g,'');
        if (!digits) {
          alert('No hay un número de WhatsApp configurado.');
          return;
        }
        const phoneIntl = digits.startsWith('52') ? digits : ('52' + digits);

        const url = `https://wa.me/${phoneIntl}?text=${text}`;

        // Mostrar toast bonito (si existe Bootstrap JS)
        const toastEl = document.getElementById('toastWA');
        if (toastEl && window.bootstrap?.Toast) {
          const toast = new bootstrap.Toast(toastEl);
          toast.show();
        }

        // Abrir WhatsApp
        window.open(url, '_blank');
      });
    }
  </script>
  @endpush
@endsection
