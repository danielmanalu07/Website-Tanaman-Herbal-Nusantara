<?php
namespace App\Http\Controllers;

use App\Service\AuthService;
use App\Service\VisitorCategoryService;
use Illuminate\Http\Request;

class VisitorCategoryController extends Controller
{
    private $auth_service, $visitor_category_service;

    public function __construct(AuthService $auth_service, VisitorCategoryService $visitor_category_service)
    {
        $this->auth_service             = $auth_service;
        $this->visitor_category_service = $visitor_category_service;
    }
    public function index()
    {
        try {
            $data               = $this->auth_service->dashboard();
            $visitor_categories = $this->visitor_category_service->get_all_visitor_category();
            return view('Admin.VisitorCategory.index', compact('data', 'visitor_categories'));
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
