<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Services\WhatsAppValidator;
use Mockery;



class UserRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_registration_with_profile_image()
    {
        Storage::fake('public');

        Mockery::mock('alias:' . WhatsAppValidator::class)
            ->shouldReceive('validate')
            ->andReturn(['status' => 'valid']);

        $file = UploadedFile::fake()->image('profile.jpg');

        $response = $this->post('/register', [
            'name' => 'New User',
            'username' => 'newuser',
            'email' => 'newuser@gmail.com',
            'password' => 'Pass12//',
            'password_confirmation' => 'Pass12//',
            'phone' => '0123456789',
            'whatsapp_number' => '+201100654128',
            'address' => 'Test Address',
            'user_image' => $file, 
        ]);
        

        $response->assertRedirect();

        $response->assertSessionHas('success', 'User registered successfully.');

        $this->assertDatabaseHas('users', [
            'email' => 'newuser@gmail.com',
        ]);
    }
}
