<?php
namespace App\Http\Repositories;

use App\Models\PlantLand;

class PlantLandRepository
{
    public function create(array $data)
    {
        return PlantLand::create($data);
    }

    public function getAll()
    {
        return PlantLand::get();
    }

    public function getDetail(int $id)
    {
        return PlantLand::findOrFail($id);
    }

    public function update(array $data, int $id)
    {
        $plant_land = PlantLand::findOrFail($id);
        $plant_land->update($data);
        return $plant_land;
    }

    public function delete(int $id)
    {
        $plant_land = PlantLand::findOrFail($id);
        $plant_land->delete();
        return $plant_land;
    }
}
