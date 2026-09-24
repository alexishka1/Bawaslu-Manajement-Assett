<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Database\Seeders\DemoItemSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QrCodePrintSheetTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_qr_code_print_sheet(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'is_verified' => true,
        ]);

        $this->seed(DemoItemSeeder::class);

        $response = $this->actingAs($admin)->get(route('qrcode.print-sheet'));

        $response->assertOk();
        $response->assertViewIs('qrcode.print-sheet');
        $response->assertSee('BMN-2026-001');
        $response->assertSee('Laptop Lenovo ThinkPad E14');
        $response->assertSee('BMN-2026-012');
        $response->assertSee('Whiteboard Magnetic');
    }

    public function test_staff_cannot_access_qr_code_print_sheet(): void
    {
        $staff = User::factory()->create([
            'role' => 'staff',
            'is_verified' => true,
        ]);

        $response = $this->actingAs($staff)->get(route('qrcode.print-sheet'));
        $response->assertRedirect(route('scan.index'));
        $response->assertSessionHas('warning');
    }

    public function test_guest_redirected_to_login_from_print_sheet(): void
    {
        $response = $this->get(route('qrcode.print-sheet'));
        $response->assertRedirect(route('login'));
    }
}

