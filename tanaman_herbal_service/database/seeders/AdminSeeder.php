<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();

        if (! $adminRole) {
            $this->command->error("Role 'admin' belum dibuat. Jalankan RolePermissionSeeder terlebih dahulu.");
            return;
        }

        $admin = User::firstOrCreate([
            'username' => 'admin',
        ], [
            'password' => bcrypt('admin12345'),
            'active'   => true,
        ]);

        if (! $admin->hasRole('admin')) {
            $admin->assignRole($adminRole);
        }
    }
}
