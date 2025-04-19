<?php
namespace App\Services\Admin;

use App\Helpers\TranslateHtmlContent;
use App\Http\Repositories\ContentRepository;
use App\Models\Language;
use App\Response\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Stichoza\GoogleTranslate\GoogleTranslate;

class ContentService
{
    private $contentRepository, $translatedHtml;
    public function __construct(ContentRepository $contentRepository, TranslateHtmlContent $translate_html_content)
    {
        $this->contentRepository = $contentRepository;
        $this->translatedHtml    = $translate_html_content;
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

            $languages  = Language::all();
            $sourceLang = currentLanguage()->code;

            $translator = new GoogleTranslate();
            $translator->setSource($sourceLang);

            foreach ($languages as $language) {
                if ($language->code == $sourceLang) {
                    $content->languages()->attach($language->id, [
                        'title'   => $content->title,
                        'content' => $content->content,
                    ]);
                } else {
                    try {
                        $translator->setTarget($language->code);
                        $translatedTitle = $translator->translate($content->title);
                        // $translatedContent = $translator->translate($news->content);
                        $translatedContent = $this->translatedHtml->translateHtmlContent($content->content, $translator, $sourceLang, $language->code);
                    } catch (\Exception $e) {
                        $translatedTitle   = $content->title;
                        $translatedContent = $content->content;
                    }

                    $content->languages()->attach($language->id, [
                        'title'   => $translatedTitle,
                        'content' => $translatedContent,
                    ]);
                }
            }

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
            $admin    = Auth::user();
            $contents = $this->contentRepository->get_detail($id);
            $newData  = array_merge($data, [
                'updated_by' => $admin->id,
            ]);
            $contentUpdate = $this->contentRepository->update($newData, $id);

            if (! empty($data['title']) && ! empty($data['content'])) {
                $languages  = Language::all();
                $sourceLang = currentLanguage()->code;

                $translator = new GoogleTranslate();
                $translator->setSource($sourceLang);

                $contentUpdate->languages()->detach();

                foreach ($languages as $language) {
                    if ($language->code == $sourceLang) {
                        $contents->languages()->attach($language->id, [
                            'title'   => $contents->title,
                            'content' => $contents->content,
                        ]);
                    } else {
                        try {
                            $translator->setTarget($language->code);
                            $translatedTitle = $translator->translate($contents->title);
                            // $translatedContent = $translator->translate($news->content);
                            $translatedContent = $this->translatedHtml->translateHtmlContent($contents->content, $translator, $sourceLang, $language->code);
                        } catch (\Exception $e) {
                            $translatedTitle   = $contents->title;
                            $translatedContent = $contents->content;
                        }

                        $contents->languages()->attach($language->id, [
                            'title'   => $translatedTitle,
                            'content' => $translatedContent,
                        ]);
                    }
                }
            }

            return $contentUpdate;
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

    public function update_status(int $id, bool $status)
    {
        try {
            $admin   = Auth::user();
            $content = $this->contentRepository->get_detail($id);

            $result = $this->contentRepository->update_status($id, $status);

            return $result;
        } catch (ModelNotFoundException $e) {
            return Response::error('Data not found', $e->getMessage(), 404);
        } catch (\Throwable $th) {
            return Response::error('Failed to update data content', $th->getMessage(), 500);
        }
    }
}
