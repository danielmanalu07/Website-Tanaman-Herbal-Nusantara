<?php
namespace App\Http\Controllers;

use App\Exports\PlantValidationExport;
use App\Service\AuthService;
use App\Service\LanguageService;
use App\Service\PlantValidationService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PlantValidationController extends Controller
{
    private $auth_service, $validation_service, $language_service;

    public function __construct(AuthService $auth_service, PlantValidationService $plant_validation_service, LanguageService $language_service)
    {
        $this->auth_service       = $auth_service;
        $this->validation_service = $plant_validation_service;
        $this->language_service   = $language_service;
    }
    public function index()
    {
        try {
            $data              = $this->auth_service->dashboard();
            $plant_validations = $this->validation_service->get_all_validation();
            $languages         = $this->language_service->get_all_lang();
            return view('Admin.PlantValidation.index', compact('data', 'plant_validations', 'languages'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function excel(Request $request)
    {
        try {
            $fromDate = $request->query('fromDate');
            $toDate   = $request->query('toDate');

            return Excel::download(new PlantValidationExport($this->validation_service, $fromDate, $toDate), 'plant_validation.xlsx');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
