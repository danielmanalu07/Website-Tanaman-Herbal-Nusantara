<?php
namespace App\Services\Admin;

use App\Http\Repositories\LandRepository;
use App\Response\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class LandService
{
    protected $landRepo;

    public function __construct(LandRepository $land_repository)
    {
        $this->landRepo = $land_repository;
    }

    public function create_land(array $data)
    {
        try {
            $admin = Auth::user();

            $land = $this->landRepo->create_land([
                'name'       => $data['name'],
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ]);

            return $land;
        } catch (\Throwable $th) {
            return Response::error('Failed to create data land', $th->getMessage(), 500);
        }
    }

    public function get_all_lands()
    {
        try {
            $lands = $this->landRepo->get_all_lands();
            if ($lands->isEmpty()) {
                return Response::error('Data not found', null, 404);
            }

            return $lands;
        } catch (\Throwable $th) {
            return Response::error('Failed to get data lands', $th->getMessage(), 500);
        }
    }

    public function get_detail_land(int $id)
    {
        try {
            $land = $this->landRepo->get_all_by_id($id);

            if (is_null($land)) {
                return Response::error('Data not found', null, 404);
            }

            return $land;
        } catch (ModelNotFoundException $e) {
            return Response::error('Data not found', $e->getMessage(), 404);
        } catch (\Throwable $th) {
            return Response::error('Failed to get data lands', $th->getMessage(), 500);
        }
    }

    public function update_land(array $data, int $id)
    {
        try {
            $admin = Auth::user();
            $land  = $this->landRepo->get_all_by_id($id);

            if (! $land) {
                return Response::error('Data not found', null, 404);
            }

            $updateData = [
                'name'       => $data['name'],
                'updated_by' => $admin->id,
            ];

            return $this->landRepo->update_land($id, $updateData);
        } catch (ModelNotFoundException $e) {
            return Response::error('Data not found', $e->getMessage(), 404);
        } catch (\Throwable $th) {
            return Response::error('Failed to get data lands', $th->getMessage(), 500);
        }
    }

    public function delete_land(int $id)
    {
        try {
            return $this->landRepo->delete_land($id);
        } catch (ModelNotFoundException $e) {
            return Response::error('Data not found', $e->getMessage(), 404);
        } catch (\Throwable $th) {
            return Response::error('Failed to delete lands', $th->getMessage(), 500);
        }
    }
}
