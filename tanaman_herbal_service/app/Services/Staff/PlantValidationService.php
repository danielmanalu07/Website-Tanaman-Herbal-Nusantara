<?php
namespace App\Services\Staff;

use App\Http\Repositories\PlantValidationRepository;
use App\Models\Image;
use App\Response\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
                $formattedDate = Carbon::createFromFormat('Y-m-d', $data['date_validation'])->format('Y-m-d'); // date sudah Y-m-d dari Flutter

                $validation = $this->plant_val_repo->create([
                    'plant_id'        => $data['plant_id'],
                    'validator_id'    => $user->id,
                    'date_validation' => $formattedDate,
                    'condition'       => $data['condition'],
                    'description'     => $data['description'],
                ]);

                // ✅ Akses file langsung dari request helper
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
