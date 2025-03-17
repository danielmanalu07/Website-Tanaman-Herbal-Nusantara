<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\LandResource;
use App\Response\Response;
use App\Services\Admin\LandService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LandsController extends Controller
{
    protected $land_service;

    public function __construct(LandService $land_service)
    {
        $this->land_service = $land_service;
    }

    public function createLand(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        try {
            $result = $this->land_service->create_land($request->all());

            if ($result instanceof JsonResponse) {
                return $result;
            }

            return Response::success('Created Land Successfully', new LandResource($result), 201);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    public function getAllLands()
    {
        try {
            $result = $this->land_service->get_all_lands();

            if ($result instanceof JsonResponse) {
                return $result;
            }

            return Response::success('Get all data successfully', LandResource::collection($result), 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    public function getDetailLand(int $id)
    {
        try {
            $result = $this->land_service->get_detail_land($id);
            if ($result instanceof JsonResponse) {
                return $result;
            }
            return Response::success('Get detail data successfully', new LandResource($result), 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    public function updateLand(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        try {
            $land = $this->land_service->update_land($request->all(), $id);
            if ($land instanceof JsonResponse) {
                return $land;
            }

            return Response::success('Updated land successfully', $land, 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    public function deleteLand(int $id)
    {
        try {
            $result = $this->land_service->delete_land($id);
            if ($result instanceof JsonResponse) {
                return $result;
            }
            return Response::success('Delete land successfully', $result, 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }
}
