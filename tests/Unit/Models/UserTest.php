<?php

namespace Tests\Unit\Models;

use App\Models\ItemReport;
use App\Models\User;
use Filament\Panel;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_user_role_helpers_work_properly(): void
    {
        $admin = User::factory()->admin()->create();
        $staff = User::factory()->staff()->create();

        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($admin->isStaff());

        $this->assertTrue($staff->isStaff());
        $this->assertFalse($staff->isAdmin());
    }

    public function test_admin_can_access_filament_panel_while_staff_cannot(): void
    {
        $admin = User::factory()->admin()->create();
        $staff = User::factory()->staff()->create();

        $panel = new Panel;

        $this->assertTrue($admin->canAccessPanel($panel));
        $this->assertFalse($staff->canAccessPanel($panel));
    }

    public function test_user_has_reports_relationship(): void
    {
        $staff = User::factory()->staff()->create();
        $report = ItemReport::factory()->create([
            'user_id' => $staff->id,
        ]);

        $this->assertTrue($staff->reports->contains($report));
    }
}
