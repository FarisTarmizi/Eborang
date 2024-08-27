<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $itLeader = Role::updateOrCreate(['name' => 'KB_BTM']);
        $itStaff = Role::updateOrCreate(['name' => 'STAFF_BTM']);
        $otherUnitsLeader = Role::updateOrCreate(['name' => 'KB']);
        $otherUnitsStaff = Role::updateOrCreate(['name' => 'PEMOHON']);

        $verifyApplication = Permission::updateOrCreate(['name' => 'verify application']);
        $manageApplication = Permission::updateOrCreate(['name' => 'manage application']);
        $applicant = Permission::updateOrCreate(['name' => 'applicant']);

        $itLeader->givePermissionTo($verifyApplication);
        $otherUnitsLeader->givePermissionTo($verifyApplication);
        $itStaff->givePermissionTo($manageApplication);
        $otherUnitsStaff->givePermissionTo($applicant);

        $staff = User::find(3);
        $staff->assignRole('STAFF_BTM');
        $kb = User::find(4);
        $kb->assignRole('KB_BTM');
    }
}
