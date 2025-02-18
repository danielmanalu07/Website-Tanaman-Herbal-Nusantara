<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Response\Response;
use App\Services\Admin\VisitorCategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VisitorCategoryController extends Controller
{
    protected $visitorCategoryService;

    public function __construct(VisitorCategoryService $visitorCategoryService)
    {
        $this->visitorCategoryService = $visitorCategoryService;
    }

    public function getVisitorCategories()
    {
        try {
            $visitorCategories = $this->visitorCategoryService->get_VisitorCategories();

            if ($visitorCategories instanceof JsonResponse) {
                return $visitorCategories;
            }

            return Response::success('Get data successfully', $visitorCategories, 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    public function createVisitorCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        try {
            $data = $this->visitorCategoryService->create_visitorCategory($request->all());

            // ✅ Cek apakah service mengembalikan response error
            if ($data instanceof JsonResponse) {
                return $data;
            }

            return Response::success('Created Successfully', $data, 201);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    public function getDetailVisitorCategory(int $id)
    {
        try {
            $data = $this->visitorCategoryService->get_detail_visitorCategory($id);

            if ($data instanceof JsonResponse) {
                return $data;
            }

            return Response::success('Get data successfully', $data, 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    public function updateVisitorCategory(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        try {
            $data = $this->visitorCategoryService->update_visitorCategory($request->all(), $id);

            if ($data instanceof JsonResponse) {
                return $data;
            }

            return Response::success('Updated Successfully', $data, 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    public function deleteVisitorCategory(int $id)
    {
        try {
            $result = $this->visitorCategoryService->delete_visitorCategory($id);
            if ($result instanceof JsonResponse) {
                return $result;
            }
            return Response::success('Data deleted successfully', null, 200);
        } catch (\Throwable $th) {
            return Response::error('Internal server error', $th->getMessage(), 500);
        }
    }

}
