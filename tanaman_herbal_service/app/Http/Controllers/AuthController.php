<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\ForgotPassword;
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

        if (! $user->hasRole('admin') && ! $user->hasRole('staff')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $token = $user->createToken('ADMIN_TOKEN')->plainTextToken;

        $user->remember_token = $token;
        $user->save();

        $user->tokens()->latest()->first()->update([
            'expires_at' => Carbon::now()->addHours(1),
        ]);

        return response()->json([
            'token'   => $token,
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

    public function validationUsername(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
        ]);

        $username = $request->input('username');
        $user     = User::where('username', $username)->first();

        if (! $user) {
            return response()->json([
                'status_code' => 404,
                'message'     => 'Username not found',
            ], 404);
        }

        $password_reset = ForgotPassword::where('username', $username)->first();

        if ($password_reset) {
            $password_reset->update([
                'user_id'             => $user->id,
                'username'            => $user->username,
                'verification_code'   => rand(10000, 99999),
                'verification_status' => false,
                'verification_date'   => now(),
            ]);
        } else {
            $password_reset = ForgotPassword::create([
                'user_id'             => $user->id,
                'username'            => $user->username,
                'verification_code'   => rand(10000, 99999),
                'verification_status' => false,
                'verification_date'   => now(),
            ]);
        }

        $password_reset_data = [
            'user_id'             => $password_reset->user_id,
            'username'            => $password_reset->username,
            'verification_code'   => $password_reset->verification_code,
            'verification_status' => $password_reset->verification_status,
            'verification_date'   => Carbon::parse($password_reset->verification_date)->translatedFormat('d F Y h:i A'),
        ];

        return response()->json([
            'status_code' => 200,
            'message'     => 'Username matched!',
            'data'        => $password_reset_data,
        ], 200);
    }

    public function verificationCode(Request $request)
    {
        $request->validate([
            'verification_code' => 'required|numeric',
        ]);

        $verification_code = $request->input('verification_code');

        $passwordReset = ForgotPassword::where('verification_code', $verification_code)->first();

        if (! $passwordReset) {
            return response()->json([
                'status_code' => 400,
                'message'     => 'invalid verification code',
            ], 400);
        }

        $passwordReset->verification_status = true;

        $passwordReset->save();

        $passwordReset_data = [
            'user_id'             => $passwordReset->user_id,
            'username'            => $passwordReset->username,
            'verification_code'   => $passwordReset->verification_code,
            'verification_status' => $passwordReset->verification_status,
            'verification_date'   => Carbon::parse($passwordReset->verification_date)->translatedFormat('d F Y h:i A'),
        ];

        return response()->json([
            'status_code' => 200,
            'message'     => 'Verification Code Successfully',
            'data'        => $passwordReset_data,
        ], 200);
    }

    public function newPassword(Request $request)
    {

    }
}
