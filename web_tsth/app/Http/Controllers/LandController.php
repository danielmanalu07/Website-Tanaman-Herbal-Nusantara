<?php
namespace App\Http\Controllers;

use App\Service\AuthService;
use App\Service\LandService;
use Illuminate\Http\Request;

class LandController extends Controller
{
    private $auth_service, $land_service;

    public function __construct(AuthService $auth_service, LandService $land_service)
    {
        $this->auth_service = $auth_service;
        $this->land_service = $land_service;
    }
    public function index()
    {
        try {
            $data  = $this->auth_service->dashboard();
            $lands = $this->land_service->get_all_land();
            return view('Admin.Land.index', compact('data', 'lands'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);
        try {
            $result = $this->land_service->create_land($request->name);

            return redirect()->back()->with('success', $result['message']);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required|string',
        ]);
        try {
            $result = $this->land_service->update_land($request->name, $id);
            return redirect()->back()->with('success', $result['message']);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function delete(int $id)
    {
        try {
            $result = $this->land_service->delete_land($id);
            return redirect()->back()->with('success', $result['message']);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }
}
