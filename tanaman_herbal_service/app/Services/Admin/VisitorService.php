<?php
namespace App\Services\Admin;

use App\Models\Visitor;
use App\Models\VisitorCategory;
use App\Response\Response;
use Illuminate\Support\Facades\Auth;

class VisitorService
{
    public function get_visitors()
    {
        try {
            $visitors = Visitor::get();

            if ($visitors->isEmpty()) {
                return Response::error('Data not found', null, 404);
            }

            return $visitors;
        } catch (\Throwable $th) {
            return Response::error('Failed to get data visitors', $th->getMessage(), 500);
        }
    }

    public function create_visitor(array $data)
    {
        try {
            $admin = Auth::user();

            $visitor_category = VisitorCategory::withTrashed()->find($data['visitor_category_id']);
            if (! $visitor_category) {
                return Response::error('Visitor Category not found', null, 404);
            }

            $existing_visitor = Visitor::where('visitor_category_id', $data['visitor_category_id'])->first();
            if ($existing_visitor) {
                return Response::error('Visitor with this category already exists', null, 409);
            }

            $visitor = Visitor::create([
                'visitor_total'       => $data['visitor_total'],
                'visitor_category_id' => $data['visitor_category_id'],
                'created_by'          => $admin->id,
                'updated_by'          => $admin->id,
            ]);

            return $visitor;
        } catch (\Throwable $th) {
            return Response::error('Failed to create data visitors', $th->getMessage(), 500);
        }
    }

    public function get_detail_visitor(int $id)
    {
        try {
            $visitor = Visitor::find($id);
            if (! $visitor) {
                return Response::error('Data not found', null, 404);
            }

            return $visitor;
        } catch (\Throwable $th) {
            return Response::error('Failed to create data visitors', $th->getMessage(), 500);
        }
    }

    public function update_visitor(array $data, int $id)
    {
        try {
            $admin   = Auth::user();
            $visitor = Visitor::find($id);
            if (! $visitor) {
                return Response::error('Data not found', null, 404);
            }

            $visitor_category = VisitorCategory::withTrashed()->find($data['visitor_category_id']);
            if (! $visitor_category) {
                return Response::error('Visitor Category not found', null, 404);
            }

            $existing_visitor = Visitor::where('visitor_category_id', $data['visitor_category_id'])
                ->where('id', '!=', $id)
                ->first();
            if ($existing_visitor) {
                return Response::error('Visitor with this category already exists', null, 409);
            }

            $visitor->update([
                'visitor_total'       => $data['visitor_total'],
                'visitor_category_id' => $data['visitor_category_id'],
                'updated_by'          => $admin->id,
            ]);

            return $visitor;
        } catch (\Throwable $th) {
            return Response::error('Failed to updated data visitors', $th->getMessage(), 500);
        }
    }

    public function delete_visitor(int $id)
    {
        try {
            $visitor = Visitor::find($id);

            if (! $visitor) {
                return Response::error('Data not found', null, 404);
            }

            return $visitor->delete();
        } catch (\Throwable $th) {
            return Response::error('Failed to deleted data visitors', $th->getMessage(), 500);
        }
    }
}
