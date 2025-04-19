<?php
namespace App\Service;

use App\Http\Constant\ApiConstant;
use App\Http\Constant\LanguageConstant;
use App\Http\Constant\TokenConstant;
use App\Http\Resources\PlantResource;
use Illuminate\Support\Facades\Http;

class PlantService
{
    private $api_url;
    private $token, $language;

    public function __construct(TokenConstant $token, LanguageConstant $languageConstant)
    {
        $this->token    = $token;
        $this->api_url  = ApiConstant::BASE_URL;
        $this->language = $languageConstant;
    }

    public function get_all_plant()
    {
        try {
            $token    = $this->token->GetToken();
            $lang     = $this->language->GetLanguage();
            $response = Http::withHeaders([
                'Authorization'   => "Bearer {$token}",
                'Accept-Language' => "{$lang}",
            ])->get("{$this->api_url}/plant");

            $result = $response->json();
            if ($response->failed()) {
                return collect();
            }
            $collection = collect($result['data'])->map(function ($item) {
                return (object) $item;
            });
            return PlantResource::collection($collection);
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function get_all_plant_user()
    {
        try {
            $lang     = $this->language->GetLanguage();
            $response = Http::withHeaders([
                'Accept-Language' => "{$lang}",
            ])->get("{$this->api_url}/plants-user");

            $result = $response->json();
            if ($response->failed()) {
                return collect();
            }
            $collection = collect($result['data'])->map(function ($item) {
                return (object) $item;
            });
            return PlantResource::collection($collection);
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function get_detail_plant_user(int $id)
    {
        try {
            $lang     = $this->language->GetLanguage();
            $response = Http::withHeaders([
                'Accept-Language' => "{$lang}",
            ])->get("{$this->api_url}/plants-user/$id");

            $result = $response->json();
            if ($response->failed()) {
                throw new \Exception($result['message']);
            }

            return $result;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function create_plant(array $data)
    {
        try {
            $token   = $this->token->GetToken();
            $request = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ]);

            if (isset($data['images']) && is_array($data['images'])) {
                foreach ($data['images'] as $file) {
                    $request->attach('images[]', file_get_contents($file->getRealPath()), $file->getClientOriginalName());
                }
            }
            $insertData = [
                'name'                => $data['name'],
                'latin_name'          => $data['latin_name'],
                'advantage'           => $data['advantage'],
                'ecology'             => $data['ecology'],
                'endemic_information' => $data['endemic_information'],
                'habitus_id'          => $data['habitus_id'],
            ];
            $response = $request->post("{$this->api_url}/plant/create", $insertData);

            $result = $response->json();

            if ($response->failed()) {
                throw new \Exception($result['message']);
            }

            return $result;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function update_plant(array $data, int $id)
    {
        try {
            $token = $this->token->GetToken();

            $request = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->asMultipart();

            $updateData = [
                ['name' => 'name', 'contents' => $data['name']],
                ['name' => 'latin_name', 'contents' => $data['latin_name']],
                ['name' => 'advantage', 'contents' => $data['advantage']],
                ['name' => 'ecology', 'contents' => $data['ecology']],
                ['name' => 'endemic_information', 'contents' => $data['endemic_information']],
                ['name' => 'habitus_id', 'contents' => $data['habitus_id']],
                ['name' => '_method', 'contents' => 'PUT'],
            ];

            if (isset($data['deleted_images']) && is_array($data['deleted_images'])) {
                foreach ($data['deleted_images'] as $index => $imageId) {
                    $updateData[] = [
                        'name'     => "deleted_images[$index]",
                        'contents' => $imageId,
                    ];
                }
            }

            foreach ($updateData as $item) {
                $request = $request->attach($item['name'], $item['contents']);
            }

            if (isset($data['new_images']) && is_array($data['new_images'])) {
                foreach ($data['new_images'] as $index => $image) {
                    $request = $request->attach(
                        "new_images[$index]",
                        file_get_contents($image->getRealPath()),
                        $image->getClientOriginalName()
                    );
                }
            }

            $response = $request->post("{$this->api_url}/plant/{$id}/edit", $updateData);

            $result = $response->json();

            if ($response->failed()) {
                throw new \Exception($result['message']);
            }

            return $result;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function delete_plant(int $id)
    {
        try {
            $token    = $this->token->GetToken();
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->delete("{$this->api_url}/plant/$id/delete");

            $result = $response->json();
            if ($response->failed()) {
                throw new \Exception($result['message']);
            }

            return $result;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function update_status(bool $status, int $id)
    {
        try {
            $token    = $this->token->GetToken();
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->put("{$this->api_url}/plant/$id/update-status", [
                'status' => $status,
            ]);

            $result = $response->json();
            if ($response->failed()) {
                throw new \Exception($result['message']);
            }

            return $result;

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function upload($file)
    {
        try {
            $token    = $this->token->GetToken();
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->attach(
                'upload',
                file_get_contents($file->getRealPath()),
                $file->getClientOriginalName()
            )->post("{$this->api_url}/plant/upload");

            $result = $response->json();

            if ($response->failed()) {
                throw new \Exception($result['error']['message'] ?? 'Upload failed');
            }

            return $result;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }
}
