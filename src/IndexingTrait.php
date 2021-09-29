<?php

namespace MichaelLindahl\H3;

use FFI;

trait IndexingTrait
{
    public function geoToH3(float $lat, float $lon, int $res): string
    {

        $ffi = FFI::cdef(
            self::H3IndexTypeDef.self::LatLngTypeDef.
            'H3Index geoToH3(const LatLng *g, int res);',
            $this->lib
        );

        $location = $ffi->new('LatLng');
        $location->lat = deg2rad($lat);
        $location->lon = deg2rad($lon);

        $h3 = $ffi->geoToH3(FFI::addr($location), $res);

        return dechex($h3);
    }

    public function h3ToGeo(string $h3Index): object
    {

        $ffi = FFI::cdef(
            self::H3IndexTypeDef.self::LatLngTypeDef.
            'void h3ToGeo(H3Index h3, LatLng *g);',
            $this->lib
        );

        $dec = hexdec($h3Index);
        $geoCord = $ffi->new('LatLng');
        $ffi->h3ToGeo($dec, FFI::addr($geoCord));

        return (object) [
            'lat' => rad2deg($geoCord->lat),
            'lon' => rad2deg($geoCord->lon),
        ];
    }

}
