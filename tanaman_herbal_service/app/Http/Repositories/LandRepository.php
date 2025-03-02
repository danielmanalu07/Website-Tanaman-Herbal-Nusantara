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
}
