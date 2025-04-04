<?php
namespace App\Services\Admin;

use App\Http\Repositories\NewsRepository;
use App\Models\Image;
use App\Models\NewsImage;
use App\Response\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NewService
{
    protected $new_repo;

    public function __construct(NewsRepository $news_repository)
    {
        $this->new_repo = $news_repository;
    }

    public function create_news(array $data)
    {
        try {
            $admin = Auth::user();

            if (! isset($data['images']) || count($data['images']) < 1) {
                return Response::error('At least one image is required', null, 422);
            }

            $newData = array_merge($data, [
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ]);

            $news = $this->new_repo->create($newData);

            $imageIds = [];
            foreach ($data['images'] as $index => $image) {
                $ext        = $image->getClientOriginalExtension();
                $fileName   = "image_{$news->title}_{$index}" . '.' . $ext;
                $path       = $image->storeAs('news', $fileName, 'public');
                $imgModel   = Image::create(['image_path' => $path]);
                $imageIds[] = [
                    'news_id'  => $news->id,
                    'image_id' => $imgModel->id,
                ];
            }

            NewsImage::insert($imageIds);

            return $news;
        } catch (\Throwable $th) {
            return Response::error("Failed to create news data", $th->getMessage(), 500);
        }
    }

    public function get_all_news()
    {
        try {
            $news = $this->new_repo->getAll();
            if ($news->isEmpty()) {
                return Response::error('No news found', null, 404);
            }
            return $news;
        } catch (\Throwable $th) {
            return Response::error("Failed to get news data", $th->getMessage(), 500);
        }
    }

    public function get_detail_news(int $id)
    {
        try {
            $news = $this->new_repo->getDetail($id);
            if (! $news) {
                return Response::error('Data not found', null, 404);
            }

            return $news;
        } catch (\Throwable $th) {
            return Response::error("Failed to get news data", $th->getMessage(), 500);
        }
    }

    public function update_news(array $data, int $id)
    {
        try {
            $admin = Auth::user();
            $news  = $this->new_repo->getDetail($id);
            if (! $news) {
                return Response::error('Data not found', null, 404);
            }

            if (! empty($data['deleted_images']) && is_array($data['deleted_images'])) {
                foreach ($data['deleted_images'] as $imageId) {
                    $image = Image::find($imageId);
                    if ($image) {
                        Storage::disk('public')->delete($image->image_path);
                        $image->delete();
                    }
                }
            }

            if (! empty($data['new_images']) && is_array($data['new_images'])) {
                $imageIds = [];
                foreach ($data['new_images'] as $index => $image) {
                    if ($image->isValid()) {
                        $extension  = $image->getClientOriginalExtension();
                        $file_name  = "image_{$news->title}_{$index}" . '.' . $extension;
                        $path       = $image->storeAs('news', $file_name, 'public');
                        $imageModel = Image::create(['image_path' => $path]);

                        $imageIds[] = [
                            'news_id'  => $news->id,
                            'image_id' => $imageModel->id,
                        ];
                    }
                }

                if (! empty($imageIds)) {
                    NewsImage::insert($imageIds);
                }
            }

            $updateData               = array_filter($data, fn($value) => ! is_null($value));
            $updateData['updated_by'] = $admin->id;

            return $this->new_repo->update($updateData, $id);
        } catch (\Throwable $th) {
            return Response::error("Failed to update news data", $th->getMessage(), 500);
        }
    }

    public function delete_news(int $id)
    {
        try {
            return $this->new_repo->delete($id);
        } catch (ModelNotFoundException $e) {
            return Response::error('Data not found', $e->getMessage(), 404);
        } catch (\Throwable $th) {
            return Response::error("Failed to update news data", $th->getMessage(), 500);
        }
    }
}
