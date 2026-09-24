<?php

namespace Tests\Feature;

use App\Models\User;
use Filament\Notifications\Models\DatabaseNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StaffRegistrationAndVerificationTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create([
            'email' => 'admin.test@bawaslu.go.id',
        ]);
    }

    public function test_guest_can_view_staff_registration_page(): void
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
        $response->assertSee('Pendaftaran Akun Pegawai');
        $response->assertSee('Bawaslu Management Asset');
    }

    public function test_staff_can_register_and_defaults_to_unverified(): void
    {
        $payload = [
            'name' => 'Fauzi Rahman',
            'nip' => '199505052020011001',
            'jabatan' => 'Staf Pengawasan Pemilu',
            'unit_kerja' => 'Divisi Hukum dan Sengketa',
            'email' => 'fauzi.rahman@bawaslu.go.id',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post(route('register.post'), $payload);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'email' => 'fauzi.rahman@bawaslu.go.id',
            'role' => 'staff',
            'is_verified' => false,
            'jabatan' => 'Staf Pengawasan Pemilu',
        ]);
    }

    public function test_unverified_staff_cannot_login_and_sees_notice(): void
    {
        $unverifiedStaff = User::factory()->unverifiedStaff()->create([
            'email' => 'unverified@bawaslu.go.id',
            'password' => bcrypt('secret123'),
        ]);

        $response = $this->post(route('login.post'), [
            'email' => 'unverified@bawaslu.go.id',
            'password' => 'secret123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors(['email']);
    }

    public function test_verified_staff_can_login_successfully(): void
    {
        $verifiedStaff = User::factory()->staff()->create([
            'email' => 'verified@bawaslu.go.id',
            'password' => bcrypt('secret123'),
            'is_verified' => true,
        ]);

        $response = $this->post(route('login.post'), [
            'email' => 'verified@bawaslu.go.id',
            'password' => 'secret123',
        ]);

        $this->assertAuthenticatedAs($verifiedStaff);
        $response->assertRedirect(route('scan.index'));
    }

    public function test_admin_can_verify_staff_account(): void
    {
        $staff = User::factory()->unverifiedStaff()->create();
        $this->assertFalse($staff->is_verified);

        $staff->update([
            'is_verified' => true,
            'verified_at' => now(),
            'verified_by' => $this->admin->id,
        ]);

        $this->assertTrue($staff->fresh()->is_verified);
        $this->assertEquals($this->admin->id, $staff->fresh()->verified_by);
    }
}
