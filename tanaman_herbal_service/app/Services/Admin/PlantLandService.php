<?php
namespace App\Services\Admin;

use App\Http\Repositories\PlantLandRepository;
use App\Models\Land;
use App\Models\Plant;
use App\Models\PlantLand;
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

            $plantIds = is_array($data['plant_id']) ? $data['plant_id'] : [$data['plant_id']];
            $landIds  = is_array($data['land_id']) ? $data['land_id'] : [$data['land_id']];

            $plantLandData = [];

            foreach ($plantIds as $plantId) {
                if (! ($plant = Plant::withTrashed()->find($plantId))) {
                    return Response::error("Plant with ID {$plantId} not found", null, 404);
                }
                foreach ($landIds as $landId) {
                    if (! ($land = Land::withTrashed()->find($landId))) {
                        return Response::error("Land with this land not found", null, 404);
                    }

                    if (PlantLand::where('plant_id', $plantId)->where('land_id', $landId)->exists()) {
                        return Response::error("Plant land with plant_id {$plantId} and land_id {$landId} already exists", null, 409);
                    }
                    $plantLandData[] = $this->plant_land_repo->create([
                        'plant_id'   => $plantId,
                        'land_id'    => $landId,
                        'created_by' => $admin->id,
                        'updated_by' => $admin->id,
                    ]);
                }
            }
            return $plantLandData;
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

            $plantIds = is_array($data['plant_id']) ? $data['plant_id'] : [$data['plant_id']];

            if (! ($plant = Plant::withTrashed()->find($data['plant_id']))) {
                return Response::error('Plant not found', null, 404);
            }

            $existingPlantLands = PlantLand::where('land_id', $data['land_id'])->get();

            $plantData = [];

            foreach ($plantIds as $plantId) {
                if (! ($plant = Plant::withTrashed()->find($plantId))) {
                    return Response::error("Plant with ID {$plantId} not found", null, 404);
                }

                $existing = $existingPlantLands->where('plant_id', $plantId)->first();
                if ($existing) {
                    $existing->update([
                        'updated_by' => $admin->id,
                    ]);
                    $plantData[] = $existing->id;
                } else {
                    $newPlantLand = $this->plant_land_repo->create([
                        'plant_id'   => $plantId,
                        'land_id'    => $data['land_id'],
                        'created_by' => $admin->id,
                        'updated_by' => $admin->id,
                    ]);
                    $plantData[] = $newPlantLand->id;
                }
            }
            return $plantData;
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
