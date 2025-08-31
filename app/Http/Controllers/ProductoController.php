<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index(Request $request)
{
    $q     = $request->input('q', '');
    $rosca = $request->input('rosca', '');
    $min   = $request->input('cap_min', ''); // <- siempre definido
    $max   = $request->input('cap_max', '');
    $sort  = $request->input('sort', '');

    $productos = Producto::query()
        ->when($q, fn($s)=>$s->where('nombre','like',"%$q%"))
        ->when($rosca, fn($s)=>$s->where('rosca',$rosca))
        ->when($min !== '', fn($s)=>$s->where('capacidad_ml','>=',(int)$min))
        ->when($max !== '', fn($s)=>$s->where('capacidad_ml','<=',(int)$max))
        ->when($sort==='cap_asc', fn($s)=>$s->orderBy('capacidad_ml','asc'))
        ->when($sort==='cap_desc', fn($s)=>$s->orderBy('capacidad_ml','desc'))
        ->when($sort==='alpha', fn($s)=>$s->orderBy('nombre'))
        ->get();

    $roscas = Producto::select('rosca')->distinct()->pluck('rosca');

    return view('productos.index', compact('productos','roscas','q','rosca','min','max','sort'));
}


    public function show(Producto $producto)
    {
        return view('productos.show', compact('producto'));
    }
}
