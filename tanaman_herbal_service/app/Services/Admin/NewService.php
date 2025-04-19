<?php
namespace App\Services\Admin;

use App\Helpers\TranslateHtmlContent;
use App\Http\Repositories\NewsRepository;
use App\Models\Image;
use App\Models\Language;
use App\Models\NewsImage;
use App\Response\Response;
use function App\Helpers\translateHtmlContent;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Stichoza\GoogleTranslate\GoogleTranslate;

class NewService
{
    protected $new_repo, $translatedHtml;

    public function __construct(NewsRepository $news_repository, TranslateHtmlContent $translate_html_content)
    {
        $this->new_repo       = $news_repository;
        $this->translatedHtml = $translate_html_content;
    }

    public function create_news(array $data)
    {
        try {
            $admin = Auth::user();

            if (empty($data['images']) || count($data['images']) < 1) {
                return Response::error('At least one image is required', null, 422);
            }

            $news = $this->new_repo->create([
                 ...$data,
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ]);

            $this->saveNewsImages($news->id, $data['images'], $news->title);

            $languages  = Language::all();
            $sourceLang = currentLanguage()->code;

            $translator = new GoogleTranslate();
            $translator->setSource($sourceLang);

            foreach ($languages as $language) {
                if ($language->code == $sourceLang) {
                    $news->languages()->attach($language->id, [
                        'title'   => $news->title,
                        'content' => $news->content,
                    ]);
                } else {
                    try {
                        $translator->setTarget($language->code);
                        $translatedTitle = $translator->translate($news->title);
                        // $translatedContent = $translator->translate($news->content);
                        $translatedContent = $this->translatedHtml->translateHtmlContent($news->content, $translator, $sourceLang, $language->code);
                    } catch (\Exception $e) {
                        $translatedTitle   = $news->title;
                        $translatedContent = $news->content;
                    }

                    $news->languages()->attach($language->id, [
                        'title'   => $translatedTitle,
                        'content' => $translatedContent,
                    ]);
                }
            }

            return $news;

        } catch (\Throwable $th) {
            return Response::error("Failed to create news data", $th->getMessage(), 500);
        }
    }

    private function saveNewsImages($newsId, $images, $newsTitle)
    {
        $imageRecords = [];

        foreach ($images as $index => $image) {
            $ext      = $image->getClientOriginalExtension();
            $fileName = 'image_' . str_replace(' ', '_', strtolower($newsTitle)) . "_{$index}." . $ext;
            $path     = $image->storeAs('news', $fileName, 'public');

            $imgModel = Image::create(['image_path' => $path]);

            $imageRecords[] = [
                'news_id'  => $newsId,
                'image_id' => $imgModel->id,
            ];
        }

        NewsImage::insert($imageRecords);
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
                $this->saveNewsImages($news->id, $data['new_images'], $news->title);
            }

            $updateData               = array_filter($data, fn($value) => ! is_null($value));
            $updateData['updated_by'] = $admin->id;

            $newsUpdate = $this->new_repo->update($updateData, $id);

            if (! empty($data['title'] && ! empty($data['content']))) {
                $languages  = Language::all();
                $sourceLang = currentLanguage()->code;

                $translator = new GoogleTranslate();
                $translator->setSource($sourceLang);

                $newsUpdate->languages()->detach();

                foreach ($languages as $language) {
                    if ($language->code == $sourceLang) {
                        $news->languages()->attach($language->id, [
                            'title'   => $news->title,
                            'content' => $news->content,
                        ]);
                    } else {
                        try {
                            $translator->setTarget($language->code);
                            $translatedTitle = $translator->translate($news->title);
                            // $translatedContent = $translator->translate($news->content);
                            $translatedContent = $this->translatedHtml->translateHtmlContent($news->content, $translator, $sourceLang, $language->code);
                        } catch (\Exception $e) {
                            $translatedTitle   = $news->title;
                            $translatedContent = $news->content;
                        }

                        $news->languages()->attach($language->id, [
                            'title'   => $translatedTitle,
                            'content' => $translatedContent,
                        ]);
                    }
                }
            }

            return $newsUpdate;
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

    public function update_status(int $id, array $data)
    {
        try {
            $admin = Auth::user();
            $new   = $this->new_repo->getDetail($id);

            $updateData = [
                'status'     => $data['status'],
                'updated_by' => $admin->id,
            ];

            if ($data['status'] && is_null($new->published_at)) {
                $updateData['published_at'] = now();
            }

            $result = $this->new_repo->update_status($id, $updateData);

            return $result;
        } catch (ModelNotFoundException $e) {
            return Response::error('Data not found', $e->getMessage(), 404);
        } catch (\Throwable $th) {
            return Response::error('Failed to update data plant', $th->getMessage(), 500);
        }
    }
}
