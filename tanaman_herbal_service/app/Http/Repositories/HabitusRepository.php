<?php
namespace App\Http\Repositories;

use App\Models\Habitus;

class HabitusRepository
{
    public function createHabitus(array $data)
    {
        return Habitus::create($data);
    }

    public function get_all_habitus()
    {
        return Habitus::all();
    }

    public function get_detail_habitus(int $id)
    {
        return Habitus::findOrFail($id);
    }
}
