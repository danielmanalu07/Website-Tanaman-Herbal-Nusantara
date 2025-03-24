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
        try {
            $request->validate([
                'full_name' => 'required',
                'email'     => 'required|email|unique:users,email',
                'phone'     => 'required|unique:users,phone',
                'username'  => 'required|string|unique:users,username',
                'password'  => 'required|min:6',
                'role'      => 'required|in:koordinator,agronom',
            ]);
            $result = $this->staff_service->create_staff($request->all());
            return redirect()->back()->with('success', $result['message']);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function update(Request $request, int $id)
    {
        try {
            $request->validate([
                'username'  => 'nullable|string|unique:users,username,' . $id,
                'full_name' => 'nullable|string',
                'email'     => 'nullable|email|unique:users,email,' . $id,
                'phone'     => 'nullable|string|unique:users,phone,' . $id,
                'password'  => 'nullable|min:6',
                'role'      => 'nullable|in:koordinator,agronom',
            ]);
            $result = $this->staff_service->update_staff($request->all(), $id);
            return redirect()->back()->with('success', $result['message']);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function delete(int $id)
    {
        try {
            $result = $this->staff_service->delete_staff($id);
            return redirect()->back()->with('success', $result['message']);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function update_status(Request $request, int $id)
    {
        try {
            $request->validate([
                'active' => 'required|boolean',
            ]);

            $result = $this->staff_service->update_status($request->active, $id);
            // dd($result);
            if ($result['success']) {
                return redirect()->back()->with('success', $result['message']);
            } else {
                return redirect()->back()->with('error', $result['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

}
