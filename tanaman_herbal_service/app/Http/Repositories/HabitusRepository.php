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

    public function update_habitus(int $id, array $data)
    {
        $habitus = Habitus::findOrFail($id);
        $habitus->update($data);
        return $habitus;
    }

    public function delete_habitus(int $id)
    {
        $habitus = Habitus::findOrFail($id);
        $habitus->delete();
        return $habitus;
    }

}
