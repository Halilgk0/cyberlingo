@props(['seed' => 'cyberlingo'])

@php
    $size = 21;

    /*
     * Looks like a QR code but encodes nothing: three finder squares in the corners,
     * the rest filled from a hash of the seed so it is the same on every render.
     */
    $isDark = function (int $x, int $y) use ($size, $seed): bool {
        $finderX = $x < 8 ? $x : ($x >= $size - 8 ? $x - ($size - 7) : null);
        $finderY = $y < 8 ? $y : ($y >= $size - 8 ? $y - ($size - 7) : null);
        $isFinderArea = $finderX !== null && $finderY !== null && ! ($x >= $size - 8 && $y >= $size - 8);

        if ($isFinderArea) {
            if ($finderX < 0 || $finderX > 6 || $finderY < 0 || $finderY > 6) {
                return false;
            }

            return max(abs($finderX - 3), abs($finderY - 3)) !== 2;
        }

        return crc32("{$seed}:{$x}:{$y}") % 2 === 0;
    };
@endphp

<svg {{ $attributes }} viewBox="-2 -2 25 25" shape-rendering="crispEdges" aria-hidden="true">
    <rect x="-2" y="-2" width="25" height="25" fill="#ffffff" />
    @for ($y = 0; $y < $size; $y++)
        @for ($x = 0; $x < $size; $x++)
            @if ($isDark($x, $y))
                <rect x="{{ $x }}" y="{{ $y }}" width="1" height="1" fill="#10203a" />
            @endif
        @endfor
    @endfor
</svg>
