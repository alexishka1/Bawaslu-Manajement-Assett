<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class AdminPanelAccessTest extends TestCase
{
    public function test_guest_is_redirected_to_filament_login(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/admin/login');
    }

    public function test_admin_can_access_filament_dashboard(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);
    }

    public function test_staff_cannot_access_filament_dashboard(): void
    {
        $staff = User::factory()->staff()->create();

        $response = $this->actingAs($staff)->get('/admin');
        $response->assertRedirect(route('scan.index'));
        $response->assertSessionHas('warning');
    }

    public function test_admin_cannot_delete_their_own_account(): void
    {
        $admin = User::factory()->admin()->create();
        $otherAdmin = User::factory()->admin()->create();

        // Admin cannot delete self
        $this->assertFalse(Gate::forUser($admin)->allows('delete', $admin));

        // Admin CAN delete another user
        $this->assertTrue(Gate::forUser($admin)->allows('delete', $otherAdmin));
    }
}
