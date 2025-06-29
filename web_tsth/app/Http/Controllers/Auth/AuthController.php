<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Service\AuthService;
use App\Service\HabitusService;
use App\Service\LandService;
use App\Service\LanguageService;
use App\Service\NewsService;
use App\Service\PlantService;
use App\Service\PlantValidationService;
use App\Service\StaffService;
use App\Service\VisitorCategoryService;
use App\Service\VisitorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    private $auth_service, $habitus_service, $language_service, $staff_service, $plant_service, $land_service, $visitor_category_service, $visitor_service, $news_service, $plant_validation_service;

    public function __construct(PlantValidationService $plant_validation_service, AuthService $authService, HabitusService $habitus_service, LanguageService $languageService, StaffService $staff_service, PlantService $plant_service, LandService $land_service, VisitorCategoryService $visitor_category_service, VisitorService $visitor_service, NewsService $news_service)
    {
        $this->auth_service             = $authService;
        $this->habitus_service          = $habitus_service;
        $this->language_service         = $languageService;
        $this->staff_service            = $staff_service;
        $this->plant_service            = $plant_service;
        $this->land_service             = $land_service;
        $this->visitor_category_service = $visitor_category_service;
        $this->visitor_service          = $visitor_service;
        $this->news_service             = $news_service;
        $this->plant_validation_service = $plant_validation_service;
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
        $habituses          = $this->habitus_service->get_all()->count();
        $data               = $this->auth_service->dashboard();
        $languages          = $this->language_service->get_all_lang();
        $staff              = $this->staff_service->get_all_staff()->count();
        $plants             = $this->plant_service->get_all_plant()->count();
        $lands              = $this->land_service->get_all_land()->count();
        $visitor_categories = $this->visitor_category_service->get_all_visitor_category()->count();
        $visitors           = $this->visitor_service->get_all_visitor()->count();
        $news               = $this->news_service->get_all_news()->count();
        $plant_validations  = $this->plant_validation_service->get_all_validation()->count();

        $visitor_category = $this->visitor_category_service->get_all_visitor_category();
        $visitor          = $this->visitor_service->get_all_visitor();

        $validations = $this->plant_validation_service->get_all_validation();
        $plant       = $this->plant_service->get_all_plant();
        $berita      = $this->news_service->get_all_news();
        return view('Admin.dashboard', compact('data', 'habituses', 'languages', 'staff', 'plants', 'lands', 'visitor_categories', 'visitors', 'news', 'plant_validations', 'visitor_category', 'visitor', 'validations', 'plant', 'berita'));

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
