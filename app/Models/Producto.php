<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'capacidad_ml', 'rosca', 'piezas_empaque', 'imagen',
    ];

    public function getImagenUrlAttribute(): string
    {
        return asset('images/'.rawurlencode((string) $this->imagen));
    }

    public static function imageUrl(?string $filename): string
    {
        return asset('images/'.rawurlencode((string) $filename));
    }
}
