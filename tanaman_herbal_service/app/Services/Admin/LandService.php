<?php
namespace App\Services\Admin;

use App\Http\Repositories\LandRepository;
use App\Models\Language;
use App\Response\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Stichoza\GoogleTranslate\GoogleTranslate;

class LandService
{
    protected $landRepo;

    public function __construct(LandRepository $land_repository)
    {
        $this->landRepo = $land_repository;
    }
    private function uploadImage(UploadedFile $file, string $landName, $landId): string
    {
        $filename = 'image_' . str_replace(' ', '_', strtolower($landName)) . '_' . $landId . '.' . $file->getClientOriginalExtension();
        $path     = $file->storeAs('lands', $filename, 'public');
        return Storage::url($path);
    }

    public function create_land(array $data)
    {
        try {
            $admin    = Auth::user();
            $landData = array_merge($data, [
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ]);

            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                $id                = uniqid();
                $imagePath         = $this->uploadImage($data['image'], $data['name'], $id);
                $landData['image'] = $imagePath;
            }
            $land = $this->landRepo->create_land($landData);

            if (! empty($landData['plants'])) {
                $land->plants()->sync($landData['plants']);
            }

            $this->updateTranslations($land, $land->name);
            return $land;
        } catch (\Throwable $th) {
            return Response::error('Failed to create data land', $th->getMessage(), 500);
        }
    }

    public function get_all_lands()
    {
        try {
            $lands = $this->landRepo->get_all_lands();
            if ($lands->isEmpty()) {
                return Response::error('Data not found', null, 404);
            }

            return $lands;
        } catch (\Throwable $th) {
            return Response::error('Failed to get data lands', $th->getMessage(), 500);
        }
    }

    public function get_detail_land(int $id)
    {
        try {
            $land = $this->landRepo->get_all_by_id($id);

            if (is_null($land)) {
                return Response::error('Data not found', null, 404);
            }

            return $land;
        } catch (ModelNotFoundException $e) {
            return Response::error('Data not found', $e->getMessage(), 404);
        } catch (\Throwable $th) {
            return Response::error('Failed to get data lands', $th->getMessage(), 500);
        }
    }

    public function update_land(array $data, int $id)
    {
        try {
            $admin = Auth::user();
            $land  = $this->landRepo->get_all_by_id($id);

            if (! $land) {
                return Response::error('Data not found', null, 404);
            }

            $updateData = [
                'name'       => $data['name'],
                'updated_by' => $admin->id,
            ];

            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                $imagePath           = $this->uploadImage($data['image'], $data['name'], $land->id);
                $updateData['image'] = $imagePath;
            }

            if (! empty($data['plants'])) {
                $land->plants()->sync($data['plants']);
            }

            $updateLand = $this->landRepo->update_land($id, $updateData);

            if (! empty($data['name'])) {
                $this->updateTranslations($updateLand, $data['name']);
            }
            return $updateLand;
        } catch (ModelNotFoundException $e) {
            return Response::error('Data not found', $e->getMessage(), 404);
        } catch (\Throwable $th) {
            return Response::error('Failed to get data lands', $th->getMessage(), 500);
        }
    }

    public function delete_land(int $id)
    {
        try {
            return $this->landRepo->delete_land($id);
        } catch (ModelNotFoundException $e) {
            return Response::error('Data not found', $e->getMessage(), 404);
        } catch (\Throwable $th) {
            return Response::error('Failed to delete lands', $th->getMessage(), 500);
        }
    }

    private function updateTranslations($land, string $name)
    {
        $languages  = Language::all();
        $sourceLang = currentLanguage()->code;
        $translator = new GoogleTranslate();
        $translator->setSource($sourceLang);

        // Clear existing translations
        $land->languages()->detach();

        // Add new translations
        foreach ($languages as $language) {
            $translatedName = $name;

            if ($language->code !== $sourceLang) {
                try {
                    $translator->setTarget($language->code);
                    $translatedName = $translator->translate($name);
                } catch (\Exception $e) {
                    $translatedName = $name;
                }
            }

            $land->languages()->attach($language->id, [
                'name' => $translatedName,
            ]);
        }
    }
}
