<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\NewsResource;
use App\Response\Response;
use App\Services\Admin\NewService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    protected $new_service;

    public function __construct(NewService $new_service)
    {
        $this->new_service = $new_service;
    }

    public function create_news(Request $request)
    {
        $request->validate([
            'title'    => 'required',
            'content'  => 'required',
            'images'   => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg',
        ]);
        try {
            $result = $this->new_service->create_news($request->all());
            if ($result instanceof JsonResponse) {
                return $result;
            }

            return Response::success('Created news successfully', new NewsResource($result), 201);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    public function get_all_news()
    {
        try {
            $result = $this->new_service->get_all_news();
            if ($result instanceof JsonResponse) {
                return $result;
            }
            return Response::success('News retrieved successfully', NewsResource::collection($result), 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    public function get_detail_news(int $id)
    {
        try {
            $result = $this->new_service->get_detail_news($id);
            if ($result instanceof JsonResponse) {
                return $result;
            }
            return Response::success('News retrieved successfully', new NewsResource($result), 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    public function update_news(Request $request, int $id)
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
            $result = $this->new_service->update_news($request->all(), $id);
            return Response::success('Updated successfully', new NewsResource($result), 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }
    public function delete_news(int $id)
    {
        try {
            $result = $this->new_service->delete_news($id);
            if ($result instanceof JsonResponse) {
                return $result;
            }
            return Response::success('News deleted successfully', null, 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    // backend/app/Http/Controllers/NewsController.php
    public function uploadCkeditor(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName   = pathinfo($originName, PATHINFO_FILENAME);
            $ext        = $request->file('upload')->getClientOriginalExtension();
            $fileName   = $fileName . '_' . time() . '.' . $ext;

            $request->file('upload')->move(public_path('media'), $fileName);

            $url = asset('media/' . $fileName);

            return response()->json([
                'fileName' => $fileName,
                'uploaded' => 1,
                'url'      => $url,
            ]);
        }

        return response()->json([
            'uploaded' => false,
            'error'    => ['message' => 'Upload gagal'],
        ], 400);
    }
}
