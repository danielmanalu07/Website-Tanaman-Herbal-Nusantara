<?php
namespace App\Http\Controllers\Staff;

use App\Exports\PlantValidationExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\ValidationResource;
use App\Models\PlantValidation;
use App\Response\Response;
use App\Services\Staff\PlantValidationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

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

    public function update(Request $request, int $id)
    {
        $request->validate([
            'plant_id'        => 'required|exists:plants,id',
            'date_validation' => 'required|date',
            'condition'       => 'required|string',
            'description'     => 'required|string',
            'delete_image'    => 'nullable|array',
            'delete_image.*'  => 'integer|exists:images,id',
            'images'          => 'nullable|array',
            'images.*'        => 'file|mimes:jpg,jpeg,png',
        ]);

        try {
            $validation = $this->plantValidationService->edit_validation($request->all(), $id);

            if (! $validation instanceof PlantValidation) {
                return $validation;
            }

            return Response::success('Validation updated successfully', new ValidationResource($validation), 200);
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

    public function getByStaff()
    {
        try {
            $validations = $this->plantValidationService->getValidationByStaff();
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

    public function export()
    {
        try {
            $staff = Auth::user();
            return Excel::download(new PlantValidationExport($staff->id), 'validation.xlsx');
        } catch (\Throwable $th) {
            return Response::error('Internal server error', $th->getMessage(), 500);
        }
    }
}
