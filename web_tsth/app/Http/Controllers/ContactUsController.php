<?php
namespace App\Http\Controllers;

use App\Service\AuthService;
use App\Service\ContactUsService;
use App\Service\LanguageService;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    private $auth_service, $language_service, $contact_service;

    public function __construct(AuthService $auth_service, LanguageService $language_service, ContactUsService $contact_us_service)
    {
        $this->auth_service     = $auth_service;
        $this->language_service = $language_service;
        $this->contact_service  = $contact_us_service;
    }
    public function index()
    {
        $data      = $this->auth_service->dashboard();
        $languages = $this->language_service->get_all_lang();
        $contacts  = $this->contact_service->get_all_contact();
        return view('Admin.ContactUs.index', compact('data', 'languages', 'contacts'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'text'  => 'required',
        ]);
        try {
            $result = $this->contact_service->create_contact($request->all());
            return redirect()->back()->with('success', $result['message']);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function upload(Request $request)
    {
        try {
            $file = $request->file('upload');
            if (! $file) {
                throw new \Exception('No file uploaded');
            }

            $result = $this->contact_service->upload($file);

            return response()->json([
                'fileName' => $result['fileName'],
                'uploaded' => $result['uploaded'],
                'url'      => $result['url'],
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'uploaded' => false,
                'error'    => ['message' => $th->getMessage()],
            ], 400);
        }
    }

    public function edit(Request $request, int $id)
    {
        $request->validate([
            'title' => 'required|string',
            'text'  => 'required',
        ]);
        try {
            $result = $this->contact_service->edit_contact($request->all(), $id);
            return redirect()->back()->with('success', $result['message']);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function delete(int $id)
    {
        try {
            $result = $this->contact_service->delete_contact($id);
            return redirect()->back()->with('success', $result['message']);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
