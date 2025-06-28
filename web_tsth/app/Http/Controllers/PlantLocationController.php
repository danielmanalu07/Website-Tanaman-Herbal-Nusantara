<?php
namespace App\Http\Controllers;

use App\Service\ContentService;
use App\Service\HabitusService;
use App\Service\LandService;
use App\Service\LanguageService;

class PlantLocationController extends Controller
{
    private $land_service, $content_service, $language_service, $habitus_service;

    public function __construct(LandService $land_service, ContentService $content_service, LanguageService $language_service, HabitusService $habitus_service)
    {
        $this->land_service     = $land_service;
        $this->content_service  = $content_service;
        $this->language_service = $language_service;
        $this->habitus_service  = $habitus_service;
    }
    public function index()
    {
        try {
            $lands     = $this->land_service->get_all_land_user();
            $contents  = $this->content_service->get_all_content_user();
            $languages = $this->language_service->get_all_lang_user();
            $habituses = $this->habitus_service->get_all_user();
            return view('User.Location.index', compact('lands', 'contents', 'languages', 'habituses'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }
}
