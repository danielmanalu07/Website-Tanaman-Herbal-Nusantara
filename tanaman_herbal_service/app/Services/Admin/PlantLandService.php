<?php
namespace App\Services\Admin;

use App\Http\Repositories\PlantLandRepository;
use App\Models\Lands;
use App\Models\PlantLand;
use App\Models\Plants;
use App\Response\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class PlantLandService
{
    protected $plant_land_repo;

    public function __construct(PlantLandRepository $plant_land_repository)
    {
        $this->plant_land_repo = $plant_land_repository;
    }

    public function create_plant_land(array $data)
    {
        try {
            $admin = Auth::user();

            if (! ($plant = Plants::withTrashed()->find($data['plant_id']))) {
                return Response::error('Plant not found', null, 404);
            }

            if (! ($land = Lands::withTrashed()->find($data['land_id']))) {
                return Response::error('Land not found', null, 404);
            }

            if (PlantLand::where('plant_id', $data['plant_id'])->where('land_id', $data['land_id'])->exists()) {
                return Response::error('Plant land with this plant and land already exists', null, 409);
            }

            return $this->plant_land_repo->create(array_merge($data, [
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ]));
        } catch (\Throwable $th) {
            return Response::error('Failed to create data plant land', $th->getMessage(), 500);
        }
    }

    public function get_all_plant_land()
    {
        try {
            $plant_land = $this->plant_land_repo->getAll();
            if ($plant_land->isEmpty()) {
                return Response::error('No data found', null, 404);
            }
            return $plant_land;
        } catch (\Throwable $th) {
            return Response::error('Failed to get data plant land', $th->getMessage(), 500);
        }
    }

    public function get_detail_plant_land(int $id)
    {
        try {
            $plant_land = $this->plant_land_repo->getDetail($id);
            if (! $plant_land) {
                return Response::error('Data not found', null, 404);
            }

            return $plant_land;
        } catch (ModelNotFoundException $e) {
            return Response::error('Data not found', $e->getMessage(), 404);
        } catch (\Throwable $th) {
            return Response::error('Failed to get detail data plant land', $th->getMessage(), 500);
        }
    }

    public function update_plant_land(array $data, int $id)
    {
        try {
            $admin      = Auth::user();
            $plant_land = $this->plant_land_repo->getDetail($id);
            if (! $plant_land) {
                return Response::error('Data Not Found', null, 404);
            }

            if (! ($plant = Plants::withTrashed()->find($data['plant_id']))) {
                return Response::error('Plant not found', null, 404);
            }

            if (! ($land = Lands::withTrashed()->find($data['land_id']))) {
                return Response::error('Land not found', null, 404);
            }

            if (PlantLand::where('plant_id', $data['plant_id'])
                ->where('land_id', $data['land_id'])
                ->where('id', '!=', $id)
                ->exists()) {
                return Response::error('Plant land with this plant and land already exists', null, 409);
            }

            return $this->plant_land_repo->update(array_merge($data, [
                'updated_by' => $admin->id,
            ]), $id);

        } catch (\Throwable $th) {
            return Response::error('Failed to update data plant land', $th->getMessage(), 500);
        }
    }

    public function delete_plantLand(int $id)
    {
        try {
            return $this->plant_land_repo->delete($id);
        } catch (ModelNotFoundException $e) {
            return Response::error('Data not found', $e->getMessage(), 404);
        } catch (\Throwable $th) {
            return Response::error('Failed to delete data plant', $th->getMessage(), 500);
        }
    }
}
