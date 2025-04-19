<?php
namespace App\Http\Controllers;

use App\Service\AuthService;
use App\Service\LanguageService;
use App\Service\VisitorCategoryService;
use Illuminate\Http\Request;

class VisitorCategoryController extends Controller
{
    private $auth_service, $visitor_category_service, $language_service;

    public function __construct(AuthService $auth_service, VisitorCategoryService $visitor_category_service, LanguageService $languageService)
    {
        $this->auth_service             = $auth_service;
        $this->visitor_category_service = $visitor_category_service;
        $this->language_service         = $languageService;
    }
    public function index()
    {
        try {
            $data               = $this->auth_service->dashboard();
            $visitor_categories = $this->visitor_category_service->get_all_visitor_category();
            $languages          = $this->language_service->get_all_lang();
            // dd($visitor_categories);
            return view('Admin.VisitorCategory.index', compact('data', 'visitor_categories', 'languages'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => "required|string",
        ]);
        try {
            $result = $this->visitor_category_service->create_visitor_category($request->name);
            return redirect()->back()->with('success', $result['message']);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required|string',
        ]);
        try {
            $result = $this->visitor_category_service->update_visitor_category($request->name, $id);
            return redirect()->back()->with('success', $result['message']);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function delete(int $id)
    {
        try {
            $result = $this->visitor_category_service->delete_visitor_category($id);
            return redirect()->back()->with('success', $result['message']);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
