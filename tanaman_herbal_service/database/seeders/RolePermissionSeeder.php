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
        $roles = ['admin', 'koordinator', 'agronom'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
        $admin_permissions = ['login', 'get profile', 'logout', 'CRUD Staff'];

        foreach ($admin_permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
        Role::where('name', 'admin')->first()?->syncPermissions($admin_permissions);
    }
}
