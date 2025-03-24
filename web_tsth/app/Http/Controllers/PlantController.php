<?php
namespace App\Http\Controllers;

use App\Service\AuthService;
use App\Service\HabitusService;
use App\Service\PlantService;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    private $auth_service, $plant_service, $habitus_service;

    public function __construct(AuthService $auth_service, PlantService $plant_service, HabitusService $habitus_service)
    {
        $this->auth_service    = $auth_service;
        $this->plant_service   = $plant_service;
        $this->habitus_service = $habitus_service;
    }
    public function index()
    {
        try {
            $data    = $this->auth_service->dashboard();
            $plants  = $this->plant_service->get_all_plant();
            $habitus = $this->habitus_service->get_all();
            return view('Admin.Plant.index', compact('data', 'plants', 'habitus'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function create(Request $request)
    {
        $request->validate([
            'name'                => 'required|string',
            'latin_name'          => 'required|string',
            'advantage'           => 'required',
            'ecology'             => 'required|string',
            'endemic_information' => 'required',
            'habitus_id'          => 'required',
        ]);
        try {
            $result = $this->plant_service->create_plant($request->all());

            return redirect()->back()->with('success', $result['message']);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'name'                => 'nullable|string',
            'latin_name'          => 'nullable|string',
            'advantage'           => 'nullable',
            'ecology'             => 'nullable|string',
            'endemic_information' => 'nullable',
            'habitus_id'          => 'nullable',
        ]);
        try {
            $result = $this->plant_service->update_plant($request->all(), $id);
            return redirect()->back()->with('success', $result['message']);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function delete(int $id)
    {
        try {
            $result = $this->plant_service->delete_plant($id);
            return redirect()->back()->with('success', $result['message']);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
