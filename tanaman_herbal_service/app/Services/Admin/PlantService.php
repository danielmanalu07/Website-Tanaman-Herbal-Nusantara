<?php
namespace App\Services\Admin;

use App\Helpers\TranslateHtmlContent;
use App\Http\Repositories\PlantRepository;
use App\Models\Habitus;
use App\Models\Image;
use App\Models\Language;
use App\Models\PlantImage;
use App\Response\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Stichoza\GoogleTranslate\GoogleTranslate;

class PlantService
{
    protected $plantRepo, $translate_html;

    public function __construct(PlantRepository $plant_repository, TranslateHtmlContent $translateHtmlContent)
    {
        $this->plantRepo      = $plant_repository;
        $this->translate_html = $translateHtmlContent;
    }
    public function create_plant(array $data)
    {
        try {
            $admin = Auth::user();

            $habitus = Habitus::withTrashed()->find($data['habitus_id']);
            if (! $habitus) {
                return Response::error('Habitus not found', null, 404);
            }

            if (! isset($data['images']) || count($data['images']) < 1) {
                return Response::error('At least one image is required', null, 422);
            }

            $plantData = array_merge($data, [
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ]);
            $plant = $this->plantRepo->create_plant($plantData);

            $imageIds = [];
            foreach ($data['images'] as $index => $image) {
                $extension  = $image->getClientOriginalExtension();
                $file_name  = "image_{$plant->latin_name}_{$index}" . '.' . $extension;
                $path       = $image->storeAs('plant', $file_name, 'public');
                $imageModel = Image::create(['image_path' => $path]);
                $imageIds[] = [
                    'plant_id' => $plant->id,
                    'image_id' => $imageModel->id,
                ];
            }

            PlantImage::insert($imageIds);

            $languages  = Language::all();
            $sourceLang = currentLanguage()->code;

            $translator = new GoogleTranslate();
            $translator->setSource($sourceLang);

            foreach ($languages as $language) {
                if ($language->code == $sourceLang) {
                    $plant->languages()->attach($language->id, [
                        'name'                => $plant->name,
                        'advantage'           => $plant->advantage,
                        'ecology'             => $plant->ecology,
                        'endemic_information' => $plant->endemic_information,
                    ]);
                } else {
                    try {
                        $translator->setTarget($language->code);
                        $translatedName               = $translator->translate($plant->name);
                        $translatedAdvantage          = $this->translate_html->translateHtmlContent($plant->advantage, $translator, $sourceLang, $language->code);
                        $translatedEcology            = $translator->translate($plant->ecology);
                        $translatedEndemicInformation = $translator->translate($plant->endemic_information);
                    } catch (\Exception $th) {
                        $translatedName               = $plant->name;
                        $translatedAdvantage          = $plant->advantage;
                        $translatedEcology            = $plant->ecology;
                        $translatedEndemicInformation = $plant->endemic_information;
                    }

                    $plant->languages()->attach($language->id, [
                        'name'                => $translatedName,
                        'advantage'           => $translatedAdvantage,
                        'ecology'             => $translatedEcology,
                        'endemic_information' => $translatedEndemicInformation,
                    ]);
                }
            }

            if (! $plant->qrcode) {
                $qrData = "http://127.0.0.1:8001/our-garden/plant/$plant->id";
                $qrCode = QrCode::format('png')->size(200)->generate($qrData);

                $qrPath = "qrcodes/plants_{$plant->latin_name}.png";
                Storage::disk('public')->put($qrPath, $qrCode);

                $plant->update(['qrcode' => $qrPath]);
            }

            return $plant;

        } catch (\Throwable $th) {
            return Response::error('Failed to create data plant', $th->getMessage(), 500);
        }
    }

    public function get_all_plant()
    {
        try {
            $plants = $this->plantRepo->get_all_plant();
            if ($plants->isEmpty()) {
                return Response::error('Data not found', null, 404);
            }
            return $plants;
        } catch (\Throwable $th) {
            return Response::error('Failed to get data plant', $th->getMessage(), 500);
        }
    }

    public function get_detail_plant(int $id)
    {
        try {
            $plant = $this->plantRepo->get_detail_plant($id);

            if (is_null($plant)) {
                return Response::error('Data not found', null, 404);
            }

            return $plant;
        } catch (ModelNotFoundException $e) {
            return Response::error('Data not found', $e->getMessage(), 404);
        } catch (\Throwable $th) {
            return Response::error('Failed to get data plant', $th->getMessage(), 500);
        }
    }

    public function update_plant(array $data, int $id)
    {
        try {
            $admin = Auth::user();
            $plant = $this->plantRepo->get_detail_plant($id);
            if (! $plant) {
                return Response::error('Data not found', null, 404);
            }

            $habitus = Habitus::withTrashed()->find($data['habitus_id']);
            if (! $habitus) {
                return Response::error('Habitus not found', null, 404);
            }

            if ($plant->qrcode && Storage::disk('public')->exists($plant->qrcode)) {
                Storage::disk('public')->delete($plant->qrcode);
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
                        $file_name  = "image_{$plant->latin_name}_{$index}" . '.' . $extension;
                        $path       = $image->storeAs('plant', $file_name, 'public');
                        $imageModel = Image::create(['image_path' => $path]);

                        $imageIds[] = [
                            'plant_id' => $plant->id,
                            'image_id' => $imageModel->id,
                        ];
                    }
                }

                if (! empty($imageIds)) {
                    PlantImage::insert($imageIds);
                }
            }

            $qrData = "http://127.0.0.1:8001/our-garden/plant/$plant->id";
            $qrCode = QrCode::format('png')->size(200)->generate($qrData);

            $qrPath = "qrcodes/plants_{$data['name']}.png";
            Storage::disk('public')->put($qrPath, $qrCode);

            $updateData = array_merge($data, [
                'qrcode'     => $qrPath,
                'updated_by' => $admin->id,
            ]);

            $plantUpdate = $this->plantRepo->update_plant($updateData, $id);

            if (! empty($data['name']) && ! empty($data['advantage']) && ! empty($data['ecology']) && ! empty($data['endemic_information'])) {
                $languages  = Language::all();
                $sourceLang = currentLanguage()->code;

                $translator = new GoogleTranslate();
                $translator->setSource($sourceLang);

                foreach ($languages as $language) {
                    if ($language->code == $sourceLang) {
                        $plant->languages()->attach($language->id, [
                            'name'                => $plant->name,
                            'advantage'           => $plant->advantage,
                            'ecology'             => $plant->ecology,
                            'endemic_information' => $plant->endemic_information,
                        ]);
                    } else {
                        try {
                            $translator->setTarget($language->code);
                            $translatedName               = $translator->translate($plant->name);
                            $translatedAdvantage          = $this->translate_html->translateHtmlContent($plant->advantage, $translator, $sourceLang, $language->code);
                            $translatedEcology            = $translator->translate($plant->ecology);
                            $translatedEndemicInformation = $translator->translate($plant->endemic_information);
                        } catch (\Exception $th) {
                            $translatedName               = $plant->name;
                            $translatedAdvantage          = $plant->advantage;
                            $translatedEcology            = $plant->ecology;
                            $translatedEndemicInformation = $plant->endemic_information;
                        }

                        $plant->languages()->attach($language->id, [
                            'name'                => $translatedName,
                            'advantage'           => $translatedAdvantage,
                            'ecology'             => $translatedEcology,
                            'endemic_information' => $translatedEndemicInformation,
                        ]);
                    }
                }
            }

            return $plantUpdate;
        } catch (ModelNotFoundException $e) {
            return Response::error('Data not found', $e->getMessage(), 404);
        } catch (\Throwable $th) {
            return Response::error('Failed to update data plant', $th->getMessage(), 500);
        }
    }

    public function delete_plant(int $id)
    {
        try {
            return $this->plantRepo->delete_plant($id);
        } catch (ModelNotFoundException $e) {
            return Response::error('Data not found', $e->getMessage(), 404);
        } catch (\Throwable $th) {
            return Response::error('Failed to delete data plant', $th->getMessage(), 500);
        }
    }

    public function update_status(int $id, bool $status)
    {
        try {
            $admin = Auth::user();
            $plant = $this->plantRepo->get_detail_plant($id);

            $updateData = [
                'status'     => $status,
                'updated_by' => $admin->id,
            ];
            $result = $this->plantRepo->update_status($id, $status);

            return $result;
        } catch (ModelNotFoundException $e) {
            return Response::error('Data not found', $e->getMessage(), 404);
        } catch (\Throwable $th) {
            return Response::error('Failed to update data plant', $th->getMessage(), 500);
        }
    }

    public function getQrCode($fileName)
    {
        $path = "qrcodes/{$fileName}";

        if (! Storage::disk('public')->exists($path)) {
            return Response::error('QR Code not found', null, 404);
        }

        $url = asset("storage/{$path}");

        return Response::success('QR Code retrieved successfully', ['url' => $url], 200);
    }

}
