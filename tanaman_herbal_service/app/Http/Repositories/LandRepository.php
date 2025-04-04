<?php
namespace App\Http\Repositories;

use App\Models\Land;

class LandRepository
{
    public function create_land(array $data)
    {
        return Land::create($data);
    }

    public function get_all_lands()
    {
        return Land::all();
    }

    public function get_all_by_id(int $id)
    {
        return Land::findOrFail($id);
    }

    public function update_land(int $id, array $data)
    {
        $land = Land::findOrFail($id);
        $land->update($data);
        return $land;
    }

    public function delete_land(int $id)
    {
        $land = Land::findOrFail($id);
        $land->delete();
        return $land;
    }
}
