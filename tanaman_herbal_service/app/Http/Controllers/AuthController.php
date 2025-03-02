<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|min:6',
        ]);

        if (! Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user   = Auth::user();
        $userId = $user->id;

        $cacheKey = "user_roles_{$userId}";

        $roles = Cache::remember($cacheKey, 3600, function () use ($user) {
            return $user->roles->pluck('name');
        });

        $allowedRoles = ['admin', 'koordinator', 'agronom'];
        if (! $roles->intersect($allowedRoles)->count()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $roleTokenName = strtoupper($user->roles->first()->name) . "_TOKEN";
        $token         = $user->createToken($roleTokenName)->plainTextToken;

        $user->remember_token = $token;
        $user->save();

        $user->tokens()->latest()->first()->update([
            'expires_at' => Carbon::now()->addHours(1),
        ]);

        return response()->json([
            'token'   => $token,
            'role'    => $user->roles->pluck('name'),
            'user'    => new UserResource($user),
            'message' => 'Login Successfully',
        ]);
    }

    public function Profile(Request $request)
    {
        $user = $request->user();

        return new UserResource($user);
    }

    public function logout(Request $request)
    {
        $user   = $request->user();
        $userId = $user->id;

        $cacheKey = "user_roles_{$userId}";
        Cache::forget($cacheKey);

        // $user->tokens()->delete();
        $request->user()->currentAccessToken()->delete();

        $user->remember_token = null;
        $user->save();
        return response()->json([
            "message" => "Logged out successfully",
        ]);
    }
}
