<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class CrudStaffController extends Controller
{
    public function getAllStaff()
    {
        $roles = ['koordinator', 'agronom'];

        $staff = User::whereHas('roles', function ($query) use ($roles) {
            $query->whereIn('name', $roles);
        })->get();
        // $staffRole = Role::where('name', 'koordinator')->first();

        // if (! $staffRole) {
        //     return response()->json([
        //         "message"     => "Role 'koordinator' not found",
        //         "status_code" => 404,
        //     ], 404);
        // }

        // $staff = User::whereHas('roles', function ($query) {
        //     $query->where('name', 'koordinator');
        // })->get();

        return response()->json([
            "status_code" => 200,
            "message"     => "Get data staff succefully",
            "data"        => UserResource::collection($staff),
        ], 200);
    }

    public function CreateStaff(Request $request)
    {

        $credentials = $request->validate([
            'username' => 'required|string|unique:users,username',
            'password' => 'required|min:6',
            'role'     => 'required|in:koordinator,agronom',
        ]);

        $staffRole = Role::where('name', $credentials['role'])->first();
        if (! $staffRole) {
            return response()->json([
                "message"     => "Role not found",
                "status_code" => 404,
            ], 404);
        }

        $admin = Auth::user();

        $staff = User::create([
            'username'   => $credentials['username'],
            'password'   => bcrypt($credentials['password']),
            'active'     => false,
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);

        $staff->assignRole($credentials['role']);

        return response()->json([
            "status_code" => 201,
            "message"     => "Staff created successfully",
            "data"        => new UserResource($staff),
        ], 201);
    }

    public function getDetailStaff($id)
    {
        $roles = ['koordinator', 'agronom'];

        $staff = User::whereHas('roles', function ($query) use ($roles) {
            $query->whereIn('name', $roles);
        })->find($id);

        if (! $staff) {
            return response()->json([
                "status_code" => 404,
                "message"     => "Data Staff Not Found",
                "data"        => null,
            ], 404);
        }

        return response()->json([
            "status_code" => 200,
            "message"     => "Get detail staff successfully",
            "data"        => new UserResource($staff),
        ], 200);
    }

    public function updateStaff(Request $request, $id)
    {
        $validate = $request->validate([
            'username' => 'required|string|unique:users,username,' . $id,
            'password' => 'required|min:6',
            'role'     => 'required|in:koordinator,agronom',
        ]);

        $roles = ['koordinator', 'agronom'];

        $staff = User::whereHas('roles', function ($query) use ($roles) {
            $query->whereIn('name', $roles);
        })->find($id);

        if (! $staff) {
            return response()->json([
                "status_code" => 404,
                "message"     => "Data Staff Not Found",
                "data"        => null,
            ], 404);
        }

        $admin = Auth::user();

        $staff->update([
            'username'   => $validate['username'],
            'password'   => bcrypt($validate['password']),
            'updated_by' => $admin->id,
        ]);

        $newRole = Role::where('name', $validate['role'])->first();
        if ($newRole) {
            $staff->syncRoles([$validate['role']]);
        }

        return response()->json([
            "status_code" => 200,
            "message"     => "Update staff successfully",
            "data"        => new UserResource($staff),
        ], 200);
    }

    public function deleteStaff($id)
    {
        $roles = ['koordinator', 'agronom'];

        $staff = User::whereHas('roles', function ($query) use ($roles) {
            $query->whereIn('name', $roles);
        })->find($id);

        if (! $staff) {
            return response()->json([
                "status_code" => 404,
                "message"     => "Data Staff Not Found",
                "data"        => null,
            ], 404);
        }

        $staff->delete();

        return response()->json([
            'status_code' => 200,
            'message'     => 'Delete staff successfully',
        ], 200);
    }
}
