<?php
namespace App\Http\Repositories;

use App\Models\PlantValidation;

class PlantValidationRepository
{
    public function create(array $data)
    {
        return PlantValidation::create($data);
    }

    public function attachImages($validation, array $imageIds)
    {
        return $validation->images()->attach($imageIds);
    }

    public function get_all()
    {
        return PlantValidation::all();
    }

    public function find(int $id)
    {
        return PlantValidation::findOrFail($id);
    }
}
