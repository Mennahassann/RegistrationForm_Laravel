<?php

namespace Tests\Feature;

use Tests\TestCase;

class LocalizationTest extends TestCase
{
    public function test_switch_to_arabic_language()
    {
        $response = $this->get('/lang/ar');

        $response->assertRedirect();
        $this->assertEquals('ar', session('locale'));
    }

    public function test_switch_with_invalid_locale_fails()
    {
        $response = $this->get('/lang/fr');

        $response->assertStatus(400); // abort(400) as in your routes
    }
}
