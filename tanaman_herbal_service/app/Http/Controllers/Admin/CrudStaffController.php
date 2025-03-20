<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Response\Response;
use App\Services\Admin\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class CrudStaffController extends Controller
{
    protected $user_service;

    public function __construct(UserService $user_service)
    {
        $this->user_service = $user_service;
    }
    public function getAllStaff()
    {
        $roles = ['koordinator', 'agronom'];

        $staff = User::whereHas('roles', function ($query) use ($roles) {
            $query->whereIn('name', $roles);
        })->get();
        return response()->json([
            "status_code" => 200,
            "message"     => "Get data staff succefully",
            "data"        => UserResource::collection($staff),
        ], 200);
    }

    public function CreateStaff(Request $request)
    {

        $credentials = $request->validate([
            'full_name' => 'required',
            'email'     => 'required|email|unique:users,email',
            'phone'     => 'required|unique:users,phone',
            'username'  => 'required|string|unique:users,username',
            'password'  => 'required|min:6',
            'role'      => 'required|in:koordinator,agronom',
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
            'full_name'  => $credentials['full_name'],
            'email'      => $credentials['email'],
            'phone'      => $credentials['phone'],
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
            'username'  => 'required|string|unique:users,username,' . $id,
            'full_name' => 'required',
            'email'     => 'required|email|unique:users,email',
            'phone'     => 'required|unique:users,phone',
            'password'  => 'required|min:6',
            'role'      => 'required|in:koordinator,agronom',
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
            'full_name'  => $validate['full_name'],
            'email'      => $validate['email'],
            'phone'      => $validate['phone'],
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

    public function update_status(Request $request, int $id)
    {
        $request->validate([
            'active' => 'required|boolean',
        ]);
        try {
            $user = $this->user_service->update_status($id, $request->active);
            if ($user instanceof JsonResponse) {
                return $user;
            }

            return Response::success('Updated Successfully', new UserResource($user), 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }
}
