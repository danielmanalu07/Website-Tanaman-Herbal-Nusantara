<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Service\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    private $auth_service;

    public function __construct(AuthService $authService)
    {
        $this->auth_service = $authService;
    }
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'username' => 'required|string|exists:users',
                'password' => 'required',
            ]);

            try {
                $data = $this->auth_service->login($request->username, $request->password);
                return redirect()->route('admin.dashboard')->with('success', $data['message']);
            } catch (\Throwable $th) {
                Log::error($th->getMessage());
                return redirect()->back()->with('error', 'Something went wrong.');
            }
        }
        return view('Auth.login');
    }

    public function dashboard()
    {
        try {
            $data = $this->auth_service->dashboard();
            return view('Admin.dashboard', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->route('admin.login')->with('error', 'You must be logged in.');
        }
    }

    public function logout(Request $request)
    {
        try {
            $data = $this->auth_service->logout();
            return redirect()->route('admin.login')->with('success', $data['message']);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
