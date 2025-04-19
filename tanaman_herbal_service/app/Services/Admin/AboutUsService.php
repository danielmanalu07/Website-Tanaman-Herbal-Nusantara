<?php
namespace App\Services\Admin;

use App\Helpers\TranslateHtmlContent;
use App\Http\Repositories\AboutUsRepository;
use App\Models\Language;
use App\Response\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Stichoza\GoogleTranslate\GoogleTranslate;

class AboutUsService
{
    protected $aboutUsRepository, $translatedHtml;

    public function __construct(AboutUsRepository $aboutUsRepository, TranslateHtmlContent $translateHtmlContent)
    {
        $this->aboutUsRepository = $aboutUsRepository;
        $this->translatedHtml    = $translateHtmlContent;
    }

    public function create_aboutUs(array $data)
    {
        try {
            $admin = Auth::user();

            $about_us = $this->aboutUsRepository->create([
                 ...$data,
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ]);

            $languages  = Language::all();
            $sourceLang = currentLanguage()->code;

            $translator = new GoogleTranslate();
            $translator->setSource($sourceLang);

            foreach ($languages as $language) {
                if ($language->code == $sourceLang) {
                    $about_us->languages()->attach($language->id, [
                        'title' => $about_us->title,
                        'text'  => $about_us->text,
                    ]);
                } else {
                    try {
                        $translator->setTarget($language->code);
                        $translatedTitle = $translator->translate($about_us->title);
                        $translatedText  = $this->translatedHtml->translateHtmlContent($about_us->text, $translator, $sourceLang, $language->code);
                    } catch (\Exception $e) {
                        $translatedTitle = $about_us->title;
                        $translatedText  = $about_us->text;
                    }

                    $about_us->languages()->attach($language->id, [
                        'title' => $translatedTitle,
                        'text'  => $translatedText,
                    ]);
                }
            }

            return $about_us;
        } catch (\Throwable $th) {
            return Response::error("Failed to create about us data", $th->getMessage(), 500);
        }
    }

    public function get_all_about_us()
    {
        try {
            $about_us = $this->aboutUsRepository->get_all();
            if ($about_us->isEmpty()) {
                return Response::error('Data not found', null, 404);
            }
            return $about_us;
        } catch (\Throwable $th) {
            return Response::error("Failed to get about us data", $th->getMessage(), 500);
        }
    }

    public function get_detail_about_us(int $id)
    {
        try {
            $about_us = $this->aboutUsRepository->get_detail($id);
            if (! $about_us) {
                return Response::error('Data not found', null, 404);
            }
            return $about_us;
        } catch (\Throwable $th) {
            return Response::error("Failed to get about us data", $th->getMessage(), 500);
        }
    }

    public function update_about_us(array $data, int $id)
    {
        try {
            $admin    = Auth::user();
            $about_us = $this->aboutUsRepository->get_detail($id);
            if (! $about_us) {
                return Response::error('Data not found', null, 404);
            }
            $updateData = [
                'title'      => $data['title'],
                'text'       => $data['text'],
                'updated_by' => $admin->id,
            ];
            $about_us_update = $this->aboutUsRepository->update_about_us($updateData, $id);
            if (! empty($data['title']) && ! empty($data['text'])) {
                $languages  = Language::all();
                $sourceLang = currentLanguage()->code;

                $translator = new GoogleTranslate();
                $translator->setSource($sourceLang);
                $about_us_update->languages()->detach();

                foreach ($languages as $language) {
                    if ($language->code == $sourceLang) {
                        $about_us_update->languages()->attach($language->id, [
                            'title' => $about_us_update->title,
                            'text'  => $about_us_update->text,
                        ]);
                    } else {
                        try {
                            $translator->setTarget($language->code);
                            $translatedTitle = $translator->translate($about_us_update->title);
                            $translatedText  = $this->translatedHtml->translateHtmlContent($about_us_update->text, $translator, $sourceLang, $language->code);
                        } catch (\Exception $e) {
                            $translatedTitle = $about_us_update->title;
                            $translatedText  = $about_us_update->text;
                        }

                        $about_us_update->languages()->attach($language->id, [
                            'title' => $translatedTitle,
                            'text'  => $translatedText,
                        ]);
                    }
                }
            }
            return $about_us_update;
        } catch (\Throwable $th) {
            return Response::error("Failed to update about us data", $th->getMessage(), 500);
        }
    }

    public function delete_about_us(int $id)
    {
        try {
            return $this->aboutUsRepository->delete_about_us($id);
        } catch (ModelNotFoundException $e) {
            return Response::error('Data not found', $e->getMessage(), 404);
        } catch (\Throwable $th) {
            return Response::error("Failed to delete about us data", $th->getMessage(), 500);
        }
    }
}
