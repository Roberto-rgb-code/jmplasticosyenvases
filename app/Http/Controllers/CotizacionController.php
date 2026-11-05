<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class CotizacionController extends Controller
{
    private function getCart(): array
    {
        return session()->get('cart', []);
    }

    private function putCart(array $cart): void
    {
        session()->put('cart', $cart);
    }

    public function add(Request $request, Producto $producto)
    {
        $cantidad = max(1, (int) $request->input('cantidad', 1));
        $cart = $this->getCart();

        if (isset($cart[$producto->id])) {
            $cart[$producto->id]['cantidad'] += $cantidad;
        } else {
            $cart[$producto->id] = [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'imagen' => $producto->imagen,
                'piezas_empaque' => $producto->piezas_empaque,
                'capacidad_ml' => $producto->capacidad_ml,
                'rosca' => $producto->rosca,
                'cantidad' => $cantidad,
            ];
        }

        $this->putCart($cart);

        return redirect()->route('cotizacion.cart')->with('ok', 'Producto agregado al cotizador.');
    }

    public function cart(Request $request)
    {
        if ($request->filled('add')) {
            $producto = Producto::find($request->integer('add'));
            if ($producto) {
                return $this->add($request, $producto);
            }
        }

        $cart = collect($this->getCart())
            ->map(function ($item) {
                $producto = Producto::find($item['id'] ?? 0);
                if (! $producto) {
                    return null;
                }

                return [
                    'id' => $producto->id,
                    'nombre' => $producto->nombre,
                    'imagen' => $producto->imagen,
                    'piezas_empaque' => $producto->piezas_empaque,
                    'capacidad_ml' => $producto->capacidad_ml,
                    'rosca' => $producto->rosca,
                    'cantidad' => max(1, (int) ($item['cantidad'] ?? 1)),
                ];
            })
            ->filter()
            ->all();
        $this->putCart($cart);

        $total_piezas = collect($cart)->sum(fn ($i) => $i['cantidad'] * $i['piezas_empaque']);
        $total_packs = collect($cart)->sum('cantidad');

        return view('cotizacion.cart', compact('cart', 'total_piezas', 'total_packs'));
    }

    public function update(Request $request, Producto $producto)
    {
        $cantidad = max(1, (int) $request->input('cantidad', 1));
        $cart = $this->getCart();

        if (isset($cart[$producto->id])) {
            $cart[$producto->id]['cantidad'] = $cantidad;
            $this->putCart($cart);
        }

        return back()->with('ok', 'Cantidad actualizada.');
    }

    public function remove(Producto $producto)
    {
        $cart = $this->getCart();
        unset($cart[$producto->id]);
        $this->putCart($cart);

        return back()->with('ok', 'Producto quitado del cotizador.');
    }

    public function submit(Request $request)
    {
        $cart = $this->getCart();

        $request->validate([
            'nombre' => 'required|string|max:120',
            'email' => 'nullable|email|max:120',
            'telefono' => 'nullable|string|max:40',
            'comentarios' => 'nullable|string|max:1000',
        ]);

        if (! $request->filled('email') && ! $request->filled('telefono')) {
            throw ValidationException::withMessages([
                'email' => 'Indica un email o un teléfono para contactarte.',
            ]);
        }

        if (empty($cart)) {
            return back()->with('err', 'Tu cotizador está vacío.');
        }

        $nombre = $request->input('nombre');
        $email = $request->input('email');
        $tel = $request->input('telefono');
        $com = $request->input('comentarios');

        $lineas = [];
        $lineas[] = 'Nueva solicitud de cotización (JM Plásticos y Envases)';
        $lineas[] = '---------------------------------------------';
        foreach ($cart as $i) {
            $packs = $i['cantidad'];
            $ppack = $i['piezas_empaque'];
            $lineas[] = "{$i['nombre']} | {$i['capacidad_ml']} ml | Rosca {$i['rosca']} | {$ppack} pzas/pack x {$packs} pack(s) = ".($ppack * $packs).' pzas';
        }
        $total = collect($cart)->sum(fn ($i) => $i['cantidad'] * $i['piezas_empaque']);
        $lineas[] = '---------------------------------------------';
        $lineas[] = "Total de piezas: {$total}";
        $lineas[] = "Cliente: {$nombre}";
        if ($tel) {
            $lineas[] = "Tel: {$tel}";
        }
        if ($email) {
            $lineas[] = "Email: {$email}";
        }
        if ($com) {
            $lineas[] = "Comentarios: {$com}";
        }

        $mensaje = implode("\n", $lineas);
        $to = env('COTIZACIONES_EMAIL') ?: config('contact.email');

        $mailOk = false;
        if ($to) {
            try {
                Mail::raw($mensaje, function ($m) use ($to) {
                    $m->to($to)->subject('Cotización - JM Plásticos y Envases');
                });
                $mailOk = true;
            } catch (\Throwable $e) {
                $mailOk = false;
                Log::warning('No se pudo enviar la cotización por correo: '.$e->getMessage());
            }
        }

        $this->putCart([]);

        $msg = $mailOk
            ? 'Cotización enviada. Te contactamos pronto. También puedes reenviar el detalle por WhatsApp si lo necesitas.'
            : 'Recibimos tu solicitud. Si el correo no llegó, reenvíala por WhatsApp con el botón verde.';

        return redirect()->route('cotizacion.cart')->with('ok', $msg);
    }
}
