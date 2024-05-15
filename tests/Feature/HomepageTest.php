<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomepageTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_homepage_generate_fixture()
    {
        $response = $this->post('/generate-simulation');

        $response->assertRedirectContains('/fixtures');
    }
}
