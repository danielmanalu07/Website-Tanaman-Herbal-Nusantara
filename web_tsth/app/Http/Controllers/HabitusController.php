<?php
namespace App\Http\Controllers;

use App\Service\AuthService;
use App\Service\HabitusService;
use Illuminate\Http\Request;

class HabitusController extends Controller
{
    private $auth_service, $habitus_service;

    public function __construct(AuthService $authService, HabitusService $habitus_service)
    {
        $this->auth_service    = $authService;
        $this->habitus_service = $habitus_service;
    }
    public function index()
    {
        try {
            $data    = $this->auth_service->dashboard();
            $habitus = $this->habitus_service->get_all();
            return view('Admin.Habitus.index', compact('data', 'habitus'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|string',
            ]);
            try {
                $result = $this->habitus_service->create_habitus($request->name);

                if (isset($result['success']) && $result['success'] === true) {
                    return redirect()->back()->with('success', $result['message']);
                }

                return redirect()->back()->with('error', $result['message']);

            } catch (\Throwable $th) {
                return redirect()->back()->with('error', 'Something went wrong.');
            }
        }
    }

    public function update_habitus(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        try {
            $result = $this->habitus_service->update_habitus($request->name, $id);
            if ($result['message'] === 'Failed to update habitus data') {
                return redirect()->back()->with('error', "Data $request->name is a duplicate entry");
            }
            if ($result['success'] !== true) {
                return redirect()->back()->with('error', $result['message']);
            }

            return redirect()->back()->with('success', $result['message']);

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function delete_habitus(int $id)
    {
        try {
            $result = $this->habitus_service->delete_habitus($id);
            if ($result['success'] !== true) {
                return redirect()->back()->with('error', $result['message']);
            }

            return redirect()->back()->with('success', $result['message']);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    // public function get_detail_habitus(int $id)
    // {
    //     try {
    //         $data = $this->habitus_service->get_detail($id);
    //         return response()->json($data);
    //     } catch (\Throwable $th) {
    //         return redirect()->back()->with('error', 'Something went wrong.');
    //     }
    // }
}
