<?php
namespace App\Http\Controllers;

use App\Http\Constant\LanguageConstant;
use App\Service\AuthService;
use App\Service\LanguageService;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    private $language_service, $auth_service;
    public function __construct(AuthService $auth_service, LanguageService $language_service)
    {
        $this->auth_service     = $auth_service;
        $this->language_service = $language_service;
    }

    public function SetLanguage(Request $request)
    {
        $request->validate([
            'language' => 'required|string',
        ]);

        try {
            $languages = $this->language_service->get_all_lang();

            $Rowlanguage = $languages->where('code', $request->language)->first();

            if (! $Rowlanguage) {
                return redirect()->back()->with('error', 'Language not found.');
            }

            // session(['app_language' => $Rowlanguage->code]);
            LanguageConstant::SetLanguage($Rowlanguage->code);

            return redirect()->back();
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function SetLanguageUser(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'language' => 'required|string',
        ]);

        try {
            $languages = $this->language_service->get_all_lang_user();

            $Rowlanguage = $languages->where('code', $request->language)->first();

            if (! $Rowlanguage) {
                return redirect()->back()->with('error', 'Language not found.');
            }
            // dd($Rowlanguage);

            // session(['app_language' => $Rowlanguage->code]);
            LanguageConstant::SetLanguage($Rowlanguage->code);

            return redirect()->back();
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function index()
    {
        try {
            $data      = $this->auth_service->dashboard();
            $languages = $this->language_service->get_all_lang();
            return view('Admin.Language.index', compact('data', 'languages'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function create_language(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'code' => 'required|string|unique:languages,code',
        ]);
        try {
            $result = $this->language_service->create_lang($request->all());
            return redirect()->back()->with('success', $result['message']);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function update_language(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required|string',
            'code' => 'required|string',
        ]);
        try {
            $result = $this->language_service->edit_lang($request->all(), $id);
            return redirect()->back()->with('success', $result['message']);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function delete_language(int $id)
    {
        try {
            $result = $this->language_service->delete_lang($id);
            return redirect()->back()->with('success', $result['message']);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

}
