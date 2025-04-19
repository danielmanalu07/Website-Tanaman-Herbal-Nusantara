<?php
namespace App\Http\Controllers;

use App\Service\ContentService;
use App\Service\HabitusService;
use App\Service\LanguageService;
use App\Service\PlantService;

class OurGardenController extends Controller
{
    private $habitus_service, $language_service, $content_service, $plant_service;

    public function __construct(HabitusService $habitus_service, LanguageService $language_service, ContentService $content_service, PlantService $plant_service)
    {
        $this->habitus_service  = $habitus_service;
        $this->language_service = $language_service;
        $this->content_service  = $content_service;
        $this->plant_service    = $plant_service;
    }

    public function index()
    {
        try {
            $habituses = $this->habitus_service->get_all_user();
            $languages = $this->language_service->get_all_lang_user();
            $contents  = $this->content_service->get_all_content_user();
            return view('User.OurGarden.index', compact('habituses', 'languages', 'contents'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function detail(int $id)
    {
        try {
            $plants    = $this->plant_service->get_all_plant_user();
            $languages = $this->language_service->get_all_lang_user();
            $contents  = $this->content_service->get_all_content_user();

            $plantHabitus = collect($plants)
                ->filter(function ($plant) use ($id) {
                    return isset($plant->habitus['id']) && $plant->habitus['id'] == $id;
                })
                ->values();
            return view('User.OurGarden.detail', compact('plantHabitus', 'languages', 'contents'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function detail_plant(int $id)
    {
        try {
            $plants    = $this->plant_service->get_detail_plant_user($id);
            $languages = $this->language_service->get_all_lang_user();
            $contents  = $this->content_service->get_all_content_user();
            $habituses = $this->habitus_service->get_all_user();
            $allPlants = $this->plant_service->get_all_plant_user();

            // Get the habitus ID of the current plant
            $currentPlantHabitusId = isset($plants['data']['habitus']['id']) ? $plants['data']['habitus']['id'] : null;

            $plantHabitus = collect($allPlants)
                ->filter(function ($plant) use ($currentPlantHabitusId, $id) {
                    return isset($plant->habitus['id']) &&
                    $plant->habitus['id'] == $currentPlantHabitusId &&
                    $plant->id != $id;
                })
                ->values();

            // dd($plants);
            return view('User.OurGarden.detail_plant', compact('plants', 'languages', 'contents', 'habituses', 'plantHabitus', 'currentPlantHabitusId'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }
}
