<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContentResource;
use App\Response\Response;
use App\Services\Admin\ContentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    private $content_service;
    public function __construct(ContentService $content_service)
    {
        $this->content_service = $content_service;
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
            if ($result instanceof JsonResponse) {
                return $result;
            }
            return Response::success('Created content successfully', new ContentResource($result), 201);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    public function get_all()
    {
        try {
            $result = $this->content_service->get_all_content();
            if ($result instanceof JsonResponse) {
                return $result;
            }
            return Response::success('Content retrieved successfully', ContentResource::collection($result), 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    public function get_detail(int $id)
    {
        try {
            $result = $this->content_service->get_detail_content($id);
            if ($result instanceof JsonResponse) {
                return $result;
            }
            return Response::success('Content retrieved successfully', new ContentResource($result), 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'key'     => 'required|string',
            'title'   => 'required|string',
            'content' => 'required',
        ]);
        try {
            $result = $this->content_service->update_content($request->all(), $id);
            if ($result instanceof JsonResponse) {
                return $result;
            }
            return Response::success('Updated content successfully', new ContentResource($result), 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    public function delete(int $id)
    {
        try {
            $result = $this->content_service->delete_content($id);
            if ($result instanceof JsonResponse) {
                return $result;
            }
            return Response::success('Deleted content successfully', null, 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

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
