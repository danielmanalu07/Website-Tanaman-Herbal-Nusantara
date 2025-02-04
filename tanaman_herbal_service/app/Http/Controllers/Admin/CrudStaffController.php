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
        $staffRole = Role::where('name', 'staff')->first();

        if (! $staffRole) {
            return response()->json([
                "message"     => "Role 'staff' not found",
                "status_code" => 404,
            ], 404);
        }

        $staff = User::whereHas('roles', function ($query) {
            $query->where('name', 'staff');
        })->get();

        return response()->json([
            "status_code" => 200,
            "message"     => "Get data staff succefully",
            "data"        => UserResource::collection($staff),
        ], 200);
    }

    public function CreateStaff(Request $request)
    {
        $staffRole = Role::where('name', 'staff')->first();
        if (! $staffRole) {
            return response()->json([
                "message"     => "Role 'staff' not found",
                "status_code" => 404,
            ], 404);
        }

        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|min:6',
        ]);

        $admin = Auth::user();

        $staff = User::create([
            'username'   => $credentials['username'],
            'password'   => bcrypt($credentials['password']),
            'active'     => false,
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);

        $staff->assignRole('staff');

        return response()->json([
            "status_code" => 201,
            "message"     => "Staff created successfully",
            "data"        => new UserResource($staff),
        ], 201);
    }

    public function getDetailStaff($id)
    {
        $staff = User::whereHas('roles', function ($query) {
            $query->where('name', 'staff');
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
            "message"     => "Get detail staff succefully",
            "data"        => new UserResource($staff),
        ]);
    }

    public function updateStaff(Request $request, $id)
    {
        $validate = $request->validate([
            'username' => 'required|string',
            'password' => 'required|min:6',
        ]);

        $staff = User::whereHas('roles', function ($query) {
            $query->where('name', 'staff');
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
            'password'   => $validate['password'],
            'updated_by' => $admin->id,
        ]);

        return response()->json([
            "status_code" => 200,
            "message"     => "Update staff succefully",
            "data"        => new UserResource($staff),
        ], 200);
    }

    public function deleteStaff($id)
    {
        $staff = User::whereHas('roles', function ($query) {
            $query->where('name', 'staff');
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
