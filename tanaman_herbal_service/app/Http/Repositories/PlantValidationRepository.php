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

    public function get_all_by_staff($id)
    {
        return PlantValidation::where('validator_id', $id)->get();
    }

    public function find(int $id)
    {
        return PlantValidation::findOrFail($id);
    }

    public function edit(array $data, int $id)
    {
        $validation = PlantValidation::findOrFail($id);
        $validation->update($data);
        return $validation;
    }

}
