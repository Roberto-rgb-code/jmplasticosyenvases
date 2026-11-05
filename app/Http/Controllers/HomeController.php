<?php

namespace App\Http\Controllers;

use App\Models\Producto;

class HomeController extends Controller
{
    public function index()
    {
        $destacados = Producto::query()
            ->orderByDesc('capacidad_ml')
            ->orderBy('nombre')
            ->get();

        return view('home', compact('destacados'));
    }
}
