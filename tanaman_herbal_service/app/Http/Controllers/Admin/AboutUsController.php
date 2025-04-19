<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AboutUsResource;
use App\Response\Response;
use App\Services\Admin\AboutUsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    protected $about_us_service;
    public function __construct(AboutUsService $about_us_service)
    {
        $this->about_us_service = $about_us_service;
    }

    public function create_aboutUs(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'text'  => 'required',
        ]);

        try {
            $result = $this->about_us_service->create_aboutUs($request->all());
            if ($result instanceof JsonResponse) {
                return $result;
            }
            return Response::success('Created Contact us successfully', new AboutUsResource($result), 201);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);

        }
    }

    public function get_all_about_us()
    {
        try {
            $result = $this->about_us_service->get_all_about_us();
            if ($result instanceof JsonResponse) {
                return $result;
            }
            return Response::success('Contact us retrieved successfully', AboutUsResource::collection($result), 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    public function update_about_us(Request $request, int $id)
    {
        $request->validate([
            'title' => 'required',
            'text'  => 'required',
        ]);
        try {
            $result = $this->about_us_service->update_about_us($request->all(), $id);
            if ($result instanceof JsonResponse) {
                return $result;
            }
            return Response::success('Contact us updated successfully', new AboutUsResource($result), 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    public function get_detail_about_us(int $id)
    {
        try {
            $result = $this->about_us_service->get_detail_about_us($id);
            if ($result instanceof JsonResponse) {
                return $result;
            }
            return Response::success('Contact us retrieved successfully', new AboutUsResource($result), 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    public function delete_about_us(int $id)
    {
        try {
            $result = $this->about_us_service->delete_about_us($id);
            if ($result instanceof JsonResponse) {
                return $result;
            }
            return Response::success('Contact us deleted successfully', null, 200);
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
