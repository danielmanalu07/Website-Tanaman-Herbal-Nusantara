<?php
namespace App\Services\Admin;

use App\Models\Language;
use App\Models\VisitorCategory;
use App\Response\Response;
use Illuminate\Support\Facades\Auth;
use Stichoza\GoogleTranslate\GoogleTranslate;

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

            $existingCategory = VisitorCategory::withTrashed()
                ->where('name', $data['name'])
                ->first();

            if ($existingCategory) {
                if ($existingCategory->trashed()) {
                    // Restore the soft-deleted category
                    $existingCategory->restore();
                    // Update the category with new data
                    $existingCategory->update([
                        'name'       => $data['name'],
                        'updated_by' => $admin->id,
                    ]);
                    // Update translations
                    $this->updateTranslations($existingCategory, $data['name']);
                    return $existingCategory->load('languages');
                } else {
                    return Response::error('Category already exists', null, 409);
                }
            }

            // Create new category if no existing one found
            $visitorCategory = VisitorCategory::create([
                'name'       => $data['name'],
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ]);
            $this->updateTranslations($visitorCategory, $data['name']);

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

            if (! empty($data['name'])) {
                $this->updateTranslations($visitorCategory, $data['name']);
            }

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

            $visitorCategory->languages()->detach();
            return $visitorCategory->delete();
        } catch (\Throwable $th) {
            return Response::error('Failed to delete data', $th->getMessage(), 500);
        }
    }

    private function updateTranslations(VisitorCategory $visitorCategory, string $name)
    {
        $languages  = Language::all();
        $sourceLang = currentLanguage()->code;
        $translator = new GoogleTranslate();
        $translator->setSource($sourceLang);

        // Clear existing translations
        $visitorCategory->languages()->detach();

        // Add new translations
        foreach ($languages as $language) {
            $translatedName = $name;

            if ($language->code !== $sourceLang) {
                try {
                    $translator->setTarget($language->code);
                    $translatedName = $translator->translate($name);
                } catch (\Exception $e) {
                    // Fallback to original name if translation fails
                    $translatedName = $name;
                }
            }

            $visitorCategory->languages()->attach($language->id, [
                'name' => $translatedName,
            ]);
        }
    }

}
