<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class CarritoController extends Controller
{
    private function getCarrito(Request $request): array
    {
        return $request->session()->get('carrito', []);
    }

    private function saveCarrito(Request $request, array $carrito): void
    {
        $request->session()->put('carrito', $carrito);
    }

    public function agregar(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad'    => 'required|integer|min:1',
        ]);

        $producto = Producto::findOrFail($request->producto_id);
        $carrito  = $this->getCarrito($request);

        if (isset($carrito[$producto->id])) {
            $carrito[$producto->id]['cantidad'] += (int)$request->cantidad;
        } else {
            $carrito[$producto->id] = [
                'id'              => $producto->id,
                'nombre'          => $producto->nombre,
                'imagen'          => $producto->imagen,
                'piezas_empaque'  => $producto->piezas_empaque,
                'capacidad_ml'    => $producto->capacidad_ml,
                'rosca'           => $producto->rosca,
                'cantidad'        => (int)$request->cantidad,
            ];
        }
        $this->saveCarrito($request, $carrito);

        return redirect()->route('carrito.index')->with('ok','Producto agregado al cotizador.');
    }

    public function index(Request $request)
    {
        $carrito = $this->getCarrito($request);
        return view('carrito.index', compact('carrito'));
    }

    public function actualizar(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|integer',
            'cantidad'    => 'required|integer|min:1',
        ]);

        $carrito = $this->getCarrito($request);
        if (isset($carrito[$request->producto_id])) {
            $carrito[$request->producto_id]['cantidad'] = (int)$request->cantidad;
            $this->saveCarrito($request, $carrito);
        }

        return back()->with('ok','Cantidad actualizada.');
    }

    public function eliminar(Request $request)
    {
        $request->validate(['producto_id' => 'required|integer']);
        $carrito = $this->getCarrito($request);
        unset($carrito[$request->producto_id]);
        $this->saveCarrito($request, $carrito);
        return back()->with('ok','Producto eliminado.');
    }

    public function solicitar(Request $request)
    {
        $request->validate([
            'nombre'  => 'required|string|min:2',
            'email'   => 'required|email',
            'telefono'=> 'required|string|min:8',
            'comentarios' => 'nullable|string',
        ]);

        $carrito = $this->getCarrito($request);
        if (empty($carrito)) {
            return back()->with('err','Tu cotizador está vacío.');
        }

        // Construir mensaje para WhatsApp
        $lineas = [];
        $totalPiezas = 0;

        foreach ($carrito as $item) {
            $pzs = $item['cantidad'] * $item['piezas_empaque'];
            $totalPiezas += $pzs;
            $lineas[] = "• {$item['nombre']} ({$item['capacidad_ml']} ml, {$item['rosca']})  "
                      . "Cajas: {$item['cantidad']}  Pzs/caja: {$item['piezas_empaque']}  Total: {$pzs}";
        }

        $mensaje  = "Hola, quiero una cotización:\n";
        $mensaje .= implode("\n", $lineas);
        $mensaje .= "\n\nTotal de piezas: {$totalPiezas}\n";
        $mensaje .= "Nombre: {$request->nombre}\nEmail: {$request->email}\nTel: {$request->telefono}\n";
        if ($request->filled('comentarios')) $mensaje .= "Comentarios: {$request->comentarios}\n";

        // Número de WhatsApp destino (cámbialo)
        $whats = '5213312345678';
        $url = "https://wa.me/{$whats}?text=".rawurlencode($mensaje);

        // Limpia carrito (opcional)
        $request->session()->forget('carrito');

        return redirect($url);
    }
}
