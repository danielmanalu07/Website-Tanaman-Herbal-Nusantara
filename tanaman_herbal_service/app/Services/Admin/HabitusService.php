<?php
namespace App\Services\Admin;

use App\Http\Repositories\HabitusRepository;
use App\Response\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class HabitusService
{
    protected $habitusRepo;
    public function __construct(HabitusRepository $habitusRepository)
    {
        $this->habitusRepo = $habitusRepository;
    }

    public function create_habitus(array $data)
    {
        try {
            $admin = Auth::user();

            $habitus = $this->habitusRepo->createHabitus([
                'name'       => $data['name'],
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ]);

            return $habitus;
        } catch (\Throwable $th) {
            return Response::error('Failed to create data habitus', $th->getMessage(), 500);
        }
    }

    public function get_all_habitus()
    {
        try {
            $habitus = $this->habitusRepo->get_all_habitus();
            if ($habitus->isEmpty()) {
                return Response::error('Data not found', null, 404);
            }

            return $habitus;
        } catch (\Throwable $th) {
            return Response::error('Failed to get data habitus', $th->getMessage(), 500);
        }
    }

    public function get_detail_habitus(int $id)
    {
        try {
            $habitus = $this->habitusRepo->get_detail_habitus($id);
            if (! $habitus) {
                return Response::error('data not found', null, '404');
            }

            return $habitus;
        } catch (ModelNotFoundException $e) {
            return Response::error('Data not found', $e->getMessage(), 404);
        } catch (\Throwable $th) {
            return Response::error('Failed to get data habitus', $th->getMessage(), 500);
        }
    }

    public function update_habitus(array $data, int $id)
    {
        try {
            $admin   = Auth::user();
            $habitus = $this->habitusRepo->get_detail_habitus($id);

            if (! $habitus) {
                return Response::error('data not found', null, '404');
            }

            $updatedData = [
                'name'       => $data['name'],
                'updated_by' => $admin->id,
            ];

            $updatedHabitus = $this->habitusRepo->update_habitus($id, $updatedData);

            return $updatedHabitus;
        } catch (ModelNotFoundException $e) {
            return Response::error('Data not found', $e->getMessage(), 404);
        } catch (\Throwable $th) {
            return Response::error('Failed to update habitus data', $th->getMessage(), 500);
        }
    }

    public function delete_habitus(int $id)
    {
        try {
            return $this->habitusRepo->delete_habitus($id);
        } catch (ModelNotFoundException $e) {
            return Response::error('Data not found', $e->getMessage(), 404);
        } catch (\Throwable $th) {
            return Response::error('Failed to delete habitus data', $th->getMessage(), 500);
        }
    }

}
