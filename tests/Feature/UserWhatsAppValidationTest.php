<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Mockery;
use App\Services\WhatsAppValidator;

class UserWhatsAppValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_fails_with_invalid_whatsapp_number()
    {
        // Mock the WhatsAppValidator to return an invalid status
        Mockery::mock('alias:' . WhatsAppValidator::class)
            ->shouldReceive('validate')
            ->andReturn(['status' => 'invalid']);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'StrongPass1#',
            'password_confirmation' => 'StrongPass1#',
            'phone' => '0123456789',
            'address' => 'Some address',
            'whatsapp_number' => '+201234567890',
        ]);

        $response->assertInvalid(['whatsapp_number']);
    }
}
