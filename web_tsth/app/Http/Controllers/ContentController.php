<?php
namespace App\Http\Controllers;

use App\Service\AuthService;
use App\Service\ContentService;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    private $auth_service, $content_service;
    public function __construct(AuthService $auth_service, ContentService $content_service)
    {
        $this->auth_service    = $auth_service;
        $this->content_service = $content_service;
    }
    public function index()
    {
        try {
            $data     = $this->auth_service->dashboard();
            $contents = $this->content_service->get_all_content();
            return view('Admin.Content.index', compact('data', 'contents'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function upload(Request $request)
    {
        try {
            $file = $request->file('upload');
            if (! $file) {
                throw new \Exception('No file uploaded');
            }

            $result = $this->content_service->upload($file);

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

    public function create(Request $request)
    {
        $request->validate([
            'key'     => 'required|string',
            'title'   => 'required|string',
            'content' => 'required',
        ]);
        try {
            $result = $this->content_service->create_content($request->all());
            return redirect()->back()->with('success', $result['message']);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function edit(Request $request, int $id)
    {
        $request->validate([
            'key'     => 'required|string',
            'title'   => 'required|string',
            'content' => 'required',
        ]);
        try {
            $result = $this->content_service->edit_content($request->all(), $id);
            return redirect()->back()->with('success', $result['message']);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function delete(int $id)
    {
        try {
            $result = $this->content_service->delete_content($id);
            return redirect()->back()->with('success', $result['message']);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

}
