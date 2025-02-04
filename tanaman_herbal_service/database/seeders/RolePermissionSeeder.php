<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['admin', 'staff'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
        $admin_permissions = ['login', 'get profile', 'logout', 'get staffs', 'create staff', 'detail staff', 'update staff', 'delete staff'];

        foreach ($admin_permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
        Role::where('name', 'admin')->first()?->syncPermissions($admin_permissions);
    }
}
