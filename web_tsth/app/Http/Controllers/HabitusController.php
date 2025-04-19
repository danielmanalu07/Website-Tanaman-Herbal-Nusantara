<?php
namespace App\Http\Controllers;

use App\Service\AuthService;
use App\Service\HabitusService;
use App\Service\LanguageService;
use Illuminate\Http\Request;

class HabitusController extends Controller
{
    private $auth_service, $habitus_service, $language_service;

    public function __construct(AuthService $authService, HabitusService $habitus_service, LanguageService $languageService)
    {
        $this->auth_service     = $authService;
        $this->habitus_service  = $habitus_service;
        $this->language_service = $languageService;
    }
    public function index()
    {
        try {
            $data      = $this->auth_service->dashboard();
            $habitus   = $this->habitus_service->get_all();
            $languages = $this->language_service->get_all_lang();
            // dd($habitus);
            return view('Admin.Habitus.index', compact('data', 'habitus', 'languages'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function create(Request $request)
    {
        $request->validate([
            'name'  => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $inserData = [
                'name'  => $request->name,
                'image' => $request->file('image'),
            ];
            $result = $this->habitus_service->create_habitus($inserData);

            if (isset($result['success']) && $result['success'] != true) {
                return redirect()->back()->with('error', $result['message']);
            }

            return redirect()->back()->with('success', $result['message']);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function update_habitus(Request $request, int $id)
    {
        // dd($request->all());
        $request->validate([
            'name'  => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        try {
            $updateData = [
                'name'  => $request->name,
                'image' => $request->file('image'),
            ];
            $result = $this->habitus_service->update_habitus($updateData, $id);
            // dd($result);
            return redirect()->back()->with('success', $result['message']);

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function delete_habitus(int $id)
    {
        try {
            $result = $this->habitus_service->delete_habitus($id);
            if ($result['success'] !== true) {
                return redirect()->back()->with('error', $result['message']);
            }

            return redirect()->back()->with('success', $result['message']);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    // public function get_detail_habitus(int $id)
    // {
    //     try {
    //         $data = $this->habitus_service->get_detail($id);
    //         return response()->json($data);
    //     } catch (\Throwable $th) {
    //         return redirect()->back()->with('error', 'Something went wrong.');
    //     }
    // }
}
