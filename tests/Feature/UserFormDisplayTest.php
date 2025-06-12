<?php

namespace Tests\Feature;

use Tests\TestCase;

class UserFormDisplayTest extends TestCase
{
    public function test_register_form_displays_correctly()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Register'); // Ensure the form contains "Register"
    }
}
