<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Mockery;
use App\Services\WhatsAppValidator;


class UserPasswordValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_fails_with_weak_password()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'username' => 'testuser1',
            'email' => 'test1@example.com',
            'password' => 'weakpass', // No uppercase, no number
            'password_confirmation' => 'weakpass',
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    public function test_registration_fails_when_passwords_do_not_match()
    {
        Mockery::mock('alias:' . WhatsAppValidator::class)
            ->shouldReceive('validate')
            ->andReturn(['status' => 'valid']);
            
        $response = $this->post('/register', [
            'name' => 'Test User',
            'username' => 'testuser2',
            'email' => 'test2@example.com',
            'password' => 'Pass1234',
            'password_confirmation' => 'WrongConfirm',
            'phone' => '0123456789',
            'address' => 'Test Address',
            'user_image' => null,
            'whatsapp_number' => '+201234567890',
        ]);

        $response->assertSessionHasErrors(['password']);
    }


    public function test_registration_passes_with_strong_password()
    {
        Mockery::mock('alias:' . WhatsAppValidator::class)
            ->shouldReceive('validate')
            ->andReturn(['status' => 'valid']);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'username' => 'testuser3',
            'email' => 'test3@example.com',
            'password' => 'StrongPass1#',
            'password_confirmation' => 'StrongPass1#',
            'phone' => '0123456789',
            'address' => 'Test Address',
            'user_image' => null, 
            'whatsapp_number' => '+201234567890',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'email' => 'test3@example.com',
        ]);
    }
}
