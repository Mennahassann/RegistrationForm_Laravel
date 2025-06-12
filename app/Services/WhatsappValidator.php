<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsAppValidator
{
    public static function validate($number)
    {
        $response = Http::withHeaders
        ([
            'Content-Type' => 'application/json',
            'x-rapidapi-host' => 'whatsapp-number-validator3.p.rapidapi.com',
            'x-rapidapi-key' => '01b18ebf75msh70a234cf11018e9p14dafejsnf14004f19b43',
        ])
        ->post('https://whatsapp-number-validator3.p.rapidapi.com/WhatsappNumberHasItWithToken', ['phone_number' => $number]);

        return $response->successful()? $response->json() : null;
    }
}