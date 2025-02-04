<?php
namespace App\Http\Controllers;

abstract class Controller
{
    // public function __construct()
    // {
    //     $this->addPermissions();
    // }

    // protected function addPermissions()
    // {
    //     $admin_permissions = ['login', 'get profile', 'logout', 'get staffs', 'create staff', 'detail staff', 'update staff', 'delete staff'];

    //     foreach ($admin_permissions as $permission) {
    //         Permission::firstOrCreate(['name' => $permission]);
    //     }
    //     Role::where('name', 'admin')->first()?->syncPermissions($admin_permissions);
    // }
}
