<?php
namespace App\Http\Controllers;

use App\Service\AuthService;
use App\Service\LandService;
use App\Service\LanguageService;
use App\Service\PlantService;
use Illuminate\Http\Request;

class LandController extends Controller
{
    private $auth_service, $land_service, $plant_service, $language_service;

    public function __construct(AuthService $auth_service, LandService $land_service, PlantService $plant_service, LanguageService $languageService)
    {
        $this->auth_service     = $auth_service;
        $this->land_service     = $land_service;
        $this->plant_service    = $plant_service;
        $this->language_service = $languageService;
    }
    public function index()
    {
        try {
            $data      = $this->auth_service->dashboard();
            $lands     = $this->land_service->get_all_land();
            $plants    = $this->plant_service->get_all_plant();
            $languages = $this->language_service->get_all_lang();
            return view('Admin.Land.index', compact('data', 'lands', 'plants', 'languages'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function create(Request $request)
    {
        $request->validate([
            'name'     => 'required|string',
            'plants'   => 'nullable|array',
            'plants.*' => 'integer|exists:plants,id',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        try {
            $insertData = [
                'name'   => $request->name,
                'plants' => $request->plants ?? [],
                'image'  => $request->file('image'),
            ];
            $result = $this->land_service->create_land($insertData);

            return redirect()->back()->with('success', 'Land created successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required|string',
            'plants'   => 'nullable|array',
            'plants.*' => 'integer|exists:plants,id',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        try {
            $updateData = [
                'name'   => $request->name,
                'plants' => $request->plants ?? [],
            ];

            // Cek kalau upload file baru
            if ($request->hasFile('image')) {
                $updateData['image'] = $request->file('image');
            }

            $result = $this->land_service->update_land($id, $updateData);

            return redirect()->back()->with('success', 'Land updated successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
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
