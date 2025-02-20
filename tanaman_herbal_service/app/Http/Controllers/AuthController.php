<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $user = Auth::user();

        if (! $user->hasRole('admin') && ! $user->hasRole('koordinator') && ! $user->hasRole('agronom')) {
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
        $user = $request->user();

        $user->tokens()->delete();

        $user->remember_token = null;
        $user->save();
        return response()->json([
            "message" => "Logged out successfully",
        ]);
    }
}
