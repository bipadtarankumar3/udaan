<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions list
        $permissions = [
            'manage-roles' => 'Manage system roles & assign permissions',
            'manage-users' => 'Manage staff & telecaller accounts',
            'manage-students' => 'View, create, edit, and delete all student leads',
            'bulk-upload-students' => 'Upload student leads in bulk via CSV',
            'assign-students' => 'Assign and reassign student leads to telecallers',
            'view-all-remarks' => 'View telecaller call logs, performance & remarks',
            'telecaller-access' => 'Access Telecaller portal & assigned leads',
            'log-remarks' => 'Log call status, remarks, and schedule follow-ups',
        ];

        foreach ($permissions as $name => $description) {
            Permission::firstOrCreate(['name' => $name], ['guard_name' => 'web']);
        }

        // 1. Admin Role (All Access / All Permissions)
        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions(Permission::all());

        // 2. Telecaller Role (telecaller-access and log-remarks)
        $telecallerRole = Role::firstOrCreate(['name' => 'Telecaller', 'guard_name' => 'web']);
        $telecallerRole->syncPermissions([
            'telecaller-access',
            'log-remarks',
        ]);

        // Clean up & migrate any users with Super Admin to Admin
        $superAdminRole = Role::where('name', 'Super Admin')->first();
        if ($superAdminRole) {
            foreach ($superAdminRole->users as $u) {
                $u->assignRole('Admin');
                $u->removeRole('Super Admin');
            }
            $superAdminRole->delete();
        }
    }
}
