<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

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
        $cantidad = max(1, (int) $request->input('cantidad', 1)); // paquetes
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
                'cantidad' => $cantidad, // paquetes
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
            ->filter(fn ($item) => Producto::whereKey($item['id'] ?? 0)->exists())
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
        return back();
    }

    public function remove(Producto $producto)
    {
        $cart = $this->getCart();
        unset($cart[$producto->id]);
        $this->putCart($cart);
        return back();
    }

    public function submit(Request $request)
    {
        $cart = $this->getCart();

        $request->validate([
            'nombre'       => 'required|string|max:120',
            'email'        => 'nullable|email',
            'telefono'     => 'nullable|string|max:40',
            'comentarios'  => 'nullable|string|max:1000',
        ]);

        if (empty($cart)) {
            return back()->with('err', 'Tu cotizador está vacío.');
        }

        $nombre = $request->input('nombre');
        $email  = $request->input('email');
        $tel    = $request->input('telefono');
        $com    = $request->input('comentarios');

        $lineas   = [];
        $lineas[] = "Nueva solicitud de cotización (JM Plásticos y Envases)";
        $lineas[] = "---------------------------------------------";
        foreach ($cart as $i) {
            $packs = $i['cantidad'];
            $ppack = $i['piezas_empaque'];
            $lineas[] = "{$i['nombre']} | {$i['capacidad_ml']} ml | Rosca {$i['rosca']} | {$ppack} pzas/pack x {$packs} pack(s) = " . ($ppack * $packs) . " pzas";
        }
        $total = collect($cart)->sum(fn ($i) => $i['cantidad'] * $i['piezas_empaque']);
        $lineas[] = "---------------------------------------------";
        $lineas[] = "Total de piezas: {$total}";
        $lineas[] = "Cliente: {$nombre}";
        if ($tel)   { $lineas[] = "Tel: {$tel}"; }
        if ($email) { $lineas[] = "Email: {$email}"; }
        if ($com)   { $lineas[] = "Comentarios: {$com}"; }

        $mensaje = implode("\n", $lineas);

        // Destinatario: .env COTIZACIONES_EMAIL o, si no existe, config('contact.email')
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
                Log::warning('No se pudo enviar la cotización por correo: ' . $e->getMessage());
            }
        }

        $msg = $mailOk
            ? '✔️ Cotización enviada por correo con éxito. También puedes mandarla por WhatsApp con el botón verde.'
            : '✔️ Recibimos tu solicitud. Si el correo no se envió, puedes mandarla por WhatsApp con el botón verde.';

        return back()->with('ok', $msg);
    }
}
