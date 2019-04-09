<?php

namespace Tests\Integration;

use Tests\TestCase;

/**
 * To run just this test: vendor/bin/phpunit --filter DashboardTest
 */
class DashboardTest extends TestCase
{
    public function testLoadDashboardAsGuestThenRedirect()
    {
        $response = $this->get('/');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function testLoadDashboardWithAuthThenSucceed()
    {
        $response = $this->actingAs($this->user)->get('/');
        $response->assertOk();
        $response->assertViewIs('dashboard');
    }
}
