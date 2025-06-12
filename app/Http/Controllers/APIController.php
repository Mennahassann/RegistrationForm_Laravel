<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\WhatsAppValidator;
use Illuminate\Http\Request;

class APIController extends Controller
{
    public function validateWhatsappNumber(Request $request)
    {
        $number = $request->input('whatsapp_number');
        $result = WhatsAppValidator::validate($number);

        return response()->json(['success' => isset($result['status']) && $result['status'] === 'valid']);
    }
}