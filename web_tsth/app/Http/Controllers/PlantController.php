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
            'images'              => 'required',
            'images.*'            => 'image|mimes:jpeg,png,jpg',
        ]);

        try {
            $multipartData = [
                'name'                => $request->name,
                'latin_name'          => $request->latin_name,
                'advantage'           => $request->advantage,
                'ecology'             => $request->ecology,
                'endemic_information' => $request->endemic_information,
                'habitus_id'          => $request->habitus_id,
                'images'              => $request->file('images'),
            ];

            $result = $this->plant_service->create_plant($multipartData);
            return redirect()->back()->with('success', $result['message']);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'name'                => 'required|string',
            'latin_name'          => 'required|string',
            'advantage'           => 'required',
            'ecology'             => 'required|string',
            'endemic_information' => 'required',
            'habitus_id'          => 'required',
            'new_images'          => 'nullable|array|min:1',
            'new_images.*'        => 'image|mimes:jpeg,png,jpg',
            'deleted_images'      => 'nullable|array',
            'deleted_images.*'    => 'integer|exists:images,id',
        ]);
        try {
            $data = [
                'name'                => $request->name,
                'latin_name'          => $request->latin_name,
                'advantage'           => $request->advantage,
                'ecology'             => $request->ecology,
                'endemic_information' => $request->endemic_information,
                'habitus_id'          => $request->habitus_id,
                'new_images'          => $request->file('new_images'),
                'deleted_images'      => $request->array('deleted_images'),
            ];
            $result = $this->plant_service->update_plant($data, $id);
            // dd($request->all());
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

    public function update_status(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|boolean',
        ]);
        try {
            $result = $this->plant_service->update_status($request->status, $id);
            return redirect()->back()->with('success', $result['message']);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function upload(Request $request)
    {
        try {
            $file = $request->file('upload');
            if (! $file) {
                throw new \Exception('No file uploaded');
            }

            $result = $this->plant_service->upload($file);

            return response()->json([
                'fileName' => $result['fileName'],
                'uploaded' => $result['uploaded'],
                'url'      => $result['url'],
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'uploaded' => false,
                'error'    => ['message' => $th->getMessage()],
            ], 400);
        }
    }

}
