<?php
namespace App\Services\Admin;

use App\Http\Repositories\ContentRepository;
use App\Response\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class ContentService
{
    private $contentRepository;
    public function __construct(ContentRepository $contentRepository)
    {
        $this->contentRepository = $contentRepository;
    }
    public function create_content(array $data)
    {
        try {
            $admin = Auth::user();

            $newData = array_merge($data, [
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ]);
            $content = $this->contentRepository->create($newData);
            return $content;
        } catch (\Throwable $th) {
            return Response::error("Failed to create news data", $th->getMessage(), 500);
        }
    }

    public function get_all_content()
    {
        try {
            $content = $this->contentRepository->get_all();
            if ($content->isEmpty()) {
                return Response::error('No content found', null, 404);
            }
            return $content;
        } catch (ModelNotFoundException $e) {
            return Response::error('Data not found', $e->getMessage(), 404);
        } catch (\Throwable $th) {
            return Response::error("Failed to create news data", $th->getMessage(), 500);
        }
    }

    public function get_detail_content(int $id)
    {
        try {
            $content = $this->contentRepository->get_detail($id);
            if (! $content) {
                return Response::error('Content not found', null, 404);
            }
            return $content;
        } catch (ModelNotFoundException $e) {
            return Response::error('Data not found', $e->getMessage(), 404);
        } catch (\Throwable $th) {
            return Response::error("Failed to create news data", $th->getMessage(), 500);
        }
    }

    public function update_content(array $data, int $id)
    {
        try {
            $admin   = Auth::user();
            $newData = array_merge($data, [
                'updated_by' => $admin->id,
            ]);
            $content = $this->contentRepository->update($newData, $id);
            return $content;
        } catch (ModelNotFoundException $e) {
            return Response::error('Data not found', $e->getMessage(), 404);
        } catch (\Throwable $th) {
            return Response::error("Failed to create news data", $th->getMessage(), 500);
        }
    }

    public function delete_content(int $id)
    {
        try {
            $content = $this->contentRepository->delete($id);
            return $content;
        } catch (ModelNotFoundException $e) {
            return Response::error('Data not found', $e->getMessage(), 404);
        } catch (\Throwable $th) {
            return Response::error("Failed to create news data", $th->getMessage(), 500);
        }
    }
}
