<?php
namespace App\Services\Admin;

use App\Http\Repositories\HabitusRepository;
use App\Models\Language;
use App\Response\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Stichoza\GoogleTranslate\GoogleTranslate;

class HabitusService
{
    protected $habitusRepo;
    public function __construct(HabitusRepository $habitusRepository)
    {
        $this->habitusRepo = $habitusRepository;
    }

    private function uploadImage(UploadedFile $file, string $habitusName, $habitusId): string
    {
        $filename = 'image_' . str_replace(' ', '_', strtolower($habitusName)) . '_' . $habitusId . '.' . $file->getClientOriginalExtension();
        $path     = $file->storeAs('habitus', $filename, 'public');
        return Storage::url($path);
    }

    public function create_habitus(array $data)
    {
        try {
            $admin = Auth::user();

            if (! isset($data['image']) || ! ($data['image'] instanceof UploadedFile)) {
                return Response::error('Image is required and must be a valid file.', null, 422);
            }

            $id        = uniqid();
            $imagePath = $this->uploadImage($data['image'], $data['name'], $id);

            $habitus = $this->habitusRepo->createHabitus([
                'name'       => $data['name'],
                'image'      => $imagePath,
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ]);

            $languages  = Language::all();
            $sourceLang = currentLanguage()->code;
            $translator = new GoogleTranslate();
            $translator->setSource($sourceLang);

            foreach ($languages as $language) {
                if ($language->code == $sourceLang) {
                    $habitus->languages()->attach($language->id, [
                        'name' => $habitus->name,
                    ]);
                } else {
                    try {
                        $translator->setTarget($language->code);
                        $translatedTitle = $translator->translate($habitus->name);
                    } catch (\Exception $e) {
                        $translatedTitle = $habitus->name;
                    }

                    $habitus->languages()->attach($language->id, [
                        'name' => $translatedTitle,
                    ]);
                }
            }

            return $habitus;
        } catch (\Throwable $th) {
            return Response::error('Failed to create data habitus', $th->getMessage(), 500);
        }
    }

    public function get_all_habitus()
    {
        try {
            $habitus = $this->habitusRepo->get_all_habitus();
            if ($habitus == null) {
                return Response::error('Data not found', null, 404);
            }

            return $habitus;
        } catch (\Throwable $th) {
            return Response::error('Failed to get data habitus', $th->getMessage(), 500);
        }
    }

    public function get_detail_habitus(int $id)
    {
        try {
            $habitus = $this->habitusRepo->get_detail_habitus($id);
            if (! $habitus) {
                return Response::error('data not found', null, '404');
            }

            return $habitus;
        } catch (ModelNotFoundException $e) {
            return Response::error('Data not found', $e->getMessage(), 404);
        } catch (\Throwable $th) {
            return Response::error('Failed to get data habitus', $th->getMessage(), 500);
        }
    }

    public function update_habitus(array $data, int $id)
    {
        try {
            $admin   = Auth::user();
            $habitus = $this->habitusRepo->get_detail_habitus($id);

            $updatedData = [
                'name'       => $data['name'],
                'updated_by' => $admin->id,
            ];

            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                $imagePath            = $this->uploadImage($data['image'], $data['name'], $habitus->id);
                $updatedData['image'] = $imagePath;
            }

            $updatedHabitus = $this->habitusRepo->update_habitus($id, $updatedData);

            if (! empty($data['name'])) {
                $languages  = Language::all();
                $sourceLang = currentLanguage()->code; // Misal 'id' atau 'en'

                $translator = new GoogleTranslate();
                $translator->setSource($sourceLang); // Set source

                foreach ($languages as $language) {
                    if ($language->code == $sourceLang) {
                        // Update existing pivot
                        $habitus->languages()->updateExistingPivot($language->id, [
                            'name' => $updatedHabitus->name,
                        ]);
                    } else {
                        try {
                            $translator->setTarget($language->code);
                            $translatedTitle = $translator->translate($updatedHabitus->name);
                        } catch (\Exception $e) {
                            $translatedTitle = $updatedHabitus->name;
                        }

                        // Update existing pivot
                        $habitus->languages()->updateExistingPivot($language->id, [
                            'name' => $translatedTitle,
                        ]);
                    }
                }
            }

            return $updatedHabitus;
        } catch (ModelNotFoundException $e) {
            return Response::error('Data not found', $e->getMessage(), 404);
        } catch (\Throwable $th) {
            return Response::error('Failed to update habitus data', $th->getMessage(), 500);
        }
    }

    public function delete_habitus(int $id)
    {
        try {
            return $this->habitusRepo->delete_habitus($id);
        } catch (ModelNotFoundException $e) {
            return Response::error('Data not found', $e->getMessage(), 404);
        } catch (\Throwable $th) {
            return Response::error('Failed to delete habitus data', $th->getMessage(), 500);
        }
    }

}
