<?php

namespace MichaelLindahl\H3;

use FFI;

trait GridTraversalTrait
{
  public function kRing(string $h3Index, int $k): array
  {
    $ffi = FFI::cdef(
      self::H3IndexTypeDef.self::LatLngTypeDef.
      'void kRing(H3Index origin, int k, H3Index out[]);',
      $this->lib
    );
    
    $dec = hexdec($h3Index);
    
    $h3SetDef = FFI::type("uint64_t[7]");
    $h3Set = $ffi->new($h3SetDef, false, true);
    $ffi->kRing($dec, $k, $h3Set);
    
    $out = [];
    foreach($h3Set as $h3dec) {
      $out[] = dechex($h3dec);
    }
    return $out;
  }
}
