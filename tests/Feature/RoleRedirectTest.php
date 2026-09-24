<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleRedirectTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_redirected_to_admin_panel_after_login(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'password' => 'password',
        ]);

        $response = $this->post('/login', [
            'email' => $admin->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin');
    }

    public function test_staff_redirected_to_scan_after_login(): void
    {
        $staff = User::factory()->create([
            'role' => 'staff',
            'password' => 'password',
        ]);

        $response = $this->post('/login', [
            'email' => $staff->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('scan.index'));
    }

    public function test_staff_cannot_access_admin_panel_and_redirected_with_warning(): void
    {
        $staff = User::factory()->create([
            'role' => 'staff',
        ]);

        $response = $this->actingAs($staff)->get('/admin');

        $response->assertRedirect(route('scan.index'));
        $response->assertSessionHas('warning');
    }

    public function test_guest_redirected_to_login_when_accessing_scan(): void
    {
        $response = $this->get(route('scan.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_staff_intended_url_honored_if_role_matches(): void
    {
        $staff = User::factory()->create([
            'role' => 'staff',
            'password' => 'password',
        ]);

        // Simulasikan session intended URL ke /scan
        $response = $this->withSession(['url.intended' => route('scan.index')])
            ->post('/login', [
                'email' => $staff->email,
                'password' => 'password',
            ]);

        $response->assertRedirect(route('scan.index'));
    }

    public function test_staff_intended_admin_url_rejected_and_redirected_to_scan(): void
    {
        $staff = User::factory()->create([
            'role' => 'staff',
            'password' => 'password',
        ]);

        // Simulasikan session intended URL ke /admin/items
        $response = $this->withSession(['url.intended' => '/admin/items'])
            ->post('/login', [
                'email' => $staff->email,
                'password' => 'password',
            ]);

        // Tidak boleh diarahkan ke /admin/items, melainkan ke /scan
        $response->assertRedirect(route('scan.index'));
    }

    public function test_home_page_redirects_authenticated_users_to_home_url(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $staff = User::factory()->create(['role' => 'staff']);

        // Admin buka / -> redirect ke /admin
        $this->actingAs($admin)->get('/')->assertRedirect('/admin');

        // Staff buka / -> redirect ke /scan
        $this->actingAs($staff)->get('/')->assertRedirect(route('scan.index'));

        // Guest buka / -> HTTP 200 (landing page)
        auth()->logout();
        $this->get('/')->assertOk();
    }

    public function test_admin_only_route_redirects_staff_to_home_url(): void
    {
        $staff = User::factory()->create(['role' => 'staff']);
        $item = Item::factory()->create();

        // Staff mencoba unduh QR (admin-only)
        $response = $this->actingAs($staff)->get(route('qrcode.download', $item));

        $response->assertRedirect(route('scan.index'));
        $response->assertSessionHas('warning');
    }
}
