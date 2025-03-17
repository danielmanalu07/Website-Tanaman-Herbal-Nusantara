<?php
namespace App\Http\Repositories;

use App\Models\Plants;

class PlantRepository
{
    public function create_plant(array $data)
    {
        return Plants::create($data);
    }

    public function get_all_plant()
    {
        return Plants::get();
    }

    public function get_detail_plant(int $id)
    {
        return Plants::findOrFail($id);
    }

    public function update_plant(array $data, int $id)
    {
        $plant = Plants::findOrFail($id);
        $plant->update($data);
        return $plant;
    }

    public function delete_plant(int $id)
    {
        $plant = Plants::findOrFail($id);
        $plant->delete();
        return $plant;
    }
}
