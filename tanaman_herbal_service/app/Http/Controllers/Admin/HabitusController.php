<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\HabitusResource;
use App\Response\Response;
use App\Services\Admin\HabitusService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HabitusController extends Controller
{
    protected $habitus_service;

    public function __construct(HabitusService $habitusService)
    {
        $this->habitus_service = $habitusService;
    }
    public function createHabitus(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:habituses,name',
        ]);
        try {

            $habitus = $this->habitus_service->create_habitus($request->all());

            if ($habitus instanceof JsonResponse) {
                return $habitus;
            }

            return Response::success('Created habitus successfully', new HabitusResource($habitus), 201);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    public function getAllHabitus()
    {
        try {
            $habituses = $this->habitus_service->get_all_habitus();

            if ($habituses instanceof JsonResponse) {
                return $habituses;
            }

            return Response::success('Get all data successfully', HabitusResource::collection($habituses), 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    public function getDetailHabitus(int $id)
    {
        try {
            $habitus = $this->habitus_service->get_detail_habitus($id);
            if ($habitus instanceof JsonResponse) {
                return $habitus;
            }
            return Response::success('Get data successfully', new HabitusResource($habitus), 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    public function updateHabitus(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required|string',
        ]);
        try {
            $habitus = $this->habitus_service->update_habitus($request->all(), $id);
            if ($habitus instanceof JsonResponse) {
                return $habitus;
            }

            return Response::success('Updated Successfully', new HabitusResource($habitus), 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    public function deleteHabitus(int $id)
    {
        try {
            $habitus = $this->habitus_service->delete_habitus($id);
            if ($habitus instanceof JsonResponse) {
                return $habitus;
            }

            return Response::success('Deleted Successfully', null, 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }
}
