<?php
namespace App\Http\Controllers;

use App\Service\AuthService;
use App\Service\LanguageService;
use App\Service\VisitorCategoryService;
use App\Service\VisitorService;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    private $auth_service, $visitor_service, $visitor_category_service, $language_service;

    public function __construct(AuthService $auth_service, VisitorService $visitor_service, VisitorCategoryService $visitor_category_service, LanguageService $languageService)
    {
        $this->auth_service             = $auth_service;
        $this->visitor_service          = $visitor_service;
        $this->visitor_category_service = $visitor_category_service;
        $this->language_service         = $languageService;
    }
    public function index()
    {
        try {
            $data               = $this->auth_service->dashboard();
            $visitors           = $this->visitor_service->get_all_visitor();
            $visitor_categories = $this->visitor_category_service->get_all_visitor_category();
            $languages          = $this->language_service->get_all_lang();
            return view('Admin.Visitor.index', compact('data', 'visitors', 'visitor_categories', 'languages'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function create(Request $request)
    {
        $request->validate([
            'visitor_total'       => 'required|numeric',
            'visitor_category_id' => 'required',
        ]);
        try {
            $result = $this->visitor_service->create_visitor($request->all());
            return redirect()->back()->with('success', $result['message']);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'visitor_total'       => 'required|numeric',
            'visitor_category_id' => 'required',
        ]);
        try {
            $result = $this->visitor_service->update_visitor($request->all(), $id);
            return redirect()->back()->with('success', $result['message']);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function delete(int $id)
    {
        try {
            $result = $this->visitor_service->delete_visitor($id);
            return redirect()->back()->with('success', $result['message']);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
