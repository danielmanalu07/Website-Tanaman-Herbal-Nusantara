<?php
namespace App\Services\Staff;

use App\Http\Repositories\PlantValidationRepository;
use App\Models\Image;
use App\Response\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PlantValidationService
{
    protected $plant_val_repo;

    public function __construct(PlantValidationRepository $plant_validation_repository)
    {
        $this->plant_val_repo = $plant_validation_repository;
    }

    public function validatePlant(array $data)
    {
        try {
            return DB::transaction(function () use ($data) {
                $user          = Auth::user();
                $formattedDate = Carbon::createFromFormat('Y-m-d', $data['date_validation'])->format('Y-m-d');

                $validation = $this->plant_val_repo->create([
                    'plant_id'        => $data['plant_id'],
                    'validator_id'    => $user->id,
                    'date_validation' => $formattedDate,
                    'condition'       => $data['condition'],
                    'description'     => $data['description'],
                ]);

                if (request()->hasFile('images')) {
                    $imageIds = [];
                    foreach (request()->file('images') as $imageFile) {
                        $path       = $imageFile->store('validation-images', 'public');
                        $image      = Image::create(['image_path' => $path]);
                        $imageIds[] = $image->id;
                    }
                    $this->plant_val_repo->attachImages($validation, $imageIds);
                }

                return $validation;
            });
        } catch (\Throwable $th) {
            return Response::error('Failed to validate data plant', $th->getMessage(), 500);
        }
    }

    public function edit_validation(array $data, int $id)
    {
        try {
            return DB::transaction(function () use ($data, $id) {
                $user          = Auth::user();
                $formattedDate = Carbon::createFromFormat('Y-m-d', $data['date_validation'])->format('Y-m-d');

                // Update data validasi
                $validation = $this->plant_val_repo->edit([
                    'plant_id'        => $data['plant_id'],
                    'validator_id'    => $user->id,
                    'date_validation' => $formattedDate,
                    'condition'       => $data['condition'],
                    'description'     => $data['description'],
                ], $id);

                if (! empty($data['delete_image']) && is_array($data['delete_image'])) {
                    foreach ($data['delete_image'] as $imageId) {
                        $image = Image::find($imageId);
                        if ($image) {
                            Storage::disk('public')->delete($image->image_path);
                            $validation->images()->detach($image->id);
                            $image->delete();
                        }
                    }
                }

                // 🟢 Tambahkan gambar baru jika ada
                if (request()->hasFile('images')) {
                    $imageIds = [];
                    foreach (request()->file('images') as $imageFile) {
                        $path       = $imageFile->store('validation-images', 'public');
                        $image      = Image::create(['image_path' => $path]);
                        $imageIds[] = $image->id;
                    }
                    $this->plant_val_repo->attachImages($validation, $imageIds);
                }

                return $validation;
            });
        } catch (\Throwable $th) {
            return Response::error('Failed to edit validation data plant', $th->getMessage(), 500);
        }
    }

    public function getValidation()
    {
        try {
            $validation = $this->plant_val_repo->get_all();
            if ($validation->isEmpty()) {
                return Response::error('Failed to get validation data plant', null, 500);
            }
            return $validation;
        } catch (\Throwable $th) {
            return Response::error('Failed to get validation data plant', $th->getMessage(), 500);
        }
    }
    public function getValidationByStaff()
    {
        try {
            $staff      = Auth::user();
            $validation = $this->plant_val_repo->get_all_by_staff($staff->id);
            if ($validation->isEmpty()) {
                return collect();
            }
            return $validation;
        } catch (\Throwable $th) {
            return Response::error('Failed to get validation data plant', $th->getMessage(), 500);
        }
    }

    public function getDetailValidation(int $id)
    {
        try {
            $validation = $this->plant_val_repo->find($id);
            if (! $validation) {
                return Response::error('Failed to get validation data plant', null, 500);
            }

            return $validation;
        } catch (\Throwable $th) {
            return Response::error('Failed to get validation data plant', $th->getMessage(), 500);
        }
    }

}
