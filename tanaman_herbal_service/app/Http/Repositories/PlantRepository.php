<?php
namespace App\Http\Repositories;

use App\Models\Plant;

class PlantRepository
{
    public function create_plant(array $data)
    {
        return Plant::create($data);
    }

    public function get_all_plant()
    {
        return Plant::get();
    }

    public function get_detail_plant(int $id)
    {
        return Plant::findOrFail($id);
    }

    public function update_plant(array $data, int $id)
    {
        $plant = Plant::findOrFail($id);
        $plant->update($data);
        return $plant;
    }

    public function delete_plant(int $id)
    {
        $plant = Plant::findOrFail($id);
        $plant->delete();
        return $plant;
    }

    public function update_status(int $id, bool $status)
    {
        $plant = Plant::findOrFail($id);
        $plant->update([
            'status' => $status,
        ]);

        return $plant;
    }
}
