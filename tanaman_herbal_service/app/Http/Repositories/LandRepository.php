<?php
namespace App\Http\Repositories;

use App\Models\Lands;

class LandRepository
{
    public function create_land(array $data)
    {
        return Lands::create($data);
    }

    public function get_all_lands()
    {
        return Lands::all();
    }

    public function get_all_by_id(int $id)
    {
        return Lands::findOrFail($id);
    }

    public function update_land(int $id, array $data)
    {
        $land = Lands::findOrFail($id);
        $land->update($data);
        return $land;
    }

    public function delete_land(int $id)
    {
        $land = Lands::findOrFail($id);
        $land->delete();
        return $land;
    }
}
