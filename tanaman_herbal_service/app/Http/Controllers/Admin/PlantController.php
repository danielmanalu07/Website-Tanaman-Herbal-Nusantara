<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlantResource;
use App\Response\Response;
use App\Services\Admin\PlantService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    protected $plant_service;

    public function __construct(PlantService $plant_service)
    {
        $this->plant_service = $plant_service;
    }

    public function createPlant(Request $request)
    {
        $request->validate([
            'name'                => 'required|string',
            'latin_name'          => 'required|string',
            'advantage'           => 'required',
            'ecology'             => 'required|string',
            'endemic_information' => 'required',
            'habitus_id'          => 'required',
            'images'              => 'required|array|min:1',
            'images.*'            => 'image|mimes:jpeg,png,jpg',
        ]);

        try {
            $result = $this->plant_service->create_plant($request->all());
            if ($result instanceof JsonResponse) {
                return $result;
            }

            return Response::success('Created plant successfully', new PlantResource($result), 201);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    public function getAllPlant()
    {
        try {
            $result = $this->plant_service->get_all_plant();

            if ($result instanceof JsonResponse) {
                return $result;
            }

            return Response::success('Get data successfully', PlantResource::collection($result), 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    public function getDetailPlant(int $id)
    {
        try {
            $result = $this->plant_service->get_detail_plant($id);
            if ($result instanceof JsonResponse) {
                return $result;
            }

            return Response::success('Get data successfully', new PlantResource($result), 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    public function updatePlant(Request $request, int $id)
    {
        $validatedData = $request->validate([
            'name'                => 'required|string',
            'latin_name'          => 'required|string',
            'advantage'           => 'required',
            'ecology'             => 'required|string',
            'endemic_information' => 'required',
            'habitus_id'          => 'required',
            'new_images'          => 'nullable|array|min:1',
            'new_images.*'        => 'image|mimes:jpeg,png,jpg',
            'deleted_images'      => 'nullable|array',
            'deleted_images.*'    => 'integer|exists:images,id',
        ]);

        try {
            $data = [
                'name'                => $validatedData['name'],
                'latin_name'          => $validatedData['latin_name'],
                'advantage'           => $validatedData['advantage'],
                'ecology'             => $validatedData['ecology'],
                'endemic_information' => $validatedData['endemic_information'],
                'habitus_id'          => $validatedData['habitus_id'],
                'new_images'          => $request->file('new_images') ?? [],
                'deleted_images'      => $request->input('deleted_images', []),
            ];

            $result = $this->plant_service->update_plant($data, $id);

            return Response::success('Updated Successfully', new PlantResource($result), 200);
        } catch (\Throwable $th) {
            return Response::error('Internal Server Error', $th->getMessage(), 500);
        }
    }

    public function deletePlant(int $id)
    {
        try {
            $result = $this->plant_service->delete_plant($id);
            if ($result instanceof JsonResponse) {
                return $result;
            }

            return Response::success('Delete Plant Successfully', null, 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    public function updateStatus(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|boolean',
        ]);
        try {
            $result = $this->plant_service->update_status($id, $request->status);
            if ($result instanceof JsonResponse) {
                return $result;
            }
            return Response::success('Update Status Successfully', new PlantResource($result), 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }
}
