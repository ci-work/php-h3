<?php

namespace MichaelLindahl\H3;

use FFI;

trait GridTraversalTrait
{
  public function kRing(string $h3Index, int $k): array
  {
    $ffi = FFI::cdef(
      self::H3IndexTypeDef.self::LatLngTypeDef.
      'void kRing(H3Index origin, int k, H3Index* out);',
      $this->lib
    );
    
    $dec = hexdec($h3Index);
    
    $h3SetDef = FFI::type("uint64_t");
    $h3Set = $ffi->new($h3SetDef);
    $ffi->kRing($dec, $k, FFI::addr($h3Set));
    
    return (array)$h3Set;
  }
}
