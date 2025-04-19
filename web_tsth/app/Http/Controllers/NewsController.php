<?php
namespace App\Http\Controllers;

use App\Service\AuthService;
use App\Service\LanguageService;
use App\Service\NewsService;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    private $auth_service, $news_service, $language_service;

    public function __construct(AuthService $auth_service, NewsService $news_service, LanguageService $languageService)
    {
        $this->auth_service     = $auth_service;
        $this->news_service     = $news_service;
        $this->language_service = $languageService;
    }

    public function index()
    {
        try {
            $data      = $this->auth_service->dashboard();
            $news      = $this->news_service->get_all_news();
            $languages = $this->language_service->get_all_lang();
            return view('Admin.News.index', compact('data', 'news', 'languages'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function create(Request $request)
    {
        $request->validate([
            'title'    => 'required|string',
            'content'  => 'required',
            'images'   => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg',
        ]);
        try {
            $result = $this->news_service->create_news($request->all());
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

            $result = $this->news_service->upload($file);

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
            'title'            => 'required|string',
            'content'          => 'required|string',
            'new_images'       => 'nullable|array|min:1',
            'new_images.*'     => 'image|mimes:jpeg,png,jpg',
            'deleted_images'   => 'nullable|array',
            'deleted_images.*' => 'integer|exists:images,id',
        ]);
        try {
            $data = [
                'title'          => $request->input('title'),
                'content'        => $request->input('content'),
                'new_images'     => $request->file('new_images'),
                'deleted_images' => $request->array('deleted_images'),
            ];
            $result = $this->news_service->edit($data, $id);

            return redirect()->back()->with('success', $result['message']);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function delete(int $id)
    {
        try {
            $result = $this->news_service->delete($id);
            return redirect()->back()->with('success', $result['message']);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function update_status(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|boolean',
        ]);
        try {
            $result = $this->news_service->update_status($request->status, $id);
            return redirect()->back()->with('success', $result['message']);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
