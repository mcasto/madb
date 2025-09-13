<?php

namespace App\Services;

class GeocodingService
{
    private static function buildUrl($address)
    {
        $key = config('services.google.geocoding.api_key');
        $urlTemplate = config('services.google.geocoding.url_template');

        $url = str_replace("{key}", $key, $urlTemplate);
        return str_replace("{address}", urlencode($address), $url);
    }

    public static function getLatLong($address)
    {
        $url = self::buildUrl($address);
        $response = file_get_contents($url);

        $data = json_decode($response, true);

        if ($data['status'] != 'OK') {
            return ['success' => false];
        }

        return ['success' => true, 'location' => $data['results'][0]['geometry']['location']];
    }
}
