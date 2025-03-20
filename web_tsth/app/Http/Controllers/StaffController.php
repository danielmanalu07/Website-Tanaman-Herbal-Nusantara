<?php
namespace App\Http\Controllers;

use App\Service\AuthService;
use App\Service\StaffService;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    private $auth_service, $staff_service;

    public function __construct(AuthService $authService, StaffService $staff_service)
    {
        $this->auth_service  = $authService;
        $this->staff_service = $staff_service;
    }

    public function index()
    {
        try {
            $data   = $this->auth_service->dashboard();
            $staffs = $this->staff_service->get_all_staff();
            return view('Admin.Staff.index', compact('data', 'staffs'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function create(Request $request)
    {
        $request->validate([
            'full_name' => 'required',
            'email'     => 'required|email|unique:users,email',
            'phone'     => 'required|unique:users,phone',
            'username'  => 'required|string|unique:users,username',
            'password'  => 'required|min:6',
            'role'      => 'required|in:koordinator,agronom',
        ]);
        try {
            $result = $this->staff_service->create_staff($request->all());
            if (isset($result['success']) && $result['success'] != 201) {
                return redirect()->back()->with('error', $result['message']);
            }
            return redirect()->back()->with('success', $result['message']);

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }
}
