<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_admin_audit_trail_page_is_accessible_for_authenticated_user(): void
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/audit-trail');

        $response->assertStatus(200);
        $response->assertSee('Audit Trail');
    }

    public function test_admin_pemberdayaan_page_is_accessible_for_authenticated_user(): void
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/pemberdayaan');

        $response->assertStatus(200);
        $response->assertSee('Penyelenggara');
    }
}
