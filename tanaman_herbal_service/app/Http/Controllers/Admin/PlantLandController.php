<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlantLandResource;
use App\Response\Response;
use App\Services\Admin\PlantLandService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlantLandController extends Controller
{
    protected $plant_land_service;

    public function __construct(PlantLandService $plant_land_service)
    {
        $this->plant_land_service = $plant_land_service;
    }

    public function createPlantLand(Request $request)
    {
        $request->validate([
            'plant_id'   => 'required|array|min:1',
            'plant_id.*' => 'integer|exists:plants,id',
            'land_id'    => 'required|array|min:1',
            'land_id.*'  => 'required|exists:lands,id',
        ]);

        try {
            $result = $this->plant_land_service->create_plant_land($request->all());

            if ($result instanceof JsonResponse) {
                return $result;
            }

            return Response::success(
                'Created Plant Land Successfully',
                PlantLandResource::collection($result), // Menggunakan collection karena data bisa lebih dari satu
                201
            );
        } catch (\Throwable $th) {
            return Response::error('Internal server error', $th->getMessage(), 500);
        }
    }

    public function getAllPlantLand()
    {
        try {
            $result = $this->plant_land_service->get_all_plant_land();
            if ($result instanceof JsonResponse) {
                return $result;
            }

            return Response::success('Get Data Successfully', PlantLandResource::collection($result), 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    public function getDetailPlantLand(int $id)
    {
        try {
            $result = $this->plant_land_service->get_detail_plant_land($id);
            if ($result instanceof JsonResponse) {
                return $result;
            }

            return Response::success('Get Data Successfully', new PlantLandResource($result), 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    public function updatePlantLand(Request $request, int $id)
    {
        $request->validate([
            'plant_id'   => 'required|array|min:1',
            'plant_id.*' => 'integer|exists:plants,id',
            'land_id'    => 'required|array|min:1',
            'land_id.*'  => 'required|exists:lands,id',
        ]);

        try {
            $result = $this->plant_land_service->update_plant_land($request->all(), $id);
            if ($result instanceof JsonResponse) {
                return $result;
            }
            return Response::success('Update Plant Land Successfully', PlantLandResource::collection($result), 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    public function deletePlantLand(int $id)
    {
        try {
            $result = $this->plant_land_service->delete_plantLand($id);
            if ($result instanceof JsonResponse) {
                return $result;
            }

            return Response::success('Delete Plant Land Successfully', null, 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }
}
