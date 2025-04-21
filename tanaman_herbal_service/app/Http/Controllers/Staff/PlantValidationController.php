<?php
namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Resources\ValidationResource;
use App\Models\PlantValidation;
use App\Response\Response;
use App\Services\Staff\PlantValidationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlantValidationController extends Controller
{
    protected PlantValidationService $plantValidationService;

    public function __construct(PlantValidationService $plantValidationService)
    {
        $this->plantValidationService = $plantValidationService;
    }

    public function store(Request $request)
    {
        $request->validate([
            'plant_id'        => 'required|exists:plants,id',
            'date_validation' => 'required|date',
            'condition'       => 'required|string',
            'description'     => 'required|string',
            'images'          => 'required|array|min:1',
            'images.*'        => 'required|file|mimes:jpg,jpeg,png',
        ]);

        try {
            $validation = $this->plantValidationService->validatePlant($request->all());

            if (! $validation instanceof PlantValidation) {
                return $validation;
            }

            return response()->json([
                'success'     => true,
                'status_code' => 200,
                'message'     => 'Validation created successfully',
                'data'        => $validation->load(['plants', 'users', 'images']),
            ], 200);
        } catch (\Throwable $th) {
            return Response::error('Internal server error', $th->getMessage(), 500);
        }
    }

    public function get()
    {
        try {
            $validations = $this->plantValidationService->getValidation();
            if ($validations instanceof JsonResponse) {
                return $validations;
            }

            return Response::success('Retrieved Data Success', ValidationResource::collection($validations), 200);
        } catch (\Throwable $th) {
            return Response::error('Internal server error', $th->getMessage(), 500);
        }
    }

    public function get_detail(int $id)
    {
        try {
            $validation = $this->plantValidationService->getDetailValidation($id);
            if ($validation instanceof JsonResponse) {
                return $validation;
            }
            return Response::success('Retrieved Data Success', new ValidationResource($validation), 200);
        } catch (\Throwable $th) {
            return Response::error('Internal server error', $th->getMessage(), 500);
        }
    }
}
