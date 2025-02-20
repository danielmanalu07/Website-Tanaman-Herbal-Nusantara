<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\VisitorResource;
use App\Response\Response;
use App\Services\Admin\VisitorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    protected $visitorService;
    public function __construct(VisitorService $visitorService)
    {
        $this->visitorService = $visitorService;
    }

    public function getVisitors()
    {
        try {
            $visitors = $this->visitorService->get_visitors();

            if ($visitors instanceof JsonResponse) {
                return $visitors;
            }

            return Response::success('Get data successfully', VisitorResource::collection($visitors), 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    public function createVisitor(Request $request)
    {
        $request->validate([
            'visitor_total'       => 'required|numeric',
            'visitor_category_id' => 'required',
        ]);

        try {
            $visitor = $this->visitorService->create_visitor($request->all());

            if ($visitor instanceof JsonResponse) {
                return $visitor;
            }

            return Response::success('Created visitor successfully', new VisitorResource($visitor), 201);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    public function getDetailVisitor(int $id)
    {
        try {
            $data = $this->visitorService->get_detail_visitor($id);
            if ($data instanceof JsonResponse) {
                return $data;
            }
            return Response::success('Get data successfully', new VisitorResource($data), 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    public function updateVisitor(Request $request, int $id)
    {
        $request->validate([
            'visitor_total'       => 'required|numeric',
            'visitor_category_id' => 'required',
        ]);
        try {
            $data = $this->visitorService->update_visitor($request->all(), $id);
            if ($data instanceof JsonResponse) {
                return $data;
            }

            return Response::success('Updated Successfully', new VisitorResource($data), 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }

    public function deleteVisitor(int $id)
    {
        try {
            $result = $this->visitorService->delete_visitor($id);
            if ($result instanceof JsonResponse) {
                return $result;
            }
            return Response::success('Deleted Successfully', null, 200);
        } catch (\Throwable $th) {
            return Response::error('internal server error', $th->getMessage(), 500);
        }
    }
}
