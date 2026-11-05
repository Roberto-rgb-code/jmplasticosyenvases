@props([
    'name',
    'size' => '22',
    'color' => '0f766e',
])
@php
    if (is_numeric($size)) {
        $px = (int) $size;
    } elseif (preg_match('/^([\d.]+)em$/', (string) $size, $m)) {
        $px = (int) round(((float) $m[1]) * 18);
    } else {
        $px = 22;
    }
    $hex = ltrim((string) $color, '#');
@endphp
<img
    src="https://api.iconify.design/line-md/{{ $name }}.svg?color=%23{{ $hex }}&height={{ $px }}"
    alt=""
    width="{{ $px }}"
    height="{{ $px }}"
    {{ $attributes->class('jm-icon') }}
>
