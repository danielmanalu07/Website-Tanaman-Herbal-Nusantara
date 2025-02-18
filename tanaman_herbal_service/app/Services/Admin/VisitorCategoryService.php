<?php
namespace App\Services\Admin;

use App\Models\VisitorCategory;
use App\Response\Response;
use Illuminate\Support\Facades\Auth;

class VisitorCategoryService
{
    public function get_VisitorCategories()
    {
        try {
            $visitorCategories = VisitorCategory::get();

            if ($visitorCategories->isEmpty()) {
                return Response::error('Data not found', null, 404);
            }

            return $visitorCategories;
        } catch (\Throwable $th) {
            return Response::error('Failed to get data', $th->getMessage(), 500);
        }
    }

    public function create_visitorCategory(array $data)
    {
        try {
            $admin = Auth::user();

            $visitorCategory = VisitorCategory::create([
                'name'       => $data['name'],
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ]);

            return $visitorCategory;
        } catch (\Throwable $th) {
            return Response::error('Failed to create data', $th->getMessage(), 500);
        }
    }

    public function get_detail_visitorCategory(int $id)
    {
        try {
            $visitorCategory = VisitorCategory::find($id);

            if (! $visitorCategory) {
                return Response::error('Data not found', null, 404);
            }

            return $visitorCategory;
        } catch (\Throwable $th) {
            return Response::error('Failed to get data', $th->getMessage(), 500);
        }
    }

    public function update_visitorCategory(array $data, int $id)
    {
        try {
            $user            = Auth::user();
            $visitorCategory = VisitorCategory::find($id);

            if (! $visitorCategory) {
                return Response::error('Data not found', null, 404);
            }

            $visitorCategory->update([
                'name'       => $data['name'],
                'updated_by' => $user->id,
            ]);

            return $visitorCategory;
        } catch (\Throwable $th) {
            return Response::error('Failed to update data', $th->getMessage(), 500);
        }
    }

    public function delete_visitorCategory($id)
    {
        try {
            $visitorCategory = VisitorCategory::find($id);

            if (! $visitorCategory) {
                return Response::error('Data not found', null, 404);
            }

            return $visitorCategory->delete();
        } catch (\Throwable $th) {
            return Response::error('Failed to delete data', $th->getMessage(), 500);
        }
    }

}
