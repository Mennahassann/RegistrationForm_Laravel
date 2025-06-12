<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Mockery;
use App\Services\WhatsAppValidator;
use App\Mail\NewUserRegistered;
use Illuminate\Support\Facades\Mail;

class UserEmailTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_registration_sends_email()
    {
        Mail::fake();

        // Mock WhatsApp as valid
        Mockery::mock('alias:' . WhatsAppValidator::class)
            ->shouldReceive('validate')
            ->andReturn(['status' => 'valid']);

        $response = $this->post('/register', [
            'name' => 'Email Test',
            'username' => 'emailuser',
            'email' => 'emailtest@example.com',
            'password' => 'StrongPass1#',
            'password_confirmation' => 'StrongPass1#',
            'phone' => '0123456789',
            'address' => 'Test Address',
            'whatsapp_number' => '+201234567890',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'email' => 'emailtest@example.com',
        ]);

        Mail::assertSent(NewUserRegistered::class, function ($mail) {
            return $mail->hasTo('rawanalnagary@gmail.com');
        });
    }
}