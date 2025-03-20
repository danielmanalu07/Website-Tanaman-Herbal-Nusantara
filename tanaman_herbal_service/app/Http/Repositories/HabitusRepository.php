<?php
namespace App\Http\Repositories;

use App\Models\Habitus;

class HabitusRepository
{
    public function createHabitus(array $data)
    {
        // return Cache::remember('habitus_create', 60, function () use ($data) {
        //     return Habitus::create($data);
        // });
        return Habitus::create($data);

    }

    public function get_all_habitus()
    {
        // return Cache::remember('habitus_get_all', 60, function () {
        //     return Habitus::all();
        // });
        return Habitus::all();
    }

    public function get_detail_habitus(int $id)
    {
        // return Cache::remember('habitus_get_detail', 60, function () use ($id) {
        //     return Habitus::findOrFail($id);
        // });
        return Habitus::findOrFail($id);

    }

    public function update_habitus(int $id, array $data)
    {
        // return Cache::remember('habitus_update', 60, function () use ($id, $data) {
        //     $habitus = Habitus::findOrFail($id);
        //     $habitus->update($data);
        //     return $habitus;
        // });
        $habitus = Habitus::findOrFail($id);
        $habitus->update($data);
        return $habitus;
    }

    public function delete_habitus(int $id)
    {
        // return Cache::remember('habitus_delete', 60, function () use ($id) {
        //     $habitus = Habitus::findOrFail($id);
        //     $habitus->delete();
        //     return $habitus;
        // });
        $habitus = Habitus::findOrFail($id);
        $habitus->delete();
        return $habitus;

    }

}
